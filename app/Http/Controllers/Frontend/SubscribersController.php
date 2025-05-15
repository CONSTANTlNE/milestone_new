<?php

namespace App\Http\Controllers;

use Helper;
use Multitenant;
use Illuminate\Http\Request;

class SubscribersController extends Controller
{
    public function subcribe(Request $request)
    {
        $emailExists  = trans(\App('language')->current->abbr.'.email-already-exists');
        $emailAdded   = trans(\App('language')->current->abbr.'.email-added');
        $emailInvalid = trans(\App('language')->current->abbr.'.provide-correct-email');

        if(filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            $getEmail = Multitenant::getModel('Subscriber')::where(['email' => $request->email])->first();
            if (!is_null($getEmail)) {
                $response = array(
                    'status' => $emailExists,
                );
            } else {
                $subscriber_one = Multitenant::getModel('Subscriber')::create([
                    'email'   => $request->email,
                ]);
                $subscriber_one->save();

                $response = array(
                    'status' => $emailAdded,
                );
            }
        } else {
            $response = array(
                'status' => $emailInvalid,
            );
        }
        return response()->json($response);
    }

    public function unsubscribe($user_email)
    {
        $email = Helper::encdec($user_email, false);

        $emailNotExists  = trans(\App('language')->current->abbr.'.email-not-exists');
        $emailDeleted = trans(\App('language')->current->abbr.'.email-deleted');

        $getEmail = Multitenant::getModel('Subscriber')::where(['email' => $email])->first();
        
        if (is_null($getEmail)) {
            $status = $emailNotExists;
        } else {
            Multitenant::getModel('Subscriber')::where('email', $email)->delete();
            $status = $emailDeleted;
        }
        
        return view('site.page.form.unsubscribe')->with('status', $status);
    }
}

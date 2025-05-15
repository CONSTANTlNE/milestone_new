<?php

namespace App\Http\Controllers;

use Multitenant;
use Helper;
use Mail;
use App\Models\Core\Menu;
use Illuminate\Http\Request;

class FormController extends Controller
{
    public $email = '';
    public $subject = '';
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = \App('menu');
        $type = array_first(collect(config('page.types'))->filter(function ($type) use ($data) {
            return $type['id'] === $data->menu->page->type;
        }));

        $template = array_first(collect(config('page.templates')[$type['name']])->filter(function ($template) use ($type, $data) {
            return $template['id'] == $data->menu->page->template_id;
        }));

        $contact = Multitenant::getModel('Detail')::withAndHas('info', function ($query) {
                $query->where('language_id', Helper::languageId());
            })->first();

        $content = Multitenant::getModel('Page')::where(['type' => $type['id'], 'template_id' => $template['id']])
            ->withAndHas('info', function ($query) {
            $query->where('language_id', Helper::languageId());
            $query->with('covers');
        })->first();


        return view('site.page.' . $type['name'] . '.' . $template['name'], ['data' => $data, 'contact' => $contact, 'content' => $content]);
    }

    public function mailSend(Request $request)
    {
        $data['fullname'] = $request->input('fullname');
        $data['email'] = $request->input('email');
        $data['text'] = $request->input('text');

        $contact = Multitenant::getModel('Detail')::withAndHas('info', function ($query) {
            $query->where('language_id', Helper::languageId());
            $query->with('covers');
        })->first();

        $this->email = $contact->email;
        $this->subject = $request->input('subject');

        Mail::send('site.page.form.mail', ['data' => $data, 'info' => $contact], function ($message) {
            $message->from('noreply@factcheck.ge', 'factcheck.ge');
            $message->subject($this->subject);
            $message->to($this->email);
        });

        return response(['message' => trans(\App('language')->current->abbr.'.message-sent-text')], 200)->header('Content-Type', 'application/json');
    }

    public function factSend(Request $request)
    {
        $data['fullname'] = $request->input('fullname');
        $data['email'] = $request->input('email');
        $data['source'] = $request->input('source');
        $data['fact'] = $request->input('fact');

        $contact = Multitenant::getModel('Detail')::withAndHas('info', function ($query) {
            $query->where('language_id', Helper::languageId());
        })->first();

        $this->email = $contact->meta['send_email'] ?? $contact->email;

        $this->subject = trans(\App('language')->current->abbr.'.verify-your-fact');

        Mail::send('site.page.form.fact', ['data' => $data, 'info' => $contact], function ($message) {
            $message->from('noreply@grass.org.ge', 'grass.org.ge');
            $message->subject($this->subject);
            $message->to('info@factcheck.ge');
        });
        Mail::failures();


        return response(['message' => trans(\App('language')->current->abbr.'.message-sent-text')], 200)->header('Content-Type', 'application/json');
    }
}

<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TwilioService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {

    }



    public function otpConfirm($request){

        if (env('LOCAL_TEST')) {
            $number =env('LOCAL_TEST_NUMBER');
        } else {
            $number = $request->phone_hidden;
        }


        try {
            $response = Http::withBasicAuth(
                config('milestone.twilio_username'),
                config('milestone.twilio_password'),
            )->asForm()->post('https://verify.twilio.com/v2/Services/VA91c9542ac451984552282926daf4ac05/VerificationCheck',
                [
                    'Code' => $request->code,
                    'To' => $number,
                ]);
        } catch (\Throwable $e) {
            Log::channel('twilio')->error('Twilio otpConfirm transport exception ' . $number, [
                'exception' => $e->getMessage(),
            ]);
            $errormsg = 'Confirmation failed due to a temporary issue, please try again later';
            return response()
                ->view('components.frontend.htmx.otp_invalid', compact('errormsg'))
                ->header('X-HTMX-Request-Type', 'manual-otp');
        }

        if ($response->successful()) {

//  =========  Success RESPONSE DATA
// "status" => "approved"
//  "payee" => null
//  "date_updated" => "2025-06-26T10:33:59Z"
//  "account_sid" => "AC2cd1c78ba1b7dcd160286bb22ed3ce2b"
//  "to" => "+995551507697"
//  "amount" => null
//  "valid" => true
//  "sid" => "VE3018ff2bea66db9e80066926abd93d1c"
//  "date_created" => "2025-06-26T10:32:54Z"
//  "service_sid" => "VA91c9542ac451984552282926daf4ac05"
//  "channel" => "sms"
            return $response;
        } else {

            $error = $response->json();

            Log::channel('twilio')->error('confirmation error during call ' . $number, [
                'Response' => $error,
            ]);


            if ($error['status'] == '404') {
                //  "code" => 20404
                //  "message" => "The requested resource /v2/Services/VA91c9542ac451984552282926daf4ac05/VerificationCheck was not found"
                //  "more_info" => "https://www.twilio.com/docs/errors/20404"
                //  "status" => 404
                //]

                Log::channel('twilio')->error('confirmation error Service unavailable?' . $number, [
                    'Response' => $error,
                ]);

                $errormsg = 'Validation timeout , please try again';

                return response()
                    ->view('components.frontend.htmx.otp_invalid', compact('errormsg'))
                    ->header('X-HTMX-Request-Type', 'manual-otp');
            }

            if ($error['status'] == '429') {
                //  "code" => 60202
                //  "message" => "Max check attempts reached"
                //  "more_info" => "https://www.twilio.com/docs/errors/60202"
                //  "status" => 429
                //]

                Log::channel('twilio')->error('confirmation error Too many attempts?' . $number, [
                    'Response' => $error,
                ]);

                $errormsg = 'Too many invalid attempts,please try again later';

                return response()
                    ->view('components.frontend.htmx.otp_invalid', compact('errormsg'))
                    ->header('X-HTMX-Request-Type', 'manual-otp');
            }

            Log::channel('twilio')->error('unknown error ' . $number, [
                'Response' => $error,
            ]);

            $errormsg = 'Confirmation faiiled to send, please try again later';

            return response()
                ->view('components.frontend.htmx.otp_invalid', compact('errormsg'))
                ->header('X-HTMX-Request-Type', 'manual-otp');
        }

    }

    public function sendQuotationOffert($mobile,$quotation)
    {

        try {
            $response = Http::withBasicAuth(
                config('milestone.twilio_username'),
                config('milestone.twilio_password'),
            )->asForm()->post('https://api.twilio.com/2010-04-01/Accounts/AC2cd1c78ba1b7dcd160286bb22ed3ce2b/Messages.json', [
                'To' => '+995551507697',
                'MessagingServiceSid' => 'MG40e3a2754be77e3b0ebe35de3f178f98',
//            'From' => '+13184148929',
                'Body' => 'hello , we send an email with your quotation offer',
            ]);
        } catch (\Throwable $e) {
            Log::channel('twilio')->error('Offer SMS transport exception ' . $mobile, [
                'exception' => $e->getMessage(),
            ]);
            return back()->with('error', 'SMS failed to send');
        }

        if ($response->successful()) {
            return;
        } else {
            Log::channel('twilio')->error('Offer SMS failed to send' . $mobile, [
                'Response' => $response->json(),
            ]);
            return back()->with('error', 'SMS failed to send');
        }

    }

    public function notify($mobile,$message){

        try {
            $response = Http::withBasicAuth(
                config('milestone.twilio_username'),
                config('milestone.twilio_password'),
            )->asForm()->post('https://api.twilio.com/2010-04-01/Accounts/AC2cd1c78ba1b7dcd160286bb22ed3ce2b/Messages.json', [
                'To' => '+995551507697',
                'MessagingServiceSid' => 'MG40e3a2754be77e3b0ebe35de3f178f98',
                'Body' =>  $message,
            ]);
        } catch (\Throwable $e) {
            Log::channel('twilio')->error('Notify SMS transport exception ' . $mobile, [
                'exception' => $e->getMessage(),
            ]);
            return; // swallow exception so callers aren’t forced to handle
        }

        if ($response->successful()) {
            return;
        } else {
            Log::channel('twilio')->error('Offer SMS failed to send' . $mobile, [
                'Response' => $response->json(),
            ]);
            return back()->with('error', 'SMS failed to send');
        }
    }
}

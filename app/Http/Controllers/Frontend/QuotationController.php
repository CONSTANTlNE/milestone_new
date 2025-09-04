<?php

namespace App\Http\Controllers\Frontend;

use App\Mail\NewQuotationEmail;
use App\Mail\SendQuotationEmail;
use App\Models\Availability;
use App\Models\CarBrand;
use App\Models\CarModel;
use App\Models\Quotation;
use App\Models\QuotationCharge;
use App\Models\User;
use App\Services\TwilioService;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Rules\UsPhone;

class QuotationController extends Controller
{

    public function index(Request $request)
    {
        $availabilities = Availability::orderBy('created_at', 'desc')->get();
        $q = trim((string)$request->query('q', ''));
        $dateFrom = trim((string)$request->query('date_from', ''));
        $dateTo = trim((string)$request->query('date_to', ''));

        $quotationsQuery = Quotation::orderBy('id', 'desc')
            ->with('user');
        $users=User::all();

        if ($q !== '') {
            $quotationsQuery->where(function ($sub) use ($q) {
                // Numeric exact matches for id and distance
                if (is_numeric($q)) {
                    $sub->orWhere('id', (int)$q)
                        ->orWhere('distance_mile', (float)$q)
                        ->orWhere('body_weight', 'like', "%$q%");
                }
                // Textual partial matches across common columns
                $sub->orWhere('start_address', 'like', "%$q%")
                    ->orWhere('destination_address', 'like', "%$q%")
                    ->orWhere('transport_type', 'like', "%$q%")
                    ->orWhere('operable', 'like', "%$q%")
                    ->orWhere('vehicle', 'like', "%$q%")
                    ->orWhere('car_type', 'like', "%$q%")
                    ->orWhere('email', 'like', "%$q%")
                    ->orWhere('phone', 'like', "%$q%")
                    ->orWhere('availability', 'like', "%$q%");
            });
        }

        // Apply created_at filtering if provided
        try {
            if ($dateFrom !== '' && preg_match('/^\d{4}-\d{2}-\d{2}$/', $dateFrom)) {
                $quotationsQuery->whereDate('created_at', '>=', $dateFrom);
            }
            if ($dateTo !== '' && preg_match('/^\d{4}-\d{2}-\d{2}$/', $dateTo)) {
                $quotationsQuery->whereDate('created_at', '<=', $dateTo);
            }
        } catch (\Throwable $e) {
            // Fail silently if invalid date format; keep minimal changes as requested
        }

        $quotations = $quotationsQuery->paginate(50)->appends([
            'q' => $q,
            'date_from' => $dateFrom,
            'date_to' => $dateTo,
        ]);

        return view('backend.quotations.index', compact('availabilities', 'quotations','users'));
    }
    public function getModels(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'make_id' => 'required|integer|exists:car_brands,id',
        ]);

        if ($validator->fails()) {
            $htmxErrors = $validator->errors();

            return response()->noContent();

//            return response()
//                ->view('components.frontend.htmx.htmx_validation_errors', compact('htmxErrors'))
//                ->header('X-HTMX-Request-Type', 'htmx_validation_errors');
        }


        if ($request->filled('make_id') && is_numeric($request->make_id)) {
            $request->validate([
                'make_id' => 'required|exists:car_brands,id',
            ]);

            $carmodels = CarModel::where('car_brand_id', $request->make_id)->get();
        } else {
            $carmodels = null;
        }


        return view('components.frontend.htmx.models_htmx', compact('carmodels'));
    }
    public function sendOtp(Request $request)
    {
//        if (env('LOCAL_TEST')) {
//            $secret_key = '1x0000000000000000000000000000000AA';
//        } else {
//            $secret_key = config('milestone.CLOUDFLARE_SECRET_KEY');
//        }
//
//        // Check cloudflare Turnstile
//        $response = Http::asForm()->post('https://challenges.cloudflare.com/turnstile/v0/siteverify', [
//            'secret' => $secret_key,
//            'response' => $request->input('cloudflare_captcha'),
//            'remoteip' => $request->ip(),
//        ]);
//
//
//        if (!($response->json('success') ?? false)) {
//            $errormsg = 'Captcha validation failed.';
//
//            return response()
//                ->view('components.frontend.htmx.captcha_failed', compact('errormsg'))
//                ->header('X-HTMX-Request-Type', 'manual-otp');
//        }


        if (env('LOCAL_TEST')) {
            $number = '+995551507697';
        } else {
            $request->validate([
                'phone' => ['required', new UsPhone],
            ]);
            // Normalize to E.164 for Twilio: +1XXXXXXXXXX
            $raw = (string) $request->input('phone');
            $digits = preg_replace('/\D+/', '', $raw) ?? '';
            if (strlen($digits) === 11 && str_starts_with($digits, '1')) {
                $digits = substr($digits, 1);
            }
            $number = '+1' . $digits;
        }
        $response = Http::withBasicAuth(
            config('milestone.twilio_username'),
            config('milestone.twilio_password'),
        )->asForm()->post('https://verify.twilio.com/v2/Services/' . config('milestone.twilio_otp_service_sid') . '/Verifications',
            [
                'Channel' => 'sms',
                'To' => $number,
            ]);

        if ($response->successful()) {
            Log::channel('twilio')->info('Successfully send OTP to ' . $number, [
                'Response' => $response->json(),
            ]);

            return view('components.frontend.htmx.confirm_phone_htmx');
        } else {
            dd($response->json());
        }
    }
    public function sendOtpBusiness(Request $request)
    {
        if (env('LOCAL_TEST')) {
            $secret_key = '1x0000000000000000000000000000000AA';
        } else {
            $secret_key = config('milestone.CLOUDFLARE_SECRET_KEY');
        }


        if (env('LOCAL_TEST')) {
            $number = '+995551507697';
        } else {
            $request->validate([
                'phone' => ['required', new UsPhone],
            ]);

            // Normalize to E.164 for Twilio: +1XXXXXXXXXX
            $raw = (string) $request->input('phone');
            $digits = preg_replace('/\D+/', '', $raw) ?? '';
            if (strlen($digits) === 11 && str_starts_with($digits, '1')) {
                $digits = substr($digits, 1);
            }
            $number = '+1' . $digits;
        }
        $response = Http::withBasicAuth(
            config('milestone.twilio_username'),
            config('milestone.twilio_password'),
        )->asForm()->post('https://verify.twilio.com/v2/Services/' . config('milestone.twilio_otp_service_sid') . '/Verifications',
            [
                'Channel' => 'sms',
                'To' => $number,
            ]);

        if ($response->successful()) {
            Log::channel('twilio')->info('Successfully send OTP to ' . $number, [
                'Response' => $response->json(),
            ]);

            return view('components.frontend.htmx.confirm_phone_htmx_business');
        } else {
            dd($response->json());
        }
    }
    public function confirmOtp(Request $request)
    {

      $response= (new TwilioService())->otpConfirm($request);

        if ($response instanceof \Symfony\Component\HttpFoundation\Response) {
            return $response;
        }


//  ==========  DATA FROM HTMX FORM
//            "code" => "598586"
//  "phone_hidden" => "+15985689859"
//  "destination_id" => "ChIJ0-t45g8Tg4cRpTZYXuQu70I"
//  "start_id" => "ChIJJTGgBnGWyYcRcdPZHNWACC4"
//  "email_hidden" => "gmta.constantine@gmail.com"
//  "from" => "59858 S 4710 Rd, Watts, OK, USA"
//  "destination" => "87929 445th Avenue, Long Pine, NE, USA"
//  "transport_type" => "open"
//  "operable" => "yes"
//  "year" => "2023"
//  "make" => "3"
//  "model" => "54"

            $data = $response->json();

            if ($data['valid'] == true) {
                if (is_numeric($request->make) && (int)$request->make == $request->make) {
                    $make = CarBrand::find($request->make)->name;
                    $model = CarModel::find($request->model)->name;
                } else {
                    $make = $request->make;
                    $model = $request->model;
                }

                $availability = Availability::where('id', $request->availability)->first();
                if ($request->type==1){
                    $request_type='individual';
                }elseif($request->type==2){
                    $request_type='business';
                } else {
                    $request_type='individual';
                }

               $quotation= Quotation::create([
                    'start_place_id' => $request->start_id,
                    'destination_place_id' => $request->destination_id,
                    'start_address' => $request->from,
                    'destination_address' => $request->destination,
                    'transport_type' => $request->transport_type,
                    'vehicle' => $request->year . ' ' . $make . ' ' . $model,
                    'operable' => $request->operable,
                    'email' => $request->email,
                    'phone' => $request->phone_hidden,
                    'availability' => $availability->getTranslation('title', 'en'),
//                    'car_brand_id' => $request->make,
//                    'car_model_id' => $request->model,
                    'request_type' => $request_type,
                ]);

                $users=User::all();
                foreach ($users as $user){
                    if($user->send_quotation==1){

                        Mail::to($user->email)
                            ->cc('michael@milestonebrokers.us')
                            ->send(new NewQuotationEmail($quotation->email,$quotation));

                        (new TwilioService())->notify($user->phone, 'New Individual quotation received, please check');

                    }
                }

                return response()->view('components.frontend.htmx.otp_success')->header('X-HTMX-Request-Type',
                    'ind-quotation-success');
            }

            if ($data['valid'] == false) {
                $errormsg = 'The code is invalid';

                return response()
                    ->view('components.frontend.htmx.otp_invalid', compact('errormsg'))
                    ->header('X-HTMX-Request-Type', 'manual-otp');
            }

//   if twilio response is successfull but some other error ?
            Log::channel('twilio')->error('unknown error during confirmation ' . $request->phone_hidden, [
                'Response' => $response->json(),
            ]);

             return back()->with('error', 'Unknown error during confirmation');


    }
    public function confirmOtpBusiness(Request $request)
    {

        $response= (new TwilioService())->otpConfirm($request);

        if ($response instanceof \Symfony\Component\HttpFoundation\Response) {
            return $response;
        }

        $data = $response->json();

        if ($data['valid'] == true) {

            return response()->view('components.frontend.htmx.otp_success_business')->header('X-HTMX-Request-Type',
                'bsiness-otp-success');
        }

        if ($data['valid'] == false) {
            $errormsg = 'The code for business quotation is invalid';

            return response()
                ->view('components.frontend.htmx.otp_invalid_business', compact('errormsg'))
                ->header('X-HTMX-Request-Type', 'manual-otp');
        }

//   if twilio response is successfull but some other error ?
        Log::channel('twilio')->error('unknown error during confirmation ' . $request->phone_hidden, [
            'Response' => $response->json(),
        ]);

        return back()->with('error', 'Unknown error during confirmation');


    }
    public function changePhone(Request $request)
    {
        return view('components.frontend.htmx.change_phone_htmx');
    }
    public function changePhoneBusiness(Request $request)
    {
        return view('components.frontend.htmx.change_phone_htmx_business');
    }
    public function delete(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:quotations,id',
        ]);

        $quotation = Quotation::find($request->id);
        $quotation->delete();

        return back();
    }
    public function calculateDistance(Request $request)
    {
        $request->validate([
            'quotation_id' => 'required|exists:quotations,id',
        ]);

        $quotation = Quotation::find($request->quotation_id);

        $origins = $quotation->start_place_id;
        $destinations = $quotation->destination_place_id;

        $response = Http::get('https://maps.googleapis.com/maps/api/distancematrix/json', [
            'origins' => "place_id:" . $origins,
            'destinations' => "place_id:" . $destinations,
            'key' => config('milestone.google_map_api_key'),
        ]);

        $data = $response->json();
        $meters = $data['rows'][0]['elements'][0]['distance']['value'];
        $miles = $meters * 0.000621371;
        $miles = round($miles, 2);

        $quotation->distance_mile = $miles;
        $quotation->save();

        return back()->with('success', 'Distance calculated successfully');
    }
    public function requestAiData(Request $request)
    {
        $request->validate([
            'quotation_id' => 'required|exists:quotations,id',
        ]);

        $quotation = Quotation::find($request->quotation_id);

        $response = Http::withToken(config('milestone.OPENAI_API_KEY'))
            ->withHeaders([
                'Content-Type' => 'application/json',
            ])
            ->post('https://api.openai.com/v1/responses', [
                'model' => 'gpt-4.1',
                'tools' => [
                    ['type' => 'web_search_preview'],
                ],
                'input' => 'Give body weight in lbs, width in inches, height in inches, length in inches and type (like SUV, sedan, motorcycle, etc.) and possible specs links (as array) for ' . $quotation->vehicle . '. Respond in **JSON** format only, and nothing else. The format must look exactly like: { "body_weight": "value",  "width": "value", "height": "value", "length": "value", "type": "value",  "specs_links": ["url1", "url2"]}',
                'temperature' => 0.3,
            ]);

        if ($response->successful()) {
            $data = $response->json();
//            dd($data);

            $rawJson = $data['output'][1]['content'][0]['text'];

            Log::channel('ailog')->info([
                'Response' => $response->json(),
            ]);

            // Step 1: Clean the text
            $cleanJson = trim($rawJson);
            $cleanJson = preg_replace('/^```json\s*/', '', $cleanJson); // Remove leading ```json
            $cleanJson = preg_replace('/```$/', '', $cleanJson);        // Remove trailing ```

            // Step 2: Decode to associative array
            $specs = json_decode($cleanJson, true);

            // Normalize numeric values by stripping units like "in", "inch(es)", "lb(s)", etc.
            $normalize = function ($value) {
                if (is_null($value)) {
                    return '';
                }
                if (is_numeric($value)) {
                    return (string)$value;
                }
                if (!is_string($value)) {
                    return '';
                }
                // Replace commas and extract first numeric (int/float) occurrence
                $v = str_replace(',', '', $value);
                if (preg_match('/-?\d*\.?\d+/', $v, $m)) {
                    return $m[0];
                }
                // Fallback: remove known unit words and trim
                $v = preg_replace('/\b(lbs?|pounds?|kg|inches|inch|in|cm|mm)\b\.?/i', '', $v);
                return trim($v);
            };

            $quotation->body_weight = $normalize($specs['body_weight'] ?? '');
            $quotation->length = $normalize($specs['length'] ?? '');
            $quotation->height = $normalize($specs['height'] ?? '');
            $quotation->width = $normalize($specs['width'] ?? '');

            $quotation->car_type = $specs['type'] ?? '';
            $quotation->specs_links = $specs['specs_links'] ?? [];
            $quotation->ai_response = $data;
            $quotation->save();

            return back()->with('success', 'AI data added successfully');
        }
    }

    public function costCalculate(Request $request)
    {
        $request->validate(['quotation_id' => 'required|exists:quotations,id']);

        $quotation = Quotation::find($request->quotation_id);

        if (!$quotation->distance_mile) {
            return back()->with('error', 'Please calculate distance');
        }

        if (!$quotation->body_weight) {
            return back()->with('error', 'Please get car specs');
        }

        $chargesArray = [];

        $surcharges = QuotationCharge::where('is_active',1)->get();
        $existingSurcharges = $quotation->surcharges ?? [];
        $total_surcharge = 0;

        // to keep previous custom surcharge
        foreach ($existingSurcharges as $existing) {
            if ($existing['custom_charge'] == 1) {
                $chargesArray[] = $existing;
                $total_surcharge += $existing['value'];
            }
        }


        if ($request->filled('custom_charge_name') && $request->filled('custom_charge_value')) {
            $rand = random_int(10000, 99999);
            $chargesArray[] = [
                'id' => $rand,
                'custom_charge' => 1,
                'name' => $request->custom_charge_name,
                'value' => $request->custom_charge_value,
            ];
            $total_surcharge += $request->custom_charge_value;
        }

        foreach ($surcharges as $surcharge) {
//            dd($surcharge);
            if ($surcharge->slug == 'base-rate') {
                $chargesArray[] = [
                    'id' => $surcharge->id,
                    'custom_charge' => 0,
                    'name' => $surcharge->name,
                    'value' => $surcharge->surcharge * $quotation->distance_mile,
                ];
                $total_surcharge += $surcharge->surcharge * $quotation->distance_mile;
            }


            if ($quotation->operable != 'yes' && $surcharge->slug == 'non-operational') {
                $chargesArray[] = [
                    'id' => $surcharge->id,
                    'custom_charge' => 0,
                    'name' => $surcharge->name,
                    'value' => $surcharge->surcharge * $quotation->distance_mile,
                ];
                $total_surcharge += $surcharge->surcharge;
            }

            if ($request->filled('suv') && $surcharge->slug == 'suv') {
                $chargesArray[] = [
                    'id' => $surcharge->id,
                    'custom_charge' => 0,
                    'name' => $surcharge->name,
                    'value' => $surcharge->surcharge,
                ];

                $total_surcharge += $surcharge->surcharge;
                $quotation->suv = 1;
            } elseif (!$request->filled('suv') && $surcharge->slug != 'suv') {
                $quotation->suv = 0;
            }

            if ($request->filled('luxury') && $surcharge->slug == 'luxury-vehicle') {
                $chargesArray[] = [
                    'id' => $surcharge->id,
                    'custom_charge' => 0,
                    'name' => $surcharge->name,
                    'value' => $surcharge->surcharge,
                ];

                $total_surcharge += $surcharge->surcharge;
                $quotation->luxury = 1;
            } elseif (!$request->filled('luxury') && $surcharge->slug != 'luxury') {
                $quotation->luxury = 0;
            }


            //  =====================================

            if ($surcharge->slug == 'width-over-84' && ($quotation->width > 84 && $quotation->width < 88)) {
                $chargesArray[] = [
                    'id' => $surcharge->id,
                    'custom_charge' => 0,
                    'name' => $surcharge->name,
                    'value' => $surcharge->surcharge,
                ];

                $total_surcharge += $surcharge->surcharge;
            }

            if ($surcharge->slug == 'width-over-88' && $quotation->width > 88) {
                $chargesArray[] = [
                    'id' => $surcharge->id,
                    'custom_charge' => 0,
                    'name' => $surcharge->name,
                    'value' => $surcharge->surcharge,
                ];
                $total_surcharge += $surcharge->surcharge;
            }

            if ($surcharge->slug == 'weight-6000-7500' && ($quotation->body_weight > 6000 && $quotation->body < 7500)) {
                $chargesArray[] = [
                    'id' => $surcharge->id,
                    'custom_charge' => 0,
                    'name' => $surcharge->name,
                    'value' => $surcharge->surcharge,
                ];
                $total_surcharge += $surcharge->surcharge;
            }

            if ($surcharge->slug == 'weight-4000-6000' && ($quotation->body_weight > 4000 && $quotation->body < 6000)) {
                $chargesArray[] = [
                    'id' => $surcharge->id,
                    'custom_charge' => 0,
                    'name' => $surcharge->name,
                    'value' => $surcharge->surcharge,
                ];
                $total_surcharge += $surcharge->surcharge;
            }

            if ($surcharge->slug == 'weight-7500' && $quotation->body_weight > 7500) {
                $chargesArray[] = [
                    'id' => $surcharge->id,
                    'custom_charge' => 0,
                    'name' => $surcharge->name,
                    'value' => $surcharge->surcharge,
                ];
                $total_surcharge += $surcharge->surcharge;
            }

            if ($surcharge->slug == 'height-over-78' && $quotation->height > 78) {
                $chargesArray[] = [
                    'id' => $surcharge->id,
                    'custom_charge' => 0,
                    'name' => $surcharge->name,
                    'value' => $surcharge->surcharge,
                ];
                $total_surcharge += $surcharge->surcharge;
            }

            if ($surcharge->slug == 'length-over-210' && $quotation->length > 210) {
                $chargesArray[] = [
                    'id' => $surcharge->id,
                    'custom_charge' => 0,
                    'name' => $surcharge->name,
                    'value' => $surcharge->surcharge,
                ];
                $total_surcharge += $surcharge->surcharge;
            }

        }

        $quotation->surcharges = $chargesArray;
        $quotation->calculated_cost = $total_surcharge;
        $quotation->save();

        return back()->with('success', 'Cost calculated successfully');
    }

    public
    function updateCharge(Request $request)
    {
        $request->validate(['quotation_id' => 'required|exists:quotations,id']);

        $quotation = Quotation::find($request->quotation_id);
        $existingSurcharges = $quotation->surcharges;

        $existingIds = collect($existingSurcharges)->pluck('id');
        if (!$existingIds->contains($request->surcharge_id)) {
            return back()->with('error', 'Surcharge not found');
        }

        foreach ($existingSurcharges as &$existingCharge) {
            if ($existingCharge['id'] == $request->surcharge_id) {
                $existingCharge['value'] = $request->surcharge_value;
                break;
            }
        }
        unset($existingCharge);

        $quotation->surcharges = $existingSurcharges;
        $quotation->calculated_cost = collect($existingSurcharges)->sum('value');
        $quotation->save();

        return back()->with('success', 'Surcharge updated successfully');

    }

    public
    function deleteCharge(Request $request)
    {
        $request->validate(['quotation_id' => 'required|exists:quotations,id']);

        $quotation = Quotation::find($request->quotation_id);
        $existingSurcharges = $quotation->surcharges;

        $existingIds = collect($existingSurcharges)->pluck('id');
        if (!$existingIds->contains($request->surcharge_id)) {
            return back()->with('error', 'Surcharge not found');
        }

        // Filter out the surcharge to be deleted
        $updatedSurcharges = array_filter($existingSurcharges, function($charge) use ($request) {
            return $charge['id'] != $request->surcharge_id;
        });

        $quotation->surcharges = array_values($updatedSurcharges); // Reset array keys
        $quotation->calculated_cost = collect($updatedSurcharges)->sum('value');
        $quotation->save();

        return back()->with('success', 'Surcharge deleted successfully');

    }

    public function approve(Request $request){
        $request->validate([
            'quotation_id' => 'required|exists:quotations,id',
        ]);

        $quotation=Quotation::find($request->quotation_id);

        if($quotation->approved==0){
            $quotation->approved=1;
            $quotation->save();
            return back()->with('success','Quotation approved successfully');
        }else{
            $quotation->approved=0;
            $quotation->save();
            return back()->with('success','Quotation disapproved');
        }

    }

    public function notifyUsers(Request $request){
        // Expecting an array of user IDs in 'users2'. If absent, treat as empty.
        $ids = collect($request->input('users', []))
            ->map(function ($v) { return (int) $v; })
            ->filter(function ($v) { return $v > 0; })
            ->unique()
            ->values();

        // Set send_quotation = 0 for all users, then enable only for provided IDs
        User::query()->update(['send_quotation' => 0]);

        if ($ids->isNotEmpty()) {
            User::whereIn('id', $ids)->update(['send_quotation' => 1]);
        }

        return back()->with('success', 'Notify users list updated successfully.');
    }

    public function sendQuotationOffer(Request $request){
        $request->validate([
            'quotation_id' => 'required|exists:quotations,id',
        ]);

        $quotation=Quotation::find($request->quotation_id);

        if(!$quotation->calculated_cost){
            return back()->with('error','Please calculate cost');
        }

         if($quotation->email){
             Mail::to($quotation->email)
                 ->cc('michael@milestonebrokers.us')
                 ->send(new SendQuotationEmail($quotation->email,$quotation));
             $quotation->quotation_sent=1;
             $quotation->quotation_sent_date=now();
             $quotation->sent_by_id=auth('web')->user()->id;
             $quotation->save();
         }

        (new TwilioService())->sendQuotationOffert($quotation->phone,$quotation);

        return back()->with('success','Quotation sent successfully');

    }

    public
    function htmxspinner(Request $request)
    {
        return view('components.frontend.htmx.hmxspinner');
    }


}

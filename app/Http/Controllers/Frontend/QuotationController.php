<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Availability;
use App\Models\CarBrand;
use App\Models\CarModel;
use App\Models\Quotation;
use App\Models\QuotationRequestType;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class QuotationController extends Controller
{

    public function index(){

//     $request_types  = QuotationRequestType::orderBy('created_at', 'desc')->get();
        $availabilities = Availability::orderBy('created_at', 'desc')->get();
        $quotations=Quotation::orderBy('created_at','desc')->paginate(50);

        return view('backend.quotations.index', compact( 'availabilities', 'quotations'));
    }

    public function getModels(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'make_id' => 'required|exists:car_brands,id',
        ]);

        if ($validator->fails()) {
            $htmxErrors = $validator->errors();

            return response()->view('components.frontend.htmx.htmx_validation_errors', compact('htmxErrors'))
                ->header('X-HTMX-Request-Type', 'htmx_validation_errors');
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

    public function getQuotation(Request $request)
    {
        $quotations = Quotation::orderBy('created_at', 'desc')->get();

        return view('admin.quotations.admin_quotations_index', compact('quotations'));
    }

    public function sendOtp(Request $request)
    {
        if (env('LOCAL_TEST')) {
            $number = '+995551507697';
        } else {
            $number = request('phone');
        }
        $response = Http::withBasicAuth(
            config('milestone.twilio_username'),
            config('milestone.twilio_password'),
        )->asForm()->post('https://verify.twilio.com/v2/Services/'.config('milestone.twilio_otp_service_sid').'/Verifications',
            [
                'Channel' => 'sms',
                'To'      => $number,
            ]);

        if ($response->successful()) {
            Log::channel('twilio')->info('Successfully send OTP to '.$number, [
                'Response' => $response->json(),
            ]);

            return view('components.frontend.htmx.confirm_phone_htmx');
        } else {
            dd($response->json());
        }
    }

    public function confirmOtp(Request $request)
    {
//        dd($request->all());
        if (env('LOCAL_TEST')) {
            $number = '+995551507697';
//            $number = '+995511479914';
        } else {
            $number = $request->phone_hidden;
        }

        $response = Http::withBasicAuth(
            config('milestone.twilio_username'),
            config('milestone.twilio_password'),
        )->asForm()->post('https://verify.twilio.com/v2/Services/VA91c9542ac451984552282926daf4ac05/VerificationCheck',
            [
                'Code' => $request->code,
                'To'   => $number,
            ]);

        if ($response->successful()) {
            Log::channel('twilio')->info('Confirmation Success '.$number, [
                'Response' => $response->json(),
            ]);

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
            $data = $response->json();


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

            if ($data['valid'] == true) {
                $make         = CarBrand::find($request->make)->name;
                $model        = CarModel::find($request->model)->name;
                $availability = Availability::where('id', $request->availability)->first();
                Quotation::create([
                    'start_place_id'       => $request->start_id,
                    'destination_place_id' => $request->destination_id,
                    'start_address'        => $request->from,
                    'destination_address'  => $request->destination,
                    'transport_type'       => $request->transport_type,
                    'vehicle'              => $request->year.' '.$make.' '.$model,
                    'operable'             => $request->operable,
                    'email'                => $request->email,
                    'phone'                => $request->phone_hidden,
                    'availability'         => $availability->getTranslation('title', 'en'),
                    'car_brand_id'         => $request->make,
                    'car_model_id'         => $request->model,
                ]);

                return response()->view('components.frontend.htmx.otp_success')->header('X-HTMX-Request-Type', 'manual-otp');
            }

            if ($data['valid'] == false) {
                $errormsg = 'The code is invalid';

                return response()
                    ->view('components.frontend.htmx.otp_invalid', compact('errormsg'))
                    ->header('X-HTMX-Request-Type', 'manual-otp');
            }

            Log::channel('twilio')->error('unknown error during confirmation '.$number, [
                'Response' => $response->json(),
            ]);

            dd($response->json());
        } else {
//            return $response->body();
            $error = $response->json();
            Log::channel('twilio')->error('confirmation error during call '.$number, [
                'Response' => $error,
            ]);


            if ($error['status'] == '404') {
                //  "code" => 20404
                //  "message" => "The requested resource /v2/Services/VA91c9542ac451984552282926daf4ac05/VerificationCheck was not found"
                //  "more_info" => "https://www.twilio.com/docs/errors/20404"
                //  "status" => 404
                //]

                Log::channel('twilio')->error('confirmation error Service unavailable?'.$number, [
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

                Log::channel('twilio')->error('confirmation error Too many attempts?'.$number, [
                    'Response' => $error,
                ]);

                $errormsg = 'Too many invalid attempts,please try again later';

                return response()
                    ->view('components.frontend.htmx.otp_invalid', compact('errormsg'))
                    ->header('X-HTMX-Request-Type', 'manual-otp');
            }

            Log::channel('twilio')->error('unknown error '.$number, [
                'Response' => $error,
            ]);

            dd($response->json());
        }
    }

    public function changePhone(Request $request)
    {
        return view('components.frontend.htmx.change_phone_htmx');
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

        $origins      = $quotation->start_place_id;
        $destinations = $quotation->destination_place_id;

        $response = Http::get('https://maps.googleapis.com/maps/api/distancematrix/json', [
            'origins'      => "place_id:".$origins,
            'destinations' => "place_id:".$destinations,
            'key'          => config('milestone.google_map_api_key'),
        ]);

        $data   = $response->json();
        $meters = $data['rows'][0]['elements'][0]['distance']['value'];
        $miles  = $meters * 0.000621371;
        $miles  = round($miles, 2);

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

        $response = Http::withToken(env('OPENAI_API_KEY'))
            ->withHeaders([
                'Content-Type' => 'application/json',
            ])
            ->post('https://api.openai.com/v1/responses', [
                'model' => 'gpt-4.1',
                'tools' => [
                    ['type' => 'web_search_preview'],
                ],
                'input' => 'Give body weight, width, height, length and type (like SUV, sedan, motorcycle, etc.) and possible specs links (as array) for '.$quotation->vehicle.'. Respond in **JSON** format only, and nothing else. The format must look exactly like: { "body_weight": "value",  "width": "value", "height": "value", "length": "value", "type": "value",  "specs_links": ["url1", "url2"]}',
                'temperature' => 0.3,
            ]);

        if ($response->successful()) {
            $data    = $response->json();
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


            $quotation->body_weight = $this->toPounds($specs['body_weight']);
            $quotation->length      = $this->convertToInches($specs['length'] ?? '');
            $quotation->height      = $this->convertToInches($specs['height'] ?? '');
            $quotation->width       = $this->convertToInches($specs['width'] ?? '');

//            $quotation->length      = $specs['length'];
//            $quotation->height      = $specs['height'];
//            $quotation->width       = $specs['width'];

            $quotation->car_type    = $specs['type'];
            $quotation->specs_links = $specs['specs_links'];
            $quotation->ai_response = $data;
            $quotation->save();

            return back()->with('success', 'AI data added successfully');
        }
    }

    function toPounds(string $rawWeight): float
    {
        // Remove thousands separators like commas
        $cleaned = str_replace(',', '', $rawWeight);

        // Extract numeric value
        preg_match('/([\d.]+)/', $cleaned, $matches);
        $value = isset($matches[1]) ? (float) $matches[1] : 0;

        // Extract unit
        $unit = strtolower(trim(preg_replace('/[\d.\s]/', '', $cleaned)));

        if (str_contains($unit, 'kg')) {
            return round($value * 2.20462, 2); // Convert kg ➜ lbs
        }

        // Already in lbs (or default fallback)
        return round($value, 2);
    }

    function convertToInches(string $raw): float
    {
        // Remove commas (thousands separators)
        $cleaned = str_replace(',', '', $raw);

        // Extract numeric value
        preg_match('/([\d.]+)/', $cleaned, $matches);
        $value = isset($matches[1]) ? (float) $matches[1] : 0;

        // Extract unit (remove digits, dots, spaces)
        $unit = strtolower(trim(preg_replace('/[\d.\s,]/', '', $cleaned)));

        if (str_contains($unit, 'in')) {
            return round($value, 2); // already inches
        }

        // Convert mm to inches
        return round($value / 25.4, 2);
    }

    public function htmxspinner(Request $request){

        return view('components.frontend.htmx.hmxspinner');
    }


}

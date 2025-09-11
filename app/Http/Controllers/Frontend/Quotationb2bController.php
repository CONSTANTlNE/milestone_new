<?php

namespace App\Http\Controllers\Frontend;

use App\Mail\NewB2bQuotationEmail;
use App\Mail\SendQuotationEmail;
use App\Mail\SendQuotationEmailB2b;
use App\Models\Availability;
use App\Models\Quotationb2b;
use App\Models\QuotationCharge;
use App\Models\User;
use App\Services\TwilioService;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class Quotationb2bController extends Controller
{

    public function index(Request $request)
    {
        $availabilities = Availability::orderBy('created_at', 'desc')->get();
        $users = User::all();
        $q = trim((string)$request->query('q', ''));
        $dateFrom = trim((string)$request->query('date_from', ''));
        $dateTo = trim((string)$request->query('date_to', ''));

        $quotationsQuery = Quotationb2b::with('user')
            ->orderBy('id', 'desc');

        if ($q !== '') {
            $quotationsQuery->where(function ($sub) use ($q) {
                // Numeric exact matches for id and distance
                if (is_numeric($q)) {
                    $sub->orWhere('id', (int)$q)
                        ->orWhere('distance_mile', (float)$q)
                        ->orWhere('body_weight', 'like', "%$q%");
                }
                // Textual partial matches across common columns
                $sub->orWhere('quotation_identifier', 'like', "%$q%")
                    ->orWhere('start_address', 'like', "%$q%")
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

        return view('backend.quotations.b2b_index', compact('availabilities', 'quotations', 'users'));
    }

    public function confirmOtp(Request $request)
    {

        $response = (new TwilioService())->otpConfirm($request);

        if ($response instanceof \Symfony\Component\HttpFoundation\Response) {
            return $response;
        }

        $data = $response->json();

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

    public function storeB2bquotation(Request $request)
    {

        $request->validate([
//            'turnstile'=>'required|string',
            'start' => 'required|array|min:1',
            'start.*' => 'required|string|max:255',
            'destination' => 'required|array|min:1',
            'destination.*' => 'required|string|max:255',
            'start_id_business' => 'required|array|min:1',
            'start_id_business.*' => 'required|string|max:255',
            'destination_id_business' => 'required|array|min:1',
            'destination_id_business.*' => 'required|string|max:255',
            'year' => 'array|min:1',
            'make_text' => 'required|array|min:1',
            'make_text.*' => 'required|string|max:255',
            'model_text' => 'required|array|min:1',
            'model_text.*' => 'required|string|max:255',
            'transport_type' => 'required|array|min:1',
            'transport_type.*' => 'required|string|in:open,closed',
            'operable' => 'required|array|min:1',
            'operable.*' => 'required|string|in:yes,no',
            // qty[] comes from the table, allow array of integers
            'qty' => 'nullable|array',
            'qty.*' => 'nullable|integer|min:1',
            'phone_business' => 'required',
            'email' => 'required|email',
        ]);

        // Build normalized items by aligning related arrays by their index, then sort.
        $starts = $request->input('start', []);
        $destinations = $request->input('destination', []);
        $startIds = $request->input('start_id_business', []);
        $destIds = $request->input('destination_id_business', []);
        $years = $request->input('year', []);
        $makeTexts = $request->input('make_text', []);
        $modelTexts = $request->input('model_text', []);
        $makeIds = $request->input('make_id', []);
        $modelIds = $request->input('model_id', []);
        $transportArr = $request->input('transport_type', []);
        $operableArr = $request->input('operable', []);
        $qtyArr = $request->input('qty', []);

        $count = count($starts);
        $items = [];

        for ($i = 0; $i < $count; $i++) {
            $start = $starts[$i] ?? null;
            $destination = $destinations[$i] ?? null;
            $startId = $startIds[$i] ?? null;
            $destId = $destIds[$i] ?? null;
            $year = $years[$i] ?? '';
            $makeText = $makeTexts[$i] ?? '';
            $modelText = $modelTexts[$i] ?? '';
            $makeId = $makeIds[$i] ?? null;
            $modelId = $modelIds[$i] ?? null;
            $transport = $transportArr[$i] ?? null;
            $operable = $operableArr[$i] ?? null;
            $qty = (int)($qtyArr[$i] ?? 1);
            $qty = $qty > 0 ? $qty : 1;

            $vehicle = trim(($year ? $year . ' ' : '') . $makeText . ' ' . $modelText);

            for ($q = 0; $q < $qty; $q++) {
                $items[] = [
                    'start_address' => $start,
                    'destination_address' => $destination,
                    'start_place_id' => $startId,
                    'destination_place_id' => $destId,
                    'year' => $year,
                    'make_text' => $makeText,
                    'model_text' => $modelText,
                    'make_id' => $makeId,
                    'model_id' => $modelId,
                    'transport_type' => $transport,
                    'operable' => $operable,
                    'vehicle' => $vehicle,
                ];
            }
        }

        // Sort related data to keep similar routes/vehicles together
        usort($items, function ($a, $b) {
            $keys = ['start_address', 'destination_address', 'vehicle', 'transport_type', 'operable'];
            foreach ($keys as $k) {
                $cmp = strcasecmp((string)($a[$k] ?? ''), (string)($b[$k] ?? ''));
                if ($cmp !== 0) return $cmp;
            }
            return 0;
        });

        // Create grouped identifier for this batch
        $identifier = 'B2B-' . now()->format('YmdHis') . '-' . random_int(1000, 9999);

        foreach ($items as $row) {
            $brandId = null;
            $modelId = null;

            // Prefer numeric IDs if provided; otherwise leave null
            if (!empty($row['make_id']) && is_numeric($row['make_id'])) {
                $brandId = (int)$row['make_id'];
            }
            if (!empty($row['model_id']) && is_numeric($row['model_id'])) {
                $modelId = (int)$row['model_id'];
            }

            Quotationb2b::create([
                'quotation_identifier' => $identifier,
                'start_place_id' => $row['start_place_id'],
                'destination_place_id' => $row['destination_place_id'],
                'start_address' => $row['start_address'],
                'destination_address' => $row['destination_address'],
                'transport_type' => $row['transport_type'],
                'vehicle' => $row['vehicle'],
                'car_brand_id' => $brandId,
                'car_model_id' => $modelId,
                'operable' => $row['operable'],
                'email' => $request->input('email'),
                'phone' => $request->input('phone_business'),
                'request_type' => 'business',
            ]);
        }

        $quotations=Quotationb2b::where('quotation_identifier',$identifier)->get();
        $users=User::all();
        foreach ($users as $user){
            if($user->send_quotation==1){
                Mail::to($user->email)
                    ->cc('michael@milestonebrokers.us')
                    ->send(new NewB2bQuotationEmail($quotations->first()->email,$quotations));
                (new TwilioService())->notify($user->phone, 'New B2B quotation received, please check');
            }
        }

        return back()->with('success', 'Your business quotation request has been submitted. We will contact you shortly.');

    }

    public function delete(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:App\Models\Quotationb2b,id',
        ]);

        $quotation = Quotationb2b::find($request->id);
        $quotation->delete();

        return back();
    }

    public function calculateDistance(Request $request)
    {
        $request->validate([
            'quotation_id' => 'required|exists:App\Models\Quotationb2b,id',
        ]);

        $quotation = Quotationb2b::find($request->quotation_id);

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
            'quotation_id' => 'required|exists:App\Models\Quotationb2b,id',
        ]);

        $quotation = Quotationb2b::find($request->quotation_id);

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
        $request->validate(['quotation_id' => 'required|exists:App\Models\Quotationb2b,id']);

        $quotation = Quotationb2b::find($request->quotation_id);

        if (!$quotation->distance_mile) {
            return back()->with('error', 'Please calculate distance');
        }

        if (!$quotation->body_weight) {
            return back()->with('error', 'Please get car specs');
        }

        $chargesArray = [];

        $surcharges = QuotationCharge::where('is_active', 1)->get();
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
        $request->validate(['quotation_id' => 'required|exists:App\Models\Quotationb2b,id']);

        $quotation = Quotationb2b::find($request->quotation_id);
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
        $request->validate(['quotation_id' => 'required|exists:App\Models\Quotationb2b,id']);

        $quotation = Quotationb2b::find($request->quotation_id);
        $existingSurcharges = $quotation->surcharges;

        $existingIds = collect($existingSurcharges)->pluck('id');
        if (!$existingIds->contains($request->surcharge_id)) {
            return back()->with('error', 'Surcharge not found');
        }

        // Filter out the surcharge to be deleted
        $updatedSurcharges = array_filter($existingSurcharges, function ($charge) use ($request) {
            return $charge['id'] != $request->surcharge_id;
        });

        $quotation->surcharges = array_values($updatedSurcharges); // Reset array keys
        $quotation->calculated_cost = collect($updatedSurcharges)->sum('value');
        $quotation->save();

        return back()->with('success', 'Surcharge deleted successfully');

    }

    public function approve(Request $request)
    {
        $request->validate([
            'quotation_id' => 'required|exists:App\Models\Quotationb2b,id',
        ]);

        $quotation = Quotationb2b::find($request->quotation_id);

        if ($quotation->approved == 0) {
            $quotation->approved = 1;
            $quotation->save();
            return back()->with('success', 'Quotation approved successfully');
        } else {
            $quotation->approved = 0;
            $quotation->save();
            return back()->with('success', 'Quotation disapproved');
        }

    }

    public function sendQuotationOffer(Request $request)
    {

        $quotations = Quotationb2b::where('quotation_identifier', $request->identifier)->get();

        if (!$quotations->first()->calculated_cost) {
            return back()->with('error', 'Please calculate cost');
        }

        if ($quotations->first()->email) {
            Mail::to($quotations->first()->email)
                ->cc('michael@milestonebrokers.us')
                    ->send(new SendQuotationEmailB2b($quotations->first()->email, $quotations));

            foreach ($quotations as $quotation) {
                $quotation->quotation_sent = 1;
                $quotation->quotation_sent_date = now();
                $quotation->sent_by_id = auth('web')->user()->id;
                $quotation->save();
            }
        }

        (new TwilioService())->sendQuotationOffert($quotations->first()->phone, 'test');


        return back()->with('success', 'Quotation sent successfully');

    }

    public function notifyUsers(Request $request)
    {
        // Expecting an array of user IDs in 'users2'. If absent, treat as empty.
        $ids = collect($request->input('users', []))
            ->map(function ($v) {
                return (int)$v;
            })
            ->filter(function ($v) {
                return $v > 0;
            })
            ->unique()
            ->values();

        // Set send_quotation = 0 for all users, then enable only for provided IDs
        User::query()->update(['send_b2b_quotation' => 0]);

        if ($ids->isNotEmpty()) {
            User::whereIn('id', $ids)->update(['send_b2b_quotation' => 1]);
        }

        return back()->with('success', 'Notify users list updated successfully.');
    }

    public function htmxspinner(Request $request)
    {
        return view('components.frontend.htmx.hmxspinner');
    }

    /**
     * Export B2B quotations to Excel (CSV format).
     *
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function export(): \Symfony\Component\HttpFoundation\StreamedResponse
    {
        $quotations = Quotationb2b::with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        $filename = 'b2b_quotations_' . date('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($quotations) {
            $file = fopen('php://output', 'w');

            // Add headers
            fputcsv($file, [
                'ID',
                'Date',
                'Unique ID',
                'Request Type',
                'Start Address',
                'End Address',
                'Distance (Miles)',
                'Transportation Type',
                'Operable',
                'Vehicle',
                'Width (inch)',
                'Height (inch)',
                'Length (inch)',
                'Weight (lbs)',
                'Vehicle Type',
                'Vehicle Specs Links',
                'Availability',
                'Email',
                'Phone',
                'SUV',
                'Luxury',
                'Calculated Cost ($)',
                'Quotation Sent Date',
                'Quotation Sent By',
                'Created At',
                'Updated At'
            ]);

            // Add data rows
            foreach ($quotations as $quotation) {
                // Handle specs links array
                $specsLinks = '';
                if ($quotation->specs_links && is_array($quotation->specs_links)) {
                    $specsLinks = implode('; ', $quotation->specs_links);
                }

                fputcsv($file, [
                    $quotation->id,
                    $quotation->created_at ? $quotation->created_at->format('d/m/Y') : '',
                    $quotation->quotation_identifier,
                    $quotation->request_type,
                    $quotation->start_address,
                    $quotation->destination_address,
                    $quotation->distance_mile,
                    $quotation->transport_type,
                    $quotation->operable,
                    $quotation->vehicle,
                    $quotation->width,
                    $quotation->height,
                    $quotation->length,
                    $quotation->body_weight,
                    $quotation->car_type,
                    $specsLinks,
                    $quotation->availability,
                    $quotation->email,
                    $quotation->phone,
                    $quotation->suv ? 'Yes' : 'No',
                    $quotation->luxury ? 'Yes' : 'No',
                    $quotation->calculated_cost ? round($quotation->calculated_cost) : '',
                    $quotation->quotation_sent_date,
                    $quotation->user ? $quotation->user->name : '',
                    $quotation->created_at ? $quotation->created_at->format('Y-m-d H:i:s') : '',
                    $quotation->updated_at ? $quotation->updated_at->format('Y-m-d H:i:s') : ''
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

}

<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\AutoAuction;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AutoAuctionController extends Controller
{
    public function index()
    {
        $page = Page::where('template', 'frontend.pages.auto_auction')->first();
        return view('frontend.pages.auto_auction', compact('page'));
    }

    public function store(Request $request)
    {

        if (config('milestone.CLOUDFLARE_CAPTCHA') == true) {
            $response = Http::asForm()->post('https://challenges.cloudflare.com/turnstile/v0/siteverify', [
                'secret' => config('milestone.CLOUDFLARE_SECRET_KEY'),
                'response' => $request->input('cf-turnstile-response'),
            ]);

            if (! $response->json('success')) {
                return back()->withErrors(['captcha' => 'Captcha failed. Try again.']);
            }
        }

        $validator = Validator::make($request->all(), [
            'legal_business_name' => 'required|string|max:255',
            'dba' => 'nullable|string|max:255',
            'business_type' => 'required|string|max:255',
            'platform_type' => 'required|array|min:1',
            'platform_type.*' => 'in:physical,online,hybrid',
            'years_operation' => 'required|integer|min:0|max:100',
            'website_url' => 'nullable|url|max:255',
            'contact_name' => 'required|string|max:255',
            'contact_title' => 'required|string|max:255',
            'contact_phone' => 'required|string|max:20',
            'contact_email' => 'required|email|max:255',
            'main_address' => 'required|string',
            'multiple_locations' => 'required|in:yes,no',
            'additional_locations' => 'nullable|string',
            'primary_auction_days' => 'required|string|max:255',
            'lot_numbers' => 'required|integer|min:1',
            'inventory_system' => 'required|in:yes,no',
            'vehicles_shipped' => 'nullable|integer|min:1',
            'vehicle_types' => 'required|array|min:1',
            'vehicle_types.*' => 'in:new,used,salvage,luxury,inoperable',
            'transport_type' => 'required|in:open,enclosed',
            'pickup_protocols' => 'required|string',
            'condition_reports' => 'required|in:yes,no',
            'carrier_preloading' => 'required|in:yes,no',
            'billing_contact' => 'required|string|max:255',
            'billing_email' => 'required|email|max:255',
            'payment_method' => 'required|array|min:1',
            'payment_method.*' => 'in:ach,credit_card,check,other',
            'vendor_platforms' => 'nullable|string|max:255',
            'ein_tax_id' => 'required|string|max:255',
            'dealer_license' => 'required|string|max:255',
            'w9_upload' => 'required|file|mimes:pdf,doc,docx|max:10240',
            'insurance_certificate' => 'required|file|mimes:pdf,doc,docx|max:10240',
            'vehicle_list'=> 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'trade_references' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $data = $validator->validated();

            // Handle file uploads
            if ($request->hasFile('w9_upload')) {
                $w9Path = $request->file('w9_upload')->store('auto_auctions/w9', 'public');
                $data['w9_upload'] = $w9Path;
            }

            if ($request->hasFile('insurance_certificate')) {
                $insurancePath = $request->file('insurance_certificate')->store('auto_auctions/insurance', 'public');
                $data['insurance_certificate'] = $insurancePath;
            }

            // Handle optional vehicle list file
            if ($request->hasFile('vehicle_list')) {
                $vehicleListPath = $request->file('vehicle_list')->store('auto_auctions/vehicle_lists', 'public');
                $data['vehicle_list'] = $vehicleListPath;
            }

            // Set default status
            $data['status'] = 'pending';

            // Create the auto auction record
            $autoAuction = AutoAuction::create($data);

            return redirect()->back()->with('success', 'Your auto auction application has been submitted successfully! We will review it and contact you soon.');

        } catch (\Exception $e) {
            return back()->with('error', 'An error occurred while submitting your application. Please try again.')->withInput();
        }
    }
}

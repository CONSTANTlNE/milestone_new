<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\AutoDealer;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AutoDealerController extends Controller
{
    public function index()
    {
        $page = Page::where('template', 'frontend.pages.auto_dealer')->first();
        return view('frontend.pages.auto_dealer', compact('page'));
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
            'years_operation' => 'required|integer|min:0|max:100',
            'website_url' => 'nullable|url|max:255',
            'contact_name' => 'required|string|max:255',
            'contact_title' => 'required|string|max:255',
            'contact_phone' => 'required|string|max:20',
            'contact_email' => 'required|email|max:255',
            'main_address' => 'required|string',
            'multiple_locations' => 'required|in:yes,no',
            'additional_addresses' => 'nullable|string',
            'dealer_license' => 'required|string|max:255',
            'federal_tax_id' => 'required|string|max:255',
            'duns_number' => 'nullable|string|max:255',
            'cars_per_month' => 'required|integer|min:1',
            'vehicle_types' => 'required|array|min:1',
            'vehicle_types.*' => 'in:new,used,luxury,oversized,inoperable',
            'transport_preference' => 'required|in:open,enclosed',
            'delivery_type' => 'required|in:door_to_door,terminal_to_terminal',
            'inventory_contact' => 'nullable|string|max:255',
            'pickup_times' => 'required|string|max:255',
            'delivery_days' => 'required|string|max:255',
            'billing_contact' => 'required|string|max:255',
            'billing_email' => 'required|email|max:255',
            'payment_method' => 'required|in:ach,credit_card,check,other',
            'vendor_platforms' => 'nullable|string|max:255',
            'nda_required' => 'required|in:yes,no',
            'trade_reference' => 'required|in:yes,no',
            'w9_upload' => 'required|file|mimes:pdf,doc,docx|max:10240',
            'insurance_certificate' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $data = $validator->validated();

            // Handle file uploads
            if ($request->hasFile('w9_upload')) {
                $w9Path = $request->file('w9_upload')->store('auto_dealers/w9', 'public');
                $data['w9_upload'] = $w9Path;
            }

            if ($request->hasFile('insurance_certificate')) {
                $insurancePath = $request->file('insurance_certificate')->store('auto_dealers/insurance', 'public');
                $data['insurance_certificate'] = $insurancePath;
            }

            // Set default status
            $data['status'] = 'pending';

            // Create the auto dealer record
            $autoDealer = AutoDealer::create($data);

            return redirect()->back()->with('success', 'Your auto dealer application has been submitted successfully! We will review it and contact you soon.');

        } catch (\Exception $e) {
            return back()->with('error', 'An error occurred while submitting your application. Please try again.')->withInput();
        }
    }
}

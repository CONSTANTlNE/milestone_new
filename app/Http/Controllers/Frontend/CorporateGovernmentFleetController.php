<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\CorporateGovernmentFleet;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CorporateGovernmentFleetController extends Controller
{
    public function index()
    {
        $page = Page::where('template', 'frontend.pages.corporate_government_fleet')->first();
        return view('frontend.pages.corporate_government_fleet', compact('page'));
    }

    public function store(Request $request)
    {
        if (config('milestone.CLOUDFLARE_CAPTCHA') == true) {
            $response = Http::asForm()->post('https://challenges.cloudflare.com/turnstile/v0/siteverify', [
                'secret' => config('milestone.CLOUDFLARE_SECRET_KEY'),
                'response' => $request->input('cf-turnstile-response'),
            ]);

            if (!$response->json('success')) {
                return back()->withErrors(['captcha' => 'Captcha failed. Try again.']);
            }
        }

        $validator = Validator::make($request->all(), [
            'legal_organization_name' => 'required|string|max:255',
            'dba' => 'nullable|string|max:255',
            'business_type' => 'required|in:corporate,government,non_profit',
            'department' => 'nullable|string|max:255',
            'years_operation' => 'required|integer|min:1|max:100',
            'website_url' => 'nullable|url|max:255',
            'contact_name' => 'required|string|max:255',
            'contact_title' => 'required|string|max:255',
            'contact_phone' => 'required|string|max:20',
            'contact_email' => 'required|email|max:255',
//            'fulfillment_address' => 'required|string',
            'fleet_locations' => 'required|integer|min:1',
            'vehicle_release_contact' => 'required|string|max:255',
            'fleet_management_software' => 'nullable|string|max:255',
            'usage_type' => 'required|array|min:1',
            'usage_type.*' => 'in:law_enforcement,utility,passenger,construction,mixed',
            'vehicle_condition' => 'required|in:mostly_new,mostly_used,mixed,varies',
            'vehicles_per_month' => 'required|integer|min:1',
            'transport_type' => 'required|in:open,enclosed',
            'transport_scope' => 'required|in:local,regional,nationwide',
            'security_requirements' => 'nullable|string',
            'pickup_protocols' => 'required|string',
            'special_handling' => 'nullable|string',
            'billing_contact' => 'required|string|max:255',
            'billing_email' => 'required|email|max:255',
            'payment_method' => 'required|in:ach,credit_card,government_po,net_terms',
            'vendor_portal_invoicing' => 'required|in:yes,no',
            'payment_platform' => 'nullable|string|max:255',
//            'government_corporate_id' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'government_corporate_id' => 'required|string|min:1|max:255 ',
            'w9_upload' => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240',
            'insurance_certificate' => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240',
            'purchase_order_format' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
            'references_contractors' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $data = $validator->validated();

            // Handle file uploads
            if ($request->hasFile('government_corporate_id')) {
                $governmentCorporateIdPath = $request->file('government_corporate_id')->store('corporate_fleet_documents', 'public');
                $data['government_corporate_id'] = $governmentCorporateIdPath;
            }

            if ($request->hasFile('w9_upload')) {
                $w9UploadPath = $request->file('w9_upload')->store('corporate_fleet_documents', 'public');
                $data['w9_upload'] = $w9UploadPath;
            }

            if ($request->hasFile('insurance_certificate')) {
                $insuranceCertificatePath = $request->file('insurance_certificate')->store('corporate_fleet_documents', 'public');
                $data['insurance_certificate'] = $insuranceCertificatePath;
            }

            // Handle optional purchase order format file
            if ($request->hasFile('purchase_order_format')) {
                $purchaseOrderFormatPath = $request->file('purchase_order_format')->store('corporate_fleet_documents', 'public');
                $data['purchase_order_format'] = $purchaseOrderFormatPath;
            }

            // Set default status
            $data['status'] = 'pending';

            // Create the corporate government fleet record
            $fleet = CorporateGovernmentFleet::create($data);

            return redirect()->back()->with('success', 'Your Corporate/Government Fleet registration has been submitted successfully! We will review your application and contact you soon.');

        } catch (\Exception $e) {
            return back()->with('error', 'An error occurred while submitting your application. Please try again.')->withInput();
        }
    }
}

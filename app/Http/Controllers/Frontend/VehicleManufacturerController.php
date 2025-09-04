<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\VehicleManufacturer;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class VehicleManufacturerController extends Controller
{
    public function index()
    {
        $page = Page::where('template', 'frontend.pages.vehicle_manufacturers')->first();
        return view('frontend.pages.vehicle_manufacturers', compact('page'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'legal_business_name' => 'required|string|max:255',
            'dba' => 'nullable|string|max:255',
            'business_type' => 'required|in:manufacturer,distributor,oem_partner',
            'years_operation' => 'required|integer|min:0|max:100',
            'website_url' => 'nullable|url|max:255',
            'us_office_location' => 'nullable|string|max:255',
            'contact_name' => 'required|string|max:255',
            'contact_title' => 'required|string|max:255',
            'contact_phone' => 'required|string|max:20',
            'contact_email' => 'required|email|max:255',
            'primary_port_factory' => 'required|string',
            'us_distribution_centers' => 'required|string',
            'delivery_frequency' => 'required|in:daily,weekly,monthly,varies',
            'monthly_volume' => 'required|integer|min:1',
            'vin_batching_format' => 'nullable|string|max:255',
            'new_car_prep' => 'required|string',
            'transport_type' => 'required|in:open,enclosed',
            'vehicle_types' => 'required|array|min:1',
            'vehicle_types.*' => 'in:new,ev,high_end,fleet,prototypes',
            'load_prep_protocols' => 'required|string',
            'special_handling' => 'nullable|string',
            'delivery_destinations' => 'required|string',
            'compliance_procedures' => 'nullable|string',
            'billing_contact' => 'required|string|max:255',
            'billing_email' => 'required|email|max:255',
            'payment_method' => 'required|array|min:1',
            'payment_method.*' => 'in:ach,credit_card,government_po,net_terms',
            'vendor_management_system' => 'required|in:yes,no',
            'system_name' => 'nullable|string|max:255',
            'w9_upload' => 'required|file|mimes:pdf,doc,docx|max:10240',
            'insurance_certificate' => 'required|file|mimes:pdf,doc,docx|max:10240',
            'business_registration' => 'required|file|mimes:pdf,doc,docx|max:10240',
            'trade_references' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $data = $validator->validated();

            // Handle file uploads
            if ($request->hasFile('w9_upload')) {
                $w9Path = $request->file('w9_upload')->store('vehicle_manufacturers/w9', 'public');
                $data['w9_upload'] = $w9Path;
            }

            if ($request->hasFile('insurance_certificate')) {
                $insurancePath = $request->file('insurance_certificate')->store('vehicle_manufacturers/insurance', 'public');
                $data['insurance_certificate'] = $insurancePath;
            }

            if ($request->hasFile('business_registration')) {
                $businessRegPath = $request->file('business_registration')->store('vehicle_manufacturers/business_registration', 'public');
                $data['business_registration'] = $businessRegPath;
            }

            // Set default status
            $data['status'] = 'pending';

            // Create the vehicle manufacturer record
            $vehicleManufacturer = VehicleManufacturer::create($data);

            return redirect()->back()->with('success', 'Your vehicle manufacturer application has been submitted successfully! We will review it and contact you soon.');

        } catch (\Exception $e) {
            return back()->with('error', 'An error occurred while submitting your application. Please try again.')->withInput();
        }
    }
}

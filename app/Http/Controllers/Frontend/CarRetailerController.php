<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\CarRetailer;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CarRetailerController extends Controller
{
    public function index()
    {
        $page = Page::where('template', 'frontend.pages.car_retailer')->first();
        return view('frontend.pages.car_retailer', compact('page'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'legal_business_name' => 'required|string|max:255',
            'dba' => 'nullable|string|max:255',
            'business_type' => 'required|string|max:255',
            'platform_type' => 'required|array|min:1',
            'platform_type.*' => 'in:marketplace,direct_seller,hybrid,other',
            'years_operation' => 'required|integer|min:0|max:100',
            'website_url' => 'nullable|url|max:255',
            'contact_name' => 'required|string|max:255',
            'contact_title' => 'required|string|max:255',
            'contact_phone' => 'required|string|max:20',
            'contact_email' => 'required|email|max:255',
            'fulfillment_address' => 'required|string',
            'multiple_warehouses' => 'required|in:yes,no',
            'shipping_nodes' => 'nullable|string',
            'inventory_api_access' => 'required|in:yes,no',
            'api_url_docs' => 'nullable|string|max:255',
            'vehicle_list' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:10240',
            'cars_shipped' => 'required|integer|min:1',
            'vehicle_types' => 'required|array|min:1',
            'vehicle_types.*' => 'in:new,used,evs,luxury,oversized',
            'transport_type' => 'required|in:open,enclosed',
            'preferred_delivery' => 'required|in:door_to_door,terminal_to_terminal',
            'unattended_pickup' => 'required|in:yes,no',
            'billing_contact' => 'required|string|max:255',
            'billing_email' => 'required|email|max:255',
            'payment_method' => 'required|in:ach,credit_card,check,other',
            'vendor_platforms' => 'nullable|string|max:255',
            'ein_tax_id' => 'required|string|max:255',
            'trade_references' => 'nullable|string',
            'w9_upload' => 'required|file|mimes:pdf,doc,docx|max:10240',
            'insurance_certificate' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'nda_required' => 'required|in:yes,no',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $data = $validator->validated();

            // Handle file uploads
            if ($request->hasFile('w9_upload')) {
                $w9Path = $request->file('w9_upload')->store('car_retailers/w9', 'public');
                $data['w9_upload'] = $w9Path;
            }

            if ($request->hasFile('insurance_certificate')) {
                $insurancePath = $request->file('insurance_certificate')->store('car_retailers/insurance', 'public');
                $data['insurance_certificate'] = $insurancePath;
            }

            // Handle optional vehicle list file
            if ($request->hasFile('vehicle_list')) {
                $vehicleListPath = $request->file('vehicle_list')->store('car_retailers/vehicle_lists', 'public');
                $data['vehicle_list'] = $vehicleListPath;
            }

            // Set default status
            $data['status'] = 'pending';

            // Create the car retailer record
            $carRetailer = CarRetailer::create($data);

            return redirect()->back()->with('success', 'Your car retailer application has been submitted successfully! We will review it and contact you soon.');

        } catch (\Exception $e) {
            return back()->with('error', 'An error occurred while submitting your application. Please try again.')->withInput();
        }
    }
}

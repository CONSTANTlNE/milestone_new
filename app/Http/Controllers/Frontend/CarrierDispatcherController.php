<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Mail\NewCarrierDispatcherEmail;
use App\Models\CarrierDispatcher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CarrierDispatcherController extends Controller
{
    public function store(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'mc_number' => 'required|string|max:20',
            'dot_number' => 'required|string|max:20',
            'cars_under_management' => 'required|integer|min:1|max:10000',
            'website_url' => 'nullable|url|max:255',
            'presentation_file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:10240',
            'vehicle_list_file' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'legal_business_name' => 'required|string|max:255',
            'dba' => 'nullable|string|max:255',
            'business_type' => 'required|string|max:100',
            'years_operation' => 'required|integer|min:0|max:100',
            'contact_name' => 'required|string|max:255',
            'contact_title' => 'required|string|max:255',
            'contact_phone' => 'required|string|max:20',
            'contact_email' => 'required|email|max:255',
            'main_address' => 'required|string|max:1000',
            'multiple_locations' => 'required|in:yes,no',
            'additional_addresses' => 'nullable|string|max:1000',
            'billing_contact' => 'required|string|max:255',
            'billing_email' => 'required|email|max:255',
            'payment_method' => 'required|array|min:1',
            'payment_method.*' => 'in:ach,credit_card,check,other',
            'nda_required' => 'required|in:yes,no',
            'w9_upload' => 'required|file|mimes:pdf,doc,docx|max:10240',
            'insurance_certificate' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
        ], [
            'mc_number.required' => 'MC Number is required.',
            'dot_number.required' => 'DOT Number is required.',
            'cars_under_management.required' => 'Number of cars under management is required.',
            'cars_under_management.integer' => 'Number of cars must be a whole number.',
            'legal_business_name.required' => 'Legal business name is required.',
            'business_type.required' => 'Business type is required.',
            'years_operation.required' => 'Years in operation is required.',
            'contact_name.required' => 'Contact name is required.',
            'contact_title.required' => 'Contact title is required.',
            'contact_phone.required' => 'Contact phone is required.',
            'contact_email.required' => 'Contact email is required.',
            'contact_email.email' => 'Please enter a valid email address.',
            'main_address.required' => 'Main business address is required.',
            'multiple_locations.required' => 'Please specify if you have multiple locations.',
            'billing_contact.required' => 'Billing contact is required.',
            'billing_email.required' => 'Billing email is required.',
            'billing_email.email' => 'Please enter a valid billing email address.',
            'payment_method.required' => 'Please select at least one payment method.',
            'nda_required.required' => 'Please specify if NDA is required.',
            'w9_upload.required' => 'W-9 form upload is required.',
            'presentation_file.mimes' => 'Presentation file must be PDF, DOC, DOCX, or Excel format.',
            'vehicle_list_file.mimes' => 'Vehicle list file must be PDF, DOC, or DOCX format.',
            'w9_upload.mimes' => 'W-9 form must be PDF, DOC, or DOCX format.',
            'insurance_certificate.mimes' => 'Insurance certificate must be PDF, DOC, or DOCX format.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Handle file uploads
            $presentationFile = null;
            $vehicleListFile = null;
            $w9File = null;
            $insuranceFile = null;

            if ($request->hasFile('presentation_file')) {
                $presentationFile = $request->file('presentation_file')->store('carrier_dispatchers/presentations', 'public');
            }

            if ($request->hasFile('vehicle_list_file')) {
                $vehicleListFile = $request->file('vehicle_list_file')->store('carrier_dispatchers/vehicle_lists', 'public');
            }

            if ($request->hasFile('w9_upload')) {
                $w9File = $request->file('w9_upload')->store('carrier_dispatchers/w9_forms', 'public');
            }

            if ($request->hasFile('insurance_certificate')) {
                $insuranceFile = $request->file('insurance_certificate')->store('carrier_dispatchers/insurance', 'public');
            }

            // Create the carrier dispatcher record
            $carrierDispatcher = CarrierDispatcher::create([
                'mc_number' => $request->mc_number,
                'dot_number' => $request->dot_number,
                'cars_under_management' => $request->cars_under_management,
                'website_url' => $request->website_url,
                'presentation_file' => $presentationFile,
                'vehicle_list_file' => $vehicleListFile,
                'legal_business_name' => $request->legal_business_name,
                'dba' => $request->dba,
                'business_type' => $request->business_type,
                'years_operation' => $request->years_operation,
                'contact_name' => $request->contact_name,
                'contact_title' => $request->contact_title,
                'contact_phone' => $request->contact_phone,
                'contact_email' => $request->contact_email,
                'main_address' => $request->main_address,
                'multiple_locations' => $request->multiple_locations,
                'additional_addresses' => $request->additional_addresses,
                'billing_contact' => $request->billing_contact,
                'billing_email' => $request->billing_email,
                'payment_method' => $request->payment_method,
                'nda_required' => $request->nda_required,
                'w9_upload' => $w9File,
                'insurance_certificate' => $insuranceFile,
            ]);

            // Send notification email to admin
            try {
                $adminEmail = config('mail.admin_email', 'admin@milestonebrokers.com');
                Mail::to($adminEmail)->send(new NewCarrierDispatcherEmail($carrierDispatcher));
            } catch (\Exception $e) {
                // Log the email error but don't fail the application submission
                \Log::error('Failed to send carrier dispatcher notification email: ' . $e->getMessage());
            }

            return redirect()->back()
                ->with('success', 'Thank you! Your application has been submitted successfully. We will review your information and contact you soon.');

        } catch (\Exception $e) {
            // Clean up uploaded files if database insertion fails
            if ($presentationFile) Storage::disk('public')->delete($presentationFile);
            if ($vehicleListFile) Storage::disk('public')->delete($vehicleListFile);
            if ($w9File) Storage::disk('public')->delete($w9File);
            if ($insuranceFile) Storage::disk('public')->delete($insuranceFile);

            return redirect()->back()
                ->with('error', 'Sorry, there was an error submitting your application. Please try again.')
                ->withInput();
        }
    }
}

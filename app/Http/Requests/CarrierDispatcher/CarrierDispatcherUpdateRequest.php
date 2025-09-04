<?php

namespace App\Http\Requests\CarrierDispatcher;

use Illuminate\Foundation\Http\FormRequest;

class CarrierDispatcherUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'legal_business_name' => 'nullable|string|max:255',
            'dba' => 'nullable|string|max:255',
            'business_type' => 'nullable|string|max:255',
            'years_operation' => 'nullable|integer|min:0',
            'contact_name' => 'nullable|string|max:255',
            'contact_title' => 'nullable|string|max:255',
            'contact_phone' => 'nullable|string|max:20',
            'contact_email' => 'nullable|email|max:255',
            'main_address' => 'nullable|string',
            'multiple_locations' => 'nullable|boolean',
            'additional_addresses' => 'nullable|string',
            'billing_contact' => 'nullable|string|max:255',
            'billing_email' => 'nullable|email|max:255',
            'payment_method' => 'nullable|array',
            'nda_required' => 'nullable|boolean',
            'status' => 'nullable|string|in:pending,approved,rejected',
            'admin_notes' => 'nullable|string',
        ];
    }
}

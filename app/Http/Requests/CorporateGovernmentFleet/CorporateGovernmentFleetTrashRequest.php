<?php

namespace App\Http\Requests\CorporateGovernmentFleet;

use Illuminate\Foundation\Http\FormRequest;

class CorporateGovernmentFleetTrashRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'search' => ['nullable', 'string'],
            'status' => ['nullable', 'string', 'in:pending,approved,rejected'],
            'business_type' => ['nullable', 'string', 'in:corporate,government,non_profit'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
        ];
    }
}

<?php

namespace App\Http\Requests\Portfolio;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PortfolioChangeStatusRequest extends FormRequest
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
            'id' => ['required', 'integer', 'exists:portfolios,id'],
            'status' => ['required', 'integer', Rule::in([0, 1])]
        ];
    }

    /**
     * Get custom error messages for validation rules.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'id.required' => 'Page ID is required.',
            'id.integer' => 'Page ID must be a number.',
            'id.exists' => 'Page not found.',
            'status.required' => 'Status is required.',
            'status.integer' => 'Status must be a number.',
            'status.in' => 'Status must be either 0 or 1.',
        ];
    }

    /**
     * Get custom attributes for validation rules.
     *
     * @return array
     */
    public function attributes(): array
    {
        return [
            'id' => 'page ID',
            'status' => 'status',
        ];
    }
}

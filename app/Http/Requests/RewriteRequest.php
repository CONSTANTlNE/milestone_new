<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RewriteRequest extends FormRequest
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
            'firstId' => ['integer', 'required', 'not_in:0'],
            'secondId' => ['integer', 'required', 'not_in:0']
        ];
    }

    public function messages(): array
    {
        return [
            'firstId.not_in' => 'The first ID cannot be zero.',
            'secondId.not_in' => 'The second ID cannot be zero.'
        ];
    }
}

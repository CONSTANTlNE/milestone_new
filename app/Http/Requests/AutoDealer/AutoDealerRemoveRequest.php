<?php

namespace App\Http\Requests\AutoDealer;

use Illuminate\Foundation\Http\FormRequest;

class AutoDealerRemoveRequest extends FormRequest
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
            'id' => ['required', 'integer', 'exists:auto_dealers,id'],
        ];
    }
}

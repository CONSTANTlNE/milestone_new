<?php

namespace App\Http\Requests\Locale;

use Illuminate\Foundation\Http\FormRequest;

class LocaleTrashRequest extends FormRequest
{
    public function authorize(): true
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'search'         => ['nullable', 'string'],
            'status'         => ['nullable', 'string'],
            'sort_column'    => ['nullable', 'string'],
            'sort_direction' => ['nullable', 'in:asc,desc'],
            'per_page'       => ['nullable', 'integer', 'min:1', 'max:50'],
        ];
    }
}

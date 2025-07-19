<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UserIndexRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Adjust as needed for your auth logic
    }

    public function rules()
    {
        return [
            'search'         => ['nullable', 'string'],
            'status'         => ['nullable', 'string'],
            'sort_column'    => ['nullable', 'string'],
            'sort_direction' => ['nullable', 'in:asc,desc'],
            'per_page'       => ['nullable', 'integer', 'min:1', 'max:100'],
        ];
    }
}

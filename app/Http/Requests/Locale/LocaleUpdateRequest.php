<?php

namespace App\Http\Requests\Locale;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LocaleUpdateRequest extends FormRequest
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
        'status' => ['required', 'string'],
        'title' => ['required', 'string'],
        'published_at' => ['nullable'],
        'images' => ['array'],
        'mainImage_id' => ['integer'],
        'cover' => ['array'],
    ];
  }
}


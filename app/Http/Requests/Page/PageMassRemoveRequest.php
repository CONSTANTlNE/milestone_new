<?php

namespace App\Http\Requests\Page;
use Illuminate\Foundation\Http\FormRequest;

class PageMassRemoveRequest extends FormRequest
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
          'ids' => ['required', 'array'],
          'ids.*' => ['exists:pages,id'], // Validate that all ids exist in the pages table
      ];
  }
}

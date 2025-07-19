<?php

namespace App\Http\Requests\Faq;
use App\Rules\IsTrashedRule;
use Illuminate\Foundation\Http\FormRequest;

class FaqRestoreRequest extends FormRequest
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
        'id' => ['required', 'integer', 'exists:faqs,id']
    ];
  }
}


<?php

namespace App\Http\Requests\ServiceCategory;
use App\Rules\IsTrashedRule;
use Illuminate\Foundation\Http\FormRequest;

class ServiceCategoryRestoreRequest extends FormRequest
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
        'id' => ['required', 'integer', 'exists:service_categories,id']
    ];
  }
}


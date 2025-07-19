<?php

namespace App\Http\Requests\BlogCategory;
use App\Rules\IsTrashedRule;
use Illuminate\Foundation\Http\FormRequest;

class BlogCategoryRestoreRequest extends FormRequest
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
        'id' => ['required', 'integer', 'exists:blog_categories,id']
    ];
  }
}


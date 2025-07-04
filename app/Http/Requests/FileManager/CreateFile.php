<?php

namespace App\Http\Requests\FileManager;

use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\NoReturn;

class CreateFile extends FormRequest
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
      'files' => 'array',
      'files.*' => 'file',
      'upload_behaviour' => 'string|required|in:default,related'
    ];
  }
}

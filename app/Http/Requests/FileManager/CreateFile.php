<?php

namespace App\Http\Requests\FileManager;

use Illuminate\Foundation\Http\FormRequest;

class CreateFile extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize()
  {
    return true;
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
      'files' => 'array',
      'files.*' => 'file',
      'upload_behaviour' => 'string|required|in:default,related'
    ];
  }
}

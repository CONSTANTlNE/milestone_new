<?php

namespace App\Http\Requests\FileManager;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFile extends FormRequest
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
      'title' => 'required|string',
      'caption' => 'string|nullable',
//      'video_link' => 'string|nullable|max:255',
//      'video_id' => 'string|nullable|max:255',
      'type' => 'string|max:255',
      'crop' => 'json|nullable'
    ];
  }
}

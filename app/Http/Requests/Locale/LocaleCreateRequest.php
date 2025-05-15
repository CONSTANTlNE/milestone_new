<?php

namespace App\Http\Requests\Locale;
use Illuminate\Foundation\Http\FormRequest;

class LocaleCreateRequest extends FormRequest
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
        'name' => ['required', 'string'],
        'code' => ['required', 'string', 'unique:locales,code'],
        'images' => ['array'],
        'mainImage_id' => ['integer'],
        'cover' => ['array'],
    ];
  }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'status.required' => __('messages.error_status'),
            'status.string' => __('messages.error_status_boolean'),

            'name' => __('strings.Error Language Name'),

            'code' => __('strings.Error Unique Language Code'),

            'images.array' => __('messages.error_images_array'),

            'mainImage_id.integer' => __('messages.error_mainImage_id_integer'),

            'cover.array' => __('messages.error_cover_array'),
            'cover.*' => __('messages.error_cover_boolean'),

        ];
    }
}


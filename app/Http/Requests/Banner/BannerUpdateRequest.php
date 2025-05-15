<?php

namespace App\Http\Requests\Banner;
use App\Rules\NonEmptyTitleArray;
use Illuminate\Foundation\Http\FormRequest;

class BannerUpdateRequest extends FormRequest
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
            'zone' => ['required', 'integer', 'not_in:0'],
            'url' => ['url'],
            'title' => ['array', new NonEmptyTitleArray],
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

            'zone.required' => __('messages.error_zone'),
            'zone.integer' => __('messages.error_zone_integer'),
            'zone.not_in' => __('messages.error_zoe_boolean'),

            'url.url' =>  __('messages.error_url_url'),

            'title.array' => __('messages.error_title_array'),
            'title.*' => __('messages.error_title_string'),

            'images.array' => __('messages.error_images_array'),

            'mainImage_id.integer' => __('messages.error_mainImage_id_integer'),

            'cover.array' => __('messages.error_cover_array'),
            'cover.*' => __('messages.error_cover_boolean'),
        ];
    }
}

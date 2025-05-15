<?php

namespace App\Http\Requests\User;
use App\Rules\NonEmptyTitleArray;
use Illuminate\Foundation\Http\FormRequest;

class UserCreateRequest extends FormRequest
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
            'title' => ['array', new NonEmptyTitleArray],
            'about' => ['array', new NonEmptyTitleArray],
            'email' => ['required', 'string', 'unique:users,email'],
            'password' => ['required', 'string', 'min:5', 'confirmed'],
            'password_confirmation' => ['required', 'string', 'min:5'],
            'role' => ['required', 'integer', 'exists:roles,id'],
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

            'parent_id.exists' => __('messages.error_parent_id_exists'),

            'title.array' => __('messages.error_title_array'),
            'title.*' => __('messages.error_title_string'),

            'slogan.array' => __('messages.error_slogan_array'),

            'content.array' => __('messages.error_content_array'),

            'seoTitles.array' =>  __('messages.error_seoTitles_array'),
            'seoTitles.*' => __('messages.error_seoTitles_string'),

            'seoKeywords.array' => __('messages.error_seoKeywords_array'),
            'seoKeywords.*' => __('messages.error_seoKeywords_string'),

            'seoDescriptions.array' => __('messages.error_seoDescriptions_array'),
            'seoDescriptions.*' => __('messages.error_seoDescriptions_string'),

            'images.array' => __('messages.error_images_array'),

            'mainImage_id.integer' => __('messages.error_mainImage_id_integer'),

            'cover.array' => __('messages.error_cover_array'),
            'cover.*' => __('messages.error_cover_boolean'),
        ];
    }

}

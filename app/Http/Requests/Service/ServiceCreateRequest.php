<?php

namespace App\Http\Requests\Service;
use App\Rules\NonEmptyTitleArray;
use Illuminate\Foundation\Http\FormRequest;

class ServiceCreateRequest extends FormRequest
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
        $rules = [
            'status' => ['required', 'string'],
            'published_at' => ['nullable'],
            'title' => ['array', new NonEmptyTitleArray],
            'category' => ['array'],
            'slogan' => ['array'],
            'content' => ['array'],
            'seoTitles' => ['array'],
            'seoKeywords' => ['array'],
            'seoDescriptions' => ['array'],
            'images' => ['array'],
            'mainImage_id' => ['integer'],
            'cover' => ['array'],
        ];

        $locales = array_keys(json_decode(file_get_contents(lang_path('config_locales.json')), true));
        foreach ($locales as $locale) {
            $rules["faq_question_{$locale}"] = ['nullable', 'array'];
            $rules["faq_answer_{$locale}"] = ['nullable', 'array'];
            $rules["service_feature_name_{$locale}"] = ['nullable', 'array'];
        }

        return $rules;
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

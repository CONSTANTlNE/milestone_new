<?php

namespace App\Http\Requests\Verdict;
use App\Rules\NonEmptyTitleArray;
use Illuminate\Foundation\Http\FormRequest;

class VerdictCreateRequest extends FormRequest
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
            //'parent_id' => ['nullable', 'integer', 'exists:verdicts,id'],
            'parent_id' => ['nullable', 'integer'],
            'color' => ['nullable', 'integer'],
            'colorCode' => ['required', 'string'],
            'title' => ['array', new NonEmptyTitleArray],
            'slogan' => ['array'],
            'seoTitles' => ['array'],
            'seoKeywords' => ['array'],
            'seoDescriptions' => ['array']
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

            'parent_id.integer' => __('messages.error_parent_id_integer_verdict'),
            'parent_id.exists' => __('messages.error_parent_id_invalid_verdict'),

            'title.array' => __('messages.error_title_array'),
            'title.*' => __('messages.error_title_string'),

            'slogan.array' => __('messages.error_content_array'),

            'seoTitles.array' =>  __('messages.error_seoTitles_array'),
            'seoTitles.*' => __('messages.error_seoTitles_string'),

            'seoKeywords.array' => __('messages.error_seoKeywords_array'),
            'seoKeywords.*' => __('messages.error_seoKeywords_string'),

            'seoDescriptions.array' => __('messages.error_seoDescriptions_array'),
            'seoDescriptions.*' => __('messages.error_seoDescriptions_string'),
        ];
    }

}

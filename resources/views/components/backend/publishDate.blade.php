@props([
    'data' => array(),
    'column' => 'name',
    'label' => 'title',
    'success-text' => 'success_field',
    'help-text' => 'error_field',
    'required' => false,
    'disabled' => false,
    'hidden' => false,
    'width' => 12,
    'choose' => ''
])
<div class="publish-date md:col-span-{{$width}} sm:col-span-12 col-span-12 mb-3">
    <label for="validationTip{{$column}}"
           class="block text-sm text-gray-600 font-medium dark:text-white font-second-geo mb-1">
        {{ __('admin.'.$label) }}
    </label>
    <input type="datetime-local"
           class="form-control"
           id="validationTip{{$column}}"
           name="{{ $column }}"
           @if(!empty($data)) value="{{ $data }}" @endif>
</div>

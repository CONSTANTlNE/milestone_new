@props([
    'data' => array(),
    'column' => 'name',
    'label' => 'title',
    'success-text' => 'success_field',
    'help-text' => 'error_field',
    'required' => false,
    'disabled' => false,
    'hidden' => 'show-search',
    'width' => 12,
    'choose' => '',
    'chooseOption' => '',
    'firstSelect' => 'select'
])
<div class="md:col-span-{{$width}} sm:col-span-12 col-span-12 space-input mb-3">
    <div class="select-static {{$hidden}} font-second-geo">
        <label for="validationTip{{$label}}"
               class="block text-sm text-gray-600 font-medium dark:text-white font-second-geo mb-1"
               @if($disabled) disabled @endif>
            {{ __('admin.'.$label) }}
        </label>
        <select class="form-control w-full !rounded-md js-choices"
                name="{{ $column }}"
                id="validationTip{{$label}}"
                @if($disabled) disabled @endif>

        @if(!empty($choose) and !empty($chooseOption))
            <option value="{{$chooseOption}}">{{ __('admin.selected') }} - {{$choose}}</option>
        @else
            <option value="">{{ __('admin.'.$firstSelect) }}</option>
        @endif
        @foreach($data as $route)
            <option value="{{ $route }}">
                {{ str_replace('.', '/', $route) }}
            </option>
        @endforeach
        </select>
    </div>
</div>

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
    'chooseOption' => ''
])
<div class="md:col-span-{{$width}} sm:col-span-12 col-span-12 space-input">
    <div class="select-static {{$hidden}} font-second-geo">
        <label for="validationTip{{$column}}"
               class="block text-sm text-gray-600 font-medium dark:text-white font-second-geo mb-1"
               @if($disabled) disabled @endif>
            {{ __('admin.'.$label) }}
        </label>
        <select class="form-control w-full !rounded-md js-choices"
                name="{{ $column }}"
                id="validationTip{{$column}}"
                @if($disabled) disabled @endif>

            @if($column == 'status' or $column == 'has_backend_access')
                @if(!empty($choose))
                    <option value="{{$choose}}">{{ __('admin.selected') }} - {{__('admin.active')}}</option>
                @else
                    <option value="0">{{ __('admin.selected') }} - {{ __('admin.disable')  }}</option>
                @endif
            @else
                @if(!empty($chooseOption))
                    <option value="{{$chooseOption}}">{{ __('admin.selected') }} - {{$choose}}</option>
                @endif
            @endif

            @foreach($data as $item)
                @php
                    $value = $item['id'];
                    $labelText =$item['title'];
                @endphp
                <option value="{{ $value }}">
                    {{ __($labelText) }}
                </option>
            @endforeach
        </select>
    </div>
</div>

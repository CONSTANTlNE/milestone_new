{{--        <label for="validationTip{{$type}}{{$title}}"--}}
{{--               class="block text-sm text-gray-600 font-medium dark:text-white font-second-geo">--}}
{{--            {{ __('admin.'.$label) }}--}}
{{--            @if ($required)--}}
{{--                <span class="text-danger">*</span>--}}
{{--            @endif--}}
{{--        </label>--}}
{{--        <div class="flex rounded-sm">--}}
{{--            <span class="px-4 inline-flex items-center min-w-fit rounded-s-sm border-e-0 border-gray-200 bg-light text-sm text-gray-600 dark:bg-black/20 dark:border-white/10 dark:text-[#8c9097] dark:text-white/50 font-second-geo">{{ empty($lang["name"]) ? __('admin.no_lang') : $lang["name"] }}</span>--}}
{{--            <input id="validationTip{{$type}}{{$title}}"--}}
{{--                   type="{{$type}}"--}}
{{--                   name="{{$title}}"--}}
{{--                   value="{{$value}}"--}}
{{--                   @if($placeHolder) placeholder="{{ __('admin.'.$placeHolder) }}" @endif--}}
{{--                   class="py-2 px-3 ti-form-input rounded-none rounded-e-sm focus:z-10 !border-s-0 font-second-geo @if($disabled) disabled @endif"--}}
{{--                   @if($required) required @endif--}}
{{--                   @if($disabled) disabled @endif--}}
{{--                   @if($type == "password") autocomplete="on" @endif--}}
{{--            />--}}
{{--        </div>--}}
<div class="md:col-span-{{$width}} sm:col-span-12 col-span-12 space-input">
    <div class="show-search-hidden font-second-geo">
        <label for="validationTip{{$title}}"
               class="block text-sm text-gray-600 font-medium dark:text-white font-second-geo"
               @if($disabled) disabled @endif>
            {{ __('admin.'.$label) }}
        </label>
        <select class="form-control w-full !rounded-md js-choices"
                name="{{ $title }}"
                id="validationTip{{$title}}"
                @if($disabled) disabled @endif>
            @foreach($data as $item)
                @php
                    $value = $item['id'];
                    $labelText =$item['title'];
                @endphp
                <option value="{{ $value }}" {{ old($title) == $value ? 'selected' : '' }}>
                    {{ __($labelText) }}
                </option>
            @endforeach
        </select>
    </div>
</div>
{{--.box-show-number .show-number--}}

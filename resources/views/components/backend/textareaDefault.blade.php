<div class="md:col-span-{{$width}} sm:col-span-12 col-span-12 space-input">
    <div>
        <label for="validationTip{{$title}}"
               class="block text-sm text-gray-600 font-medium dark:text-white font-second-geo">
            {{ __('admin.'.$label) }}
            @if ($required)
                <span class="text-danger">*</span>
            @endif
        </label>
        <div class="flex rounded-sm">
            <span class="px-4 inline-flex items-center min-w-fit rounded-s-sm border-e-0 border-gray-200 bg-light text-sm text-gray-600 dark:bg-black/20 dark:border-white/10 dark:text-[#8c9097] dark:text-white/50 font-second-geo">{{ empty($lang["title"]) ? __('admin.no_lang') : $lang["title"] }}</span>
            <textarea id="validationTip{{$title}}"
                   name="{{$title}}"
                   @if($placeHolder) placeholder="{{ __('admin.'.$placeHolder) }}" @endif
                   @if($disabled) disabled @endif
                   @if($required) required @endif
                   class="py-2 px-3 ti-form-input rounded-none rounded-e-sm focus:z-10 !border-s-0 font-second-geo" rows="1" style="height: 130px;">
                {{$value ?? ''}}
            </textarea>
        </div>
    </div>
</div>

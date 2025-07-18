@props(['lang', 'code', 'title', 'label', 'placeHolder', 'required', 'disabled', 'value'])

<div id class="grid grid-cols-12 gap-6">
    <div class="xl:col-span-12 col-span-12">
        <div class="form-group">
            <label for="content-{{$code}}" class="block text-sm text-gray-600 font-medium dark:text-white font-second-geo">
                {{ __('admin.'.$label) }}
                @if ($required)
                    <span class="text-danger">*</span>
                @endif

                - ({{ empty(data_get($lang, 'title')) ? __('admin.no_lang') : data_get($lang, 'title') }})
            </label>
            <textarea
                id="content-{{$code}}"
                name="content[{{$code}}]"
                class="py-2 px-3 ti-form-input rounded-e-sm focus:z-10 !border-s-0 font-second-geo"
                data-quill
                data-lang="{{$code}}"
                data-quill-options='{
                    "placeholder": "{{ __("admin.start_writing") }}",
                    "modules": {
                        "toolbar": {
                            "container": [
                                [{ "header": [1, 2, 3, 4, 5, 6, false] }],
                                ["bold", "italic", "underline", "strike"],
                                [{ "color": [] }, { "background": [] }],
                                [{ "list": "ordered"}, { "list": "bullet" }],
                                [{ "indent": "-1"}, { "indent": "+1" }],
                                [{ "align": [] }],
                                ["link", "image", "video"],
                                ["code-block", "blockquote"],
                                ["clean", "textonly", "wordcount", "fullscreen", "save", "print"]
                            ]
                        }
                    }
                }'
                @if($placeHolder) placeholder="{{ __('admin.'.$placeHolder) }}" @endif
                @if($disabled) disabled @endif
                @if($required) required @endif
            >{{ $value ?? '' }}</textarea>
            @error("content.{$code}")
            <span class="text-danger text-sm">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>

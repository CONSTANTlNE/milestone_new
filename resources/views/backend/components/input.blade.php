<div class="col-md-{{ $width }}">
    <div class="form-group position-relative">
        <label class="font-w600" @if($required) for="validationTip{{$type}}{{$title}}" @endif>
            {{ __('strings.'.$label) }} {{ empty($lang["name"]) ? '' : '- ('.$lang["name"].')' }}
        </label>
        <input
            type="{{ $type }}"
            class="form-control @if($disabled) disabled @endif"
            name="{{ $title }}"
            value="{{ $value }}"
            @if($placeHolder) placeholder="{{ __('strings.'.$placeHolder) }}" @endif
            @if($required)   id="validationTip{{$type}}{{$title}}"  required @endif
            @if($disabled)  disabled @endif
            @if($type == "password") autocomplete="on" @endif
        />
        @if($helpText && $successText && $required)
            <div class="valid-tooltip">
                {{ __('strings.'.$successText) }}
            </div>
            <div class="invalid-tooltip">
                {{ __('strings.'.$helpText) }}
            </div>
        @endif
        {{-- @include('backend.layouts.components.error', ['name' => $title]) --}}
    </div>
</div>

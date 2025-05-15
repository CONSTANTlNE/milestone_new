<div class="col-md-{{ $width }}">
    <div class="form-group">
        <div class="custom-control custom-checkbox">
            <input
                type="checkbox"
                class="custom-control-input @if($disabled) disabled @endif"
                name="{{ $title }}"
                value="{{ $value }}"
                @if($required) id="validationTipcheckbox{{$title}}"  required @endif
            />
            <label class="custom-control-label font-w600"
                   @if($required) for="validationTipcheckbox{{$title}}" @endif
                   @if($disabled)  disabled @endif>
                {{ __('strings.'.$label) }} {{ empty($lang["name"]) ? '' : '- ('.$lang["name"].')' }}
            </label>
            @if($helpText && $successText && $required)
                <div class="valid-tooltip">
                    {{ __('strings.'.$successText) }}
                </div>
                <div class="invalid-tooltip">
                    {{ __('strings.'.$helpText) }}
                </div>
            @endif
        </div>
    </div>
</div>

<?php
    $lang = $lang ?? false;
    $width = $width ?? 12;
    $data = isset($data) && !empty($data) ? (object) $data : [];
    $label = $label ?? 'Title';
    $columnName = $column ?? 'title';
    $columnId = $lang ? $columnName.'_'.$lang->code : $columnName;
    $title = $lang ? $columnName.'_'.$lang->code : $columnName;
    if ($data && $lang && method_exists($data, 'getTranslations')) {
        $translation = $data->getTranslations($columnName);
        if (Arr::has($translation, $lang->code)) {
            $value = old($title, Arr::get($translation, $lang->code));
        } else {
            $value = "";
        }
    } elseif($data && !$lang) {
        $value = $data->{$columnName};
    } else {
        $value = old($title, '');
    }
    $placeHolder = $placeHolder ?? '';
    $helpText = $helpText ?? '';
    $successText = $successText ?? '';
    $required = $required ?? false;
    $disabled = $disabled ?? false;
?>

<div class="col-md-{{$width}}">
    <div class="form-group position-relative">
        <label class="font-w600" @if($required) for="validationTooltip{{$columnId}}" @endif>{{ __('strings.'.$label) }} {{ empty($lang["name"]) ? '' : '- ('.$lang["name"].')' }}</label>
        <input type="text" class="form-control @if($disabled)  disabled @endif" name="{{$title}}" value="{{$value}}" placeholder="{{ __('strings.'.$placeHolder) }}" @if($required)   id="validationTooltip{{$columnId}}"  required @endif @if($disabled)  disabled @endif>
        @if($helpText && $successText)
            <div class="valid-tooltip">
                {{ __('strings.'.$successText) }}
            </div>
            <div class="invalid-tooltip">
                {{ __('strings.'.$helpText) }}
            </div>
        @endif
{{--    @include('backend.layouts.components.error', ['name' => $title])--}}
    </div>
</div>



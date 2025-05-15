<?php

    $lang = isset($lang) && $lang ? $lang : false;
    $width = isset($width) && $width ? $width : 12;
    $data = isset($data) && !empty($data) ? (object) $data : [];
    $label = isset($label) && $label ? $label : 'Title';
    $columnName = isset($column) && $column ? $column : 'title';
    $columnEditorId = $lang ? $columnName.'_'.$lang->code : $columnName;
    $columnId = $lang ? $columnName.'_'.$lang->code : $columnName;
    $name = $lang ? $columnName . '[' . $lang->code . ']' : $columnName;
    //Define $value
    if($data && $lang && Arr::get($data->getTranslations($columnName), $lang->code) !== null){
        $value = old($name,$data->getTranslation($columnName,$lang->code));
    }
    elseif($data && !$lang){ $value = $data->{$columnName}; }
    else { $value = old($name) ? old($name) : ''; }
    //End of $value Definition
    $placeHolder = isset($placeHolder) && $placeHolder ? $placeHolder : '';
    $helpText = isset($helpText) ? $helpText : '';
    $successText = isset($successText) ? $successText : '';
    $required = isset($required) && $required ? $required : false;

?>

<div class="col-md-12">
    <div class="form-group position-relative">
        <label @if($required) for="textarea{{$columnEditorId}}" @endif>{{ $label }} - ({{$lang["name"] ?? ''}})</label>
        <textarea id="textarea{{$columnEditorId}}" name="{{$name}}" class="form-control" cols="30" rows="3" @if($required) required @endif placeholder="{{ $placeHolder }}">
            {{$value}}
        </textarea>
        @if($helpText && $successText)
        <div class="valid-tooltip">
            {{ $successText }}
        </div>
        <div class="invalid-tooltip">
            {{ $helpText }}
        </div>
        @endif
        @include('backend.layouts.components.error', ['name' => $name])
    </div>
</div>

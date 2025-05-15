<?php

    $lang = isset($lang) && $lang ? $lang : false;
    $width = isset($width) && $width ? $width : 12;
    $data = isset($data) && !empty($data) ? (object) $data : [];
    $label = isset($label) && $label ? $label : 'Title';
    $columnName = isset($column) && $column ? $column : 'title';
    $columnId = $lang ? $columnName.'_'.$lang->code : $columnName;
    $title = $lang ? $columnName.'_'.$lang->code : $columnName;
    //Define $value
    if($data && $lang){
        $value = old($title,$data->getTranslation($columnName,$lang->code));
    }
    elseif($data && !$lang){ $value = $data->{$columnName}; }
    else { $value = old($title) ? old($title) : ''; }
    //End of $value Definition
    $placeHolder = isset($placeHolder) && $placeHolder ? $placeHolder : '';
    $helpText = isset($helpText) ? $helpText : '';
    $successText = isset($successText) ? $successText : '';
    $required = isset($required) && $required ? $required : false;
//    $staticKeyLabel = isset($lang) && $lang ? staticWordKey($label)[$lang->code] : wordKey($label);
//    $staticKeyPlaceholder = isset($lang) && $lang ? staticWordKey($placeHolder)[$lang->code] : wordKey($placeHolder);
//    $staticKeySuccessText = isset($lang) && $lang ? staticWordKey($successText)[$lang->code] : wordKey($successText);
//    $staticKeyhelpText = isset($lang) && $lang ? staticWordKey($helpText)[$lang->code] : wordKey($helpText);
$staticKeyLabel = isset($lang) && $lang ? $label[$lang->code] : $label;
$staticKeyPlaceholder = isset($lang) && $lang ? $placeHolder[$lang->code] : $placeHolder;
$staticKeySuccessText = isset($lang) && $lang ? $successText[$lang->code] : $successText;
$staticKeyhelpText = isset($lang) && $lang ? $helpText[$lang->code] : $helpText;
?>

<div class="col-md-{{$width}}">
    <div class="form-group position-relative">
        <label @if($required) for="validationTooltip{{$columnId}}" @endif>{{ $staticKeyLabel }}</label>
        <input type="number" class="form-control" name="{{$title}}" value="{{$value}}" placeholder="{{ $staticKeyPlaceholder }}" @if($required)  id="validationTooltip{{$columnId}}"  required @endif>
        @if($helpText && $successText)
        <div class="valid-tooltip">
            {{ $staticKeySuccessText }}
        </div>
        <div class="invalid-tooltip">
            {{ $staticKeyhelpText }}
        </div>
        @endif
        @include('backend.layouts.components.error', ['name' => $title])
    </div>
</div>

<?php
    $lang = isset($lang) && $lang ? $lang : false;
    $data = isset($data) && !empty($data) ? (object) $data : [];
    $optionName = isset($optionName) ? $optionName : 'name';
    $optionValue = isset($optionValue) ? $optionValue : 'value';
    $label = isset($label) && $label ? $label : 'name';
    $columnName = isset($column) && $column ? $column : 'name';
    $columnId = $lang ? $columnName.'_'.$lang->locale : $columnName;
    $title = $lang ? $columnName.'_'.$lang->locale : $columnName;
    $id = $id ? $id : '';
    $helpText = isset($helpText) ? $helpText : '';
    $successText = isset($successText) ? $successText : '';
    $required = isset($required) && $required ? $required : false;
    $dataLoad = isset($dataLoad) && !empty($dataLoad) ? $dataLoad : [];
    $placeHolder = isset($placeHolder) && $placeHolder ? $placeHolder : 'fill the field!';
    //Define $value
    if($data && $lang ){
        $value = old($id);
    }
    elseif($data && !$lang){ $value = $data->id; }
    else { $value = old($id) ? old($id) : ''; }

    $staticKeyLabel = isset($lang) && $lang ? staticWordKey($label)[$lang->code] : wordKey($label);
    $staticKeyPlaceholder = isset($lang) && $lang ? staticWordKey($placeHolder)[$lang->code] : wordKey($placeHolder);
    $staticKeySuccessText = isset($lang) && $lang ? staticWordKey($successText)[$lang->code] : wordKey($successText);
    $staticKeyhelpText = isset($lang) && $lang ? staticWordKey($helpText)[$lang->code] : wordKey($helpText);
?>

@if(!empty($dataLoad))
<div class="col-md-12">
    <div class="form-group position-relative">
        <label @if($required) for="validationTooltip{{$columnId}}" @endif class="control-label">{{$staticKeyLabel}}</label>
        <select class="select2 form-control select2-multiple" name="{{$title}}" multiple="multiple" data-placeholder="{{$staticKeyPlaceholder}}" @if($required) for="validationTooltip{{$columnId}}" required @endif>
            <option value="0">{{$staticKeyPlaceholder}}</option>
            @foreach($dataLoad as $permission)
               <option value="{{ $permission->id }}" <?= ($permission->id == $value) ? 'selected' : '' ?>>{{ $permission->getTranslation('title', app()->getLocale()) }}</option>
            @endforeach
        </select>
        @if($helpText && $successText)
        <div class="valid-tooltip">
            {{ $staticKeySuccessText }}
        </div>
        <div class="invalid-tooltip">
            {{ $staticKeyhelpText }}
        </div>
        @endif
    </div>
</div>
@else
<div class="form-group col-md-12">
</div>
@endif

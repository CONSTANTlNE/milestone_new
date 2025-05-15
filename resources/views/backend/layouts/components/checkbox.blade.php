<?php
    $lang = isset($lang) && $lang ? $lang : false;
    $data = isset($data) && !empty($data) ? (object) $data : [];
    $label = isset($label) && $label ? $label : 'name';
    $columnName = isset($column) && $column ? $column : 'name';
    $columnId = $lang ? $columnName.'_'.$lang->locale : $columnName;
    $name = $lang ? $columnName.'_'.$lang->locale : $columnName;
    //Define $value
    if($data && $lang && $data->translate($lang->locale)->locale == $lang->locale){
        //$value = old($name) ? old($name) : $data->translate($lang->locale)->{$columnName};
        $value = old($name,$data->getTranslation($columnName,$lang->locale));
    }
    elseif($data && !$lang){ $value = $data->{$columnName}; }
    else { $value = old($name) ? old($name) : 1; }
    //End of $value Definition
    $placeHolder = isset($placeHolder) && $placeHolder ? $placeHolder : 'fill the field!';
    $helpText = isset($helpText) ? $helpText : '';
?>
<div class="form-group col-md-8">
    <div class="custom-control custom-checkbox">
        <input type="checkbox" name="{{$name}}" value="1" class="custom-control-input" id="{{$columnId}}" {{ $value ? 'checked' : '' }}>
        <label class="custom-control-label" for="{{$columnId}}">{{tr($label)}} @if($lang)(: {{$lang->locale}})@endif</label>
    </div>
    @if($helpText)
    <span class="help-block">{{ tr($helpText) }}</span>
    @endif
    @include('CMS.layout.components.error', ['name' => $name])
</div>

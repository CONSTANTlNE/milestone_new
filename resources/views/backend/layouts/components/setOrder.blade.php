<?php 

    $lang = isset($lang) && $lang ? $lang : false; 
    $data = isset($data) && !empty($data) ? (object) $data : [];
    $label = isset($label) && $label ? $label : 'Set Order';
    $columnName = isset($column) && $column ? $column : 'name';
    $columnId = $lang ? $columnName.'_'.$lang->locale : $columnName;
    $name = $lang ? $columnName.'_'.$lang->locale : $columnName;
    //Define $value
    if($data && $lang && $data->translate($lang->locale)->locale == $lang->locale){
        $value = $data->translate($lang->locale)->{$columnName};
    }
    elseif($data && !$lang){ $value = $data->{$columnName}; }
    else { $value = old($name) ? old($name) : 0; }
    //End of $value Definition
    $placeHolder = isset($placeHolder) && $placeHolder ? $placeHolder : 'fill the field!';
    $helpText = isset($helpText) ? $helpText : 'Set Order by setting numbers, so 0 means first, 1 - second and so on';
  
?>
<div class="form-group col-md-12">
    <label class="form-label"for="{{$columnId}}">{{tr($label)}}: @if($lang)({{$lang->locale}})@endif</label>
    <input type="text" id="{{$columnId}}"
        name="{{$name}}"
        value="{{ $value }}"
        class="form-control" @if($lang && $lang->active == 1) required @endif>
    @if($helpText)
    <span class="help-block">{{ tr($helpText) }}</span>
    @endif
    @include('CMS.layout.components.error', ['name' => $name])
</div>
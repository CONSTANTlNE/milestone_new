<?php 
    $lang = isset($lang) && $lang ? $lang : false; 
    $data = isset($data) && !empty($data) ? (object) $data : [];
    $label = isset($label) ? ucfirst($label) : '';
    $columnName = isset($column) && $column ? $column : 'file';
    $columnId = $lang ? $columnName.'_'.$lang->locale : $columnName;
    $name = $lang ? $columnName.'_'.$lang->locale : $columnName;
    $icon = isset($icon) ? $icon : 'ni ni-info';
    $folder = isset($folder) ? $folder : 'documents';
    $accept = isset($accept) ? $accept : 'application/pdf';

    //check plugin scope, if model multilingual and the plugin is also multilingual
    if($data && $lang && $data->translate($lang->locale)->locale == $lang->locale){
        $value = $data->translate($lang->locale)->{$columnName};
    }
    elseif($data && !$lang){ $value = $data->{$columnName}; }
    else { $value = old($name) ? old($name) : ''; }
    $placeHolder = isset($placeHolder) && $placeHolder ? $placeHolder : 'attach file!';
    $helpText = isset($helpText) ? $helpText : ''; 
?>
<div class="form-group col-md-6">
    <label class="form-label" for="{{$columnId}}">{{ $label }}</label>
    <input type="file" accept="{{ $accept }}"  name="{{ $name }}" id="{{$columnId}}" class="form-control" >
    @if($helpText)
    <span class="help-block">{{ tr($helpText) }}</span>
    @endif
    @include('CMS.layout.components.error', ['name' => $name])
</div>
@if($value)
<div class="form-group col-md-6">
    <a href="{{ asset('files/'.$folder.'/'.$value) }}" target="_blank" class="btn btn-lg btn-primary waves-effect waves-themed">{{ $data->{$columnName} }}<span class="badge bg-primary-300 ml-2"><i class="far fa-arrow-square-down"></i></span></a>
</div>
@endif
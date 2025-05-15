<?php
    $format = isset($format) ? $format : 'Y-m-d H:i';
    $enableTime = isset($enableTime) && !$enableTime ? 0 : 1;
    $carbon = \Carbon\Carbon::now()->format($format);
    $lang = isset($lang) && $laenableTimeng ? $lang : false;
    $data = isset($data) && !empty($data) ? (object) $data : [];
    $label = isset($label) && $label ? $label : 'name';
    $columnName = isset($column) && $column ? $column : 'name';
    $columnId = $lang ? $columnName.'_'.$lang->locale : $columnName;
    $name = $lang ? $columnName.'_'.$lang->locale : $columnName;
    //Define $value
    if($data && $lang && $data->translate($lang->locale)->locale == $lang->locale){
        $value =  old($name,$data->getTranslation($columnName,$lang->locale));
    }
    elseif($data && !$lang){ $value = $data->{$columnName}; }
    else { $value = old($name,$carbon); }
    //End of $value Definition
    $helpText = isset($helpText) ? $helpText : '';
    $required = isset($required) && $required ? $required : false;

?>
<div class="form-group col-md-4">
    <label class="form-label"for="{{$columnId}}">{{tr($label)}}@if($lang): ({{$lang->locale}})@endif</label>
    <div class="input-group ">
        <input type="text" name="{{$columnName}}" value="{{$value}}"  class="form-control" id="{{$columnId}}">
        <div class="input-group-append">
            <span class="input-group-text fs-xl">
                <i class="fal fa-calendar-exclamation"></i>
            </span>
        </div>
    </div>
    @if($helpText)
    <span class="help-block">{{ tr($helpText) }}</span>
    @endif
    @include('CMS.layout.components.error', ['name' => $name])
</div>

@push('componentScripts')

<script>
    $("#{{$columnId}}").flatpickr({
        enableTime: {{$enableTime ? 'true' : 'false'}},
        dateFormat: '{{ $format }}',
        time_24hr: {{$enableTime ? 'true' : 'false'}},
    });
</script>

@endPush

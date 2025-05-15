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

    $model = isset($model) ? $model : '';
    $fullRemove = isset($fullRemove) ? $fullRemove : false;

    //check plugin scope, if model multilingual and the plugin is also multilingual

    if($data && $lang){
        $value = $data->getTranslation($columnName,$lang->locale);

    }

    elseif($data && !$lang){ $value = $data->{$columnName}; }
    else { $value = old($name) ? old($name) : ''; }
    $placeHolder = isset($placeHolder) && $placeHolder ? $placeHolder : 'attach file!';
    $helpText = isset($helpText) ? $helpText : '';

?>


@if($type == 'upload')
<div class="form-group col-md-6">
    <label class="form-label" for="{{$columnId}}">{{ $label }}</label>

    <input type="file" accept="{{ $accept }}"  name="{{ $name }}" id="{{$columnId}}" class="form-control" >

    @if($helpText)
    <span class="help-block">{{ tr($helpText) }}</span>
    @endif
    @include('CMS.layout.components.error', ['name' => $name])
</div>
@endif

@if($type == 'link')
    <div class="form-group col-md-6">
        <label class="form-label" for="{{$columnId}}">{{ $label }}</label>

        <input type="text" value="{{$value}}" name="{{ $name }}" id="{{$columnId}}" class="form-control" >

        @if($helpText)
            <span class="help-block">{{ tr($helpText) }}</span>
        @endif
        @include('CMS.layout.components.error', ['name' => $name])
    </div>
@endif


@if($type == 'both')
    <div class="form-group col-md-6">

        <label class="form-label" for="{{$columnId}}">{{ $label }}</label>
        <div class="border px-3 pt-3 pb-0 rounded">
            <ul class="nav nav-pills" role="tablist">
                <li class="nav-item "><a class="videoupload nav-link active" data-toggle="tab" href="#upload"><i class="fal fa-file-video mr-1"></i>{{tr('upload')}}</a></li>
                <li class="nav-item "><a class="videolink nav-link" data-toggle="tab" href="#link"><i class="fal fa-link mr-1"></i>{{tr('link')}}</a></li>
            </ul>
            <div class="tab-content py-3">
                <div class="tab-pane fade show active" id="upload" role="tabpanel">



                    <input type="file"  accept="{{ $accept }}"  name="{{ $name }}" id="{{$columnId}}" class="form-control videouploadinput" >

                    @if($helpText)
                        <span class="help-block">{{ tr($helpText) }}</span>
                    @endif
                    @include('CMS.layout.components.error', ['name' => $name])

                </div>
                <div class="tab-pane fade" id="link" role="tabpanel">



                    <input type="text" value="{{$value}}" name="{{ $name }}" id="{{$columnId}}" class="form-control videolinkinput" >
                    @if($helpText)
                        <span class="help-block">{{ tr('supported platforms: youtube/vimeo') }}</span>
                    @endif
                    @include('CMS.layout.components.error', ['name' => $name])

                </div>

            </div>
        </div>


    </div>
@endif




@if($value)
    @if (filter_var($value, FILTER_VALIDATE_URL) === FALSE)
<div class="form-group col-md-6 video-container">
    <span class="remove-video remove-video-{{ $name }}" data-id="{{ $data->id }}" data-column="{{ $columnName }}" style="cursor: pointer;"><i class="far fa-trash-alt fa-1x"></i></span>
    <video src="{{ asset('files/'.$folder.'/'.$value) }}" style="width:100%" controls></video>
</div>
    @else

        <div class="form-group col-md-6 video-container">

            <iframe width="560" height="315" src="{{$value}}" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        </div>
        @endif

@endif
<br>

@push('componentScripts')
@if(!$fullRemove)
<script>
    $('.remove-video-{{ $name }}').click(function(){
        var result = confirm("Are you sure to delete?");
        if(result){
            id = $(this).data('id');
            column = $(this).data('column');
            let {!! $name !!}removeVideo = new removeVideo();
            {!! $name !!}removeVideo.init(id, column, '{!! $model !!}', '{!! $folder !!}', false);
            $(this).parent().remove();
        }
    });

    @if($type == 'both')

        var checkvideoinputtype = function(){
            setTimeout(function () {
                if($('.videoupload').hasClass('active')){
                    $('.videolinkinput').attr('disabled',true);
                    $('.videouploadinput').attr('disabled',false);

                }
                if($('.videolink').hasClass('active')){
                    $('.videouploadinput').attr('disabled',true);
                    $('.videolinkinput').attr('disabled',false);
                }
            },200)
        }

        checkvideoinputtype();
        $('.nav-item').click(function () {
             setTimeout(function () {
                 checkvideoinputtype();
             },200)
        });

    var link = $('.videolinkinput').val();
    if(link.indexOf("://")>-1){
        setTimeout(function () {
            $('.videolink').click();
        },200)
    }else{
        setTimeout(function () {
            $('.videoupload').click();
        },200)
    }

        @endif


</script>
@endif
@endpush

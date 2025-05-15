<?php
    $data = isset($data) && !empty($data) ? (object) $data : [];
    $label = isset($label) ? ucfirst($label) : '';
    $columnName = isset($columnName) ? $columnName  : 'image';
    $columnId = $column.'_';
    $name = isset($column) ? $column : 'images';
    $icon = isset($icon) ? $icon : 'ni ni-info';
    $folder = isset($folder) ? $folder : 'images';
    $model = isset($model) ? $model : '';
    $gate = isset($gate) ? $gate : '';

    //check plugin scope, if model multilingual and the plugin is also multilingual
    $values = isset($values) ?  $values : null;
    $placeHolder = isset($placeHolder) && $placeHolder ? $placeHolder : 'fill the field!';
    $helpText = isset($helpText) ? $helpText : '';
?>
<div class="form-group {!! $columnId !!} col-md-4">
    <label class="col-form-label text-lg-left form-label">{{ $label }}</label>
    <div class="input-group bg-white">
	    <div class="custom-file" style="overflow:hidden;">
	        <input type="file" accept="image/*" name="{{$name}}[]" class="required borrowerImageFile custom-file-input" id="{{$columnId}}" data-errormsg="PhotoUploadErrorMsg" multiple="multiple">
	        <label class="custom-file-label" for="{{$columnId}}">Choose file</label>
	    </div>
	</div>
	<div class="input-group bg-white">
	    @if($helpText)
	    <span class="help-block">{{ $helpText }}</span>
	    @endif
	</div>
    @include('CMS.layout.components.error', ['name' => $name])
</div>
@if($values)
<div class="form-group col-md-12" id="{{$columnId}}-prev">
    <ul id="sortable" class="gallery gallery-{{$columnId}}">
        @foreach($values as $key => $image)
        <li data-id="{{$image->id}}" class="li-item" id="{{$image->id}}">
            <span class="btn btn-xs gallery--remove_item remove-multi-img-{{ $name }}" data-id="{{ $image->id }}"><i class="far fa-trash-alt fa-1x"></i></span>
            <img src="{{ asset('files/'.$folder.'/'.$image->{$columnName}) }}" />
        </li>
        @endforeach
    </ul>
</div>
@else

@endif
<div class="{{$columnId}}-end" syle="visibility:hidden;"></div>

@push('componentScripts')
<script>
	$('{!! "#".$columnId !!}').change(function(e){
        let {!! $name !!}MultiImg = new handleMultiImages('{!! $columnId !!}',event.target.files);
        {{ $name }}MultiImg.change();
    });
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#js-lightgallery{!!$name!!}").lightGallery();
    });
</script>
<script>
    $('.remove-multi-img-{{ $name }}').click(function(){
        let imgData = [];
        var result = confirm("Are you sure to delete?");
        if(result){
            // Delete logic goes here
            imgData['el']    = $(this);
            imgData['gate']  = '{!! $gate !!}';
            imgData['model']  = '{!! $model !!}';
            imgData['id']     = $(this).attr('data-id');
            imgData['column'] = '{!! $columnName !!}';
            imgData['folder'] = '{!! $folder !!}';
            imgData['modelRemove'] = true;

            var imgModel = new removeModelImage();
            imgModel.init(imgData);
        }
    });
    @if($values)
    var itemsArray = [];
    $( function() {
        $( "#sortable" ).sortable({update: function( event, ui ) {
            itemsArray = [];
            let items = document.querySelectorAll('#sortable li');
            for(var i = 0;  i < items.length; i++){
                var obj = {
                    position: i,
                    id: items[i].getAttribute('id'),
                }
                itemsArray.push(obj);
                console.log(i);
            }
            if(itemsArray.length > 0){
                var data = {
                    gate: '{!! $gate !!}',
                    model: '{!! $model !!}',
                    data: itemsArray
                }
                $.ajax({
                    type: "POST",
                    beforeSend: function (request) {
                        request.setRequestHeader(
                            "X-CSRF-Token",
                            $('meta[name="csrf-token"]').attr("content")
                        );
                    },
                    url: "/connect/sort-images",
                    data: data,
                    success: function (msg) {
                        console.log(msg);
                    },
                });
            }
            console.log(itemsArray);
        }});

        $( "#sortable" ).disableSelection();
    } );
    @endif
</script>

@endpush

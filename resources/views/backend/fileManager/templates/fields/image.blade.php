<?php
if(old($name)) {
  $image = \App\Models\File::find(old($name));
} else {
  $image = !empty($item->generalImage) ? $item->generalImage->first() : null;
}
?>
<div class="image-group" data-name="{{ $name }}" data-multi="false" style="width: 100%">
  <div class="col-md-12 pl-0 pr-0">
    <div class="form-group">
      <label class="control-label">{{ __('strings.'.$label) }}</label>
        <button type="button" class="btn btn-info btn-sm btn-block select-media-btn"
                style="border-radius: 0.2rem;font-size: 16px !important; font-weight: 600">
            <i class="bx bx-images font-size-18 align-middle me-2"></i>{{ __('strings.Select Main Image') }}
        </button>
        <div class="selected-image-inputs">
          @if($image)
          <input type="hidden" name="{{ $name }}" value="{{ $image->id }}">
          @endif
        </div>
      </div>
  </div>

  <div class="col-md-12 mt-4 border border-start-0 border-end-0 p-3" style="border: 2px dashed #ced4da !important;
    background: #f9f9f9;
    min-height: 230px;">
    <i class="bx bxs-file-image font-size-24 align-middle me-2" style="{{ !$image ? '' : 'display:none;' }} font-size: 84px !important;line-height: 2;color: #ced4da;"></i>
    <div class="form-group" style="{{ !$image ? 'display:none': '' }} ">
      <label class="col-md-12 mt-1 control-label">{{ __('strings.Display') }}:</label>
      <div class="col-md-12 mt-2 general-image">
        <ul class="image-previews one-image sortable-images" style="display: flex;justify-content: center;">
          @if($image)
          <li class="image" href="{{asset($image->src)}}" data-id="{{ $image->id }}"
              title="{{ $image->title  }}">
            <select name='cover[]' id='general-covers' class='form-control covers general-covers exclude' data-select2-id='covers' tabindex='-1' aria-hidden='true' style='display:none !important;'><option value='general'>general</option></select>
            <button data-id="{{ $image->id }}" class="btn btn-danger btn-circle" type="button"><i
                class="fa fa-times"></i></button>
            @if($image->type =="image")
            <img class="rounded avatar-xl" href="{{asset($image->src)}}" src="{{asset($image->src)}}"
                 alt="{{ $image->title }}">
            @else
            <img class="runded avatar-lg" href="{{asset($image->src)}}" src="{{asset('storage/defaults/files.svg')}}"
                     alt="{{ $image->title }}">
            @endif
          </li>
          @endif
        </ul>
      </div>
    </div>
  </div>
</div>

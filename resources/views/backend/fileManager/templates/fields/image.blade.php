<?php
if(old($name)) {
  $image = \App\Models\File::find(old($name));
} else {
  $image = !empty($item->generalImage) ? $item->generalImage->first() : null;
}
?>
<div class="image-group" data-name="{{ $name }}" data-multi="false" style="width: 100%">
    <div class="image-upload-group">
        <p class="font-second-geo  text-defaulttextcolor/70">{{ __('admin.'.$label) }}</p>
        <button type="button" class="w-full btn-file-upload hs-dropdown-toggle ti-btn mt-10 !gap-0 !py-2 !px-2 text-[0.75rem] !font-medium bg-secondary text-white flex items-center cursor-pointer justify-center font-second-geo select-media-btn" data-hs-overlay="#hs-full-screen-modal">
            <div class="me-2">
                <i class="ri ri-upload-cloud-line align-middle text-[1.25rem] !me-1 text-white"></i>
            </div>
            {{ __('admin.select_main_image') }}
        </button>
        <div class="selected-image-inputs">
            @if($image)
            <input type="hidden" name="{{ $name }}" value="{{ $image->id }}">
            @endif
        </div>
    </div>
  <div class="image-body-view mt-2 border border-start-0 border-end-0 p-3">
    <i class="bx bxs-file-image font-size-24 align-middle me-2" style="{{ !$image ? '' : 'display:none;' }} font-size: 84px !important;line-height: 2;color: #ced4da;"></i>
    <div class="form-group" style="{{ !$image ? 'display:none': '' }} ">
      <p class="font-second-geo text-defaulttextcolor/70 py-2">{{ __('admin.main_image_display') }}</p>
      <div class="general-image">
        <ul class="image-previews one-image sortable-images" style="display: flex;justify-content: center;">
          @if($image)
          <li class="image" href="{{asset($image->src)}}" data-id="{{ $image->id }}" title="{{ $image->title  }}">
            <select name='cover[]' id='general-covers' class='form-control covers general-covers exclude' data-select2-id='covers' tabindex='-1' aria-hidden='true' style='display:none !important;'><option value='general'>general</option></select>
            <button data-id="{{ $image->id }}" class="btn btn-danger btn-circle" type="button">
                <i class="ri ri-close-line"></i>
            </button>
            @if($image->type =="image")
            <img class="rounded avatar-xl" href="{{asset($image->src)}}" src="{{asset($image->src)}}"
                 alt="{{ $image->title }}">
            @else
            <img class="rounded avatar-lg" href="{{asset($image->src)}}" src="{{asset('storage/defaults/files.svg')}}"
                     alt="{{ $image->title }}">
            @endif
          </li>
          @endif
        </ul>
      </div>
    </div>
  </div>
</div>

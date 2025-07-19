<div class="image-group" style="width: 100%">
    <div class="images-upload-group">
        <p class="font-second-geo  text-defaulttextcolor/70">{{ __('admin.'.$label) }}</p>
        <button type="button"  class="w-full btn-file-upload hs-dropdown-toggle ti-btn !gap-0 mt-10 !py-2 !px-2 text-[0.75rem] !font-medium bg-primary text-white flex items-center justify-center select-media-btn" data-hs-overlay="#hs-full-screen-modal">
            <div class="me-2">
                <i class="ri ri-folder-upload-line align-middle text-[1.25rem] !me-1 text-white"></i>
            </div>
            {{ __('admin.select_additional_images') }}
        </button>
        <div class="selected-image-inputs">
            @foreach($imageIds as $image_id)
                <input type="hidden" name="images[]" value="{{ $image_id }}">
            @endforeach
        </div>
    </div>

    <div class="image-body-view mt-2 border border-start-0 border-end-0 p-3">
        <i class="bx bxs-file-image font-size-24 align-middle me-2"
           style="font-size: 84px !important;line-height: 2;color: #ced4da;{{ !$images || !count($images) ? '': 'display:none' }}"></i>
        <div class="form-group" style="{{ !$images || !count($images) ? 'display:none': '' }} ">
            <p class="font-second-geo text-defaulttextcolor/70 py-2">{{ __('admin.additional_image_or_files') }}</p>

            <div class="more-image" style="overflow: hidden;">
                <ul class="image-previews sortable-images" data-type="multy">
                    @foreach($images as $image)
                        <li class="image {{ $image->type !='image' ? 'no-type-image' : 'type-image'}}"
                            href="{{asset($image->src)}}" data-id="{{ $image->id }}"
                            title="{{ $image->title }}">
                            @if($image->type =="image")
                                <select name='cover[]' id='covers' class='form-control covers exclude' data-select2-id='covers'
                                        tabindex='-1' aria-hidden='true'>
                                    @if(!empty($image->pivot->cover))
                                        <option value='{{$image->pivot->cover}}'>--{{$image->pivot->cover}}</option>
                                    @endif
                                    <option value='default'>Default</option>
                                    <option value='slider'>Slider</option>
                                    <option value='cover'>Cover</option>
                                    <option value='versus1'>Versus1</option>
                                    <option value='versus2'>Versus2</option>
                                    <option value='sent'>Sent</option>
                                    <option value='received'>Received</option>
                                </select>
                            @else
                                <label for='covers'></label><select name='cover[]' id='covers'
                                                                    class='form-control covers' data-select2-id='covers'
                                                                    tabindex='-1' aria-hidden='true'
                                                                    style='display:none;'>
                                    <option value='default'>default</option>
                                </select>
                            @endif

                            <button data-id="{{ $image->id }}" class="btn btn-danger btn-circle" type="button"><i
                                    class="fa fa-times"></i></button>
                            @if($image->type == "image")
                                <img class="avatar-lg" href="{{asset($image->src)}}" src="{{asset($image->src)}}"
                                     alt="{{ $image->title }}">
                            @else
                                <img class="avatar-lg" href="{{asset($image->src)}}"
                                     src="{{asset('storage/defaults/files.svg')}}"
                                     alt="{{ $image->title }}">
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>

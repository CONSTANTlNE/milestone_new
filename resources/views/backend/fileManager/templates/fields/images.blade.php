<div class="image-group" style="width: 100%">
    <div class="col-md-12 pl-0 pr-0">
        <div class="form-group">
            <label class="control-label">{{ __('strings.'.$label) }}</label>
            <button type="button" class="btn btn-warning btn-sm btn-block select-media-btn"
                    style="border-radius: 0.2rem;font-size: 16px !important; font-weight: 600">
                <i class="bx bx-images font-size-18 align-middle me-2"></i> {{ __('strings.Select Additional Images') }}
            </button>
            <div class="selected-image-inputs">
                @foreach($imageIds as $image_id)
                    <input type="hidden" name="images[]" value="{{ $image_id }}">
                @endforeach
            </div>
        </div>
    </div>

    <div class="col-md-12 mt-4 border border-start-0 border-end-0 p-3" style="border: 2px dashed #ced4da !important;
      background: #f9f9f9;
      min-height: 230px;">
        <i class="bx bxs-file-image font-size-24 align-middle me-2"
           style="font-size: 84px !important;line-height: 2;color: #ced4da;{{ !$images || !count($images) ? '': 'display:none' }}"></i>
        <div class="form-group" style="{{ !$images || !count($images) ? 'display:none': '' }} ">
            <label class="col-md-12 mt-1 control-label">{{ __('strings.Display Additional Images') }}</label>
            <div class="col-md-12 mt-2 p-0 more-image" style="overflow: hidden;">
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

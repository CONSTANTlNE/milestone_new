@switch(!empty($row->generalImage) && !empty($row->generalImage->first()->type) && $row->generalImage->first()->type)
    @case('image')
        <img src="{{ asset($row->generalImage->first()->src)}}" style="height: 30px;max-width: 60px;">
        @break
    @case('document')
        <i class="fa fa-file sss" style="font-size: 32px;color: #3b5de7;"></i>
        @break
    @case('archive')
        <i class="fa fa-file sss" style="font-size: 32px;color: #3b5de7;"></i>
        @break
    @default
        <img src="{{ asset(config('filemanager.default_backend_image'))}}" style="height: 30px;max-width: 60px;">
@endswitch

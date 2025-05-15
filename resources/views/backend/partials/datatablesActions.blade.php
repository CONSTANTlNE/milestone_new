<div class="actions">
@if(!empty($statusGate))
@can($statusGate)
    <div class="custom-control-status custom-control custom-switch mb-2" dir="ltr">
        <input id="customSwitch{{$row->id}}" class="custom-control-input status" data-id="{{$row->id}}" type="checkbox" data-onstyle="yes" data-offstyle="no" data-toggle="toggle" data-on=" " data-off=" " data-status="{{$row->status}}" {{ $row->status ? 'checked' : '' }}>
        <label class="custom-control-label" for="customSwitch{{$row->id}}" style="cursor: pointer;"></label>
    </div>
@endcan
@endif
@can($showGate)
    <a href="{{ route($showGate, [app()->getLocale(), $row->id]) }}" class="btn btn-warning shadow btn-xs sharp mr-1" style="color: #fff"><i class="flaticon-381-view-2"></i></a>
@endcan

@can($editGate)
    <a href="{{ route($editGate, [app()->getLocale(), $row->id]) }}" class="btn btn-primary shadow btn-xs sharp mr-1" style="color: #fff"><i class="flaticon-381-edit-1"></i></a>
@endcan

@can($destroyGate)
    <form action="{{ route($destroyGate, [app()->getLocale(), $row->id]) }}" method="POST" class="action-list" onsubmit="return confirm('{{ __('strings.Really Delete') }}');" style="display: inline-block;">
        @csrf
        @method('DELETE')

        <button type="submit" class="btn btn-danger shadow btn-xs sharp"><i class="flaticon-381-trash-2"></i></button>
    </form>
@endcan
@if(isset($row->articles))
<a class="btn btn-primary shadow btn-xs sharp ml-1 count-articles" style="color: #fff">{{ count($row->articles) }}</a>
@endif
</div>

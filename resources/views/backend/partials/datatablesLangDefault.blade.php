<div class="custom-control-default custom-control custom-switch mb-2" dir="ltr">
    <input id="customSwitchDefault{{$row->id}}" class="custom-control-input default" data-id="{{$row->id}}" type="checkbox" data-onstyle="yes" data-offstyle="no" data-toggle="toggle" data-on=" " data-off=" " data-status="{{$row->default}}" {{ $row->default ? 'checked' : '' }}>
    <label class="custom-control-label" for="customSwitchDefault{{$row->id}}" style="cursor: pointer;"></label>
</div>
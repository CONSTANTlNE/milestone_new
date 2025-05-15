<?php 
    $model = isset($model) && $model ? $model : '';
    $id = isset($id) && $id ? $id : '';
    $value = isset($value) && $value ? $value : 0;
    $column = isset($column) && $column ? $column : 'active';
    $inc = isset($inc) ? $inc : 0;
?>
<div class="custom-control custom-switch">
    <input type="checkbox" class="custom-control-input {{'set_active_'.$model.'_'.$column}}" value="{{$value}}" id="{{'set_active_'.$id.'_'.$inc}}" {{$value ? 'checked' : ''}} data-id="{{$id}}">
    <label class="custom-control-label" for="{{'set_active_'.$id.'_'.$inc}}"></label>
</div>

@section('scripts')
<script>
    
	$('{!! ".".'set_active_'.$model.'_'.$column !!}').change(function(e) 
	{
        let setActive = new SetActive('{!!$model!!}','{!!$column!!}');
        let id = this.getAttribute('data-id');

        if (e.target.checked) {
            setActive.init(id, 1);
        } else {
            setActive.init(id, 0);
        }
    });
</script>
@endsection
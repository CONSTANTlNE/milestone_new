@if($carmodels !==null)
    <select class="iq-select" id="model" autocomplete="off" name="model">
        <option value="">Select Model</option>
        @foreach($carmodels as $model)
            <option value="{{$model->id}}">{{$model->name}}</option>
        @endforeach
    </select>
@else
    <select class="iq-select" id="model" autocomplete="off" name="model">
        <option value="">Select Model</option>
    </select>
@endif

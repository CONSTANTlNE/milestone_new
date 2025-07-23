@if($carmodels !==null)
    <select form="quotation_form" style="width: 200px" id="model" autocomplete="off" name="model">
        <option  value="">Select Model</option>
        @foreach($carmodels as $model)
            <option value="{{$model->id}}">{{$model->name}}</option>
        @endforeach
    </select>
@else
    <select style="width: 200px" id="model" autocomplete="off" name="model">
        <option value="">Select Model</option>
    </select>
@endif

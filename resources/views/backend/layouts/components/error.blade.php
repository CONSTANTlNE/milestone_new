<?php $name = isset($name) ? $name : ''; ?>
@if($errors->has($name))
    <div class="alert alert-danger alert-dismissible fade show" role="alert" style="margin-top:5px;">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true"><i class="fal fa-trash-alt"></i></span>
        </button>
         <strong>Oh snap!</strong> {{ $errors->first($name) }}
    </div>
@endif
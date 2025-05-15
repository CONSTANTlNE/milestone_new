@extends('backend.layouts.master')
@section('title') {{ __('strings.Permission Create') }} @endsection
@section('content')
    <div class="container-fluid">
        <div class="form-head d-md-flex mb-sm-4 mb-3 align-items-start">
            <div class="mr-auto  d-lg-block">
                <h2 class="text-black font-w600">{{ __('strings.Permission Create') }}</h2>
                <p class="mb-0 font-w600">{{ __('strings.Welcome') }}</p>
            </div>
            @can('backend.permissions.index')
                <a href="{{ route('backend.permissions.index', app()->getLocale())}}" class="btn btn-info rounded"><i class="flaticon-381-repeat-1"></i> {{ __('strings.Return Back') }} - {{ __('strings.All Permission') }}</a>
            @endcan
            @can('backend.permissions.trash')
                <a href="{{ route('backend.permissions.trash', app()->getLocale())}}" class="btn btn-primary rounded light deleted-archive ml-3"><i class="flaticon-381-trash-2"></i>  {{ __('strings.Deleted Permissions') }}</a>
            @endcan
        </div>
        @include('backend.layouts.components.errors',[
          'errors' => $errors,
        ])
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <form method="post" class="needs-validation" action="{{ route('backend.permissions.store', app()->getLocale()) }}" novalidate enctype="multipart/form-data">
                            {{csrf_field()}}
                             <div class="col-md-12">
                                @include('backend.layouts.includes.langTabComponent')
                                <div class="tab-content p-3 text-muted">
                                    @foreach(getLocales() as $key => $lang)
                                        <div class="tab-pane {{($key == 0) ? 'active' : ''}}" id="locale-{{$lang->code}}" role="tabpanel">
                                            <div class="row">
                                                <x-input
                                                    type="text"
                                                    :lang="$lang"
                                                    :data="null"
                                                    label="Title"
                                                    column="title"
                                                    place-holder="Holder Title"
                                                    success-text="Success Field"
                                                    help-text="Error Field"
                                                    :required="false"
                                                    :disabled="false"
                                                    width="12"
                                                />
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <hr>
                                <div class="col-md-8 p-3">
                                    <div class="form-group position-relative">
                                        <label for="single-select" class="control-label font-w600">{{ __('strings.Choose Permissions Route') }}</label>
                                        <select class="form-control font-w600 select2" name="name" id="single-select" required>
                                            <option value="0">{{ __('strings.View All Route') }}</option>
                                            @foreach($routes as $route)
                                                <option value="{{ $route }}">{{ str_replace('.', '/', $route) }}</option>
                                            @endforeach
                                        </select>
                                        <div class="valid-tooltip">
                                            {{ __('strings.Success Field') }}
                                        </div>
                                        <div class="invalid-tooltip">
                                            {{ __('strings.Error Field') }}
                                        </div>
                                    </div>
                                </div>
                                 <x-checkbox
                                     column="block"
                                     label="Review"
                                     place-holder="Review"
                                     success-text="Checkbox Success"
                                     help-text="Checkbox Error"
                                     :required="true"
                                 />
                                <div class="col-lg-12 p-3">
                                    <button class="btn btn-primary" type="submit">{{ __('strings.Create') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="{{URL::asset('/js/additional/form-advanced.min.js')}}"></script>
@endpush


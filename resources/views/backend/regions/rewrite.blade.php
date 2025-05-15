@extends('backend.layouts.master')
@section('title') {{ __('strings.Rewrite') }} @endsection
@section('content')
    <div class="container-fluid">
        <div class="form-head d-md-flex mb-sm-4 mb-3 align-items-start">
            <div class="mr-auto  d-lg-block">
                <h2 class="text-black font-w600">{{ __('strings.Rewrite') }}</h2>
                <p class="mb-0 font-w600">{{ __('strings.Welcome') }}</p>
            </div>
            @can('backend.regions.create')
                <a href="{{ route('backend.regions.create', app()->getLocale()) }}" class="btn btn-primary rounded mr-3"><i class="flaticon-381-add-2"></i> {{ __('strings.Add a new Regions') }}</a>
            @endcan
            @can('backend.regions.trash')
                <a href="{{ route('backend.regions.trash', app()->getLocale()) }}" class="btn btn-primary rounded light deleted-archive"><i class="flaticon-381-trash-2"></i> {{ __('strings.Deleted Regions') }}</a>
            @endcan
        </div>
        @include('backend.layouts.components.errors',[
          'errors' => $errors,
        ])
        <form method="post" class="needs-validation" action="{{ route('backend.regions.rewriteRegion', app()->getLocale()) }}" novalidate enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="row">
                <div class="col-md-12 p-0">
                    <div class="col-md-12 col-xl-9 float-left">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">

                                        <div class="col-md-5">
                                            <div class="form-group position-relative select-access">
                                                <label class="control-label font-w600" for="validationTipSelectRegionFirst">
                                                    {{ __('strings.Rewrite') }} - {{ __('strings.From') }}
                                                </label>

                                                <select id="validationTipSelectRegionFirst" class="select2 form-control select2 dropdown-groups"  name="firstId" required>
                                                    <option value="0">{{ __('strings.Regions') }}</option>
                                                    @foreach($regions as $key => $region)
                                                        <option value="{{$key}}">{{$region}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="form-group position-relative select-access">
                                                <label class="control-label font-w600" for="validationTipSelectRegionSecond">
                                                    {{ __('strings.Rewrite') }} - {{ __('strings.To') }}
                                                </label>

                                                <select id="validationTipSelectRegionSecond" class="select2 form-control select2 dropdown-groups"  name="secondId" required>
                                                    <option value="0">{{ __('strings.Regions') }}</option>
                                                    @foreach($regions as $key => $region)
                                                        <option value="{{$key}}">{{$region}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <button class="btn btn-primary" type="submit">{{ __('strings.Create') }}</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
@push('scripts')
    <script src="{{URL::asset('/js/additional/select2.min.js')}}"></script>
    <script src="{{URL::asset('/js/plugins-init/select2-init.js')}}"></script>
@endpush

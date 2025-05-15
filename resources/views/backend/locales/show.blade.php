@extends('backend.layouts.master')
@section('title') {{ __('strings.View Language') }} @endsection
@section('content')
    <div class="container-fluid">
        <div class="form-head d-md-flex mb-sm-4 mb-3 align-items-start">
            <div class="mr-auto  d-lg-block">
                <h2 class="text-black font-w600">{{ __('strings.View Language') }}</h2>
                <p class="mb-0 font-w600">{{ __('strings.Welcome') }}</p>
            </div>
            @can('backend.locales.index')
                <a href="{{ route('backend.locales.index', app()->getLocale())}}" class="btn btn-info rounded"><i class="flaticon-381-repeat-1"></i> {{ __('strings.Return Back') }} - {{ __('strings.All Languages') }}</a>
            @endcan
            @can('backend.locales.create')
                <a href="{{ route('backend.locales.create', app()->getLocale())}}" class="btn btn-primary rounded ml-3"><i class="flaticon-381-add-2"></i> {{ __('strings.Add a new Language') }}</a>
            @endcan
            @can('backend.locales.trash')
                <a href="{{ route('backend.locales.trash', app()->getLocale())}}" class="btn btn-primary rounded light deleted-archive ml-3"><i class="flaticon-381-trash-2"></i>  {{ __('strings.Deleted Languages') }}</a>
            @endcan
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                       <div class="card bg-primary text-white-50 mb-0">
                            <div class="card-body" style="color:#fff;">
                                <p class="card-text">{{ __('strings.Create Date') }} -
                                    {{ $locale->created_at->format('d-m-Y h:i:s') }}
                                </p>
                                <hr>
                                <h5 class="mt-0 mb-4 text-white"><i class="mdi mdi-bullseye-arrow"></i>{{ __('strings.Title') }} - {{$locale->name}}</h5>
                                <hr>
                                <p class="card-text">{{ __('strings.Code') }} - {{$locale->code}}</p>
                                @if(isset($locale->generalImage[0]))
                                    @if($locale->generalImage[0]->type == "image")
                                        <hr>
                                        <p class="card-text">{{ __('strings.Main Image') }}:
                                            <a href="{{ asset($locale->generalImage[0]->src ?? config('filemanager.default_backend_image')) }}" target="black">
                                                <img class="avatar-lg" src="{{ asset($locale->generalImage[0]->src ?? config('filemanager.default_backend_image')) }}" style="border: 1px solid #fff;background: #fff;width: 100px">
                                            </a>
                                        </p>
                                        <hr>
                                    @else
                                        <hr>
                                        <p class="card-text">{{ __('strings.Main File') }}:
                                            <a href="{{ asset($locale->generalImage[0]->src ?? config('filemanager.default_backend_image')) }}" target="_blank" class="avatar-lg" style="cursor: pointer;font-size: 52px;color: #3b5de7;display: block;background: #f5f9ff;text-align: center;width: 100px"><i class="fa fa-file sss"></i></a>
                                        </p>
                                        <hr>
                                    @endif
                                @else
                                    <hr>
                                    <p class="card-text">{{ __('strings.Main Image') }}:
                                        <a href="{{ asset(config('filemanager.default_backend_image')) }}" target="black">
                                            <img class="avatar-lg" src="{{ asset(config('filemanager.default_backend_image')) }}" style="border: 1px solid #fff;background: #fff;width: 100px">
                                        </a>
                                    </p>
                                    <hr>
                                @endif

                                <p class="card-text">{{ __('strings.Status') }} -
                                    @if($locale->status == "1")
                                        {{ __('strings.Activated') }}
                                    @else
                                        {{ __('strings.Disabled') }}
                                    @endif
                                </p>
                                <hr>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

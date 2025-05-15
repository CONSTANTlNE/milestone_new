@extends('backend.layouts.master')
@section('title') {{ __('strings.View Partner') }} @endsection
@section('content')
    <div class="container-fluid">
        <div class="form-head d-md-flex mb-sm-4 mb-3 align-items-start">
            <div class="mr-auto  d-lg-block">
                <h2 class="text-black font-w600">{{ __('strings.View Partner') }}</h2>
                <p class="mb-0 font-w600">{{ __('strings.Welcome') }}</p>
            </div>
            @can('backend.partners.index')
                <a href="{{ route('backend.partners.index', app()->getLocale())}}" class="btn btn-info rounded"><i class="flaticon-381-repeat-1"></i> {{ __('strings.Return Back') }} - {{ __('strings.Partners') }}</a>
            @endcan
            @can('backend.partners.create')
                <a href="{{ route('backend.partners.create', app()->getLocale())}}" class="btn btn-primary rounded ml-3"><i class="flaticon-381-add-2"></i> {{ __('strings.Add a new Partner') }}</a>
            @endcan
            @can('backend.partners.trash')
                <a href="{{ route('backend.partners.trash', app()->getLocale())}}" class="btn btn-primary rounded light deleted-archive ml-3"><i class="flaticon-381-trash-2"></i> {{ __('strings.Deleted Partners') }}</a>
            @endcan
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="bg-primary text-white-50">
                            <div class="card-body" style="color:#fff;">
                                <p class="card-text">{{ __('strings.Create Date') }} -
                                    {{ $partner->created_at->format('d-m-Y h:i:s') }}
                                </p>
                                <hr>
                                <h5 class="mt-0 mb-4 text-white"><i class="mdi mdi-bullseye-arrow"></i>
                                    {{ __('strings.Title') }} -
                                    @if (Arr::get($partner->getTranslations('title'), app()->getLocale()) === null)
                                        {{ __('strings.TranslationTitle') }} ({{ __('strings.Translated') }} {{ implode(', ', array_keys($partner->getTranslations('title'))) }})
                                    @else
                                        {{Str::limit($partner->getTranslation('title', app()->getLocale()), 30)}}
                                    @endif
                                </h5>
                                <hr>
                                <p class="card-text">{{ __('strings.Partner Url') }} -
                                    {{ $partner->url }}
                                </p>
                                <hr>
                                <p class="card-text">{{ __('strings.Status') }} -
                                    @if($partner->status == "1")
                                        {{ __('strings.Activated') }}
                                    @else
                                        {{ __('strings.Disabled') }}
                                    @endif
                                </p>
                                <hr>

                                @if(isset($partner->generalImage[0]))
                                    @if($partner->generalImage[0]->type == "image")
                                        <hr>
                                        <p class="card-text">{{ __('strings.Main Image') }}:
                                            <a href="{{ asset($partner->generalImage[0]->src ?? asset(config('filemanager.default_backend_image'))) }}" target="black">
                                                <img class="avatar-lg" src="{{ asset($partner->generalImage[0]->src ?? asset(config('filemanager.default_backend_image'))) }}" style="border: 1px solid #fff;background: #fff;width: 100px">
                                            </a>
                                        </p>
                                        <hr>
                                    @else
                                        <hr>
                                        <p class="card-text">{{ __('strings.Main File') }}:
                                            <a href="{{ asset($partner->generalImage[0]->src ?? asset(config('filemanager.default_backend_image'))) }}" target="_blank" class="avatar-lg" style="cursor: pointer;font-size: 52px;color: #3b5de7;display: block;background: #f5f9ff;text-align: center;width: 100px"><i class="fa fa-file sss"></i></a>
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

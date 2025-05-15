@extends('backend.layouts.master')
@section('title') {{ __('strings.View Social Network') }} @endsection
@section('content')
    <div class="container-fluid">
        <div class="form-head d-md-flex mb-sm-4 mb-3 align-items-start">
            <div class="mr-auto  d-lg-block">
                <h2 class="text-black font-w600">{{ __('strings.View Social Network') }}</h2>
                <p class="mb-0 font-w600">{{ __('strings.Welcome') }}</p>
            </div>
            @can('backend.socials.index')
                <a href="{{ route('backend.socials.index', app()->getLocale())}}" class="btn btn-info rounded"><i class="flaticon-381-repeat-1"></i> {{ __('strings.Return Back') }} - {{ __('strings.Social Network') }}</a>
            @endcan
            @can('backend.socials.create')
                <a href="{{ route('backend.socials.create', app()->getLocale())}}" class="btn btn-primary rounded ml-3"><i class="flaticon-381-add-2"></i> {{ __('strings.Add a new Social Network') }}</a>
            @endcan
            @can('backend.socials.trash')
                <a href="{{ route('backend.socials.trash', app()->getLocale())}}" class="btn btn-primary rounded light deleted-archive ml-3"><i class="flaticon-381-trash-2"></i> {{ __('strings.Deleted Social Network') }}</a>
            @endcan
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="bg-primary text-white-50">
                            <div class="card-body" style="color:#fff;">
                                <p class="card-text">{{ __('strings.Create Date') }} -
                                    {{ $social->created_at->format('d-m-Y h:i:s') }}
                                </p>
                                <hr>
                                <h5 class="mt-0 mb-4 text-white"><i class="mdi mdi-bullseye-arrow"></i>
                                    {{ __('strings.Title') }} - {{$social->title}}
                                </h5>
                                <hr>
                                <h5 class="mt-0 mb-4 text-white"><i class="mdi mdi-bullseye-arrow"></i>
                                    {{ __('strings.Code') }} - {{$social->icon}}
                                </h5>
                                <hr>
                                <h5 class="mt-0 mb-4 text-white"><i class="mdi mdi-bullseye-arrow"></i>
                                    {{ __('strings.Links') }} - <a href="{{$social->link}}" target="_blank" style="color: #fff;">{{$social->link}}</a>
                                </h5>
                                <hr>
                                <p class="card-text">{{ __('strings.Status') }} -
                                    @if($social->status == "1")
                                        {{ __('strings.Activated') }}
                                    @else
                                        {{ __('strings.Disabled') }}
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

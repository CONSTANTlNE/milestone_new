@extends('backend.layouts.master')
@section('title') {{ __('strings.View Role') }} @endsection
@section('content')
    <div class="container-fluid">
        <div class="form-head d-md-flex mb-sm-4 mb-3 align-items-start">
            <div class="mr-auto  d-lg-block">
                <h2 class="text-black font-w600">{{ __('strings.View Role') }}</h2>
                <p class="mb-0 font-w600">{{ __('strings.Welcome') }}</p>
            </div>
            @can('backend.roles.index')
                <a href="{{ route('backend.roles.index', app()->getLocale())}}" class="btn btn-info rounded"><i class="flaticon-381-repeat-1"></i> {{ __('strings.Return Back') }} - {{ __('strings.All Role') }}</a>
            @endcan
            @can('backend.roles.create')
                <a href="{{ route('backend.roles.create', app()->getLocale())}}" class="btn btn-primary rounded ml-3"><i class="flaticon-381-add-2"></i> {{ __('strings.Add a new Role') }}</a>
            @endcan
            @can('backend.roles.trash')
                <a href="{{ route('backend.roles.trash', app()->getLocale())}}" class="btn btn-primary rounded light deleted-archive ml-3"><i class="flaticon-381-trash-2"></i> {{ __('strings.Deleted Roles') }}</a>
            @endcan
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="bg-primary text-white-50 mb-0">
                            <div class="card-body" style="color:#fff;">
                                <p class="card-text">{{ __('strings.Create Date') }} -
                                    {{ $role->created_at->format('d-m-Y h:i:s') }}
                                </p>
                                <hr>
                                <h5 class="mt-0 mb-4 text-white"><i class="mdi mdi-bullseye-arrow"></i>{{ __('strings.Title') }} - {{$role->title}}</h5>
                                <hr>
                                <p class="card-text">{{ __('strings.Role Name') }} - {{$role->name}}</p>
                                <hr>
                                <div class="form-group position-relative">
                                    <h5 class="mt-0 mb-4 text-white">{{ __('strings.All Permission') }}:</h5>
                                    @foreach($role->permissions as $permission)
                                        {{$permission->name}}  |
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

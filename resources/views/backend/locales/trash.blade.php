@extends('backend.layouts.master')
@section('title') {{ __('strings.Deleted Languages') }} @endsection
@section('content')
    <div class="container-fluid">
        <div class="form-head d-md-flex mb-sm-4 mb-3 align-items-start">
            <div class="mr-auto  d-lg-block">
                <h2 class="text-black font-w600">{{ __('strings.Deleted Languages') }}</h2>
                <p class="mb-0 font-w600">{{ __('strings.Welcome') }}</p>
            </div>
            @can('backend.locales.index')
                <a href="{{ route('backend.locales.index', app()->getLocale())}}" class="btn btn-info rounded"><i class="flaticon-381-repeat-1"></i> {{ __('strings.Return Back') }} - {{ __('strings.All Languages') }}</a>
            @endcan
            @can('backend.locales.create')
                <a href="{{ route('backend.locales.create', app()->getLocale())}}" class="btn btn-primary rounded ml-3">{{ __('strings.Add a new Language') }}</a>
            @endcan
        </div>
        @if(session('success'))
            @include('backend.layouts.components.success',[
              'success' => session('success'),
            ])
        @endif
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-responsive-md">
                                <thead>
                                <tr>
                                    <th class="width80"><strong>#id</strong></th>
                                    <th><strong>{{ __('strings.Title') }}</strong></th>
                                    <th><strong>{{ __('strings.Code') }}</strong></th>
                                    <th><strong>{{ __('strings.Images') }}</strong></th>
                                    <th><strong>{{ __('strings.Actions') }}</strong></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($locales as $locale)
                                    <tr>
                                        <td><strong>{{$locale->id}}</strong></td>
                                        <td>{{$locale->name}}</td>
                                        <td>{{$locale->code}}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="{{ asset($locale->generalImage[0]->src ?? config('filemanager.default_backend_image')) }}" class="rounded-lg mr-2" width="24" alt="">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex">
                                                @can('backend.locales.restore')
                                                    <a href="{{ route('backend.locales.restore', [app()->getLocale(), 'id'=>$locale->id]) }}"
                                                       class="btn btn-success shadow btn-xs sharp restore" style="color: #fff">
                                                        <i class="flaticon-381-back-2"></i>
                                                        <span>{{ __('strings.Restore') }}</span>
                                                    </a>
                                                @endcan
                                                @can('backend.locales.remove')
                                                    <form action="{{ route('backend.locales.remove', [app()->getLocale(), $locale->id]) }}" method="POST" class="action-list d-inline-block last-delete ml-2" onsubmit="return confirm('{{ __('strings.Really Final Deletion') }}');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-danger shadow btn-xs sharp">
                                                            <i class="flaticon-381-trash-2"></i>
                                                            <span>{{ __('strings.Final Deletion') }}</span>
                                                        </button>
                                                    </form>
                                                @endcan
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

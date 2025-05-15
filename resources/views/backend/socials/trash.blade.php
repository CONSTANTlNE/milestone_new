@extends('backend.layouts.master')
@section('title') {{ __('strings.Deleted Social Network') }} @endsection
@section('content')
    <div class="container-fluid">
        <div class="form-head d-md-flex mb-sm-4 mb-3 align-items-start">
            <div class="mr-auto  d-lg-block">
                <h2 class="text-black font-w600">{{ __('strings.Deleted Social Network') }}</h2>
                <p class="mb-0 font-w600">{{ __('strings.Welcome') }}</p>
            </div>
            @can('backend.socials.index')
                <a href="{{ route('backend.socials.index', app()->getLocale())}}" class="btn btn-info rounded"><i class="flaticon-381-repeat-1"></i> {{ __('strings.Return Back') }} - {{ __('strings.Social Network') }}</a>
            @endcan
            @can('backend.socials.create')
                <a href="{{ route('backend.socials.create', app()->getLocale())}}" class="btn btn-primary rounded ml-3">{{ __('strings.Add a new Social Network') }}</a>
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
                                    <th><strong>{{ __('strings.Actions') }}</strong></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($socials as $social)
                                    <tr>
                                        <td><strong>{{$social->id}}</strong></td>
                                        <td>{{$social->title}}</td>
                                        <td>{{$social->icon}}</td>
                                        <td>
                                            <div class="d-flex">
                                                @can('backend.socials.restore')
                                                    <a href="{{ route('backend.socials.restore', [app()->getLocale(), $social->id]) }}"
                                                       class="btn btn-success shadow btn-xs sharp restore" style="color: #fff">
                                                        <i class="flaticon-381-back-2"></i>
                                                        <span>{{ __('strings.Restore') }}</span>
                                                    </a>
                                                @endcan
                                                @can('backend.socials.remove')
                                                    <form action="{{ route('backend.socials.remove', [app()->getLocale(), $social->id]) }}" method="POST" class="action-list d-inline-block last-delete ml-2" onsubmit="return confirm('{{ __('strings.Really Final Deletion') }}');">
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

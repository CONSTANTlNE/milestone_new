@extends('backend.layouts.master')
@section('title') {{ __('strings.All Languages') }} @endsection
@push('styles')
    <link href="{{URL::asset('css/additional/toastr.min.css')}}" rel="stylesheet" type="text/css" >
@endpush
@section('content')
    <div class="container-fluid">
        <div class="form-head d-md-flex mb-sm-4 mb-3 align-items-start">
            <div class="mr-auto  d-lg-block">
                <h2 class="text-black font-w600">{{ __('strings.All Languages') }}</h2>
                <p class="mb-0 font-w600">{{ __('strings.Welcome') }}</p>
            </div>
            @can('backend.locales.create')
            <a href="{{ route('backend.locales.create', app()->getLocale())}}" class="btn btn-primary rounded"><i class="flaticon-381-add-2"></i> {{ __('strings.Add a new Language') }}</a>
            @endcan
            @can('backend.locales.trash')
            <a href="{{ route('backend.locales.trash', app()->getLocale())}}" class="btn btn-primary rounded light deleted-archive ml-3"><i class="flaticon-381-trash-2"></i> {{ __('strings.Deleted Languages') }}</a>
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
                                    <th><strong>{{ __('strings.Main Language') }}</strong></th>
                                    <th><strong>{{ __('strings.Title') }}</strong></th>
                                    <th><strong>{{ __('strings.Code') }}</strong></th>
                                    <th><strong>{{ __('strings.Images') }}</strong></th>
                                    <th><strong>{{ __('strings.Status') }}</strong></th>
                                    <th><strong>{{ __('strings.Actions') }}</strong></th>
                                </tr>
                                </thead>
                                <tbody id="post_sortable" class="post_list_ul datatable-status"
                                       data-reorder="{{route('backend.locales.reorder', app()->getLocale())}}"
                                >
                                    @foreach($locales as $locale)
                                    <tr class="ui-state-default" data-id="{{ $locale->id }}">
                                        <td><strong>{{$locale->id}}</strong></td>
                                        <td width="150">
                                            <div class="form-switch">
                                                <a id="general-{{$locale->id}}"
                                                           @if($locale->default === 0)
                                                               href="{{ route('backend.locales.general', [app()->getLocale(), $locale->id]) }}"
                                                           @else
                                                               href="#"
                                                           @endif
                                                        class="btn btn-lg btn-toggle btn-toggle-switch {{ $locale->default === 0 ? "" : "active" }}"
                                                        >
                                                    <div class="switch"></div>
                                                </a>
                                            </div>
                                        </td>
                                        <td>{{$locale->name}}</td>
                                        <td>{{$locale->code}}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="{{ asset($locale->generalImage[0]->src ?? config('filemanager.default_backend_image')) }}" class="rounded-lg mr-2" width="24" alt="">
                                            </div>
                                        </td>
                                        <td width="200" id="parent-{{$locale->id}}">
                                            @if($locale->default != 1)
                                                <div class="form-switch mr-3">
                                                    <a id="status-{{$locale->id}}"
                                                       href="{{ route('backend.locales.status', [app()->getLocale(), $locale->id]) }}"
                                                       class="btn btn-lg btn-toggle btn-toggle-switch {{ $locale->status === 0 ? "" : "active" }}"
                                                    >
                                                        <div class="switch"></div>
                                                    </a>
                                                </div>
                                            @else
                                                <span class="w-75 fs-12 d-block">{{ __('strings.The status of the main language will not change') }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex">
                                                @can('backend.locales.show')
                                                <a href="{{ route('backend.locales.show', [app()->getLocale(), $locale->id]) }}" class="btn btn-warning shadow btn-xs sharp mr-1" style="color: #fff"><i class="flaticon-381-view-2"></i></a>
                                                @endcan
                                                @can('backend.locales.edit')
                                                <a href="{{ route('backend.locales.edit', [app()->getLocale(), $locale->id]) }}" class="btn btn-primary shadow btn-xs sharp mr-1"><i class="flaticon-381-edit-1"></i></a>
                                                @endcan
                                                @if($locale->default != 1)
                                                    @can('backend.locales.destroy')
                                                        <form action="{{ route('backend.locales.destroy', [app()->getLocale(), $locale->id]) }}" method="POST" class="action-list d-inline-block" onsubmit="return confirm('{{ __('strings.You really want to delete it') }}');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="btn btn-danger shadow btn-xs sharp"><i class="flaticon-381-trash-2"></i></button>
                                                        </form>
                                                    @endcan
                                                @endif
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
@push('scripts')
    <script src="{{URL::asset('/js/additional/sortable.min.js')}}"></script>
@endpush

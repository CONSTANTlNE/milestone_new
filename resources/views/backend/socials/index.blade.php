@extends('backend.layouts.master')
@section('title') {{ __('strings.Social Network') }} @endsection
@push('styles')
    <link href="{{URL::asset('css/additional/toastr.min.css')}}" rel="stylesheet" type="text/css" >
@endpush
@section('content')
    <div class="container-fluid">
        <div class="form-head d-md-flex mb-sm-4 mb-3 align-items-start">
            <div class="mr-auto  d-lg-block">
                <h2 class="text-black font-w600">{{ __('strings.Social Network') }}</h2>
                <p class="mb-0 font-w600">{{ __('strings.Welcome') }}</p>
            </div>
            @can('backend.socials.create')
                <a href="{{ route('backend.socials.create', app()->getLocale())}}" class="btn btn-primary rounded"><i class="flaticon-381-add-2"></i> {{ __('strings.Add a new Social Network') }}</a>
            @endcan
            @can('backend.socials.trash')
                <a href="{{ route('backend.socials.trash', app()->getLocale())}}" class="btn btn-primary rounded light deleted-archive ml-3"><i class="flaticon-381-trash-2"></i> {{ __('strings.Deleted Social Network') }}</a>
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
                                    @can('backend.socials.status')
                                    <th><strong>{{ __('strings.Status') }}</strong></th>
                                    @endcan
                                    <th><strong>{{ __('strings.Actions') }}</strong></th>
                                </tr>
                                </thead>
                                <tbody id="post_sortable" class="post_list_ul datatable-status"
                                       data-reorder="{{route('backend.socials.reorder', app()->getLocale())}}"
                                       data-status="{{ route('backend.socials.status', app()->getLocale()) }}"
                                >
                                @foreach($socials as $social)
                                    <tr class="ui-state-default" data-id="{{ $social->id }}">
                                        <td><strong>{{$social->id}}</strong></td>
                                        <td>{{$social->title}}</td>
                                        <td>{{ __('strings.Code') }} : {{$social->icon}}</td>
                                        @can('backend.socials.status')
                                        <td>
                                            <div class="custom-control-status custom-control custom-switch mb-2" dir="ltr">
                                                <input id="customSwitch{{$social->id}}" class="custom-control-input status"
                                                       data-id="{{$social->id}}"
                                                       type="checkbox"
                                                       data-onstyle="yes"
                                                       data-offstyle="no"
                                                       data-toggle="toggle"
                                                       data-on=" " data-off=" "
                                                    {{ $social->status ? 'checked' : '' }}>
                                                <label class="custom-control-label no-datatable" for="customSwitch{{$social->id}}" style="cursor: pointer;"></label>
                                            </div>
                                        </td>
                                        @endcan
                                        <td>
                                            <div class="d-flex">
                                                @can('backend.socials.show')
                                                    <a href="{{ route('backend.socials.show', [app()->getLocale(), $social->id]) }}" class="btn btn-warning shadow btn-xs sharp mr-1" style="color: #fff"><i class="flaticon-381-view-2"></i></a>
                                                @endcan
                                                @can('backend.socials.edit')
                                                    <a href="{{ route('backend.socials.edit', [app()->getLocale(), $social->id]) }}" class="btn btn-primary shadow btn-xs sharp mr-1"><i class="flaticon-381-edit-1"></i></a>
                                                @endcan
                                                @can('backend.socials.destroy')
                                                    <form action="{{ route('backend.socials.destroy', [app()->getLocale(), $social->id]) }}" method="POST" class="action-list d-inline-block" onsubmit="return confirm('{{ __('strings.You really want to delete it') }}');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-danger shadow btn-xs sharp"><i class="flaticon-381-trash-2"></i></button>
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
@push('scripts')
    <script src="{{URL::asset('/js/additional/sortable.min.js')}}"></script>
@endpush

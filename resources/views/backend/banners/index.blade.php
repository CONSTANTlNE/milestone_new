@extends('backend.layouts.master')
@section('title') {{ __('strings.Banners') }} @endsection
@push('styles')
    <link href="{{URL::asset('css/additional/toastr.min.css')}}" rel="stylesheet" type="text/css" >
@endpush
@section('content')
    <div class="container-fluid">
        <div class="form-head d-md-flex mb-sm-4 mb-3 align-items-start">
            <div class="mr-auto  d-lg-block">
                <h2 class="text-black font-w600">{{ __('strings.All Banner') }}</h2>
                <p class="mb-0 font-w600">{{ __('strings.Welcome') }}</p>
            </div>
            @can('backend.banners.create')
                <a href="{{ route('backend.banners.create', app()->getLocale()) }}" class="btn btn-primary rounded mr-3"><i class="flaticon-381-add-2"></i> {{ __('strings.Add a new Banner') }}</a>
            @endcan
            @can('backend.banners.position')
                <a href="{{ route('backend.banners.position', app()->getLocale()) }}" class="btn btn-warning rounded mr-3"><i class="flaticon-381-more-1"></i> {{ __('strings.Reorder') }}</a>
            @endcan
            @can('backend.banners.trash')
                <a href="{{ route('backend.banners.trash', app()->getLocale()) }}" class="btn btn-primary rounded light deleted-archive"><i class="flaticon-381-trash-2"></i> {{ __('strings.Deleted Banners') }}</a>
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
                        <div class="table-responsive datatable-status yes-datatable"
                             data-status="{{ route('backend.banners.status', app()->getLocale()) }}"
                        >
                            {{ $dataTable->table() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="{{asset('js/additional/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('/js/additional/toastr.min.js')}}"></script>
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush

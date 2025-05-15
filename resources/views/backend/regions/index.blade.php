@extends('backend.layouts.master')
@section('title') {{ __('strings.Regions') }} @endsection
@push('styles')
    <link href="{{URL::asset('css/additional/toastr.min.css')}}" rel="stylesheet" type="text/css" >
@endpush
@section('content')
    <div class="container-fluid">
        <div class="form-head d-md-flex mb-sm-4 mb-3 align-items-start">
            <div class="mr-auto  d-lg-block">
                <h2 class="text-black font-w600">{{ __('strings.Regions') }}</h2>
                <p class="mb-0 font-w600">{{ __('strings.Welcome') }}</p>
            </div>
            @can('backend.regions.create')
                <a href="{{ route('backend.regions.create', app()->getLocale()) }}" class="btn btn-primary rounded mr-3"><i class="flaticon-381-add-2"></i> {{ __('strings.Add a new Regions') }}</a>
            @endcan
            @can('backend.regions.create')
                <a href="{{ route('backend.regions.rewrite', app()->getLocale()) }}" class="btn btn-primary rounded mr-3"><i class="flaticon-381-upload-1"></i> {{ __('strings.Rewrite') }}</a>
            @endcan
            @can('backend.regions.trash')
                <a href="{{ route('backend.regions.trash', app()->getLocale()) }}" class="btn btn-primary rounded light deleted-archive"><i class="flaticon-381-trash-2"></i> {{ __('strings.Deleted Regions') }}</a>
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
                             data-status="{{ route('backend.regions.status', app()->getLocale()) }}"
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

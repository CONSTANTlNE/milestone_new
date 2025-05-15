@extends('backend.layouts.master')
@section('title') {{ __('strings.Teams') }} @endsection
@push('styles')
    <link href="{{URL::asset('css/additional/toastr.min.css')}}" rel="stylesheet" type="text/css" >
@endpush
@section('content')
    <div class="container-fluid">
        <div class="form-head d-md-flex mb-sm-4 mb-3 align-items-start">
            <div class="mr-auto  d-lg-block">
                <h2 class="text-black font-w600">{{ __('strings.All Team') }}</h2>
                <p class="mb-0 font-w600">{{ __('strings.Welcome') }}</p>
            </div>
            @can('backend.teams.create')
                <a href="{{ route('backend.teams.create', app()->getLocale()) }}" class="btn btn-primary rounded mr-3"><i class="flaticon-381-add-2"></i> {{ __('strings.Add a new Team') }}</a>
            @endcan
            @can('backend.teams.position')
                <a href="{{ route('backend.teams.position', app()->getLocale()) }}" class="btn btn-warning rounded mr-3"><i class="flaticon-381-more-1"></i> {{ __('strings.Reorder') }}</a>
            @endcan
            @can('backend.teams.trash')
                <a href="{{ route('backend.teams.trash', app()->getLocale()) }}" class="btn btn-primary rounded light deleted-archive"><i class="flaticon-381-trash-2"></i> {{ __('strings.Deleted Teams') }}</a>
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
                             data-status="{{ route('backend.teams.status', app()->getLocale()) }}"
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

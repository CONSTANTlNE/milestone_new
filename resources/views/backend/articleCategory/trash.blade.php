@extends('backend.layouts.master')
@section('title') {{ __('strings.Deleted Category Articles') }} @endsection
@section('content')
    <div class="container-fluid">
        <div class="form-head d-md-flex mb-sm-4 mb-3 align-items-start">
            <div class="mr-auto  d-lg-block">
                <h2 class="text-black font-w600">{{ __('strings.Deleted Category Articles') }}</h2>
                <p class="mb-0 font-w600">{{ __('strings.Welcome') }}</p>
            </div>
            @can('backend.articleCategory.index')
                <a href="{{ route('backend.articleCategory.index', app()->getLocale())}}" class="btn btn-info rounded"><i class="flaticon-381-repeat-1"></i> {{ __('strings.Return Back') }} - {{ __('strings.Category Articles') }}</a>
            @endcan
            @can('backend.articleCategory.create')
                <a href="{{ route('backend.articleCategory.create', app()->getLocale()) }}" class="btn btn-primary rounded ml-3"><i class="flaticon-381-add-2"></i> {{ __('strings.Add a new Category Articles') }}</a>
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
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush

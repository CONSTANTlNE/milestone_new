@extends('backend.layouts.master')
@section('title') {{ __('strings.Subscribers') }} @endsection
@section('content')
    <div class="container-fluid">
        <div class="form-head d-md-flex mb-sm-4 mb-3 align-items-start">
            <div class="mr-auto  d-lg-block">
                <h2 class="text-black font-w600">{{ __('strings.All Subscriber') }}</h2>
                <p class="mb-0 font-w600">{{ __('strings.Welcome') }}</p>
            </div>
            @can('backend.subscribers.trash')
                <a href="{{ route('backend.subscribers.trash', app()->getLocale()) }}" class="btn btn-primary rounded light deleted-archive"><i class="flaticon-381-trash-2"></i> {{ __('strings.Deleted Subscribers') }}</a>
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
    <script src="{{asset('js/additional/datatables/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('js/additional/datatables/buttons.server-side.js')}}"></script>
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush

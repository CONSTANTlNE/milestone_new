@extends('backend.layouts.master')
@section('title') {{ __('strings.File Manager') }} @endsection
@section('content')
    <div class="container-fluid">
        <div class="form-head d-md-flex mb-sm-4 mb-3 align-items-start">
            <div class="mr-auto  d-lg-block">
                <h2 class="text-black font-w600">{{ __('strings.File Manager') }}</h2>
                <p class="mb-0 font-w600">{{ __('strings.Welcome') }}</p>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body card-file-manager">
                        <div id="file-manager-static"></div>
                        @include('backend.fileManager.templates.file-manager-board')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
  <script>
      $(function () {
          var indexRoute = "{{ route('backend.files.index', app()->getLocale()) }}";
          window.fileManager = createFileManager({
              el: $('#file-manager-static'),
              indexRoute: indexRoute
          });
          window.fileManager.load();
      });
  </script>
@endpush

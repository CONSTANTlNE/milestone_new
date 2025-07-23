@extends('backend.layouts.master')
@section('title') {{ __('admin.file_manager') }} @endsection
@section('content')
    <div class="content">
        <div class="main-content">
            <div id="file-manager-static"></div>
            @include('backend.fileManager.templates.file-manager-board')
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const fileManagerEl = document.querySelector('#file-manager-static');
            const indexRoute = "{{route('backend.files.index')}}";

            if (fileManagerEl) {
                window.fileManager = createFileManager({
                    el: fileManagerEl,
                    indexRoute: indexRoute
                });

                window.fileManager.load();
            }
        });
    </script>
@endpush

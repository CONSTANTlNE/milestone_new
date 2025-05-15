<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <title> @yield('title') | {{ __('site title') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="{{ __('site title') }}" name="description" />
    <meta content="boris barabadze" name="author" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <!-- App favicon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon.png') }}">
{{--    @include('backend.layouts.head')--}}
{{--    <link href="{{ asset('build/assets/app-hvPi3zSJ.css') }}" rel="stylesheet" type="text/css"/>--}}
{{--    @vite(['public/css/style.css'])--}}
    @stack('styles')

</head>
<body>
<div id="preloader">
    <div class="sk-three-bounce">
        <div class="sk-child sk-bounce1"></div>
        <div class="sk-child sk-bounce2"></div>
        <div class="sk-child sk-bounce3"></div>
    </div>
</div>

<div id="main-wrapper">
    <div class="nav-header">
        <a href="{{ route('backend.index')}}" class="brand-logo">
            <img class="logo-abbr" src="{{ asset('images/logo.png') }}" alt="">
        </a>
        <div class="nav-control">
            <div class="hamburger">
                <span class="line"></span><span class="line"></span><span class="line"></span>
            </div>
        </div>
    </div>

    @include('backend.layouts.header')

{{--    @include('backend.layouts.sidebar')--}}
    <div class="content-body">
        @yield('content')
    </div>

    @include('backend.layouts.footer')
</div>
    {{--	@include('elements.footer-scripts')--}}
    {{--<script src="{{ asset('build/assets/app-X0b48MIg.js') }}" type="text/javascript"></script>--}}
    {{--@vite(['public/js/app.js'])--}}

    <script src="{{ asset('vendor/global/global.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('vendor/bootstrap-select/dist/js/bootstrap-select.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('vendor/peity/jquery.peity.min.js') }}" type="text/javascript"></script>
    {{--defer="defer"--}}
    @stack('scripts')
    <script src="{{ asset('js/custom.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/deznav-init.js') }}" type="text/javascript"></script>

</body>
</html>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="ltr" data-nav-layout="vertical" class="light" data-header-styles="light" data-menu-styles="dark">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>@yield('title') | {{ __('config.admin_title') }}</title>
    <meta name="description" content="{{ __('config.admin_description') }}">
    <meta name="keywords" content="{{ __('config.admin_keywords') }}">
    <meta name="author" content="{{ __('config.admin_author') }}" />

    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset(config('filemanager.favicons.32')) }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset(config('filemanager.favicons.16')) }}">
    <link rel="apple-touch-icon" href="{{ asset(config('filemanager.favicons.apple')) }}">
    <meta name="theme-color" content="#ffffff">

    @vite('public/css/admin-app.css')
    @yield('styles')
    
</head>
<body>
    <div id="loader" >
        <img src="{{ asset('backend/assets/images/loader.svg') }}" alt="{{ __('config.admin_title') }} - loader">
    </div>

    <div class="page">
        @include('backend.layouts.header')
        @include('backend.layouts.sidebar')
        @yield('content')
        @include('backend.layouts.footer')
    </div>

    @vite('public/js/admin-app.js')
    @stack('scripts')
</body>
</html>

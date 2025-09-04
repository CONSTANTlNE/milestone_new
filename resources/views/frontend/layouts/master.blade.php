<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>@yield('title') {{__('site_title')}}</title>
    <meta name="robots" content="noindex, follow">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="htmx-config" content='{"selfRequestsOnly":false}'>
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('assets/images/favicon.ico')}}">
    @include('frontend.layouts.head')
    @vite('resources/js/app.js')
    @yield('seo')
    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js?render=explicit&onload=onloadTurnstileCallback" defer></script>
    {{--    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>--}}
</head>
<body >
<div class="page-wrapper" id="page">
    <header class="site-header header-style-1">
        @include('frontend.layouts.header')
        @yield('header_background')
    </header>
    <div class="page-content">
        @yield('content')
    </div>
    @include('frontend.layouts.footer')
</div>
@include('frontend.layouts.scripts')
</body>
</html>

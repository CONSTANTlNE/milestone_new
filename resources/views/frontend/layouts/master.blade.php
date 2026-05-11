<!doctype html>
<html class="no-js" lang="en">
<head>
  <!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-2TSXS9B2X7"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-2TSXS9B2X7');
</script>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>@yield('title') {{__('site_title')}}</title>
    <meta name="robots" content="index, follow">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="htmx-config" content='{"selfRequestsOnly":false}'>
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('assets/images/favicon.ico')}}">
    @include('frontend.layouts.head')
    @vite('resources/js/app.js')
    @yield('seo')
{{--    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js?render=explicit&onload=onloadTurnstileCallback" defer></script>--}}
    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
</head>
<body >
<div class="page-wrapper" id="page">
    <header class="site-header {{ !empty($class) ? 'header-style-2' : 'header-style-1'}}">
        @include('frontend.layouts.header')
        @yield('header_background')
        @if(getPageById(20) !== null or getPageById(19) !== null)
{{--        <div class="container">--}}
{{--            <div class="row">--}}
{{--                <div class="clients-mobile mt-2">--}}
{{--                    @if(getPageById(19) !== null)--}}
{{--                        <div class="pbmit-button">--}}
{{--                            <a class="pbmit-btn" href="{{ route(getPageById(19)->template) }}">--}}
{{--                            <span class="pbmit-button-content-wrapper">--}}
{{--                                <span class="pbmit-button-text">{{getPageById(19)->title}}</span>--}}
{{--                            </span>--}}
{{--                            </a>--}}
{{--                        </div>--}}
{{--                    @endif--}}
{{--                    @if(getPageById(20) !== null)--}}
{{--                    <div class="pbmit-button mt-2">--}}
{{--                        <a class="pbmit-btn" href="{{ route(getPageById(20)->template) }}">--}}
{{--                            <span class="pbmit-button-content-wrapper">--}}
{{--                                <span class="pbmit-button-text">{{getPageById(20)->title}}</span>--}}
{{--                            </span>--}}
{{--                        </a>--}}
{{--                    </div>--}}
{{--                    @endif--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
        @endif
    </header>
    <div class="page-content">
        @yield('content')
    </div>
    @include('frontend.layouts.footer')
</div>
@include('frontend.layouts.scripts')
</body>
</html>

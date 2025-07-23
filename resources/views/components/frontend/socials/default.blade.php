    <title>{{ __('site slogan') }} | {{ __('site_title') }}</title>
    <meta name="description" content="{{ __('site_description') }}"/>
    <meta name="keywords" content="{{ __('site_keywords') }}"/>
{{--    <meta property="og:url" content="{{url(app()->getLocale().''.Session::get('langPath'))}}">--}}
    <meta property="og:site_name" content="{{ __('site_title') }}"/>
    <meta property="og:title" content="{{ __('site_slogan') }} | {{ __('site_title') }}">
    <meta property="og:type" content="article">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image" content="{{ asset(config('filemanager.default_seo_image')) }}">
    <meta property="og:description" content="{{ __('site_description') }}">
    <meta property="fb:app_id" content="">
    <meta property="fb:pages" content="">
    <meta itemprop="name" content="">
    <meta itemprop="image" content="{{ asset(config('filemanager.default_seo_image')) }}">
    <meta name="twitter:card" content="summary_large_image" />
{{--    <meta name="twitter:url" content="{{url(app()->getLocale().''.Session::get('langPath'))}}" />--}}
    <meta name="twitter:title" content="{{ __('site_slogan') }} | {{ __('site_title') }}" />
    <meta name="twitter:description" content="{{ __('site_description') }}" />
    <meta name="twitter:image:src" content="{{ asset(config('filemanager.default_seo_image')) }}" />
    <meta name="twitter:site" content="{{ __('site_title') }}" />

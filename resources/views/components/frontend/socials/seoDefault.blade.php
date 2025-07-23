    <title>{{$data->getTranslation('title', app()->getLocale()) }} | {{ __('site_title') }}</title>
    <meta name="description" content="{{ Str::limit(strip_tags($data->content), 150) }}"/>
    <meta name="keywords" content=""/>
{{--    <meta property="og:url" content="{{url(app()->getLocale().''.Session::get('langPath'))}}">--}}
    <meta property="og:site_name" content="{{ __('site_title') }}"/>
    <meta property="og:title" content="{{$data->getTranslation('title', app()->getLocale())}} | {{ __('site_title') }}">
    <meta property="og:type" content="article">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image" content="{{ asset($data->src ?: config('filemanager.default_backend_image')) }}">
    <meta property="og:description" content="{{ Str::limit($data->content, 150) }}">
    <meta property="fb:app_id" content="">
    <meta property="fb:pages" content="">
    <meta itemprop="name" content="">
    <meta itemprop="image" content="{{ asset($data->src ?: config('filemanager.default_backend_image')) }}">
    <meta name="twitter:card" content="summary_large_image" />
{{--    <meta name="twitter:url" content="{{url(app()->getLocale().''.Session::get('langPath'))}}" />--}}
    <meta name="twitter:title" content="{{$data->getTranslation('title', app()->getLocale()) ?? ''}} | {{ __('site_title') }}" />
    <meta name="twitter:description" content="{{ Str::limit($data->content, 150) }}" />
    <meta name="twitter:image:src" content="{{ asset($data->src ?: config('filemanager.default_backend_image')) }}" />
    <meta name="twitter:site" content="{{ __('site_title') }}" />

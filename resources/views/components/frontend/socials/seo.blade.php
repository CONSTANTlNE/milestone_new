@if(!empty(optional($data)->seo) && !empty(optional($data)->seo->first()))
    <title>{{$data->seo->first()->getTranslation('seoTitles', app()->getLocale()) ?? ''}} | {{ __('site_title') }}</title>
    <meta name="description" content="{{$data->seo->first()->getTranslation('seoDescriptions', app()->getLocale()) ?? ''}}"/>
    <meta name="keywords" content="{{$data->seo->first()->getTranslation('seoKeywords', app()->getLocale()) ?? ''}}"/>
{{--    <meta property="og:url" content="{{url(app()->getLocale().''.Session::get('langPath'))}}">--}}
    <meta property="og:site_name" content="{{ __('site_title') }}"/>
    <meta property="og:title" content="{{$data->seo->first()->getTranslation('seoTitles', app()->getLocale()) ?? ''}} | {{ __('site_title') }}">
    <meta property="og:type" content="article">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image" content="{{ asset($data->src ?: config('filemanager.default_backend_image')) }}">
    <meta property="og:description" content="{{$data->seo->first()->getTranslation('seoDescriptions', app()->getLocale()) ?? ''}}">
    <meta property="fb:app_id" content="">
    <meta property="fb:pages" content="">
    <meta itemprop="name" content="">
    <meta itemprop="image" content="{{ asset($data->src ?: config('filemanager.default_backend_image')) }}">
    <meta name="twitter:card" content="summary_large_image" />
{{--    <meta name="twitter:url" content="{{url(app()->getLocale().''.Session::get('langPath'))}}" />--}}
    <meta name="twitter:title" content="{{$data->seo->first()->getTranslation('seoTitles', app()->getLocale()) ?? ''}} | {{ __('site_title') }}" />
    <meta name="twitter:description" content="{{$data->seo->first()->getTranslation('seoDescriptions', app()->getLocale()) ?? ''}}" />
    <meta name="twitter:image:src" content="{{ asset($data->src ?: config('filemanager.default_backend_image')) }}" />
    <meta name="twitter:site" content="{{ __('site_title') }}" />
@elseif(!empty($data))
    @include('components.frontend.socials.seoDefault', ['data' => $data])
@else
    @include('components.frontend.socials.default')
@endif


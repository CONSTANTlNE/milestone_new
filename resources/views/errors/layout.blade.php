<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>{{ __('config.admin_title') }} - @yield('code')</title>
    <meta name="description" content="{{ __('config.admin_description') }}">
    <meta name="keywords" content="{{ __('config.admin_keywords') }}">
    <meta name="author" content="{{ __('config.admin_author') }}" />

    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset(config('filemanager.favicons.32')) }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset(config('filemanager.favicons.16')) }}">
    <link rel="apple-touch-icon" href="{{ asset(config('filemanager.favicons.apple')) }}">
    <meta name="theme-color" content="#ffffff">

    @vite('public/css/error-app.css')
</head>
<body>

    <div id="loader" >
        <img src="{{ asset('backend/assets/images/loader.svg') }}" alt="{{ __('config.admin_title') }} - loader">
    </div>

    <div class="page error-bg dark:!bg-bodybg">
        <div class="error-page">
            <div class="container text-defaulttextcolor dark:text-defaulttextcolor/70 text-defaultsize">
                <div class="text-center p-5 my-auto">
                    <div class="flex items-center justify-center h-full">
                      <div class="xl:col-span-3"></div>
                        <div class="xl:col-span-6 col-span-12">
                            <p class="error-text sm:mb-0 mb-2">@yield('code')</p>
                            <p class="text-[1.125rem] font-semibold font-second-geo mb-4">Oops &#128557;, @yield('error-message')</p>
                            <div class="flex justify-center items-center mb-[3rem]">
                                <div class="xl:col-span-6 w-[70%]">
                                    <p class="mb-0 opacity-[0.7] font-second-geo">@yield('message')</p>
                                </div>
                            </div>
                            @yield('link')
                        </div>
                        <div class="xl:col-span-3"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @vite('public/js/error-app.js')
</body>
</html>
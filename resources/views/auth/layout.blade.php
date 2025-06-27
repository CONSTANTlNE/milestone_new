<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>@yield('title') - {{ __('config.admin_title') }} </title>
    <meta name="description" content="{{ __('config.admin_description') }}">
    <meta name="keywords" content="{{ __('config.admin_keywords') }}">
    <meta name="author" content="{{ __('config.admin_author') }}" />

    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset(config('filemanager.favicons.32')) }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset(config('filemanager.favicons.16')) }}">
    <link rel="apple-touch-icon" href="{{ asset(config('filemanager.favicons.apple')) }}">
    <meta name="theme-color" content="#ffffff">

    @vite('public/css/auth-app.css')
</head>
<body class="bg-white dark:!bg-bodybg">
    <div id="loader" >
        <img src="{{ asset(config('filemanager.default_auth_loader')) }}" alt="{{ __('config.admin_title') }} - loader">
    </div>
    <div class="grid grid-cols-12 authentication mx-0 text-defaulttextcolor text-defaultsize">
        <div class="xxl:col-span-7 xl:col-span-7 lg:col-span-12 col-span-12">
            <div class="flex justify-center items-center h-full">
                <div class="xxl:col-span-3 xl:col-span-3 lg:col-span-3 md:col-span-3 sm:col-span-2"></div>
                <div class="xxl:col-span-6 xl:col-span-6 lg:col-span-6 md:col-span-6 sm:col-span-8 col-span-12">
                    <div class="p-[3rem]">
                        <div class="xl:col-span-12 col-span-12 mb-4 overflow-hidden">
                            <p class="h5 font-semibold mb-2 float-left font-first-geo">@yield('title')</p>
                            <div class="ti-btn ti-btn-icon ti-btn-light float-right">
                                <a aria-label="anchor"
                                   class="hs-dark-mode-active:hidden flex hs-dark-mode group
                                   flex-shrink-0 justify-center items-center gap-2 font-medium
                                   transition-all text-lg dark:text-[#8c9097]
                                   dark:text-white/50 dark:hover:text-white dark:focus:ring-white/10 dark:focus:ring-offset-white/10"
                                   href="javascript:void(0);" data-hs-theme-click-value="dark">
                                    <i class="ri ri-contrast-2-fill header-link-icon"></i>
                                </a>
                                <a aria-label="anchor"
                                   class="hs-dark-mode-active:flex hidden hs-dark-mode group flex-shrink-0
                                   justify-center items-center gap-2 font-medium text-defaulttextcolor
                                   transition-all text-lg dark:text-[#8c9097]
                                   dark:text-white/50 dark:hover:text-white dark:focus:ring-white/10 dark:focus:ring-offset-white/10"
                                   href="javascript:void(0);" data-hs-theme-click-value="light">
                                    <i class="ri ri-contrast-2-line header-link-icon"></i>
                                </a>
                            </div>
                        </div>
                        <p class="mb-4 text-[#8c9097] dark:text-white/50 opacity-[0.8] font-normal font-second-geo text-[12px] auth-text-450">@yield('content')</p>
                        <div class="text-center my-[3rem] authentication-barrier font-second-geo">
                            <span>{{ __('config.login_to_the_system') }}</span>
                        </div>

                        @yield('form')
                        @fortifyFeature('registration')
                        @if (Route::currentRouteName() !== 'register')
                        <div class="text-center">
                            <p class="text-[0.75rem] text-[#8c9097] dark:text-white/50 mt-4 font-second-geo">{{ __('config.you_have_account') }}
                                <a href="{{ route('register') }}" class="text-primary font-second-geo">{{ __('config.register') }}</a></p>
                        </div>
                        @endif
                        @endfortifyFeature
                    </div>
                </div>
                <div class="xxl:col-span-3 xl:col-span-3 lg:col-span-3 md:col-span-3 sm:col-span-2"></div>
            </div>
        </div>
        <x-backend.auth-info />
    </div>
    @vite('public/js/auth-app.js')
</body>
</html>

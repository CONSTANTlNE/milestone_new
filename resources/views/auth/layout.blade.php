<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>{{ __('config.admin_title') }} - @yield('title')</title>
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
                            <p class="h5 font-semibold mb-2 float-left">@yield('title')</p>
                            <div class="ti-btn ti-btn-icon ti-btn-light float-right">
                                <a aria-label="anchor"
                                   class="hs-dark-mode-active:hidden flex hs-dark-mode group flex-shrink-0 justify-center items-center gap-2  rounded-full font-medium transition-all text-xs dark:bg-bgdark dark:hover:bg-black/20 dark:text-[#8c9097] dark:text-white/50 dark:hover:text-white dark:focus:ring-white/10 dark:focus:ring-offset-white/10"
                                   href="javascript:void(0);" data-hs-theme-click-value="dark">
                                    <i class="bx bx-moon header-link-icon"></i>
                                </a>
                                <a aria-label="anchor"
                                   class="hs-dark-mode-active:flex hidden hs-dark-mode group flex-shrink-0 justify-center items-center gap-2  rounded-full font-medium text-defaulttextcolor  transition-all text-xs dark:bg-bodybg dark:bg-bgdark dark:hover:bg-black/20 dark:text-[#8c9097] dark:text-white/50 dark:hover:text-white dark:focus:ring-white/10 dark:focus:ring-offset-white/10"
                                   href="javascript:void(0);" data-hs-theme-click-value="light">
                                    <i class="bx bx-sun header-link-icon"></i>
                                </a>
                            </div>
                        </div>
                        <p class="mb-4 text-[#8c9097] dark:text-white/50 opacity-[0.8] font-normal font-second-geo auth-text-450">@yield('content')</p>
                        @if (Route::currentRouteName() !== 'register')
                        <div class="btn-list">
                            <button aria-label="button" type="button" class="ti-btn ti-btn-lg ti-btn-light !font-medium me-[0.365rem] dark:border-defaultborder/10"><svg class="google-svg" xmlns="http://www.w3.org/2000/svg" width="2443" height="2500" preserveAspectRatio="xMidYMid" viewBox="0 0 256 262"><path fill="#4285F4" d="M255.878 133.451c0-10.734-.871-18.567-2.756-26.69H130.55v48.448h71.947c-1.45 12.04-9.283 30.172-26.69 42.356l-.244 1.622 38.755 30.023 2.685.268c24.659-22.774 38.875-56.282 38.875-96.027"/><path fill="#34A853" d="M130.55 261.1c35.248 0 64.839-11.605 86.453-31.622l-41.196-31.913c-11.024 7.688-25.82 13.055-45.257 13.055-34.523 0-63.824-22.773-74.269-54.25l-1.531.13-40.298 31.187-.527 1.465C35.393 231.798 79.49 261.1 130.55 261.1"/><path fill="#FBBC05" d="M56.281 156.37c-2.756-8.123-4.351-16.827-4.351-25.82 0-8.994 1.595-17.697 4.206-25.82l-.073-1.73L15.26 71.312l-1.335.635C5.077 89.644 0 109.517 0 130.55s5.077 40.905 13.925 58.602l42.356-32.782"/><path fill="#EB4335" d="M130.55 50.479c24.514 0 41.05 10.589 50.479 19.438l36.844-35.974C195.245 12.91 165.798 0 130.55 0 79.49 0 35.393 29.301 13.925 71.947l42.211 32.783c10.59-31.477 39.891-54.251 74.414-54.251"/></svg>Sign In with google</button>
                        </div>
                        <div class="text-center my-[3rem] authentication-barrier">
                            <span>ან111</span>
                        </div>
                        @endif

                        @yield('form')
                        @fortifyFeature('registration')
                        @if (Route::currentRouteName() !== 'register')
                        <div class="text-center">
                            <p class="text-[0.75rem] text-[#8c9097] dark:text-white/50 mt-4">{{ __('config.you_have_account') }}
{{--                                გაქვთ თქვენ ექაუნთი?--}}
                                <a href="{{ route('register') }}" class="text-primary">{{ __('config.register') }}</a></p>
                        </div>
                        @endif
                        @endfortifyFeature
                    </div>
                </div>
                <div class="xxl:col-span-3 xl:col-span-3 lg:col-span-3 md:col-span-3 sm:col-span-2"></div>
            </div>
        </div>
        @include('auth.components.info')
    </div>
    @vite('public/js/auth-app.js')
</body>
</html>

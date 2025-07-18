<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="vertical" class="light" data-header-styles="light" data-menu-styles="dark"
      data-toggled="close">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Milestone Brokers</title>
    <meta name="description"
          content="A Tailwind CSS admin template is a pre-designed web page for an admin dashboard. Optimizing it for SEO includes using meta descriptions and ensuring it's responsive and fast-loading.">
    <meta name="keywords"
          content="html dashboard,tailwind css,tailwind admin dashboard,template dashboard,html and css template,tailwind dashboard,tailwind css templates,admin dashboard html template,tailwind admin,html panel,template tailwind,html admin template,admin panel html">

    <!-- Favicon -->
    <link rel="shortcut icon" href="../assets/images/brand-logos/favicon.ico">

    <!-- Main JS -->
    <script src="{{asset('adminassets/js/main.js')}}"></script>

    <!-- Style Css -->
    {{--    <link rel="stylesheet" href="{{asset('adminAssets/css/style.css')}}">--}}

    <!-- Simplebar Css -->
    {{--    <link rel="stylesheet" href="../assets/libs/simplebar/simplebar.min.css">--}}

    <!-- Color Picker Css -->
    <link rel="stylesheet" href="{{asset('adminassets/libs/@simonwep/pickr/themes/nano.min.css')}}">

    <!-- Prism CSS -->
    <link rel="stylesheet" href="{{asset('adminassets/libs/prismjs/themes/prism-coy.min.css')}}">

    @vite('resources/js/admin.js')
    @stack('css')
</head>

<body>

<!-- ========== Switcher  ========== -->
@include('components.backend.switcher')
<!-- ========== END Switcher  ========== -->

<!-- Loader -->
<div id="loader">
    {{--        <img src="../assets/images/media/loader.svg" alt="">--}}
</div>
<!-- Loader -->
<div class="page">


    @include('components.backend.header')

    @include('components.backend.sideabar')


    <div class="content" style="overflow-y: visible ">
        <div class="main-content" style="overflow: hidden ">
            @if(session()->has('error'))
                <div class="alert alert-danger text-center mt-3 backend_notifications" role="alert">
                    {{session('error')}}
                </div>
            @endif
            @if(session()->has('success'))
                <div class="alert alert-success !border-success/10 text-center mt-3 backend_notifications" role="alert">
                    {{session('success')}}
                </div>
            @endif
            @if($errors->any())
                <div class="bg-danger/20 border border-danger/20 text-sm text-danger/80 rounded-lg p-4 mt-5"
                     role="alert">
                    <div class="flex justify-center">
                        <div class="flex-shrink-0">
                            <svg class="flex-shrink-0 size-4 mt-0.5" xmlns="http://www.w3.org/2000/svg" width="24"
                                 height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                 stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"></circle>
                                <path d="m15 9-6 6"></path>
                                <path d="m9 9 6 6"></path>
                            </svg>
                        </div>
                        <div class="ms-4 ">
                            <h3 class="text-sm font-semibold text-center">
                                Please fix issues below and submit again
                            </h3>
                            <div class="mt-2 text-sm text-red-700 dark:text-red-400 flex justify-center">
                                <ul class="list-disc space-y-1 ps-5">
                                    @foreach($errors->all() as $error)
                                        <li>
                                            {{$error}}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @yield('admin_main')
            @yield('languages')
            @yield('admin_quotations_page')
            @yield('admin_faqs_page')
            @yield('contact_info_page')
            @yield('admin_faqs_edit_page')
            @yield('admin_services_page')
            @yield('admin_sliders_page')
            @yield('create_service_page')
            @yield('staticTranslation')
        </div>
    </div>

    @include('components.backend.modals.search_modal')


    <!-- Footer Start -->
    {{--    @include('components.backend.footer')--}}
    <!-- Footer End -->

</div>

<!-- Back To Top -->
<div class="scrollToTop">
    <span class="arrow"><i class="ri-arrow-up-s-fill text-xl"></i></span>
</div>

<div id="responsive-overlay"></div>


<!-- Switch JS -->
<script src="{{asset('adminAssets/js/switch.js')}}"></script>

<!-- Preline JS -->
{{--<script src="{{asset('adminAssets/libs/preline/preline.js')}}"></script>--}}

<!-- popperjs -->
<script src="{{asset('adminAssets/libs/@popperjs/core/umd/popper.min.js')}}"></script>

<!-- Color Picker JS -->
<script src="{{asset('adminAssets/libs/@simonwep/pickr/pickr.es5.min.js')}}"></script>

<!-- sidebar JS -->
<script src="{{asset('adminAssets/js/defaultmenu.js')}}"></script>

<!-- sticky JS -->
<script src="{{asset('adminAssets/js/sticky.js')}}"></script>

<!-- Simplebar JS -->
{{--<script src="../assets/libs/simplebar/simplebar.min.js"></script>--}}

<script src="{{asset('frontendAssets/js/custom-htmx.js')}}"></script>

<!-- Custom-Switcher JS -->
<script src="{{asset('adminAssets/js/custom-switcher.js')}}"></script>
@stack('js')
<!-- Custom JS -->
<script src="{{asset('adminAssets/js/custom.js')}}"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.backend_notifications').forEach((notif) => {
            removeNotification(notif);
        });
    });
    function removeNotification(notif){
        setTimeout(()=>{
            notif.remove()
        },3000)
    }
</script>
</body>

</html>


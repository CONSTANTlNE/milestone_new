<header class="app-header">
    <nav class="main-header !h-[3.75rem]" aria-label="Global">
        <div class="main-header-container ps-[0.725rem] pe-[1rem] ">
            <div class="header-content-left">
                <div class="header-element">
                    <x-backend.logos wrapperClass="horizontal-logo" />
                </div>
                <div class="header-element md:px-[0.325rem] !items-center">
                    <a aria-label="Hide Sidebar"
                       class="sidemenu-toggle animated-arrow  hor-toggle horizontal-navtoggle inline-flex items-center"
                       href="javascript:void(0);"><span></span></a>
                </div>
            </div>
            <div class="header-content-right">
                @include('backend.components.header.locales')
{{--                @include('backend.components.header.theme-mode')--}}
                @include('backend.components.header.frontend-site-link')
{{--                @can('backend.notifications.index')--}}
{{--                @include('backend.components.header.notifications')--}}
{{--                @endcan--}}
                @can('backend.laravel-actions')
                @include('backend.components.header.laravel-actions')
                @endcan
                @include('backend.components.header.fullscreen')
                @include('backend.components.header.profile')
            </div>
        </div>
    </nav>
</header>

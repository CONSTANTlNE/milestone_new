<div class="site-navigation">
    <nav class="main-menu navbar-expand-xl navbar-light">
        <div class="navbar-header">
            <button class="navbar-toggler" type="button">
                <i class="pbmit-base-icon-menu-1"></i>
            </button>
        </div>
        <div class="pbmit-mobile-menu-bg"></div>
        <div class="collapse navbar-collapse clearfix show" id="pbmit-menu">
            <div class="pbmit-menu-wrap">
                <div class="row-mobile">
                    <div class="header-mobile">
                        <a class="d-hidden" href="{{ route('frontend.index') }}">
                            <img class="logo-img" src="{{asset('assets/images/logo-0.png')}}" alt="{{__('site_title')}}">
                        </a>

                        <div class="locales-mobile d-hidden">
                            @include('components.frontend.locales-mobile')
                        </div>

                        <span class="closepanel">
                            <svg  class="qodef-svg--close qodef-m" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" width="20" height="20">
                                <defs>
                                    <image  width="114" height="140" id="img1" href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAHIAAACMBAMAAABSa+AnAAAAAXNSR0IB2cksfwAAABVQTFRFAAAAAAwkAA0kAA0lAA4kAAwkAA0kr7/L7QAAAAd0Uk5TAH//n4CP7+3MA98AAADRSURBVHic7dOxDYMwFIRhA06dCWKsjOARKDI3g0TgCZDTpgiReaF8Fz2UdEdFwadfwufGHX0aSkpKSkpKSkpKSkpKyj/KJs7ykqZik21cNtH1r2yTPqxbNJUw2qQbco12fXtXPlClRPUk+Lc1CpJA1ihIovMc8uOsJ5H0wTk9CTc0ZJCEMpV1PiS73rlFmR6WqVwnENVlPUsZklXWs9zXa5IyHxBVpcwHRDV5ushZ6lH9Zst8fDDf7PiZz+052uT3h5KSkpKSkpKSkpKSkvIX8g0Ui0SNpLnpLgAAAABJRU5ErkJggg=="/>
                                </defs>
                                <style>
                                </style>
                                <use id="Layer 1" href="#img1" x="-47" y="-60"/>
                            </svg>
                        </span>
                    </div>

                    <ul class="navigation clearfix">
                        @foreach ($mainMenus as $menu)
                            @php
                                $isMenuActive = request()->routeIs($menu->route)
                                    || $menu->children->contains(function ($child) {
                                        return request()->routeIs($child->route);
                                    });
                            @endphp
                            <li class="{{ $isMenuActive ? 'active' : 'no-active' }}{{ $menu->children->isNotEmpty() ? ' dropdown' : '' }}">
                                <a @if($menu->children->isNotEmpty()) href=#  @else
                                    href="{{ $menu->is_prefix ? route($menu->route, ['id'=>$menu->model_id, 'slug'=>$menu->getTranslation('slug', app()->getLocale())]) : route($menu->route)}}"
                                    @endif
                                >
                                    {{$menu->getTranslation('title', app()->getLocale()) ?? 'N/A'}}
                                </a>
                                @if($menu->children->isNotEmpty())
                                    <ul>
                                        @foreach($menu->children as $child)
                                            <li class="{{ request()->routeIs($child->route) ? 'active' : '' }}">
                                                <a href="{{ $child->is_prefix ? route($child->route, [ 'id'=>$child->model_id, 'slug'=>$child->getTranslation('slug', app()->getLocale())]) : route($child->route)}}">
                                                    {{$child->getTranslation('title', app()->getLocale()) ?? 'N/A'}}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </li>
                        @endforeach
                    </ul>

                    @if(getPageById(20) !== null or getPageById(19) !== null)
                        <div class="clients-mobile">
                            @if(getPageById(19) !== null)
                                <div class="pbmit-button transform-bottom transform-delay-4">
                                    <a class="pbmit-btn" href="{{ route(getPageById(19)->template) }}">
                                        <span class="pbmit-button-content-wrapper">
                                            <span class="pbmit-button-text">{{getPageById(19)->title}}</span>
                                        </span>
                                    </a>
                                </div>
                            @endif
                            @if(getPageById(20) !== null)
                                <div class="pbmit-button transform-bottom transform-delay-4">
                                    <a class="pbmit-btn" href="{{ route(getPageById(20)->template) }}">
                                        <span class="pbmit-button-content-wrapper">
                                            <span class="pbmit-button-text">{{getPageById(20)->title}}</span>
                                        </span>
                                    </a>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </nav>
</div>

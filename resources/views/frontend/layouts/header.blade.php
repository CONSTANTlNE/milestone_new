    <div class="pbmit-header-overlay">
        <div class="pbmit-main-header-area">
            <div class="container-fluid">
                <div class="pbmit-header-content d-flex justify-content-between align-items-center">
                    <div class="pbmit-logo-menuarea d-flex justify-content-between align-items-center">
                        <div class="site-branding">
                            <h1 class="site-title">
                                <a href="{{ route('frontend.index') }}">
                                    <img class="logo-img logo-black" src="{{asset('assets/images/logo-0.png')}}" alt="{{__('site_title')}}">
                                    <img class="logo-img logo-white" src="{{asset('assets/images/logo.png')}}" alt="{{__('site_title')}}">
                                </a>
                            </h1>
                        </div>
                        @include('frontend.layouts.mainMenu')
                    </div>

                    <div class="pbmit-right-box d-flex align-items-center gap-2">
                        @include('components.frontend.locales')
                        @if(getPageById(20) !== null or getPageById(19) !== null)
                            <div class="clients">
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
                        @auth
                            <div class="pbmit-header-user-btn">
                                <a href="{{ route('backend.index') }}">
                                    <i class="pbmit-base-icon-user-1"></i>
                                </a>
                            </div>
                        @endauth
                        <div class="pbmit-header-search-btn hidden">
                            <a href="#" title="{{__('search')}}">
                                <i class="pbmit-base-icon-search-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

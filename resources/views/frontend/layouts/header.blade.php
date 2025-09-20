    <div class="pbmit-header-overlay">
        <div class="pbmit-main-header-area">
            <div class="container-fluid">
                <div class="pbmit-header-content d-flex justify-content-between align-items-center">
                    <div class="pbmit-logo-menuarea d-flex justify-content-between align-items-center">
                        <div class="site-branding">
                            <h1 class="site-title">
                                <a href="{{ route('frontend.index') }}">
                                    <img class="logo-img" src="{{asset('assets/images/logo.png')}}" alt="{{__('site_title')}}">
                                    <span class="logo-text">
                                        Milestone
                                        Brokers
                                    </span>
                                </a>
                            </h1>
                        </div>
                        @include('frontend.layouts.mainMenu')
                    </div>

                    <div class="pbmit-right-box d-flex align-items-center">
                        @include('components.frontend.locales')
                        @auth
                            <div class="pbmit-header-user-btn">
                                <a href="{{ route('backend.index') }}">
                                    <i class="pbmit-base-icon-user-1"></i>
                                </a>
                            </div>
                        @endauth
                        <div class="pbmit-header-search-btn">
                            <a href="#" title="{{__('search')}}">
                                <i class="pbmit-base-icon-search-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if(getPageById(20) !== null or getPageById(19) !== null)
            <div class="clients">
                @if(getPageById(19) !== null)
                    <div class="pbmit-button transform-bottom transform-delay-4 mt-3">
                        <a class="pbmit-btn" href="{{ route(getPageById(19)->template) }}">
                        <span class="pbmit-button-content-wrapper">
                            <span class="pbmit-button-text">{{getPageById(19)->title}}</span>
                        </span>
                        </a>
                    </div>
                @endif
                @if(getPageById(20) !== null)
                    <div class="pbmit-button transform-bottom transform-delay-4 mt-3">
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

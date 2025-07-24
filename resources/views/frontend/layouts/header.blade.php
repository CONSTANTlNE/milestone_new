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
                        <div class="pbmit-header-search-btn">
                            <a href="#" title="{{__('search')}}">
                                <i class="pbmit-base-icon-search-1"></i>
                            </a>
                        </div>
                        <div class="pbmit-header-button2 pbmit-header-book-consult-btn">
                            <a class="pbmit-btn pbmit-btn-white" href="#" id="consultation-trigger">
                                <span class="pbmit-button-content-wrapper">
                                    <span class="pbmit-button-text">{{__('book')}}</span>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="pbmit-header-overlay">
        <div class="pbmit-main-header-area">
            <div class="container-fluid">
                <div class="pbmit-header-content d-flex justify-content-between align-items-center">
                    <div class="pbmit-logo-menuarea d-flex justify-content-between align-items-center">
                        <div class="site-branding">
                            <h1 class="site-title">
                                <a href="{{ route('frontend.index') }}">
                                    <img class="logo-img" src="{{asset('assets/images/logo.png')}}" alt="Shipex" style="margin-top: 1px;float: left;">
                                    <span style="
    color: #fff;
    font-size: 22px;
    width: 21px;
    display: block;
    float: left;
    line-height: 20px;
    margin-top: 9px;
    margin-left: 5px;
">
                                        Milestone
                                        Brokers
                                    </span>
                                </a>
                            </h1>
                        </div>
                        @include('frontend.layouts.mainMenu')
                    </div>
                    <div class="pbmit-right-box d-flex align-items-center">
                        <div class="social-links-wrapper">
                            <ul class="pbmit-social-links">
                                <li class="pbmit-social-li pbmit-social-facebook">
                                    <a title="Facebook" href="#" target="_blank">
                                        <span><i class="pbmit-base-icon-facebook-f"></i></span>
                                    </a>
                                </li>
                                <li class="pbmit-social-li pbmit-social-twitter">
                                    <a title="Twitter" href="#" target="_blank">
                                        <span><i class="pbmit-base-icon-twitter-2"></i></span>
                                    </a>
                                </li>
                                <li class="pbmit-social-li pbmit-social-linkedin">
                                    <a title="LinkedIn" href="#" target="_blank">
                                        <span><i class="pbmit-base-icon-linkedin-in"></i></span>
                                    </a>
                                </li>
                                <li class="pbmit-social-li pbmit-social-instagram">
                                    <a title="Instagram" href="#" target="_blank">
                                        <span><i class="pbmit-base-icon-instagram"></i></span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="pbmit-header-search-btn">
                            <a href="#" title="Search">
                                <i class="pbmit-base-icon-search-1"></i>
                            </a>
                        </div>
                        <div class="pbmit-header-button2">
                            <a class="pbmit-btn pbmit-btn-white" href="contact-us.html">
										<span class="pbmit-button-content-wrapper">
											<span class="pbmit-button-text">Book Consult</span>
										</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<footer class="site-footer">
    <div class="pbmit-footer-big-area-wrapper">

        <div class="pbmit-footer-widget-area">
            <div class="container">
                <div class="row">
                    <div class="pbmit-footer-widget-col-1 col-md-4">
                        <aside class="widget footer-about">
                            <div class="pbmit-footer-logo">
                                <img src="{{asset('assets/images/logo.png')}}" class="img-fluid" alt="">
                            </div>
                            <h3 style="color: #fff">Milestone Brokers<span class="small-r">®</span></h3>
                            <p>Milestone Brokers is a U.S.-based auto-logistics brokerage connecting clients with fully vetted, insured, and performance-proven carriers.
                                We focus on secure transport execution, transparent communication, and long-term partnerships.</p>
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
                        </aside>
                    </div>
                    <div class="pbmit-footer-widget-col-2 col-md-3"></div>
                    <div class="pbmit-footer-widget-col-3 col-md-2">
                        <aside class="widget">
                            <h2 class="widget-title">{{__('useful_link')}}</h2>
                            <ul class="menu">
                                @foreach($linksMenus as $linksMenu)
                                    <li><a href="{{ route($linksMenu->route) }}">{{$linksMenu->title}}</a></li>
                                @endforeach
                            </ul>
                        </aside>
                    </div>
                    <div class="pbmit-footer-widget-col-4 col-md-2">
                        <aside class="widget">
                            <h2 class="widget-title">{{__('our_services')}}</h2>
                            <ul class="menu">
                                @foreach($servicesMenus as $servicesMenu)
                                    <li><a href="{{ route($servicesMenu->route) }}">{{$servicesMenu->title}}</a></li>
                                @endforeach
                            </ul>
                        </aside>
                    </div>
                    <div class="pbmit-footer-widget-col-5 col-md-12">
                        <aside class="widget widget_text">
                            <h4>Reliable Auto Transport.</h4>
                            <h4>Handled with Care.</h4>
                            <h4>Delivered with Confidence.</h4>
                        </aside>
                    </div>
                </div>
            </div>
        </div>
        <div class="pbmit-footer-text-area">
            <div class="container">
                <div class="pbmit-footer-text-inner">
                    <div class="row">
                        <div class="col-md-6" style="align-items: center;display: flex;">
                            <div class="pbmit-footer-copyright-text-area">
                                Copyright © {{date('Y')}}, All Rights Reserved.
                            </div>
                        </div>
                        <div class="col-md-6">
                            <ul class="pbmit-social-links" style="display: flex;justify-content: right;">
                                <li class="pbmit-social-li pbmit-social-facebook">
                                    <a title="#" href="#" target="_blank">
                                        <span>
                                            <img src="{{asset('assets/images/facebook.svg')}}" class="img-fluid" alt="">
                                        </span>
                                    </a>
                                </li>
                                <li class="pbmit-social-li pbmit-social-x">
                                    <a title="#" href="#" target="_blank">
                                        <span>
                                            <img src="{{asset('assets/images/x.svg')}}" class="img-fluid" alt="">
                                        </span>
                                    </a>
                                </li>
                                <li class="pbmit-social-li pbmit-social-linkdin">
                                    <a title="#" href="#" target="_blank">
                                        <span>
                                            <img src="{{asset('assets/images/linkdin.svg')}}" class="img-fluid" alt="">
                                        </span>
                                    </a>
                                </li>
                                <li class="pbmit-social-li pbmit-social-instagram">
                                    <a title="#" href="#" target="_blank">
                                        <span>
                                            <img src="{{asset('assets/images/instagram.svg')}}" class="img-fluid" alt="">
                                        </span>
                                    </a>
                                </li>
{{--                                @foreach(getSocials() as $social)--}}
{{--                                    <li class="pbmit-social-li pbmit-social-{{$social->title}}">--}}
{{--                                        <a title="{{$social->title}}" href="{{$social->link}}" target="_blank">--}}
{{--                                            <span><i class="{{$social->icon}}"></i></span>--}}
{{--                                        </a>--}}
{{--                                    </li>--}}
{{--                                @endforeach--}}
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

<footer class="site-footer pbmit-bg-color-secondary">
    <div class="pbmit-footer-big-area-wrapper">

        <div class="pbmit-footer-widget-area">
            <div class="container">
                <div class="row">
                    <div class="pbmit-footer-widget-col-1 col-md-4">
                        <aside class="widget">
                            <div class="pbmit-footer-logo" style="width: 100% !important;">
                                <img src="{{asset('assets/images/logo.png')}}" class="img-fluid" alt="">
                            </div>
                            <h3 style="color: #fff">Milestone <br> Brokers</h3>
                        </aside>
                    </div>
                    <div class="pbmit-footer-widget-col-2 col-md-4">
                        <aside class="widget">
                            <h2 class="widget-title">Contact Information</h2>
                            <div class="pbmit-contact-widget-lines">
                                <div class="pbmit-contact-widget-line pbmit-base-icon-phone"><span><i class="pbmit-base-icon-email"></i></span> pbminfotech@gmail.com</div>
                                <div class="pbmit-contact-widget-line pbmit-base-icon-phone"><span><i class="pbmit-base-icon-email"></i></span> no-reply@pbminfotech.com</div>
                                <div class="pbmit-contact-widget-line pbmit-base-icon-phone"><span><i class="pbmit-base-icon-phone"></i></span> +001 236-895-4732</div>
                                <div class="pbmit-contact-widget-line pbmit-base-icon-phone"><span><i class="pbmit-base-icon-phone"></i></span> +001 236-895-4732 </div>
                                <div class="pbmit-contact-widget-line mt-3">
                                    <ul class="pbmit-social-links">
                                        @foreach(getSocials() as $social)
                                            <li class="pbmit-social-li pbmit-social-{{$social->title}}">
                                                <a title="{{$social->title}}" href="{{$social->link}}" target="_blank">
                                                    <span><i class="{{$social->icon}}"></i></span>
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </aside>
                    </div>
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
                        <aside class="widget widget_text">
                            <h2 class="widget-title">{{__('our_services')}}</h2>
                            <ul class="menu">
                                @foreach($servicesMenus as $servicesMenu)
                                    <li><a href="{{ route($servicesMenu->route) }}">{{$servicesMenu->title}}</a></li>
                                @endforeach
                            </ul>
                        </aside>
                    </div>
                </div>
            </div>
        </div>
        <div class="pbmit-footer-text-area">
            <div class="container">
                <div class="pbmit-footer-text-inner">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="pbmit-footer-copyright-text-area">
                                Copyright © {{date('Y')}}, All Rights Reserved.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

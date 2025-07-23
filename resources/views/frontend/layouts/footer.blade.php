<footer class="site-footer pbmit-bg-color-secondary">
    <div class="pbmit-footer-big-area-wrapper">

        <div class="pbmit-footer-widget-area">
            <div class="container">
                <div class="row">
                    <div class="pbmit-footer-widget-col-1 col-md-4">
                        <aside class="widget">
                            <div class="pbmit-footer-logo" style="width: 100% !important;">
                                <img src="{{asset('assets/images/logo.png')}}" class="img-fluid" alt="">
                            </div><br>
                            <ul class="pbmit-social-links">
                                @foreach(getSocials() as $social)
                                <li class="pbmit-social-li pbmit-social-{{$social->title}}">
                                    <a title="{{$social->title}}" href="{{$social->link}}" target="_blank">
                                        <span><i class="{{$social->icon}}"></i></span>
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </aside>
                    </div>
                    <div class="pbmit-footer-widget-col-2 col-md-4">
                        <aside class="widget">
                            <h2 class="widget-title">Say Hello</h2>
                            <div class="pbmit-contact-widget-lines">
                                <div class="pbmit-contact-widget-line pbmit-base-icon-phone">+1-800123-456-789</div>
                                <div class="pbmit-contact-widget-line pbmit-base-icon-email"><a href="/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="fb9594d6899e8b9782bb8b999692959d948f9e9893d5989496">[email&#160;protected]</a></div>
                            </div>
                        </aside>
                    </div>
                    <div class="pbmit-footer-widget-col-3 col-md-2">
                        <aside class="widget">
                            <h2 class="widget-title">{{__('useful_link')}}</h2>
                            <ul class="menu">
                                <li><a href="#">About</a></li>
                                <li><a href="#">Our Service</a></li>
                                <li><a href="#">Company</a></li>
                                <li><a href="#">News & Media</a></li>
                                <li><a href="#">Team</a></li>
                            </ul>
                        </aside>
                    </div>
                    <div class="pbmit-footer-widget-col-4 col-md-2">
                        <aside class="widget widget_text">
                            <h2 class="widget-title">Our Services</h2>
                            <ul class="menu">
                                <li><a href="#">Logistics</a></li>
                                <li><a href="#">Manufacturing</a></li>
                                <li><a href="#">Production</a></li>
                                <li><a href="#">Transportation</a></li>
                                <li><a href="#">Warehouse</a></li>
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
                                Copyright © 2025, All Rights Reserved.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

@extends('frontend.layouts.master')
@section('title') {{ __('strings.Home') }} @endsection

@section('header_background')
    <div class="pbmit-title-bar-wrapper" style="background-image: url({{asset($page->src ?: config('filemanager.default_backend_image'))}});">
        <div class="container">
            <div class="pbmit-title-bar-content">
                <div class="pbmit-title-bar-content-inner">
                    <div class="pbmit-tbar">
                        <div class="pbmit-tbar-inner container">
                            <h1 class="pbmit-tbar-title">{{$page->title}}</h1>
                        </div>
                    </div>
                    <div class="pbmit-breadcrumb">
                        <div class="pbmit-breadcrumb-inner">
								<span>
									<a title="" href="#" class="home"><span>{{__('page')}}</span></a>
								</span>
                            <span class="sep">
									<i class="pbmit-base-icon-angle-right"></i>
								</span>
                            <span><span class="post-root post post-post current-item"> {{$page->title}}</span></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <!-- About Start -->
    <section class="about-section-three" id="pbmit-about">
        <div class="container">
            <div class="row g-0">
                <div class="col-md-12 col-xl-6">
                    <div class="about-three-left-box">
                        <div class="fid-style-box animated zoomIn">
                            <div class="pbminfotech-ele-fid-style-4">
                                <div class="pbmit-fld-contents">
                                    <div class="pbmit-fld-wrap">
                                        <h4 class="pbmit-fid-inner">
                                            <span class="pbmit-fid-before"></span>
                                            <span class="pbmit-number-rotate numinate" data-appear-animation="animateDigits" data-from="0" data-to="25" data-interval="5" data-before="" data-before-style="" data-after="" data-after-style="">25</span>
                                            <span class="pbmit-fid"><span>+</span></span>
                                        </h4>
                                        <span class="pbmit-fid-title">Years of<br> experience</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="about-first-img">
                            <img src="{{asset('assets/images/homepage-3/about-01.jpg')}}" class="img-fluid" alt="">
                        </div>
                        <div class="about-second-img">
                            <div class="img-wrap">
                                <img src="{{asset('assets/images/homepage-3/about-02.jpg')}}" alt="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-xl-6">
                    <div class="about-three-right-box">
                        <div class="pbmit-heading-subheading">
                            <h4 class="pbmit-subtitle">Who we are</h4>
                            <h2 class="pbmit-title">Reducing costs and increasing efficiency</h2>
                            <div class="pbmit-heading-desc">
                                Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt  suspendisse ultrices gravida risus.
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="pe-4">
                                    <div class="pbmit-ihbox-style-3">
                                        <div class="pbmit-ihbox-box d-flex">
                                            <div class="pbmit-ihbox-icon">
                                                <div class="pbmit-ihbox-icon-wrapper pbmit-icon-type-icon">
                                                    <svg enable-background="new 0 0 512 512" height="512" viewbox="0 0 512 512" width="512" xmlns="http://www.w3.org/2000/svg"><g id="_x30_5_x2C__logistics_x2C__shipping_x2C__truck_x2C__delivery_x2C__checked"><g id="XMLID_175_"><path id="XMLID_176_" d="m125.132 401.481c-2.272 0-4.122 1.842-4.122 4.106 0 2.274 1.849 4.125 4.122 4.125 2.267 0 4.11-1.851 4.11-4.125 0-2.264-1.844-4.106-4.11-4.106z"></path><path id="XMLID_210_" d="m318.133 67.967h-281.076v234h281.076zm-140.539 211.515c-52.116 0-94.516-42.399-94.516-94.515s42.399-94.516 94.516-94.516 94.516 42.399 94.516 94.516c0 52.116-42.399 94.515-94.516 94.515z"></path><path id="XMLID_226_" d="m125.126 367.162c-21.193 0-38.435 17.241-38.435 38.435s17.242 38.436 38.435 38.436 38.435-17.242 38.435-38.436-17.242-38.435-38.435-38.435zm.006 52.551c-7.787 0-14.122-6.337-14.122-14.125 0-7.778 6.335-14.106 14.122-14.106 7.78 0 14.11 6.328 14.11 14.106 0 7.788-6.33 14.125-14.11 14.125z"></path><path id="XMLID_229_" d="m377.753 367.161c-21.193 0-38.436 17.242-38.436 38.436s17.242 38.437 38.436 38.437c21.193 0 38.435-17.242 38.435-38.437-.001-21.194-17.242-38.436-38.435-38.436zm.004 52.552c-7.787 0-14.122-6.337-14.122-14.125 0-7.778 6.335-14.106 14.122-14.106 7.781 0 14.111 6.328 14.111 14.106 0 7.788-6.33 14.125-14.111 14.125z"></path><path id="XMLID_230_" d="m377.757 401.481c-2.272 0-4.122 1.842-4.122 4.106 0 2.274 1.849 4.125 4.122 4.125 2.267 0 4.111-1.851 4.111-4.125 0-2.264-1.844-4.106-4.111-4.106z"></path><path id="XMLID_231_" d="m351.868 298.231v-99.965h-23.735v108.701c0 2.762-2.239 5-5 5h-286.076v62.23l16.479 16.48h25.516c6.306-19.427 24.571-33.516 46.074-33.516s39.767 14.088 46.073 33.516h160.479c6.306-19.428 24.571-33.517 46.074-33.517 25.019 0 45.667 19.069 48.177 43.436h33.025l15.989-15.116v-82.249h-118.075c-2.761 0-5-2.238-5-5z"></path><path id="XMLID_237_" d="m177.594 100.451c-46.602 0-84.516 37.914-84.516 84.516s37.914 84.515 84.516 84.515 84.516-37.914 84.516-84.515c0-46.602-37.913-84.516-84.516-84.516zm45.218 56.218-56.75 56.75c-1.954 1.953-5.118 1.952-7.071 0l-32.25-32.25c-1.953-1.953-1.953-5.119 0-7.071s5.118-1.952 7.071 0l28.714 28.714 53.214-53.214c1.953-1.952 5.118-1.952 7.071 0 1.954 1.953 1.954 5.119.001 7.071z"></path><path id="XMLID_238_" d="m361.868 198.266v94.965h113.075v-23.157l-61.272-71.808z"></path></g></g></svg>
                                                </div>
                                            </div>
                                            <div class="pbmit-ihbox-contents">
                                                <h2 class="pbmit-element-title">Packaging and crating</h2>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="pe-3 mt-md-0 mt-4">
                                    <div class="pbmit-ihbox-style-3">
                                        <div class="pbmit-ihbox-box d-flex">
                                            <div class="pbmit-ihbox-icon">
                                                <div class="pbmit-ihbox-icon-wrapper pbmit-icon-type-icon">
                                                    <svg enable-background="new 0 0 512 512" height="512" viewbox="0 0 512 512" width="512" xmlns="http://www.w3.org/2000/svg"><g id="_x30_9_x2C__Box_x2C__delivery_x2C__fast_x2C__logistics_x2C__package"><g id="XMLID_92_"><path id="XMLID_97_" d="m214.187 139.087h83.622v70.413h-83.622z"></path><path id="XMLID_127_" d="m218.666 44.516h-115.871l-53.655 84.571h155.727z"></path><path id="XMLID_128_" d="m296.997 129.087-13.799-84.571h-54.4l-13.799 84.571z"></path><path id="XMLID_137_" d="m462.86 129.087-53.655-84.571h-115.875l13.799 84.571z"></path><path id="XMLID_161_" d="m307.809 214.499c0 2.761-2.239 5-5 5h-93.622c-2.761 0-5-2.239-5-5v-75.413h-159.141v328.397h421.907v-328.396h-159.144zm45.495 63.645c.798-1.815 2.594-2.987 4.577-2.987s3.778 1.172 4.577 2.986c7.449 16.933 48.733 19.658 62.515 3.441 1.358-1.598 3.567-2.178 5.535-1.455 1.967.724 3.275 2.597 3.275 4.693 0 20.441.242 41.094.242 61.57 0 40.563-28.416 78.062-74.16 97.86-1.241.538-2.682.559-3.972 0-45.742-19.8-74.157-57.297-74.157-97.86 0-20.482.244-41.127.244-61.57 0-2.097 1.308-3.97 3.275-4.693s4.176-.142 5.535 1.455c13.753 16.184 55.055 13.518 62.514-3.44z"></path><path id="XMLID_167_" d="m291.735 346.393c0 35.933 25.286 69.415 66.144 87.806 40.858-18.391 66.146-51.873 66.146-87.806 0-16.872-.166-33.883-.224-51.147-19.854 11.598-51.881 8.912-65.92-6.223-14.071 15.171-46.112 17.794-65.919 6.223-.058 16.996-.227 34.219-.227 51.147zm32.742 7.8c1.975-1.932 5.14-1.895 7.071.08l19.5 19.947 39.591-47.283c1.773-2.117 4.926-2.395 7.043-.624 2.117 1.773 2.396 4.927.624 7.044l-43.138 51.52c-1.883 2.249-5.323 2.418-7.409.285l-23.362-23.898c-1.931-1.976-1.895-5.142.08-7.071z"></path></g></g></svg>
                                                </div>
                                            </div>
                                            <div class="pbmit-ihbox-contents">
                                                <h2 class="pbmit-element-title">Certified & Awards winner</h2>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <ul class="list-group style-2">
                            <li class="list-group-item">
									<span class="pbmit-icon-list-icon">
										<svg aria-hidden="true" class="e-font-icon-svg e-fas-check" viewbox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><path d="M173.898 439.404l-166.4-166.4c-9.997-9.997-9.997-26.206 0-36.204l36.203-36.204c9.997-9.998 26.207-9.998 36.204 0L192 312.69 432.095 72.596c9.997-9.997 26.207-9.997 36.204 0l36.203 36.204c9.997 9.997 9.997 26.206 0 36.204l-294.4 294.401c-9.998 9.997-26.207 9.997-36.204-.001z"></path></svg>
									</span>
                                <span class="pbmit-icon-list-text">With over four decades of experience providing solutions</span>
                            </li>
                            <li class="list-group-item">
									<span class="pbmit-icon-list-icon">
										<svg aria-hidden="true" class="e-font-icon-svg e-fas-check" viewbox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><path d="M173.898 439.404l-166.4-166.4c-9.997-9.997-9.997-26.206 0-36.204l36.203-36.204c9.997-9.998 26.207-9.998 36.204 0L192 312.69 432.095 72.596c9.997-9.997 26.207-9.997 36.204 0l36.203 36.204c9.997 9.997 9.997 26.206 0 36.204l-294.4 294.401c-9.998 9.997-26.207 9.997-36.204-.001z"></path></svg>
									</span>
                                <span class="pbmit-icon-list-text">With over four decades of experience providing solutions</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- About End -->

    <!-- Static Box Start -->
    <section class="pbmit-element-static-box-style-1 section-md" style="padding-top: 0px;">
        <div class="container">
            <div class="pbmit-heading-subheading text-center">
                <h4 class="pbmit-subtitle">
                    How it works
                </h4>
                <h2 class="pbmit-title">
                    Logistics Solutions to <br> Help Businesses
                </h2>
            </div>
            <div class="row">
                <article class="pbmit-static-box-style-1">
                    <div class="pbmit-staticbox-wrapper">
                        <div class="pbmit-bg-imgbox col-md-6" style="background-image: url({{asset('assets/images/homepage-1/static-box/static-box-01.jpg')}});">
                            <div class="pbmit-img">
                                <img src="{{asset('assets/images/homepage-1/static-box/static-box-01.jpg')}}" class="img-fluid" alt="Receive packages">
                            </div>
                            <div class="pbmit-box-number">01</div>
                            <h4 class="pbmit-static-box-title">Receive packages</h4>
                        </div>
                        <div class="pbmit-content-box col-md-6">
                            <div class="pbmit-box-number">01</div>
                            <div class="pbmit-content-inner">
                                <h4 class="pbmit-static-box-title">Receive packages</h4>
                                <div class="pbmit-static-box-desc">Sed ut perspiciatis unde omnis iste natus ut perspic iatis unde omnis iste perspiciatis ut perspiciatis unde omnis iste natus Perspiciatis unde omnis iste natus. sed do euism od tempor incidunt ut nsectetur </div>
                                <div class="pbmit-static-btn">
                                    <a class="pbmit-btn pbmit-btn-outline" href="#">
											<span class="pbmit-button-content-wrapper">
												<span class="pbmit-button-text">View Detail</span>
											</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </article>
                <article class="pbmit-static-box-style-1">
                    <div class="pbmit-staticbox-wrapper">
                        <div class="pbmit-bg-imgbox col-md-6" style="background-image: url({{asset('assets/images/homepage-1/static-box/static-box-02.jpg')}});">
                            <div class="pbmit-img">
                                <img src="{{asset('assets/images/homepage-1/static-box/static-box-02.jpg')}}" class="img-fluid" alt="Deliver packages">
                            </div>
                            <div class="pbmit-box-number">02</div>
                            <h4 class="pbmit-static-box-title">Deliver packages</h4>
                        </div>
                        <div class="pbmit-content-box col-md-6">
                            <div class="pbmit-box-number">02</div>
                            <div class="pbmit-content-inner">
                                <h4 class="pbmit-static-box-title">Deliver packages</h4>
                                <div class="pbmit-static-box-desc">Sed ut perspiciatis unde omnis iste natus ut perspic iatis unde omnis iste perspiciatis ut perspiciatis unde omnis iste natus Perspiciatis unde omnis iste natus. sed do euism od tempor incidunt ut nsectetur </div>
                                <div class="pbmit-static-btn">
                                    <a class="pbmit-btn pbmit-btn-outline" href="#">
											<span class="pbmit-button-content-wrapper">
												<span class="pbmit-button-text">View Detail</span>
											</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </article>
                <article class="pbmit-static-box-style-1">
                    <div class="pbmit-staticbox-wrapper">
                        <div class="pbmit-bg-imgbox col-md-6" style="background-image: url({{asset('assets/images/homepage-1/static-box/static-box-03.jpg')}});">
                            <div class="pbmit-img">
                                <img src="{{asset('assets/images/homepage-1/static-box/static-box-03.jpg')}}" class="img-fluid" alt="Transport packages">
                            </div>
                            <div class="pbmit-box-number">03</div>
                            <h4 class="pbmit-static-box-title">Transport packages</h4>
                        </div>
                        <div class="pbmit-content-box col-md-6">
                            <div class="pbmit-box-number">03</div>
                            <div class="pbmit-content-inner">
                                <h4 class="pbmit-static-box-title">Transport packages</h4>
                                <div class="pbmit-static-box-desc">Sed ut perspiciatis unde omnis iste natus ut perspic iatis unde omnis iste perspiciatis ut perspiciatis unde omnis iste natus Perspiciatis unde omnis iste natus. sed do euism od tempor incidunt ut nsectetur </div>
                                <div class="pbmit-static-btn">
                                    <a class="pbmit-btn pbmit-btn-outline" href="#">
											<span class="pbmit-button-content-wrapper">
												<span class="pbmit-button-text">View Detail</span>
											</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </article>
                <article class="pbmit-static-box-style-1">
                    <div class="pbmit-staticbox-wrapper">
                        <div class="pbmit-bg-imgbox col-md-6" style="background-image: url({{asset('assets/images/homepage-1/static-box/static-box-04.jpg')}});">
                            <div class="pbmit-img">
                                <img src="{{asset('assets/images/homepage-1/static-box/static-box-04.jpg')}}" class="img-fluid" alt="Warehousing Operation">
                            </div>
                            <div class="pbmit-box-number">04</div>
                            <h4 class="pbmit-static-box-title">Warehousing Operation</h4>
                        </div>
                        <div class="pbmit-content-box col-md-6">
                            <div class="pbmit-box-number">04</div>
                            <div class="pbmit-content-inner">
                                <h4 class="pbmit-static-box-title">Warehousing Operation</h4>
                                <div class="pbmit-static-box-desc">Sed ut perspiciatis unde omnis iste natus ut perspic iatis unde omnis iste perspiciatis ut perspiciatis unde omnis iste natus Perspiciatis unde omnis iste natus. sed do euism od tempor incidunt ut nsectetur </div>
                                <div class="pbmit-static-btn">
                                    <a class="pbmit-btn pbmit-btn-outline" href="#">
											<span class="pbmit-button-content-wrapper">
												<span class="pbmit-button-text">View Detail</span>
											</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </section>
@endsection

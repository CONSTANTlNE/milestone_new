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
    <!-- Services Start -->
    <section class="section-lg">
        <div class="container">
            <div class="pbmit-element-posts-wrapper row">
                <article class="pbmit-service-style-1 col-md-4">
                    <div class="pbminfotech-post-item">
                        <div class="pbmit-box-content-wrap">
                            <div class="pbmit-service-image-wrapper">
                                <div class="pbmit-featured-img-wrapper">
                                    <div class="pbmit-featured-wrapper">
                                        <img src="images/service/service-img-01.jpg" class="img-fluid" alt="">
                                    </div>
                                </div>
                                <div class="pbmit-service-btn-wrapper">
                                    <a class="pbmit-service-btn" href="services.html" title="Warehouse Storage">
												<span class="pbmit-button-icon">
													<i class="pbmit-base-icon-angle-right"></i>
												</span>
                                    </a>
                                </div>
                            </div>
                            <div class="pbmit-content-box">
                                <div class="pbminfotech-box-number">01</div>
                                <div class="pbmit-serv-cat"></div>
                                <h3 class="pbmit-service-title"><a href="services.html">Warehouse Storage</a></h3>
                                <div class="pbmit-service-description">
                                    <p>many variations of passages of Lorem Ipsum available, but the majority have suffered.</p>
                                </div>
                                <div class="pbmit-service-icon">
                                    <svg enable-background="new 0 0 512 512" height="512" viewbox="0 0 512 512" width="512" xmlns="http://www.w3.org/2000/svg"><g id="_x30_1_x2C__package_x2C__Box_x2C__delivery_x2C__return_x2C__shipment"><g id="XMLID_186_"><path id="XMLID_187_" d="m214.187 139.087h83.622v70.413h-83.622z"></path><path id="XMLID_206_" d="m218.666 44.516h-115.871l-53.655 84.571h155.727z"></path><path id="XMLID_256_" d="m296.997 129.087-13.799-84.571h-54.4l-13.799 84.571z"></path><path id="XMLID_257_" d="m462.86 129.087-53.655-84.571h-115.875l13.799 84.571z"></path><path id="XMLID_265_" d="m307.809 139.087v75.413c0 2.761-2.239 5-5 5h-93.622c-2.761 0-5-2.239-5-5v-75.413h-159.141v328.397h421.907v-328.397zm-224.809 303.412c0 2.762-2.239 5-5 5s-5-2.238-5-5v-82c0-2.762 2.239-5 5-5s5 2.238 5 5zm25.5 0c0 2.762-2.239 5-5 5s-5-2.238-5-5v-82c0-2.762 2.239-5 5-5s5 2.238 5 5zm248.024-84.261c0 36.44-34.906 66.087-77.812 66.087h-92.746c-2.761 0-5-2.238-5-5s2.239-5 5-5h92.746c37.392 0 67.812-25.16 67.812-56.087v-1.424c0-30.926-30.42-56.086-67.812-56.086h-76.258l52.023 34.752c2.296 1.533 2.914 4.639 1.38 6.935-1.524 2.28-4.623 2.925-6.935 1.38-.17-.113-65.842-43.983-65.734-43.911-2.587-1.741-2.971-5.396-.808-7.629.619-.639-3.654 2.299 66.543-44.594 2.296-1.534 5.401-.916 6.935 1.38s.916 5.401-1.38 6.935l-52.026 34.752h76.261c42.905 0 77.812 29.646 77.812 66.086v1.424z"></path></g></g></svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </article>
                <article class="pbmit-service-style-1 col-md-4">
                    <div class="pbminfotech-post-item">
                        <div class="pbmit-box-content-wrap">
                            <div class="pbmit-service-image-wrapper">
                                <div class="pbmit-featured-img-wrapper">
                                    <div class="pbmit-featured-wrapper">
                                        <img src="images/service/service-img-02.jpg" class="img-fluid" alt="">
                                    </div>
                                </div>
                                <div class="pbmit-service-btn-wrapper">
                                    <a class="pbmit-service-btn" href="services.html" title="Warehouse Storage">
												<span class="pbmit-button-icon">
													<i class="pbmit-base-icon-angle-right"></i>
												</span>
                                    </a>
                                </div>
                            </div>
                            <div class="pbmit-content-box">
                                <div class="pbminfotech-box-number">01</div>
                                <div class="pbmit-serv-cat"></div>
                                <h3 class="pbmit-service-title"><a href="services.html">Warehouse Storage</a></h3>
                                <div class="pbmit-service-description">
                                    <p>many variations of passages of Lorem Ipsum available, but the majority have suffered.</p>
                                </div>
                                <div class="pbmit-service-icon">
                                    <svg enable-background="new 0 0 512 512" height="512" viewbox="0 0 512 512" width="512" xmlns="http://www.w3.org/2000/svg"><g id="_x30_1_x2C__package_x2C__Box_x2C__delivery_x2C__return_x2C__shipment1"><g id="XMLID_186_1"><path id="XMLID_187_1" d="m214.187 139.087h83.622v70.413h-83.622z"></path><path id="XMLID_206_1" d="m218.666 44.516h-115.871l-53.655 84.571h155.727z"></path><path id="XMLID_256_1" d="m296.997 129.087-13.799-84.571h-54.4l-13.799 84.571z"></path><path id="XMLID_257_1" d="m462.86 129.087-53.655-84.571h-115.875l13.799 84.571z"></path><path id="XMLID_265_1" d="m307.809 139.087v75.413c0 2.761-2.239 5-5 5h-93.622c-2.761 0-5-2.239-5-5v-75.413h-159.141v328.397h421.907v-328.397zm-224.809 303.412c0 2.762-2.239 5-5 5s-5-2.238-5-5v-82c0-2.762 2.239-5 5-5s5 2.238 5 5zm25.5 0c0 2.762-2.239 5-5 5s-5-2.238-5-5v-82c0-2.762 2.239-5 5-5s5 2.238 5 5zm248.024-84.261c0 36.44-34.906 66.087-77.812 66.087h-92.746c-2.761 0-5-2.238-5-5s2.239-5 5-5h92.746c37.392 0 67.812-25.16 67.812-56.087v-1.424c0-30.926-30.42-56.086-67.812-56.086h-76.258l52.023 34.752c2.296 1.533 2.914 4.639 1.38 6.935-1.524 2.28-4.623 2.925-6.935 1.38-.17-.113-65.842-43.983-65.734-43.911-2.587-1.741-2.971-5.396-.808-7.629.619-.639-3.654 2.299 66.543-44.594 2.296-1.534 5.401-.916 6.935 1.38s.916 5.401-1.38 6.935l-52.026 34.752h76.261c42.905 0 77.812 29.646 77.812 66.086v1.424z"></path></g></g></svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </article>
                <article class="pbmit-service-style-1 col-md-4">
                    <div class="pbminfotech-post-item">
                        <div class="pbmit-box-content-wrap">
                            <div class="pbmit-service-image-wrapper">
                                <div class="pbmit-featured-img-wrapper">
                                    <div class="pbmit-featured-wrapper">
                                        <img src="images/service/service-img-03.jpg" class="img-fluid" alt="">
                                    </div>
                                </div>
                                <div class="pbmit-service-btn-wrapper">
                                    <a class="pbmit-service-btn" href="services.html" title="Warehouse Storage">
												<span class="pbmit-button-icon">
													<i class="pbmit-base-icon-angle-right"></i>
												</span>
                                    </a>
                                </div>
                            </div>
                            <div class="pbmit-content-box">
                                <div class="pbminfotech-box-number">01</div>
                                <div class="pbmit-serv-cat"></div>
                                <h3 class="pbmit-service-title"><a href="services.html">Warehouse Storage</a></h3>
                                <div class="pbmit-service-description">
                                    <p>many variations of passages of Lorem Ipsum available, but the majority have suffered.</p>
                                </div>
                                <div class="pbmit-service-icon">
                                    <svg enable-background="new 0 0 512 512" height="512" viewbox="0 0 512 512" width="512" xmlns="http://www.w3.org/2000/svg"><g id="_x30_1_x2C__package_x2C__Box_x2C__delivery_x2C__return_x2C__shipment2"><g id="XMLID_186_2"><path id="XMLID_187_2" d="m214.187 139.087h83.622v70.413h-83.622z"></path><path id="XMLID_206_2" d="m218.666 44.516h-115.871l-53.655 84.571h155.727z"></path><path id="XMLID_256_2" d="m296.997 129.087-13.799-84.571h-54.4l-13.799 84.571z"></path><path id="XMLID_257_2" d="m462.86 129.087-53.655-84.571h-115.875l13.799 84.571z"></path><path id="XMLID_265_2" d="m307.809 139.087v75.413c0 2.761-2.239 5-5 5h-93.622c-2.761 0-5-2.239-5-5v-75.413h-159.141v328.397h421.907v-328.397zm-224.809 303.412c0 2.762-2.239 5-5 5s-5-2.238-5-5v-82c0-2.762 2.239-5 5-5s5 2.238 5 5zm25.5 0c0 2.762-2.239 5-5 5s-5-2.238-5-5v-82c0-2.762 2.239-5 5-5s5 2.238 5 5zm248.024-84.261c0 36.44-34.906 66.087-77.812 66.087h-92.746c-2.761 0-5-2.238-5-5s2.239-5 5-5h92.746c37.392 0 67.812-25.16 67.812-56.087v-1.424c0-30.926-30.42-56.086-67.812-56.086h-76.258l52.023 34.752c2.296 1.533 2.914 4.639 1.38 6.935-1.524 2.28-4.623 2.925-6.935 1.38-.17-.113-65.842-43.983-65.734-43.911-2.587-1.741-2.971-5.396-.808-7.629.619-.639-3.654 2.299 66.543-44.594 2.296-1.534 5.401-.916 6.935 1.38s.916 5.401-1.38 6.935l-52.026 34.752h76.261c42.905 0 77.812 29.646 77.812 66.086v1.424z"></path></g></g></svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </article>
                <article class="pbmit-service-style-1 col-md-4">
                    <div class="pbminfotech-post-item">
                        <div class="pbmit-box-content-wrap">
                            <div class="pbmit-service-image-wrapper">
                                <div class="pbmit-featured-img-wrapper">
                                    <div class="pbmit-featured-wrapper">
                                        <img src="images/service/service-img-04.jpg" class="img-fluid" alt="">
                                    </div>
                                </div>
                                <div class="pbmit-service-btn-wrapper">
                                    <a class="pbmit-service-btn" href="services.html" title="Warehouse Storage">
												<span class="pbmit-button-icon">
													<i class="pbmit-base-icon-angle-right"></i>
												</span>
                                    </a>
                                </div>
                            </div>
                            <div class="pbmit-content-box">
                                <div class="pbminfotech-box-number">01</div>
                                <div class="pbmit-serv-cat"></div>
                                <h3 class="pbmit-service-title"><a href="services.html">Warehouse Storage</a></h3>
                                <div class="pbmit-service-description">
                                    <p>many variations of passages of Lorem Ipsum available, but the majority have suffered.</p>
                                </div>
                                <div class="pbmit-service-icon">
                                    <svg enable-background="new 0 0 512 512" height="512" viewbox="0 0 512 512" width="512" xmlns="http://www.w3.org/2000/svg"><g id="_x30_1_x2C__package_x2C__Box_x2C__delivery_x2C__return_x2C__shipment3"><g id="XMLID_186_3"><path id="XMLID_187_3" d="m214.187 139.087h83.622v70.413h-83.622z"></path><path id="XMLID_206_3" d="m218.666 44.516h-115.871l-53.655 84.571h155.727z"></path><path id="XMLID_256_3" d="m296.997 129.087-13.799-84.571h-54.4l-13.799 84.571z"></path><path id="XMLID_257_3" d="m462.86 129.087-53.655-84.571h-115.875l13.799 84.571z"></path><path id="XMLID_265_3" d="m307.809 139.087v75.413c0 2.761-2.239 5-5 5h-93.622c-2.761 0-5-2.239-5-5v-75.413h-159.141v328.397h421.907v-328.397zm-224.809 303.412c0 2.762-2.239 5-5 5s-5-2.238-5-5v-82c0-2.762 2.239-5 5-5s5 2.238 5 5zm25.5 0c0 2.762-2.239 5-5 5s-5-2.238-5-5v-82c0-2.762 2.239-5 5-5s5 2.238 5 5zm248.024-84.261c0 36.44-34.906 66.087-77.812 66.087h-92.746c-2.761 0-5-2.238-5-5s2.239-5 5-5h92.746c37.392 0 67.812-25.16 67.812-56.087v-1.424c0-30.926-30.42-56.086-67.812-56.086h-76.258l52.023 34.752c2.296 1.533 2.914 4.639 1.38 6.935-1.524 2.28-4.623 2.925-6.935 1.38-.17-.113-65.842-43.983-65.734-43.911-2.587-1.741-2.971-5.396-.808-7.629.619-.639-3.654 2.299 66.543-44.594 2.296-1.534 5.401-.916 6.935 1.38s.916 5.401-1.38 6.935l-52.026 34.752h76.261c42.905 0 77.812 29.646 77.812 66.086v1.424z"></path></g></g></svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </article>
                <article class="pbmit-service-style-1 col-md-4">
                    <div class="pbminfotech-post-item">
                        <div class="pbmit-box-content-wrap">
                            <div class="pbmit-service-image-wrapper">
                                <div class="pbmit-featured-img-wrapper">
                                    <div class="pbmit-featured-wrapper">
                                        <img src="images/service/service-img-05.jpg" class="img-fluid" alt="">
                                    </div>
                                </div>
                                <div class="pbmit-service-btn-wrapper">
                                    <a class="pbmit-service-btn" href="services.html" title="Warehouse Storage">
												<span class="pbmit-button-icon">
													<i class="pbmit-base-icon-angle-right"></i>
												</span>
                                    </a>
                                </div>
                            </div>
                            <div class="pbmit-content-box">
                                <div class="pbminfotech-box-number">01</div>
                                <div class="pbmit-serv-cat"></div>
                                <h3 class="pbmit-service-title"><a href="services.html">Warehouse Storage</a></h3>
                                <div class="pbmit-service-description">
                                    <p>many variations of passages of Lorem Ipsum available, but the majority have suffered.</p>
                                </div>
                                <div class="pbmit-service-icon">
                                    <svg enable-background="new 0 0 512 512" height="512" viewbox="0 0 512 512" width="512" xmlns="http://www.w3.org/2000/svg"><g id="_x30_1_x2C__package_x2C__Box_x2C__delivery_x2C__return_x2C__shipment4"><g id="XMLID_186_4"><path id="XMLID_187_4" d="m214.187 139.087h83.622v70.413h-83.622z"></path><path id="XMLID_206_4" d="m218.666 44.516h-115.871l-53.655 84.571h155.727z"></path><path id="XMLID_256_4" d="m296.997 129.087-13.799-84.571h-54.4l-13.799 84.571z"></path><path id="XMLID_257_4" d="m462.86 129.087-53.655-84.571h-115.875l13.799 84.571z"></path><path id="XMLID_265_4" d="m307.809 139.087v75.413c0 2.761-2.239 5-5 5h-93.622c-2.761 0-5-2.239-5-5v-75.413h-159.141v328.397h421.907v-328.397zm-224.809 303.412c0 2.762-2.239 5-5 5s-5-2.238-5-5v-82c0-2.762 2.239-5 5-5s5 2.238 5 5zm25.5 0c0 2.762-2.239 5-5 5s-5-2.238-5-5v-82c0-2.762 2.239-5 5-5s5 2.238 5 5zm248.024-84.261c0 36.44-34.906 66.087-77.812 66.087h-92.746c-2.761 0-5-2.238-5-5s2.239-5 5-5h92.746c37.392 0 67.812-25.16 67.812-56.087v-1.424c0-30.926-30.42-56.086-67.812-56.086h-76.258l52.023 34.752c2.296 1.533 2.914 4.639 1.38 6.935-1.524 2.28-4.623 2.925-6.935 1.38-.17-.113-65.842-43.983-65.734-43.911-2.587-1.741-2.971-5.396-.808-7.629.619-.639-3.654 2.299 66.543-44.594 2.296-1.534 5.401-.916 6.935 1.38s.916 5.401-1.38 6.935l-52.026 34.752h76.261c42.905 0 77.812 29.646 77.812 66.086v1.424z"></path></g></g></svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </article>
                <article class="pbmit-service-style-1 col-md-4">
                    <div class="pbminfotech-post-item">
                        <div class="pbmit-box-content-wrap">
                            <div class="pbmit-service-image-wrapper">
                                <div class="pbmit-featured-img-wrapper">
                                    <div class="pbmit-featured-wrapper">
                                        <img src="images/service/service-img-06.jpg" class="img-fluid" alt="">
                                    </div>
                                </div>
                                <div class="pbmit-service-btn-wrapper">
                                    <a class="pbmit-service-btn" href="services.html" title="Warehouse Storage">
												<span class="pbmit-button-icon">
													<i class="pbmit-base-icon-angle-right"></i>
												</span>
                                    </a>
                                </div>
                            </div>
                            <div class="pbmit-content-box">
                                <div class="pbminfotech-box-number">01</div>
                                <div class="pbmit-serv-cat"></div>
                                <h3 class="pbmit-service-title"><a href="services.html">Warehouse Storage</a></h3>
                                <div class="pbmit-service-description">
                                    <p>many variations of passages of Lorem Ipsum available, but the majority have suffered.</p>
                                </div>
                                <div class="pbmit-service-icon">
                                    <svg enable-background="new 0 0 512 512" height="512" viewbox="0 0 512 512" width="512" xmlns="http://www.w3.org/2000/svg"><g id="_x30_1_x2C__package_x2C__Box_x2C__delivery_x2C__return_x2C__shipment5"><g id="XMLID_186_5"><path id="XMLID_187_5" d="m214.187 139.087h83.622v70.413h-83.622z"></path><path id="XMLID_206_5" d="m218.666 44.516h-115.871l-53.655 84.571h155.727z"></path><path id="XMLID_256_5" d="m296.997 129.087-13.799-84.571h-54.4l-13.799 84.571z"></path><path id="XMLID_257_5" d="m462.86 129.087-53.655-84.571h-115.875l13.799 84.571z"></path><path id="XMLID_265_5" d="m307.809 139.087v75.413c0 2.761-2.239 5-5 5h-93.622c-2.761 0-5-2.239-5-5v-75.413h-159.141v328.397h421.907v-328.397zm-224.809 303.412c0 2.762-2.239 5-5 5s-5-2.238-5-5v-82c0-2.762 2.239-5 5-5s5 2.238 5 5zm25.5 0c0 2.762-2.239 5-5 5s-5-2.238-5-5v-82c0-2.762 2.239-5 5-5s5 2.238 5 5zm248.024-84.261c0 36.44-34.906 66.087-77.812 66.087h-92.746c-2.761 0-5-2.238-5-5s2.239-5 5-5h92.746c37.392 0 67.812-25.16 67.812-56.087v-1.424c0-30.926-30.42-56.086-67.812-56.086h-76.258l52.023 34.752c2.296 1.533 2.914 4.639 1.38 6.935-1.524 2.28-4.623 2.925-6.935 1.38-.17-.113-65.842-43.983-65.734-43.911-2.587-1.741-2.971-5.396-.808-7.629.619-.639-3.654 2.299 66.543-44.594 2.296-1.534 5.401-.916 6.935 1.38s.916 5.401-1.38 6.935l-52.026 34.752h76.261c42.905 0 77.812 29.646 77.812 66.086v1.424z"></path></g></g></svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </article>
                <article class="pbmit-service-style-1 col-md-4">
                    <div class="pbminfotech-post-item">
                        <div class="pbmit-box-content-wrap">
                            <div class="pbmit-service-image-wrapper">
                                <div class="pbmit-featured-img-wrapper">
                                    <div class="pbmit-featured-wrapper">
                                        <img src="images/service/service-img-07.jpg" class="img-fluid" alt="">
                                    </div>
                                </div>
                                <div class="pbmit-service-btn-wrapper">
                                    <a class="pbmit-service-btn" href="services.html" title="Warehouse Storage">
												<span class="pbmit-button-icon">
													<i class="pbmit-base-icon-angle-right"></i>
												</span>
                                    </a>
                                </div>
                            </div>
                            <div class="pbmit-content-box">
                                <div class="pbminfotech-box-number">01</div>
                                <div class="pbmit-serv-cat"></div>
                                <h3 class="pbmit-service-title"><a href="services.html">Warehouse Storage</a></h3>
                                <div class="pbmit-service-description">
                                    <p>many variations of passages of Lorem Ipsum available, but the majority have suffered.</p>
                                </div>
                                <div class="pbmit-service-icon">
                                    <svg enable-background="new 0 0 512 512" height="512" viewbox="0 0 512 512" width="512" xmlns="http://www.w3.org/2000/svg"><g id="_x30_1_x2C__package_x2C__Box_x2C__delivery_x2C__return_x2C__shipment6"><g id="XMLID_186_6"><path id="XMLID_187_6" d="m214.187 139.087h83.622v70.413h-83.622z"></path><path id="XMLID_206_6" d="m218.666 44.516h-115.871l-53.655 84.571h155.727z"></path><path id="XMLID_256_6" d="m296.997 129.087-13.799-84.571h-54.4l-13.799 84.571z"></path><path id="XMLID_257_6" d="m462.86 129.087-53.655-84.571h-115.875l13.799 84.571z"></path><path id="XMLID_265_6" d="m307.809 139.087v75.413c0 2.761-2.239 5-5 5h-93.622c-2.761 0-5-2.239-5-5v-75.413h-159.141v328.397h421.907v-328.397zm-224.809 303.412c0 2.762-2.239 5-5 5s-5-2.238-5-5v-82c0-2.762 2.239-5 5-5s5 2.238 5 5zm25.5 0c0 2.762-2.239 5-5 5s-5-2.238-5-5v-82c0-2.762 2.239-5 5-5s5 2.238 5 5zm248.024-84.261c0 36.44-34.906 66.087-77.812 66.087h-92.746c-2.761 0-5-2.238-5-5s2.239-5 5-5h92.746c37.392 0 67.812-25.16 67.812-56.087v-1.424c0-30.926-30.42-56.086-67.812-56.086h-76.258l52.023 34.752c2.296 1.533 2.914 4.639 1.38 6.935-1.524 2.28-4.623 2.925-6.935 1.38-.17-.113-65.842-43.983-65.734-43.911-2.587-1.741-2.971-5.396-.808-7.629.619-.639-3.654 2.299 66.543-44.594 2.296-1.534 5.401-.916 6.935 1.38s.916 5.401-1.38 6.935l-52.026 34.752h76.261c42.905 0 77.812 29.646 77.812 66.086v1.424z"></path></g></g></svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </article>
                <article class="pbmit-service-style-1 col-md-4">
                    <div class="pbminfotech-post-item">
                        <div class="pbmit-box-content-wrap">
                            <div class="pbmit-service-image-wrapper">
                                <div class="pbmit-featured-img-wrapper">
                                    <div class="pbmit-featured-wrapper">
                                        <img src="images/service/service-img-08.jpg" class="img-fluid" alt="">
                                    </div>
                                </div>
                                <div class="pbmit-service-btn-wrapper">
                                    <a class="pbmit-service-btn" href="services.html" title="Warehouse Storage">
												<span class="pbmit-button-icon">
													<i class="pbmit-base-icon-angle-right"></i>
												</span>
                                    </a>
                                </div>
                            </div>
                            <div class="pbmit-content-box">
                                <div class="pbminfotech-box-number">01</div>
                                <div class="pbmit-serv-cat"></div>
                                <h3 class="pbmit-service-title"><a href="services.html">Warehouse Storage</a></h3>
                                <div class="pbmit-service-description">
                                    <p>many variations of passages of Lorem Ipsum available, but the majority have suffered.</p>
                                </div>
                                <div class="pbmit-service-icon">
                                    <svg enable-background="new 0 0 512 512" height="512" viewbox="0 0 512 512" width="512" xmlns="http://www.w3.org/2000/svg"><g id="_x30_1_x2C__package_x2C__Box_x2C__delivery_x2C__return_x2C__shipment7"><g id="XMLID_186_7"><path id="XMLID_187_7" d="m214.187 139.087h83.622v70.413h-83.622z"></path><path id="XMLID_206_7" d="m218.666 44.516h-115.871l-53.655 84.571h155.727z"></path><path id="XMLID_256_7" d="m296.997 129.087-13.799-84.571h-54.4l-13.799 84.571z"></path><path id="XMLID_257_7" d="m462.86 129.087-53.655-84.571h-115.875l13.799 84.571z"></path><path id="XMLID_265_7" d="m307.809 139.087v75.413c0 2.761-2.239 5-5 5h-93.622c-2.761 0-5-2.239-5-5v-75.413h-159.141v328.397h421.907v-328.397zm-224.809 303.412c0 2.762-2.239 5-5 5s-5-2.238-5-5v-82c0-2.762 2.239-5 5-5s5 2.238 5 5zm25.5 0c0 2.762-2.239 5-5 5s-5-2.238-5-5v-82c0-2.762 2.239-5 5-5s5 2.238 5 5zm248.024-84.261c0 36.44-34.906 66.087-77.812 66.087h-92.746c-2.761 0-5-2.238-5-5s2.239-5 5-5h92.746c37.392 0 67.812-25.16 67.812-56.087v-1.424c0-30.926-30.42-56.086-67.812-56.086h-76.258l52.023 34.752c2.296 1.533 2.914 4.639 1.38 6.935-1.524 2.28-4.623 2.925-6.935 1.38-.17-.113-65.842-43.983-65.734-43.911-2.587-1.741-2.971-5.396-.808-7.629.619-.639-3.654 2.299 66.543-44.594 2.296-1.534 5.401-.916 6.935 1.38s.916 5.401-1.38 6.935l-52.026 34.752h76.261c42.905 0 77.812 29.646 77.812 66.086v1.424z"></path></g></g></svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </article>
                <article class="pbmit-service-style-1 col-md-4">
                    <div class="pbminfotech-post-item">
                        <div class="pbmit-box-content-wrap">
                            <div class="pbmit-service-image-wrapper">
                                <div class="pbmit-featured-img-wrapper">
                                    <div class="pbmit-featured-wrapper">
                                        <img src="images/service/service-img-09.jpg" class="img-fluid" alt="">
                                    </div>
                                </div>
                                <div class="pbmit-service-btn-wrapper">
                                    <a class="pbmit-service-btn" href="services.html" title="Warehouse Storage">
												<span class="pbmit-button-icon">
													<i class="pbmit-base-icon-angle-right"></i>
												</span>
                                    </a>
                                </div>
                            </div>
                            <div class="pbmit-content-box">
                                <div class="pbminfotech-box-number">01</div>
                                <div class="pbmit-serv-cat"></div>
                                <h3 class="pbmit-service-title"><a href="services.html">Warehouse Storage</a></h3>
                                <div class="pbmit-service-description">
                                    <p>many variations of passages of Lorem Ipsum available, but the majority have suffered.</p>
                                </div>
                                <div class="pbmit-service-icon">
                                    <svg enable-background="new 0 0 512 512" height="512" viewbox="0 0 512 512" width="512" xmlns="http://www.w3.org/2000/svg"><g id="_x30_1_x2C__package_x2C__Box_x2C__delivery_x2C__return_x2C__shipment8"><g id="XMLID_186_8"><path id="XMLID_187_8" d="m214.187 139.087h83.622v70.413h-83.622z"></path><path id="XMLID_206_8" d="m218.666 44.516h-115.871l-53.655 84.571h155.727z"></path><path id="XMLID_256_8" d="m296.997 129.087-13.799-84.571h-54.4l-13.799 84.571z"></path><path id="XMLID_257_8" d="m462.86 129.087-53.655-84.571h-115.875l13.799 84.571z"></path><path id="XMLID_265_8" d="m307.809 139.087v75.413c0 2.761-2.239 5-5 5h-93.622c-2.761 0-5-2.239-5-5v-75.413h-159.141v328.397h421.907v-328.397zm-224.809 303.412c0 2.762-2.239 5-5 5s-5-2.238-5-5v-82c0-2.762 2.239-5 5-5s5 2.238 5 5zm25.5 0c0 2.762-2.239 5-5 5s-5-2.238-5-5v-82c0-2.762 2.239-5 5-5s5 2.238 5 5zm248.024-84.261c0 36.44-34.906 66.087-77.812 66.087h-92.746c-2.761 0-5-2.238-5-5s2.239-5 5-5h92.746c37.392 0 67.812-25.16 67.812-56.087v-1.424c0-30.926-30.42-56.086-67.812-56.086h-76.258l52.023 34.752c2.296 1.533 2.914 4.639 1.38 6.935-1.524 2.28-4.623 2.925-6.935 1.38-.17-.113-65.842-43.983-65.734-43.911-2.587-1.741-2.971-5.396-.808-7.629.619-.639-3.654 2.299 66.543-44.594 2.296-1.534 5.401-.916 6.935 1.38s.916 5.401-1.38 6.935l-52.026 34.752h76.261c42.905 0 77.812 29.646 77.812 66.086v1.424z"></path></g></g></svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </section>
    <!-- Services end -->
@endsection

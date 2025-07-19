@extends('frontend.layouts.master')
@section('title') {{ __('strings.Home') }} @endsection

@section('header_background')
<div class="pbmit-slider-area pbmit-slider-one">
    <div class="swiper-slider" data-autoplay="true" data-loop="true" data-dots="true" data-arrows="false" data-columns="1" data-margin="0" data-effect="fade">
        <div class="swiper-wrapper">
            @foreach($sliders as $slider)
                <div class="swiper-slide">
                    <div class="pbmit-slider-item">
                        <div class="pbmit-slider-bg" style="background-image: url({{$slider->src ?: config('filemanager.default_backend_image')}});"></div>
                        <div class="container">
                            <div class="pbmit-slider-content">
                                <div class="row align-items-end g-0">
                                    <div class="col-md-12 col-lg-8">
                                        <h5 class="pbmit-sub-title transform-right transform-delay-1"><span>Logistic Transportation</span></h5>
                                        <h2 class="pbmit-title transform-left-1 transform-delay-2"><span>Heavy Truck Logistics: <br> Maximizing Capacity</span></h2>
                                    </div>
                                    <div class="col-md-12 col-lg-4">
                                        <div class="pbmit-slider-right-content">
                                            <div class="pbmit-desc transform-center transform-delay-3">
                                                Streamlining your logistics with transportation <br> solutions timely deliveries and exceptional service <br> worldwide.
                                            </div>
                                            <div class="pbmit-button transform-bottom transform-delay-4">
                                                <a class="pbmit-btn" href="services.html">
															<span class="pbmit-button-content-wrapper">
																<span class="pbmit-button-text">our services</span>
															</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

@section('content')
<!-- About Start -->
<section style="padding: 150px;">
    <div class="container">
        <div class="row g-0">
            <div class="col-md-4 about-one-col1">
                <div class="about-one-img">
                </div>
            </div>
            <div class="col-md-3 about-one-col2">
                <div class="about-one-center-box pbmit-bg-color-white">
                    <div class="pbmit-custom-heading">
                        <h2>Delivering Monster for <br> industry leaders</h2>
                    </div>
                    <div class="align-self-end">
                        <div class="pbminfotech-ele-fid-style-3">
                            <div class="pbmit-fld-contents">
                                <div class="pbmit-fld-wrap">
                                    <h4 class="pbmit-fid-inner">
                                        <span class="pbmit-fid-before"></span>
                                        <span class="pbmit-number-rotate numinate" data-appear-animation="animateDigits" data-from="0" data-to="245" data-interval="10" data-before="" data-before-style="" data-after="" data-after-style="">245</span>
                                        <span class="pbmit-fid"><span>+</span></span>
                                    </h4>
                                    <span class="pbmit-fid-title">Cargo Delivered Per<br>  Month</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-5 about-one-col3">
                <div class="ps-xl-5">
                    <p>Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt dolores suspendisse ultrices gravida risus.</p>
                    <ul class="list-group style-2">
                        <li class="list-group-item">
										<span class="pbmit-icon-list-icon">
											<i class="pbmit-shipex-icon pbmit-shipex-icon-tick"></i>
										</span>
                            <span class="pbmit-icon-list-text">We will never compromise the safety of our people</span>
                        </li>
                        <li class="list-group-item">
										<span class="pbmit-icon-list-icon">
											<i class="pbmit-shipex-icon pbmit-shipex-icon-tick"></i>
										</span>
                            <span class="pbmit-icon-list-text">With over four decades of experience providing solutions</span>
                        </li>
                        <li class="list-group-item">
										<span class="pbmit-icon-list-icon">
											<i class="pbmit-shipex-icon pbmit-shipex-icon-tick"></i>
										</span>
                            <span class="pbmit-icon-list-text">See projects through and proactively develop solutions</span>
                        </li>
                    </ul>
                    <a class="pbmit-btn pbmit-btn-outline mt-4" href="about-us.html">
									<span class="pbmit-button-content-wrapper">
										<span class="pbmit-button-text">Know About Us</span>
									</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- About End -->

<!-- Service Start -->
<section class="service-one-bg pbmit-bg-color-blackish">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="pbmit-heading-subheading">
                    <h4 class="pbmit-subtitle">
                        Our experience
                    </h4>
                    <h2 class="pbmit-title">
                        Essential Features<br> of our Services.
                    </h2>
                </div>
            </div>
            <div class="col-md-4 text-end">
                <div class="service-arrow swiper-btn-custom d-inline-flex flex-row-reverse"></div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="swiper-slider pbmit-element-service-style-3" data-columns="4" data-loop="true" data-autoplay="false" data-arrows="true" data-dots="false" data-arrows-class="service-arrow" data-margin="40" data-effect="slide">
            <div class="swiper-wrapper">
                <!-- Slide1 -->
                <article class="pbmit-service-style-3 swiper-slide">
                    <div class="pbminfotech-post-item">
                        <div class="pbminfotech-box-content-desc-wraper">
                            <div class="pbminfotech-box-content">
                                <div class="pbmit-content-box">
                                    <div class="pbmit-serv-cat"></div>
                                    <h3 class="pbmit-service-title">
                                        <a href="service-details.html">Warehouse Storage</a>
                                    </h3>
                                </div>
                                <div class="pbmit-service-icon">
                                    <svg enable-background="new 0 0 512 512" height="512" viewbox="0 0 512 512" width="512" xmlns="http://www.w3.org/2000/svg"><g id="_x30_6_x2C__Delivery_x2C__domestic_ems_x2C__express_x2C__global_x2C__logistics"><g id="XMLID_129_"><path id="XMLID_139_" d="m97.239 406.218c31.077 40.974 78.875 68.6 133.144 72.611-18.323-19.421-33.738-44.255-44.965-72.611z"></path><path id="XMLID_189_" d="m196.314 406.218c11.981 29.004 28.578 54.262 48.735 73.109.296-.002.59-.008.886-.011 20.152-18.846 36.745-44.099 48.723-73.098z"></path><path id="XMLID_190_" d="m164.905 300.114h-104.971c.949 35.414 11.948 68.362 30.233 96.104h91.536c-10.541-30.006-16.306-62.928-16.798-96.104z"></path><path id="XMLID_191_" d="m230.427 111.395c-54.286 3.999-102.1 31.627-133.186 72.611h88.474c11.099-28.048 26.279-52.973 44.712-72.611z"></path><path id="XMLID_192_" d="m274.606 113.628c-4.076-.588-8.519-1.148-12.911-1.608 4.773 5.147 9.33 10.646 13.644 16.485-.659-5.137-.874-10.029-.733-14.877z"></path><path id="XMLID_193_" d="m294.806 184.006c-11.874-29.064-28.313-54.311-48.273-73.08-.505-.013-.994-.022-1.475-.027-20.087 18.87-36.643 44.119-48.615 73.108h98.363z"></path><path id="XMLID_194_" d="m192.565 194.006c-10.833 29.551-17.052 62.452-17.652 96.107h141.146c-.59-33.713-6.725-66.608-17.415-96.107z"></path><path id="XMLID_195_" d="m192.431 396.218h106.11c10.826-29.55 17.004-62.455 17.526-96.104h-141.161c.521 33.649 6.699 66.555 17.525 96.104z"></path><path id="XMLID_196_" d="m181.977 194.006h-91.809c-18.286 27.743-29.286 60.692-30.235 96.107h104.981c.581-33.506 6.578-66.339 17.063-96.107z"></path><path id="XMLID_199_" d="m368.279 32.673c-46.162 0-83.717 37.554-83.717 83.713 0 56.623 50.137 70.383 82.944 131.892 16.825-39.657 65.856-74.841 75.682-94.472 27.532-54.996-12.18-121.133-74.909-121.133zm.002 131.694c-26.996 0-48.958-21.963-48.958-48.959s21.963-48.959 48.958-48.959c26.997 0 48.959 21.963 48.959 48.959s-21.963 48.959-48.959 48.959z"></path><path id="XMLID_200_" d="m368.281 76.449c-21.482 0-38.958 17.477-38.958 38.959s17.477 38.959 38.958 38.959c21.482 0 38.959-17.477 38.959-38.959s-17.477-38.959-38.959-38.959z"></path><path id="XMLID_201_" d="m428.207 290.114c-1.122-28.314-11.42-59.494-21.345-80.797-15.114 16.513-29.316 34.951-33.716 53.587-.502 2.126-2.327 3.681-4.507 3.838-2.172.158-4.207-1.116-5.01-3.152-10.688-27.086-37.395-54.794-56.762-76.294.1.274.182.556.233.85 11.659 31.238 18.349 66.185 18.959 101.969h102.148z"></path><path id="XMLID_202_" d="m309.27 396.218h88.743c18.284-27.743 29.284-60.69 30.233-96.104h-102.179c-.492 33.176-6.256 66.098-16.797 96.104z"></path><path id="XMLID_203_" d="m260.83 478.571c53.014-4.798 99.614-32.144 130.11-72.352h-85.386c-11.177 28.231-26.507 52.969-44.724 72.352z"></path></g></g></svg>
                                </div>
                            </div>
                            <div class="pbmit-service-description">
                                <p>many variations of passages of Lorem Ipsum available, but the majority have suffered.</p>
                            </div>
                        </div>
                        <div class="pbmit-service-image-wrapper">
                            <div class="pbmit-featured-img-wrapper">
                                <div class="pbmit-featured-wrapper">
                                    <img src="images/homepage-1/service/service-01.jpg" class="img-fluid w-100" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </article>
                <!-- Slide2 -->
                <article class="pbmit-service-style-3 swiper-slide">
                    <div class="pbminfotech-post-item">
                        <div class="pbminfotech-box-content-desc-wraper">
                            <div class="pbminfotech-box-content">
                                <div class="pbmit-content-box">
                                    <div class="pbmit-serv-cat"></div>
                                    <h3 class="pbmit-service-title">
                                        <a href="service-details.html">Real Time Tracking</a>
                                    </h3>
                                </div>
                                <div class="pbmit-service-icon">
                                    <svg enable-background="new 0 0 512 512" height="512" viewbox="0 0 512 512" width="512" xmlns="http://www.w3.org/2000/svg"><g id="_x30_5_x2C__logistics_x2C__shipping_x2C__truck_x2C__delivery_x2C__checked"><g id="XMLID_175_"><path id="XMLID_176_" d="m125.132 401.481c-2.272 0-4.122 1.842-4.122 4.106 0 2.274 1.849 4.125 4.122 4.125 2.267 0 4.11-1.851 4.11-4.125 0-2.264-1.844-4.106-4.11-4.106z"></path><path id="XMLID_210_" d="m318.133 67.967h-281.076v234h281.076zm-140.539 211.515c-52.116 0-94.516-42.399-94.516-94.515s42.399-94.516 94.516-94.516 94.516 42.399 94.516 94.516c0 52.116-42.399 94.515-94.516 94.515z"></path><path id="XMLID_226_" d="m125.126 367.162c-21.193 0-38.435 17.241-38.435 38.435s17.242 38.436 38.435 38.436 38.435-17.242 38.435-38.436-17.242-38.435-38.435-38.435zm.006 52.551c-7.787 0-14.122-6.337-14.122-14.125 0-7.778 6.335-14.106 14.122-14.106 7.78 0 14.11 6.328 14.11 14.106 0 7.788-6.33 14.125-14.11 14.125z"></path><path id="XMLID_229_" d="m377.753 367.161c-21.193 0-38.436 17.242-38.436 38.436s17.242 38.437 38.436 38.437c21.193 0 38.435-17.242 38.435-38.437-.001-21.194-17.242-38.436-38.435-38.436zm.004 52.552c-7.787 0-14.122-6.337-14.122-14.125 0-7.778 6.335-14.106 14.122-14.106 7.781 0 14.111 6.328 14.111 14.106 0 7.788-6.33 14.125-14.111 14.125z"></path><path id="XMLID_230_" d="m377.757 401.481c-2.272 0-4.122 1.842-4.122 4.106 0 2.274 1.849 4.125 4.122 4.125 2.267 0 4.111-1.851 4.111-4.125 0-2.264-1.844-4.106-4.111-4.106z"></path><path id="XMLID_231_" d="m351.868 298.231v-99.965h-23.735v108.701c0 2.762-2.239 5-5 5h-286.076v62.23l16.479 16.48h25.516c6.306-19.427 24.571-33.516 46.074-33.516s39.767 14.088 46.073 33.516h160.479c6.306-19.428 24.571-33.517 46.074-33.517 25.019 0 45.667 19.069 48.177 43.436h33.025l15.989-15.116v-82.249h-118.075c-2.761 0-5-2.238-5-5z"></path><path id="XMLID_237_" d="m177.594 100.451c-46.602 0-84.516 37.914-84.516 84.516s37.914 84.515 84.516 84.515 84.516-37.914 84.516-84.515c0-46.602-37.913-84.516-84.516-84.516zm45.218 56.218-56.75 56.75c-1.954 1.953-5.118 1.952-7.071 0l-32.25-32.25c-1.953-1.953-1.953-5.119 0-7.071s5.118-1.952 7.071 0l28.714 28.714 53.214-53.214c1.953-1.952 5.118-1.952 7.071 0 1.954 1.953 1.954 5.119.001 7.071z"></path><path id="XMLID_238_" d="m361.868 198.266v94.965h113.075v-23.157l-61.272-71.808z"></path></g></g></svg>
                                </div>
                            </div>
                            <div class="pbmit-service-description">
                                <p>Sed ut perspiciatis unde omnis iste natus ut persp iatis unde omnis iste perspiciatis.</p>
                            </div>
                        </div>
                        <div class="pbmit-service-image-wrapper">
                            <div class="pbmit-featured-img-wrapper">
                                <div class="pbmit-featured-wrapper">
                                    <img src="images/homepage-1/service/service-02.jpg" class="img-fluid w-100" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </article>
                <!-- Slide3 -->
                <article class="pbmit-service-style-3 swiper-slide">
                    <div class="pbminfotech-post-item">
                        <div class="pbminfotech-box-content-desc-wraper">
                            <div class="pbminfotech-box-content">
                                <div class="pbmit-content-box">
                                    <div class="pbmit-serv-cat"></div>
                                    <h3 class="pbmit-service-title">
                                        <a href="service-details.html">Distribution Centers</a>
                                    </h3>
                                </div>
                                <div class="pbmit-service-icon">
                                    <svg enable-background="new 0 0 512 512" height="512" viewbox="0 0 512 512" width="512" xmlns="http://www.w3.org/2000/svg"><g id="_x30_4_x2C__address_x2C__Gps_x2C__location_x2C__pin_x2C__sign"><g id="XMLID_180_"><path id="XMLID_184_" d="m391.996 174.086c0-74.988-61.007-135.995-135.996-135.995-74.987 0-135.994 61.007-135.994 135.995 0 68.159 114.342 187.283 135.994 209.224 21.652-21.945 135.996-141.085 135.996-209.224zm-209.266 0c0-40.402 32.869-73.271 73.271-73.271s73.271 32.869 73.271 73.271-32.87 73.271-73.271 73.271c-40.402 0-73.271-32.869-73.271-73.271z"></path><path id="XMLID_232_" d="m288.845 174.086c0-18.11-14.734-32.844-32.845-32.844-18.11 0-32.844 14.734-32.844 32.844 0 18.111 14.734 32.845 32.844 32.845 18.111 0 32.845-14.734 32.845-32.845z"></path><path id="XMLID_239_" d="m319.272 174.086c0-34.888-28.383-63.271-63.271-63.271s-63.271 28.383-63.271 63.271 28.383 63.271 63.271 63.271 63.271-28.383 63.271-63.271zm-106.116 0c0-23.625 19.22-42.844 42.844-42.844s42.845 19.22 42.845 42.844-19.22 42.845-42.845 42.845-42.844-19.221-42.844-42.845z"></path><path id="XMLID_240_" d="m336.429 306.875c-24.213 31.241-56.168 66.726-76.926 87.084-1.945 1.91-5.061 1.911-7.006 0-19.942-19.53-52.196-55.177-76.925-87.084h-56.343l-28.306 167.034h330.154l-28.306-167.033h-56.342z"></path></g></g></svg>
                                </div>
                            </div>
                            <div class="pbmit-service-description">
                                <p>Sed ut perspiciatis unde omnis iste natus ut persp iatis unde omnis iste perspiciatis.</p>
                            </div>
                        </div>
                        <div class="pbmit-service-image-wrapper">
                            <div class="pbmit-featured-img-wrapper">
                                <div class="pbmit-featured-wrapper">
                                    <img src="images/homepage-1/service/service-03.jpg" class="img-fluid w-100" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </article>
                <!-- Slide4 -->
                <article class="pbmit-service-style-3 swiper-slide">
                    <div class="pbminfotech-post-item">
                        <div class="pbminfotech-box-content-desc-wraper">
                            <div class="pbminfotech-box-content">
                                <div class="pbmit-content-box">
                                    <div class="pbmit-serv-cat"></div>
                                    <h3 class="pbmit-service-title">
                                        <a href="service-details.html">Bonded Warehousing</a>
                                    </h3>
                                </div>
                                <div class="pbmit-service-icon">
                                    <svg enable-background="new 0 0 512 512" height="512" viewbox="0 0 512 512" width="512" xmlns="http://www.w3.org/2000/svg"><g id="_x30_1_x2C__package_x2C__Box_x2C__delivery_x2C__return_x2C__shipment"><g id="XMLID_186_"><path id="XMLID_187_" d="m214.187 139.087h83.622v70.413h-83.622z"></path><path id="XMLID_206_" d="m218.666 44.516h-115.871l-53.655 84.571h155.727z"></path><path id="XMLID_256_" d="m296.997 129.087-13.799-84.571h-54.4l-13.799 84.571z"></path><path id="XMLID_257_" d="m462.86 129.087-53.655-84.571h-115.875l13.799 84.571z"></path><path id="XMLID_265_" d="m307.809 139.087v75.413c0 2.761-2.239 5-5 5h-93.622c-2.761 0-5-2.239-5-5v-75.413h-159.141v328.397h421.907v-328.397zm-224.809 303.412c0 2.762-2.239 5-5 5s-5-2.238-5-5v-82c0-2.762 2.239-5 5-5s5 2.238 5 5zm25.5 0c0 2.762-2.239 5-5 5s-5-2.238-5-5v-82c0-2.762 2.239-5 5-5s5 2.238 5 5zm248.024-84.261c0 36.44-34.906 66.087-77.812 66.087h-92.746c-2.761 0-5-2.238-5-5s2.239-5 5-5h92.746c37.392 0 67.812-25.16 67.812-56.087v-1.424c0-30.926-30.42-56.086-67.812-56.086h-76.258l52.023 34.752c2.296 1.533 2.914 4.639 1.38 6.935-1.524 2.28-4.623 2.925-6.935 1.38-.17-.113-65.842-43.983-65.734-43.911-2.587-1.741-2.971-5.396-.808-7.629.619-.639-3.654 2.299 66.543-44.594 2.296-1.534 5.401-.916 6.935 1.38s.916 5.401-1.38 6.935l-52.026 34.752h76.261c42.905 0 77.812 29.646 77.812 66.086v1.424z"></path></g></g></svg>
                                </div>
                            </div>
                            <div class="pbmit-service-description">
                                <p>Sed ut perspiciatis unde omnis iste natus ut persp iatis unde omnis iste perspiciatis.</p>
                            </div>
                        </div>
                        <div class="pbmit-service-image-wrapper">
                            <div class="pbmit-featured-img-wrapper">
                                <div class="pbmit-featured-wrapper">
                                    <img src="images/homepage-1/service/service-04.jpg" class="img-fluid w-100" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </div>
</section>
<!-- Service end -->

<!-- Static Box Start -->
<section class="pbmit-element-static-box-style-1 section-lg">
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
                    <div class="pbmit-bg-imgbox col-md-6" style="background-image: url(images/homepage-1/static-box/static-box-01.jpg);">
                        <div class="pbmit-img">
                            <img src="images/homepage-1/static-box/static-box-01.jpg" class="img-fluid" alt="Receive packages">
                        </div>
                        <div class="pbmit-box-number">01</div>
                        <h4 class="pbmit-static-box-title">Receive packages</h4>
                    </div>
                    <div class="pbmit-content-box col-md-6">
                        <div class="pbmit-box-number">01</div>
                        <div class="pbmit-content-inner">
                            <h4 class="pbmit-static-box-title">Receive packages</h4>
                            <div class="pbmit-static-box-desc">Sed ut perspiciatis unde omnis iste natus ut perspic iatis unde omnis iste perspiciatis ut perspiciatis unde omnis iste natus Perspiciatis unde omnis iste natus. sed do euism od tempor incidunt ut nsectetur </div>
                        </div>
                    </div>
                </div>
            </article>
            <article class="pbmit-static-box-style-1">
                <div class="pbmit-staticbox-wrapper">
                    <div class="pbmit-bg-imgbox col-md-6" style="background-image: url(images/homepage-1/static-box/static-box-02.jpg);">
                        <div class="pbmit-img">
                            <img src="images/homepage-1/static-box/static-box-03.jpg" class="img-fluid" alt="Deliver packages">
                        </div>
                        <div class="pbmit-box-number">02</div>
                        <h4 class="pbmit-static-box-title">Deliver packages</h4>
                    </div>
                    <div class="pbmit-content-box col-md-6">
                        <div class="pbmit-box-number">02</div>
                        <div class="pbmit-content-inner">
                            <h4 class="pbmit-static-box-title">Deliver packages</h4>
                            <div class="pbmit-static-box-desc">Sed ut perspiciatis unde omnis iste natus ut perspic iatis unde omnis iste perspiciatis ut perspiciatis unde omnis iste natus Perspiciatis unde omnis iste natus. sed do euism od tempor incidunt ut nsectetur </div>
                        </div>
                    </div>
                </div>
            </article>
            <article class="pbmit-static-box-style-1">
                <div class="pbmit-staticbox-wrapper">
                    <div class="pbmit-bg-imgbox col-md-6" style="background-image: url(images/homepage-1/static-box/static-box-03.jpg);">
                        <div class="pbmit-img">
                            <img src="images/homepage-1/static-box/static-box-04.jpg" class="img-fluid" alt="Transport packages">
                        </div>
                        <div class="pbmit-box-number">03</div>
                        <h4 class="pbmit-static-box-title">Transport packages</h4>
                    </div>
                    <div class="pbmit-content-box col-md-6">
                        <div class="pbmit-box-number">03</div>
                        <div class="pbmit-content-inner">
                            <h4 class="pbmit-static-box-title">Transport packages</h4>
                            <div class="pbmit-static-box-desc">Sed ut perspiciatis unde omnis iste natus ut perspic iatis unde omnis iste perspiciatis ut perspiciatis unde omnis iste natus Perspiciatis unde omnis iste natus. sed do euism od tempor incidunt ut nsectetur </div>
                        </div>
                    </div>
                </div>
            </article>
            <article class="pbmit-static-box-style-1">
                <div class="pbmit-staticbox-wrapper">
                    <div class="pbmit-bg-imgbox col-md-6" style="background-image: url(images/homepage-1/static-box/static-box-04.jpg);">
                        <div class="pbmit-img">
                            <img src="images/homepage-1/static-box/static-box-02.jpg" class="img-fluid" alt="Warehousing Operation">
                        </div>
                        <div class="pbmit-box-number">04</div>
                        <h4 class="pbmit-static-box-title">Warehousing Operation</h4>
                    </div>
                    <div class="pbmit-content-box col-md-6">
                        <div class="pbmit-box-number">04</div>
                        <div class="pbmit-content-inner">
                            <h4 class="pbmit-static-box-title">Warehousing Operation</h4>
                            <div class="pbmit-static-box-desc">Sed ut perspiciatis unde omnis iste natus ut perspic iatis unde omnis iste perspiciatis ut perspiciatis unde omnis iste natus Perspiciatis unde omnis iste natus. sed do euism od tempor incidunt ut nsectetur </div>
                        </div>
                    </div>
                </div>
            </article>
        </div>
    </div>
</section>
<!-- Static Box Start -->

<!-- Ihbox Start -->
<section class="section-lgb">
    <div class="container">
        <div class="row g-0">
            <article class="pbmit-miconheading-style-8 col-md-6 col-lg-4">
                <div class="pbmit-ihbox-style-8">
                    <div class="pbmit-ihbox-box">
                        <div class="pbmit-ihbox-icon">
                            <div class="pbmit-ihbox-icon-wrapper pbmit-icon-type-icon">
                                <svg enable-background="new 0 0 512 512" height="512" viewbox="0 0 512 512" width="512" xmlns="http://www.w3.org/2000/svg">
                                    <g id="_x30_6_x2C__Delivery_x2C__domestic_ems_x2C__express_x2C__global_x2C__logistics1">
                                        <g id="XMLID_129_1">
                                            <path id="XMLID_139_1" d="m97.239 406.218c31.077 40.974 78.875 68.6 133.144 72.611-18.323-19.421-33.738-44.255-44.965-72.611z"></path>
                                            <path id="XMLID_189_1" d="m196.314 406.218c11.981 29.004 28.578 54.262 48.735 73.109.296-.002.59-.008.886-.011 20.152-18.846 36.745-44.099 48.723-73.098z"></path>
                                            <path id="XMLID_190_1" d="m164.905 300.114h-104.971c.949 35.414 11.948 68.362 30.233 96.104h91.536c-10.541-30.006-16.306-62.928-16.798-96.104z"></path>
                                            <path id="XMLID_191_1" d="m230.427 111.395c-54.286 3.999-102.1 31.627-133.186 72.611h88.474c11.099-28.048 26.279-52.973 44.712-72.611z"></path>
                                            <path id="XMLID_192_1" d="m274.606 113.628c-4.076-.588-8.519-1.148-12.911-1.608 4.773 5.147 9.33 10.646 13.644 16.485-.659-5.137-.874-10.029-.733-14.877z"></path>
                                            <path id="XMLID_193_1" d="m294.806 184.006c-11.874-29.064-28.313-54.311-48.273-73.08-.505-.013-.994-.022-1.475-.027-20.087 18.87-36.643 44.119-48.615 73.108h98.363z"></path>
                                            <path id="XMLID_194_1" d="m192.565 194.006c-10.833 29.551-17.052 62.452-17.652 96.107h141.146c-.59-33.713-6.725-66.608-17.415-96.107z"></path>
                                            <path id="XMLID_195_1" d="m192.431 396.218h106.11c10.826-29.55 17.004-62.455 17.526-96.104h-141.161c.521 33.649 6.699 66.555 17.525 96.104z"></path>
                                            <path id="XMLID_196_1" d="m181.977 194.006h-91.809c-18.286 27.743-29.286 60.692-30.235 96.107h104.981c.581-33.506 6.578-66.339 17.063-96.107z"></path>
                                            <path id="XMLID_199_1" d="m368.279 32.673c-46.162 0-83.717 37.554-83.717 83.713 0 56.623 50.137 70.383 82.944 131.892 16.825-39.657 65.856-74.841 75.682-94.472 27.532-54.996-12.18-121.133-74.909-121.133zm.002 131.694c-26.996 0-48.958-21.963-48.958-48.959s21.963-48.959 48.958-48.959c26.997 0 48.959 21.963 48.959 48.959s-21.963 48.959-48.959 48.959z"></path>
                                            <path id="XMLID_200_1" d="m368.281 76.449c-21.482 0-38.958 17.477-38.958 38.959s17.477 38.959 38.958 38.959c21.482 0 38.959-17.477 38.959-38.959s-17.477-38.959-38.959-38.959z"></path>
                                            <path id="XMLID_201_1" d="m428.207 290.114c-1.122-28.314-11.42-59.494-21.345-80.797-15.114 16.513-29.316 34.951-33.716 53.587-.502 2.126-2.327 3.681-4.507 3.838-2.172.158-4.207-1.116-5.01-3.152-10.688-27.086-37.395-54.794-56.762-76.294.1.274.182.556.233.85 11.659 31.238 18.349 66.185 18.959 101.969h102.148z"></path>
                                            <path id="XMLID_202_1" d="m309.27 396.218h88.743c18.284-27.743 29.284-60.69 30.233-96.104h-102.179c-.492 33.176-6.256 66.098-16.797 96.104z"></path>
                                            <path id="XMLID_203_1" d="m260.83 478.571c53.014-4.798 99.614-32.144 130.11-72.352h-85.386c-11.177 28.231-26.507 52.969-44.724 72.352z"></path>
                                        </g>
                                    </g>
                                </svg>
                            </div>
                        </div>
                        <div class="pbmit-ihbox-contents">
                            <h2 class="pbmit-element-title">
                                Transparent Pricing
                            </h2>
                            <div class="pbmit-heading-desc">Sed ut perspiciatis unde omnis iste natus ut perspic iatis unde omnis iste petis.</div>
                        </div>
                    </div>
                </div>
            </article>
            <article class="pbmit-miconheading-style-8 col-md-6 col-lg-4">
                <div class="pbmit-ihbox-style-8">
                    <div class="pbmit-ihbox-box">
                        <div class="pbmit-ihbox-icon">
                            <div class="pbmit-ihbox-icon-wrapper pbmit-icon-type-icon">
                                <svg enable-background="new 0 0 512 512" height="512" viewbox="0 0 512 512" width="512" xmlns="http://www.w3.org/2000/svg">
                                    <g id="_x30_9_x2C__Box_x2C__delivery_x2C__fast_x2C__logistics_x2C__package">
                                        <g id="XMLID_92_">
                                            <path id="XMLID_97_" d="m214.187 139.087h83.622v70.413h-83.622z"></path>
                                            <path id="XMLID_127_" d="m218.666 44.516h-115.871l-53.655 84.571h155.727z"></path>
                                            <path id="XMLID_128_" d="m296.997 129.087-13.799-84.571h-54.4l-13.799 84.571z"></path>
                                            <path id="XMLID_137_" d="m462.86 129.087-53.655-84.571h-115.875l13.799 84.571z"></path>
                                            <path id="XMLID_161_" d="m307.809 214.499c0 2.761-2.239 5-5 5h-93.622c-2.761 0-5-2.239-5-5v-75.413h-159.141v328.397h421.907v-328.396h-159.144zm45.495 63.645c.798-1.815 2.594-2.987 4.577-2.987s3.778 1.172 4.577 2.986c7.449 16.933 48.733 19.658 62.515 3.441 1.358-1.598 3.567-2.178 5.535-1.455 1.967.724 3.275 2.597 3.275 4.693 0 20.441.242 41.094.242 61.57 0 40.563-28.416 78.062-74.16 97.86-1.241.538-2.682.559-3.972 0-45.742-19.8-74.157-57.297-74.157-97.86 0-20.482.244-41.127.244-61.57 0-2.097 1.308-3.97 3.275-4.693s4.176-.142 5.535 1.455c13.753 16.184 55.055 13.518 62.514-3.44z"></path>
                                            <path id="XMLID_167_" d="m291.735 346.393c0 35.933 25.286 69.415 66.144 87.806 40.858-18.391 66.146-51.873 66.146-87.806 0-16.872-.166-33.883-.224-51.147-19.854 11.598-51.881 8.912-65.92-6.223-14.071 15.171-46.112 17.794-65.919 6.223-.058 16.996-.227 34.219-.227 51.147zm32.742 7.8c1.975-1.932 5.14-1.895 7.071.08l19.5 19.947 39.591-47.283c1.773-2.117 4.926-2.395 7.043-.624 2.117 1.773 2.396 4.927.624 7.044l-43.138 51.52c-1.883 2.249-5.323 2.418-7.409.285l-23.362-23.898c-1.931-1.976-1.895-5.142.08-7.071z"></path>
                                        </g>
                                    </g>
                                </svg>
                            </div>
                        </div>
                        <div class="pbmit-ihbox-contents">
                            <h2 class="pbmit-element-title">
                                Supply Chain Visibility
                            </h2>
                            <div class="pbmit-heading-desc">Sed ut perspiciatis unde omnis iste natus ut perspic iatis unde omnis iste petis.</div>
                        </div>
                    </div>
                </div>
            </article>
            <article class="pbmit-miconheading-style-8 col-md-6 col-lg-4">
                <div class="pbmit-ihbox-style-8">
                    <div class="pbmit-ihbox-box">
                        <div class="pbmit-ihbox-icon">
                            <div class="pbmit-ihbox-icon-wrapper pbmit-icon-type-icon">
                                <svg enable-background="new 0 0 512 512" height="512" viewbox="0 0 512 512" width="512" xmlns="http://www.w3.org/2000/svg">
                                    <g id="_x30_5_x2C__logistics_x2C__shipping_x2C__truck_x2C__delivery_x2C__checked1">
                                        <g id="XMLID_175_1">
                                            <path id="XMLID_176_1" d="m125.132 401.481c-2.272 0-4.122 1.842-4.122 4.106 0 2.274 1.849 4.125 4.122 4.125 2.267 0 4.11-1.851 4.11-4.125 0-2.264-1.844-4.106-4.11-4.106z"></path>
                                            <path id="XMLID_210_1" d="m318.133 67.967h-281.076v234h281.076zm-140.539 211.515c-52.116 0-94.516-42.399-94.516-94.515s42.399-94.516 94.516-94.516 94.516 42.399 94.516 94.516c0 52.116-42.399 94.515-94.516 94.515z"></path>
                                            <path id="XMLID_226_1" d="m125.126 367.162c-21.193 0-38.435 17.241-38.435 38.435s17.242 38.436 38.435 38.436 38.435-17.242 38.435-38.436-17.242-38.435-38.435-38.435zm.006 52.551c-7.787 0-14.122-6.337-14.122-14.125 0-7.778 6.335-14.106 14.122-14.106 7.78 0 14.11 6.328 14.11 14.106 0 7.788-6.33 14.125-14.11 14.125z"></path>
                                            <path id="XMLID_229_1" d="m377.753 367.161c-21.193 0-38.436 17.242-38.436 38.436s17.242 38.437 38.436 38.437c21.193 0 38.435-17.242 38.435-38.437-.001-21.194-17.242-38.436-38.435-38.436zm.004 52.552c-7.787 0-14.122-6.337-14.122-14.125 0-7.778 6.335-14.106 14.122-14.106 7.781 0 14.111 6.328 14.111 14.106 0 7.788-6.33 14.125-14.111 14.125z"></path>
                                            <path id="XMLID_230_1" d="m377.757 401.481c-2.272 0-4.122 1.842-4.122 4.106 0 2.274 1.849 4.125 4.122 4.125 2.267 0 4.111-1.851 4.111-4.125 0-2.264-1.844-4.106-4.111-4.106z"></path>
                                            <path id="XMLID_231_1" d="m351.868 298.231v-99.965h-23.735v108.701c0 2.762-2.239 5-5 5h-286.076v62.23l16.479 16.48h25.516c6.306-19.427 24.571-33.516 46.074-33.516s39.767 14.088 46.073 33.516h160.479c6.306-19.428 24.571-33.517 46.074-33.517 25.019 0 45.667 19.069 48.177 43.436h33.025l15.989-15.116v-82.249h-118.075c-2.761 0-5-2.238-5-5z"></path>
                                            <path id="XMLID_237_1" d="m177.594 100.451c-46.602 0-84.516 37.914-84.516 84.516s37.914 84.515 84.516 84.515 84.516-37.914 84.516-84.515c0-46.602-37.913-84.516-84.516-84.516zm45.218 56.218-56.75 56.75c-1.954 1.953-5.118 1.952-7.071 0l-32.25-32.25c-1.953-1.953-1.953-5.119 0-7.071s5.118-1.952 7.071 0l28.714 28.714 53.214-53.214c1.953-1.952 5.118-1.952 7.071 0 1.954 1.953 1.954 5.119.001 7.071z"></path>
                                            <path id="XMLID_238_1" d="m361.868 198.266v94.965h113.075v-23.157l-61.272-71.808z"></path>
                                        </g>
                                    </g>
                                </svg>
                            </div>
                        </div>
                        <div class="pbmit-ihbox-contents">
                            <h2 class="pbmit-element-title">
                                Cost Management
                            </h2>
                            <div class="pbmit-heading-desc">Sed ut perspiciatis unde omnis iste natus ut perspic iatis unde omnis iste petis.</div>
                        </div>
                    </div>
                </div>
            </article>
        </div>
    </div>
</section>
<!-- Ihbox End -->

<!-- Contact Start -->
<section>
    <div class="container-fluid px-4">
        <div class="row g-0">
            <div class="col-md-12 col-xl-6">
                <div class="contact-one-left-bg"></div>
            </div>
            <div class="col-md-12 col-xl-6">
                <div class="pbmit-bg-color-global contact-one-right-bg">
                    <div class="pbmit-heading-subheading">
                        <h4 class="pbmit-subtitle">
                            What to expect
                        </h4>
                        <h2 class="pbmit-title">
                            Get your free estimate!
                        </h2>
                    </div>
                    <form class="contact-form" method="post" id="contact-form" action="send-dummy.php">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="tel" class="form-control" placeholder="Phone Number" name="number" required="">
                            </div>
                            <div class="col-md-6">
                                <input type="email" class="form-control" placeholder="Email Address" name="email" required="">
                            </div>
                            <div class="col-md-6">
                                <input type="text" class="form-control" placeholder="City Of Depature" name="City" required="">
                            </div>
                            <div class="col-md-6">
                                <input type="text" class="form-control" placeholder="Delivery city" name="Delivery" required="">
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control" placeholder="Weight" name="weight" required="">
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control" placeholder="Length" name="length" required="">
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control" placeholder="Width" name="width" required="">
                            </div>
                            <div>
                                <button class="pbmit-btn pbmit-btn-white submit my-3">
												<span class="pbmit-button-content-wrapper">
													<span class="pbmit-button-text">Submit Now</span>
												</span>
                                    <span class="form-btn-loader d-none">
													<svg xmlns="http://www.w3.org/2000/svg" viewbox="0 0 200 100"><circle fill="#0036FF" stroke="#0036FF" stroke-width="15" r="15" cx="40" cy="50"><animate attributename="opacity" calcmode="spline" dur="2" values="1;0;1;" keysplines=".5 0 .5 1;.5 0 .5 1" repeatcount="indefinite" begin="-.4"></animate></circle><circle fill="#0036FF" stroke="#0036FF" stroke-width="15" r="15" cx="100" cy="50"><animate attributename="opacity" calcmode="spline" dur="2" values="1;0;1;" keysplines=".5 0 .5 1;.5 0 .5 1" repeatcount="indefinite" begin="-.2"></animate></circle><circle fill="#0036FF" stroke="#0036FF" stroke-width="15" r="15" cx="160" cy="50"><animate attributename="opacity" calcmode="spline" dur="2" values="1;0;1;" keysplines=".5 0 .5 1;.5 0 .5 1" repeatcount="indefinite" begin="0"></animate></circle></svg>
												</span>
                                </button>
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-12 message-status"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Contact End -->


<!-- Blog start -->
<section class="section-lg">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="pbmit-heading-subheading">
                    <h4 class="pbmit-subtitle">
                        Our Blog
                    </h4>
                    <h2 class="pbmit-title">Updated Blogs & News</h2>
                </div>
            </div>
            <div class="col-md-4 text-md-end mb-md-0 mb-5 d-md-block d-none">
                <a class="pbmit-btn pbmit-btn-outline" href="blog-grid-col-4.html">
								<span class="pbmit-button-content-wrapper">
									<span class="pbmit-button-text">View All Post</span>
								</span>
                </a>
            </div>
        </div>
        <div class="swiper-slider" data-autoplay="false" data-loop="true" data-dots="false" data-arrows="false" data-columns="3" data-margin="30" data-effect="slide">
            <div class="swiper-wrapper">
                @foreach($blogs as $blog)
                <article class="pbmit-blog-style-1 swiper-slide">
                    <div class="post-item">
                        <div class="pbminfotech-box-content">
                            <div class="pbmit-date-wraper d-flex align-items-center">
                                <div class="pbmit-meta-category-wrapper pbmit-meta-line">
                                    <div class="pbmit-meta-category">
                                        <a href="blog-classic.html" rel="category tag">Strategy</a>
                                    </div>
                                </div>
                                <div class="pbmit-date-author-wrapper">
                                    <div class="pbmit-meta-author pbmit-meta-line">
                                        <span class="pbmit-post-author">shipexpbm</span>
                                    </div>
                                    <div class="pbmit-meta-date-wrapper pbmit-meta-line">
                                        <div class="pbmit-meta-date">
                                            <span class="pbmit-post-date">27  Dec, 2024</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="pbmit-featured-container">
                                <div class="pbmit-featured-img-wrapper">
                                    <div class="pbmit-featured-wrapper">
                                        <img src="images/homepage-1/blog/blog-01.jpg" class="img-fluid" alt="">
                                    </div>
                                </div>
                            </div>
                            <div class="pbmit-content-wrapper">
                                <h3 class="pbmit-post-title">
                                    <a href="blog-single-details.html">The Guide On How to Ship Oversize Loads</a>
                                </h3>
                                <div class="pbmit-blog-button">
                                    <a class="pbmit-button-inner" href="blog-single-details.html" title="The Guide On How to Ship Oversize Loads">
                                        <span class="pbmit-button-icon">Read More</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </article>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endsection
@push('scripts')
@endpush

@extends('frontend.layouts.master')
@section('title')
    {{ $page->title }} -
@endsection
@section('seo')
    @include('components.frontend.socials.seo', ['data' => $page])
@endsection
@section('header_background')
    <div class="pbmit-slider-area pbmit-slider-one">
        <div class="swiper-slider" data-autoplay="true" data-loop="true" data-dots="true" data-arrows="false"
             data-columns="1" data-margin="0" data-effect="fade">
            <div class="swiper-wrapper">
                @foreach($sliders as $slider)
                    <div class="swiper-slide">
                        <div class="pbmit-slider-item">
                            <div class="pbmit-slider-bg"
                                 style="background-image: url({{$slider->src ?: config('filemanager.default_backend_image')}});"></div>
                            <div class="container-fluid container-content">
                                <div class="pbmit-slider-content">
                                    <div class="row align-items-end g-0">
                                        <div class="col-md-12 col-lg-8">
                                            <h5 class="pbmit-sub-title transform-right transform-delay-1">
                                                <span><img src="{{asset('assets/images/logistics.png')}}" alt="{{$slider->slogan}}"> {{$slider->slogan}}</span>
                                            </h5>
                                            <h2 class="pbmit-title transform-left-1 transform-delay-2">
                                                <span>{{$slider->title}}</span></h2>
                                        </div>
                                        <div class="col-md-12 col-lg-7">
                                            <div class="pbmit-slider-right-content">
                                                <div class="pbmit-desc transform-center transform-delay-3">
                                                    {!! clear($slider->content) !!}
                                                </div>
                                                @if(!empty(clear($slider->url)))
                                                    <div class="pbmit-button transform-bottom transform-delay-4">
                                                        <a class="pbmit-btn" href="{{$slider->url}}">
                                                            <span class="pbmit-button-content-wrapper">
                                                                <span class="pbmit-button-text">{{__('view_more')}}</span>
                                                            </span>
                                                        </a>
                                                    </div>
                                                @endif
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
    <!-- <div id="mb-page-loader" class="mb-page-loader" role="status" aria-live="polite" aria-busy="true">
        <div class="mb-page-loader__inner">
            <div class="mb-page-loader__logo-wrap">
                <img
                    class="mb-page-loader__logo"
                    src="{{ asset('assets/images/logo.png') }}"
                    alt=""
                    width="220"
                    height="66"
                    decoding="async"
                >
            </div>
            <p class="mb-page-loader__brand">
                <span class="mb-page-loader__brand-part mb-page-loader__brand-part--1">Milestone</span>
                <span class="mb-page-loader__brand-part mb-page-loader__brand-part--2">Brokers</span>
            </p>
        </div>
    </div>
    <script>
        document.documentElement.classList.add('mb-page-loader-lock');
    </script> -->

    {{-- About strip below hero: static image, no scroll effect --}}
    <section class="service-one-bg-white pbmit-bg-color-white about-us" aria-labelledby="mb-hap-heading" style="padding: 0;" data-aos="fade-up" data-aos-duration="750" data-aos-easing="ease-out">
        <div class="mb-hap-visual">
            <img class="mb-hap-visual-img"
                 src="{{ asset('assets/images/mm1.webp') }}"
                 width="1920" height="1080"
                 alt="Milestone Brokers logistics container">
        </div>
        <div class="mb-hap-sheet" id="mb-hap-content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-xl-12 about">
                        <p class="mb-hap-label" data-aos="fade-up" data-aos-delay="40" data-aos-duration="550"><span style="color: rgba(79, 98, 130, 1);">01</span> | About Us</p>
                        <h2 class="mb-hap-title mb-reveal-wipe" id="mb-hap-heading">Smarter Transport. Better Results</h2>
                        <p class="mb-hap-lead" data-aos="fade-up" data-aos-delay="120" data-aos-duration="600">
                            We help move vehicles more efficiently through careful planning, fair market-based pricing, and strong carrier relationships. Every shipment is handled by trusted, compliance-verified partners with a proven record of safe, reliable delivery.
                        </p>
                        <div class="all-blog d-md-block d-none">
                            <a class="pbmit-btn" href="#">
                                <span class="pbmit-button-content-wrapper">
                                    <span class="pbmit-button-text">Know About Us</span>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section-lg section-home-blogs pbmit-bg-color-black" style="background-image: url({{ asset('assets/images/sky1.webp') }}); background-repeat: no-repeat; background-position: center; background-size: cover; margin: 0 10px; border-radius: 20px; position: relative; overflow: hidden; padding: 100px 0; margin-bottom: 10px;" data-aos="fade-up" data-aos-duration="750" data-aos-easing="ease-out">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-4 pbmit-heading-content mb-md-0 d-md-block d-none">
                    <p style="color: #ffff;" data-aos="fade-up" data-aos-delay="60" data-aos-duration="600">
                        We connect businesses with secure transport capacity through a carefully screened network of experienced carriers and dispatch teams.
                    </p>
                </div>
                <div class="col-md-3"></div>
                <div class="col-md-5">
                    <div class="pbmit-heading-subheading">
                        <h4 class="pbmit-subtitle" style="    text-align: left;
    color: #fff;" data-aos="fade-up" data-aos-delay="80" data-aos-duration="600">
                            <span style="
    color: rgba(255, 255, 255, 0.8);
">02</span> | Our Expertise
                        </h4>
                        <h2 class="pbmit-title mb-reveal-wipe" style="
    text-align: left;
    color: #fff;
">Essential Features of Our Services</h2>
                    </div>
                </div>
            </div>
            <div class="row g-0 align-items-start mb-faq-sync-row">
                <div class="col-md-12 col-xl-5 order-2 order-xl-1">
                    <div class="pe-xl-4 mb-4 mb-xl-0">
                        <p class="pbmit-subtitle mb-2" style="color: rgba(255,255,255,0.65);">
                            <span id="mbFaqPreviewNumber" style="
    font-size: 32px;
    color: #fff;
    line-height: 40px;
    letter-spacing: -2%;
">01</span>
                        </p>
                        <h3 class="pbmit-title mb-4" id="mbFaqPreviewTitle" style="font-size: 16px;line-height: 24px;color: rgb(255 255 255 / 60%);font-weight: 400;margin-top: 140px;">
                            Auto Auctions
                        </h3>
                        <div class="mb-faq-preview-img-wrap overflow-hidden" style="
    border-radius: 16px;
">
                            <img
                                src="{{ asset('assets/images/222223.jpg') }}"
                                alt=""
                                class="img-fluid w-100 d-block"
                                id="mbFaqPreviewImg"
                                width="800"
                                height="520"
                            >
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-xl-7 order-1 order-xl-2">
                    <div class="ps-xl-5">
                        <div class="accordion style-3 mb-faq-sync-accordion" id="accordionExample1">
                            <div class="accordion-item active">
                                <h2 class="accordion-header" id="heading1">
                                    <button
                                        class="accordion-button"
                                        type="button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#collapse1"
                                        aria-expanded="true"
                                        aria-controls="collapse1"
                                    >
                                        <span class="pbmit-accordion-title">
                                            Auto Auctions
                                        </span>
                                        <span class="pbmit-accordion-icon">
                                            <span class="pbmit-accordion-icon-opened">
                                              <i
                                                  class="pbmit-shipex-icon pbmit-shipex-icon-levels"
                                              ></i>
                                            </span>
                                            <span class="pbmit-accordion-icon-closed">
                                              <i
                                                  class="pbmit-shipex-icon pbmit-shipex-icon-levels"
                                              ></i>
                                            </span>
                                        </span>
                                    </button>
                                </h2>
                                <div
                                    id="collapse1"
                                    class="accordion-collapse collapse show"
                                    aria-labelledby="heading1"
                                    data-bs-parent="#accordionExample1"
                                >
                                    <div class="accordion-body" data-number="(01)" data-name="Auto Auctions" data-image="{{ asset('assets/images/222223.jpg') }}">
                                        Efficient pickup and delivery coordination from Copart, IAAI, and Manheim locations with strict carrier compliance and damage-prevention protocols.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading2">
                                    <button
                                        class="accordion-button collapsed"
                                        type="button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#collapse2"
                                        aria-expanded="false"
                                        aria-controls="collapse2"
                                    >
                                      <span class="pbmit-accordion-title">
                                        Auto Dealerships
                                      </span>
                                                        <span class="pbmit-accordion-icon">
                                        <span class="pbmit-accordion-icon-opened">
                                          <i
                                              class="pbmit-shipex-icon pbmit-shipex-icon-levels"
                                          ></i>
                                        </span>
                                        <span class="pbmit-accordion-icon-closed">
                                          <i
                                              class="pbmit-shipex-icon pbmit-shipex-icon-levels"
                                          ></i>
                                        </span>
                                      </span>
                                    </button>
                                </h2>
                                <div
                                    id="collapse2"
                                    class="accordion-collapse collapse"
                                    aria-labelledby="heading2"
                                    data-bs-parent="#accordionExample1"
                                >
                                    <div class="accordion-body" data-number="(02)" data-name="Auto Dealerships" data-image="{{ asset('assets/images/222223.jpg') }}">
                                        Efficient pickup and delivery coordination from Copart, IAAI, and Manheim locations with strict carrier compliance and damage-prevention protocols.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading3">
                                    <button
                                        class="accordion-button collapsed"
                                        type="button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#collapse3"
                                        aria-expanded="false"
                                        aria-controls="collapse3"
                                    >
                      <span class="pbmit-accordion-title">
                        Car Retailers
                      </span>
                                        <span class="pbmit-accordion-icon">
                        <span class="pbmit-accordion-icon-opened">
                          <i
                              class="pbmit-shipex-icon pbmit-shipex-icon-levels"
                          ></i>
                        </span>
                        <span class="pbmit-accordion-icon-closed">
                          <i
                              class="pbmit-shipex-icon pbmit-shipex-icon-levels"
                          ></i>
                        </span>
                      </span>
                                    </button>
                                </h2>
                                <div
                                    id="collapse3"
                                    class="accordion-collapse collapse"
                                    aria-labelledby="heading3"
                                    data-bs-parent="#accordionExample1"
                                >
                                    <div class="accordion-body" data-number="(03)" data-name="Car Retailers" data-image="{{ asset('assets/images/222223.jpg') }}">
                                        Efficient pickup and delivery coordination from Copart, IAAI, and Manheim locations with strict carrier compliance and damage-prevention protocols.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading4">
                                    <button
                                        class="accordion-button collapsed"
                                        type="button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#collapse4"
                                        aria-expanded="false"
                                        aria-controls="collapse4"
                                    >
                      <span class="pbmit-accordion-title">
                        Corporate/Government Fleet
                      </span>
                                        <span class="pbmit-accordion-icon">
                        <span class="pbmit-accordion-icon-opened">
                          <i
                              class="pbmit-shipex-icon pbmit-shipex-icon-levels"
                          ></i>
                        </span>
                        <span class="pbmit-accordion-icon-closed">
                          <i
                              class="pbmit-shipex-icon pbmit-shipex-icon-levels"
                          ></i>
                        </span>
                      </span>
                                    </button>
                                </h2>
                                <div
                                    id="collapse4"
                                    class="accordion-collapse collapse"
                                    aria-labelledby="heading4"
                                    data-bs-parent="#accordionExample1"
                                >
                                    <div class="accordion-body" data-number="(04)" data-name="Corporate/Government Fleet" data-image="{{ asset('assets/images/222223.jpg') }}">
                                        Efficient pickup and delivery coordination from Copart, IAAI, and Manheim locations with strict carrier compliance and damage-prevention protocols.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading5">
                                    <button
                                        class="accordion-button collapsed"
                                        type="button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#collapse5"
                                        aria-expanded="false"
                                        aria-controls="collapse5"
                                    >
                      <span class="pbmit-accordion-title">
                        Vechile Manufactures
                      </span>
                                        <span class="pbmit-accordion-icon">
                        <span class="pbmit-accordion-icon-opened">
                          <i
                              class="pbmit-shipex-icon pbmit-shipex-icon-levels"
                          ></i>
                        </span>
                        <span class="pbmit-accordion-icon-closed">
                          <i
                              class="pbmit-shipex-icon pbmit-shipex-icon-levels"
                          ></i>
                        </span>
                      </span>
                                    </button>
                                </h2>
                                <div
                                    id="collapse5"
                                    class="accordion-collapse collapse"
                                    aria-labelledby="heading5"
                                    data-bs-parent="#accordionExample1"
                                >
                                    <div class="accordion-body" data-number="(05)" data-name="Vechile Manufactures" data-image="{{ asset('assets/images/222223.jpg') }}">
                                        Efficient pickup and delivery coordination from Copart, IAAI, and Manheim locations with strict carrier compliance and damage-prevention protocols.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if(isset(getPageById(19)->id) or isset(getPageById(20)->id))
        <section class="section-lg section-home-blogs service-one-bg-white pbmit-bg-color-white" data-aos="fade-up" data-aos-duration="750" data-aos-easing="ease-out">
            <div class="container">
                <div class="row align-items-center services">
                    <div class="col-md-4">
                        <div class="pbmit-heading-subheading">
                            <h4 class="pbmit-subtitle" data-aos="fade-up" data-aos-delay="80" data-aos-duration="600">
                                <span>03</span> |  Our Services
                            </h4>
                            <h2 class="pbmit-title mb-reveal-wipe">{{__('home_service_title_2')}}</h2>
                        </div>
                    </div>
                    <div class="col-md-4"></div>
                    <div class="col-md-4 pbmit-heading-content mb-md-0 d-md-block d-none">
                        <p data-aos="fade-up" data-aos-delay="100" data-aos-duration="600">
                            Reliable, cost-efficient transport services designed to streamline operations and support scalable growth.
                        </p>
                    </div>
                </div>
                <div class="row services-content">
                    @if(isset(getPageById(19)->id))
                        <div class="col-md-6 mb-4 services-content-left">
                            <div
                                class="how-it-work-item position-relative overflow-hidden hover-effect">
                                <a href="{{ route(getPageById(19)->template) }}" class="text-decoration-none">
                                    <div class="work-image-container position-relative">
                                        @if(getPageById(19)->mainImageShow())
{{--                                            <img src="{{ getPageById(19)->mainImageShow()->src }}"--}}
{{--                                                 alt="{{ getPageById(19)->getTranslation('title', app()->getLocale()) }}"--}}
{{--                                                 class="img-fluid work-image">--}}
                                            <img src="{{asset('assets/images/111113.png')}}"
                                                 alt="{{ getPageById(19)->getTranslation('title', app()->getLocale()) }}"
                                                 class="img-fluid work-image">
                                        @else
                                            <div
                                                class="placeholder-image bg-gradient-primary d-flex align-items-center justify-content-center"
                                                style="height: 250px;">
                                                <i class="fas fa-image text-white" style="font-size: 3rem;"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <!-- Bottom Content -->
                                    <div class="work-content p-4 bg-white">
                                        <h3 class="text-dark mb-2 mb-reveal-wipe">{{ getPageById(19)->getTranslation('title', app()->getLocale()) }}</h3>
{{--                                        @if(getPageById(19)->getTranslation('slogan', app()->getLocale()))--}}
{{--                                            <p class="text-muted mb-0">{{ getPageById(19)->getTranslation('slogan', app()->getLocale()) }}</p>--}}
{{--                                        @endif--}}
                                        <p>End-to-end transport management for auctions, dealerships, exporters, and fleet operators. We prioritize capacity reliability, cost control, and partnerships with trusted carriers who meet strict safety and performance benchmarks.</p>
                                        <div class="col-md-4 all-blog d-md-block d-none">
                                            <a class="pbmit-btn" href="#">
                                            <span class="pbmit-button-content-wrapper">
                                                <span class="pbmit-button-text">Calculate Now</span>
                                            </span>
                                            </a>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endif

                    @if(isset(getPageById(20)->id))
                        <div class="col-md-6 mb-4 services-content-right">
                            <div
                                class="how-it-work-item position-relative overflow-hidden hover-effect">
                                <a href="{{ route(getPageById(20)->template) }}" class="text-decoration-none">
                                    <div class="work-image-container position-relative">
                                        @if(getPageById(19)->mainImageShow())
{{--                                            <img src="{{ getPageById(20)->mainImageShow()->src }}"--}}
{{--                                                 alt="{{ getPageById(20)->getTranslation('title', app()->getLocale()) }}"--}}
{{--                                                 class="img-fluid work-image">--}}
                                            <img src="{{asset('assets/images/111112.png')}}"
                                                 alt="{{ getPageById(19)->getTranslation('title', app()->getLocale()) }}"
                                                 class="img-fluid work-image">
                                        @else
                                            <div
                                                class="placeholder-image bg-gradient-primary d-flex align-items-center justify-content-center"
                                                style="height: 250px;">
                                                <i class="fas fa-image text-white" style="font-size: 3rem;"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <!-- Bottom Content -->
                                    <div class="work-content p-4 bg-white">
                                        <h3 class="text-dark mb-2 mb-reveal-wipe">{{ getPageById(20)->getTranslation('title', app()->getLocale()) }}</h3>
{{--                                        @if(getPageById(20)->getTranslation('slogan', app()->getLocale()))--}}
{{--                                            <p class="text-muted mb-0">{{ getPageById(20)->getTranslation('slogan', app()->getLocale()) }}</p>--}}
{{--                                        @endif--}}
                                        <p>Secure vehicle shipping for private customers with transparent pricing, careful handling, and experienced transport professionals.</p>
                                        <div class="col-md-4 all-blog d-md-block d-none">
                                            <a class="pbmit-btn" href="#">
                                            <span class="pbmit-button-content-wrapper">
                                                <span class="pbmit-button-text">Calculate Now</span>
                                            </span>
                                            </a>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </section>
    @endif

    @if(count($blogs))
        <section class="section-lg section-home-blogs service-one-bg-white pbmit-bg-color-white" data-aos="fade-up" data-aos-duration="750" data-aos-easing="ease-out">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-5 pbmit-heading-content mb-md-0 d-md-block d-none">
                        <p data-aos="fade-up" data-aos-delay="80" data-aos-duration="600">
                            Insights on vehicle logistics, transport planning, and industry best practices from a compliance-focused brokerage perspective.
                        </p>
                    </div>

                    <div class="col-md-7">
                        <div class="pbmit-heading-subheading">
                            <h4 class="pbmit-subtitle" data-aos="fade-up" data-aos-delay="80" data-aos-duration="600">
                                <span>04</span> | Our Blog
                            </h4>
                            <h2 class="pbmit-title mb-reveal-wipe">{{__('updated_blogs_news')}}</h2>
                        </div>
                    </div>
                </div>
                <div class="swiper-slider" data-autoplay="false" data-loop="true" data-dots="false" data-arrows="false"
                     data-columns="3" data-margin="10" data-effect="slide">
                    <div class="swiper-wrapper">
                        @foreach($blogs as $blog)
                            <article class="pbmit-blog-style-1 swiper-slide">
                                <div class="post-item">
                                    <div class="pbminfotech-box-content">
                                        <div class="pbmit-featured-container">
                                            <div class="pbmit-featured-img-wrapper">
                                                <div class="pbmit-featured-wrapper">
                                                    <a href="{{ route('frontend.blogs.show', ['id' => $blog->id, 'slug' => $blog->slug]) }}">
                                                        <img
                                                            src="{{asset($blog->src ?: config('filemanager.default_backend_image'))}}"
                                                            class="img-fluid" alt="{{$blog->title}}">
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="pbmit-content-wrapper">
                                            <div class="pbmit-date-wraper d-flex align-items-center">
                                                <div class="pbmit-date-author-wrapper">
                                                    <div class="pbmit-meta-author pbmit-meta-line">
                                                    <span
                                                        class="pbmit-post-author">{{$blog->created_at->format('M d, Y')}}</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <h3 class="pbmit-post-title">
                                                <a href="{{ route('frontend.blogs.show', ['id' => $blog->id, 'slug' => $blog->slug]) }}">{{$blog->title}}</a>
                                            </h3>
                                            <div class="pbmit-entry-content">
                                                <p>
                                                    Flexible vehicle logistics services for individual clients, ensuring safe transport, transparent pricing, and reliable delivery from pickup to destination.
                                                </p>
                                            </div>
                                            <div class="pbmit-static-btn">
                                                <a class="pbmit-button-inner"
                                                   href="{{ route('frontend.blogs.show', ['id' => $blog->id, 'slug' => $blog->slug]) }}"
                                                   title="{{$blog->title}}">
                                                    <span class="pbmit-button-icon">
                                                        {{__('view_post')}}
                                                    </span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>
                <div class="col-md-4 all-blog d-md-block d-none">
                    <a class="pbmit-btn" href="{{ route('frontend.blogs.index') }}">
                        <span class="pbmit-button-content-wrapper">
                            <span class="pbmit-button-text">{{__('view_all_post')}}</span>
                        </span>
                    </a>
                </div>
            </div>
        </section>
    @endif
@endsection

@section('scripts')
    <script>
        (function () {
            var root = document.querySelector('.mb-faq-sync-row');
            if (!root) return;
            var acc = root.querySelector('#accordionExample1.mb-faq-sync-accordion');
            if (!acc) return;
            var numEl = document.getElementById('mbFaqPreviewNumber');
            var titleEl = document.getElementById('mbFaqPreviewTitle');
            var imgEl = document.getElementById('mbFaqPreviewImg');
            if (!numEl || !titleEl || !imgEl) return;

            function syncFromBody(body) {
                if (!body) return;
                var n = body.getAttribute('data-number');
                var name = body.getAttribute('data-name');
                var img = body.getAttribute('data-image');
                if (n) numEl.textContent = n;
                if (name) titleEl.textContent = name;
                if (img) {
                    imgEl.src = img;
                    imgEl.alt = name || '';
                }
            }

            function syncFromOpenPanel() {
                var open = acc.querySelector('.accordion-collapse.collapse.show .accordion-body');
                if (open) syncFromBody(open);
            }

            acc.querySelectorAll('.accordion-collapse').forEach(function (col) {
                col.addEventListener('shown.bs.collapse', function () {
                    var body = col.querySelector('.accordion-body');
                    syncFromBody(body);
                });
            });

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', syncFromOpenPanel);
            } else {
                syncFromOpenPanel();
            }
        })();
    </script>
    <script>
        window.addEventListener('load', function () {
            if (typeof AOS !== 'undefined' && typeof AOS.refresh === 'function') {
                AOS.refresh();
            }
        });
    </script>
    <script>
        (function () {
            window.addEventListener('load', function () {
                var loader = document.getElementById('mb-page-loader');
                if (!loader) return;

                var reduceMotion =
                    window.matchMedia &&
                    window.matchMedia('(prefers-reduced-motion: reduce)').matches;
                var minAfterLoadMs = reduceMotion ? 0 : 720;

                function dismiss() {
                    loader.classList.add('mb-page-loader--done');
                    loader.setAttribute('aria-busy', 'false');

                    var finished = false;
                    function cleanup() {
                        if (finished) return;
                        finished = true;
                        loader.removeEventListener('transitionend', onEnd);
                        if (loader.parentNode) {
                            loader.parentNode.removeChild(loader);
                        }
                        document.documentElement.classList.remove('mb-page-loader-lock');
                    }

                    function onEnd(e) {
                        if (e.propertyName !== 'opacity') return;
                        cleanup();
                    }

                    loader.addEventListener('transitionend', onEnd);
                    window.setTimeout(cleanup, reduceMotion ? 260 : 900);
                }

                window.setTimeout(dismiss, minAfterLoadMs);
            });
        })();
    </script>
@endsection

@push('scripts')
@endpush

@push('css')
    <style>
        /* Full-page loader (home only) */
        html.mb-page-loader-lock,
        html.mb-page-loader-lock body {
            overflow: hidden;
        }

        .mb-page-loader {
            position: fixed;
            inset: 0;
            z-index: 2147483646;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(160deg, #0a0a0c 0%, #15151a 48%, #0f1118 100%);
            transition: opacity 0.55s ease, visibility 0.55s ease;
        }

        .mb-page-loader.mb-page-loader--done {
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
        }

        .mb-page-loader__inner {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: clamp(18px, 4vw, 28px);
            text-align: center;
            padding: 24px;
        }

        .mb-page-loader__logo-wrap {
            opacity: 0;
            transform: translateY(12px) scale(0.94);
            animation: mb-loader-logo-in 0.85s cubic-bezier(0.22, 1, 0.36, 1) forwards;
            animation-delay: 0.08s;
        }

        .mb-page-loader__logo {
            display: block;
            width: clamp(160px, 42vw, 260px);
            height: auto;
            filter: drop-shadow(0 12px 32px rgba(0, 0, 0, 0.45));
        }

        .mb-page-loader__brand {
            margin: 0;
            font-size: clamp(1.35rem, 4.2vw, 2rem);
            font-weight: 600;
            letter-spacing: 0.02em;
            line-height: 1.2;
            color: #f4f6fb;
        }

        .mb-page-loader__brand-part {
            display: inline-block;
            opacity: 0;
            transform: translateY(18px);
            animation: mb-loader-brand-in 0.75s cubic-bezier(0.22, 1, 0.36, 1) forwards;
        }

        .mb-page-loader__brand-part--1 {
            animation-delay: 0.35s;
            margin-right: 0.35em;
        }

        .mb-page-loader__brand-part--2 {
            animation-delay: 0.52s;
            font-weight: 700;
            background: linear-gradient(90deg, #e8ecf4 0%, #93a4c9 55%, #c8d4ee 100%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .mb-page-loader__brand-part--2::after {
            content: '';
            display: block;
            height: 2px;
            margin-top: 10px;
            border-radius: 2px;
            background: linear-gradient(90deg, transparent, rgba(200, 212, 238, 0.55), transparent);
            opacity: 0;
            animation: mb-loader-rule-in 0.6s ease forwards 0.85s;
        }

        @keyframes mb-loader-logo-in {
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        @keyframes mb-loader-brand-in {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes mb-loader-rule-in {
            to {
                opacity: 1;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            .mb-page-loader__logo-wrap,
            .mb-page-loader__brand-part {
                animation: none !important;
                opacity: 1 !important;
                transform: none !important;
            }

            .mb-page-loader__brand-part--2::after {
                animation: none !important;
                opacity: 0.85 !important;
            }

            .mb-page-loader {
                transition-duration: 0.2s;
            }
        }

        /* Home: about strip below hero (static image only) */
        .mb-home-about-strip {
            --mb-hap-bg: #e8eaee;
            --mb-hap-sheet: #eef1f4;
            --mb-hap-ink: #0f172a;
            --mb-hap-muted: #5c6478;
            background: var(--mb-hap-bg);
        }

        .mb-hap-bridge {
            background: #0a0a0c;
            padding: 12px 0 14px;
        }

        .mb-hap-pill {
            display: inline-flex;
            align-items: center;
            padding: 10px 22px;
            border-radius: 999px;
            background: #fff;
            color: #0a0a0c;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            line-height: 1;
            transition: opacity 0.2s ease;
        }

        .mb-hap-pill:hover {
            color: #0a0a0c;
            opacity: 0.92;
        }

        .mb-hap-icon-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: #fff;
            color: #0a0a0c;
            text-decoration: none;
            transition: opacity 0.2s ease, transform 0.2s ease;
        }

        .mb-hap-icon-btn:hover {
            color: #0a0a0c;
            opacity: 0.92;
            transform: translateY(-1px);
        }

        .mb-hap-visual {
            position: relative;
            height: min(80vh, 736px);
            overflow: hidden;
            background: var(--mb-hap-bg);
            z-index: 11111111;
        }

        .mb-hap-visual-img {
            /* width: 100%; */
            /* height: 100%; */
            width: 980px;
            max-width: 100%;
            margin: auto;
            height: auto;
            display: block;
            will-change: transform;
            /* box-shadow: -9.09px 13.63px 36.35px 0px rgba(0, 0, 0, 0.1); */
            /* box-shadow: -37.1px 54.52px 65.88px 0px rgba(0, 0, 0, 0.09); */
            /* box-shadow: -84.05px 121.91px 88.59px 0px rgba(0, 0, 0, 0.05); */
            /* box-shadow: -149.17px 217.32px 105.25px 0px rgba(0, 0, 0, 0.01); */
            /* box-shadow: -233.22px 339.23px 115.1px 0px rgba(0, 0, 0, 0); */
        }

        .mb-hap-sheet {
            position: relative;
            z-index: 2;
            width: 980px;
            margin: auto;
            height: 572px;
            justify-content: space-between;
            opacity: 1;
            padding: 32px 22px;
            border-radius: 16px;
            border-top-width: 1px;
            border-right-width: 1px;
            border-bottom-width: 1px;
            background-color: rgba(245, 245, 245, 1);
            overflow: hidden;
            top: -175px;
        }

        /* Animated decorative background (11.png) — slow drift + gentle rotation */
        .mb-hap-sheet::after {
            content: '';
            position: absolute;
            z-index: 0;
            right: -75px;
            bottom: -240px;
            width: min(600px, 100%);
            height: min(600px, 100%);
            background-image: url("http://localhost:8000/assets/images/world.webp");
            background-repeat: no-repeat;
            /*background-position: bottom right;*/
            background-size: 100%;
            pointer-events: none;
            transform-origin: 90% 100%;
            animation: mb-hap-sheet-bg-motion 10s ease-in-out infinite;
        }

        .mb-hap-sheet > .container {
            position: relative;
            z-index: 1;
        }

        @keyframes mb-hap-sheet-bg-motion {
            0%, 100% {
                transform: translate(0, 0) rotate(0deg);
            }
            20% {
                transform: translate(-8px, -6px) rotate(2.5deg);
            }
            40% {
                transform: translate(5px, -14px) rotate(-2deg);
            }
            60% {
                transform: translate(-6px, 5px) rotate(1.8deg);
            }
            80% {
                transform: translate(7px, -8px) rotate(-1.2deg);
            }
        }

        .mb-hap-label {
            font-size: 16px;
            text-transform: capitalize;
            margin-bottom: 20px;
            color: rgba(0, 0, 0, 1);
            font-weight: 500;
        }

        .mb-hap-title {
            font-size: 44px;
            font-weight: 500;
            line-height: 1.15;
            margin-bottom: 18px;
            color: rgba(0, 13, 36, 1);
            width: 100%;
            letter-spacing: -2%;
        }

        .mb-hap-lead {
            max-width: 42em;
            font-weight: 400;
            font-size: 18px;
            line-height: 32px;
            letter-spacing: -1%;
            color: rgba(79, 98, 130, 1);
        }

        @media (max-width: 575px) {
            .mb-hap-visual {
                height: min(52vh, 420px);
            }

            .mb-hap-sheet {
                margin-top: -24px;
                padding: 36px 0 44px;
                border-radius: 22px 22px 0 0;
            }

            .mb-hap-sheet::after {
                width: min(260px, 70%);
                height: min(200px, 38%);
                right: 4px;
                bottom: 4px;
                animation-duration: 32s;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            .mb-hap-sheet::after {
                animation: none;
            }

            .mb-hap-visual-img {
                transform: none !important;
            }
        }

        /* How It Works Section Styles */
        .how-it-work-item {
            transition: all 0.3s ease;
            border-radius: 15px;
            overflow: hidden;
        }

        .how-it-work-item:hover {
            transform: translateY(-10px);
            /* box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15) !important; */
        }

        .work-image-container {
            position: relative;
            overflow: hidden;
            height: 620px;
        }

        .work-image {
            width: 100%;
            /* height: 100%; */
            margin: auto;
            /* object-fit: cover; */
            transition: transform 0.5s ease;
        }

        .how-it-work-item:hover .work-image {
            transform: scale(1.03);
        }

        .image-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.7) 0%, rgba(0, 0, 0, 0.4) 100%);
            opacity: 0;
            transition: all 0.3s ease;
            backdrop-filter: blur(2px);
        }

        .how-it-work-item:hover .image-overlay {
            opacity: 1;
        }

        .overlay-content {
            transform: translateY(20px);
            transition: transform 0.3s ease;
        }

        .how-it-work-item:hover .overlay-content {
            transform: translateY(0);
        }

        .step-number .badge {
            font-size: 1.2rem;
            font-weight: bold;
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 3px solid rgba(255, 255, 255, 0.3);
        }

        .overlay-title {
            font-size: 1.3rem;
            font-weight: 600;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        .overlay-description {
            font-size: 0.95rem;
            opacity: 0.9;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
        }

        .overlay-arrow {
            opacity: 0;
            transform: translateX(-10px);
            transition: all 0.3s ease;
        }

        .how-it-work-item:hover .overlay-arrow {
            opacity: 1;
            transform: translateX(0);
        }

        .overlay-arrow i {
            font-size: 1.2rem;
            background: rgba(255, 255, 255, 0.2);
            padding: 8px 12px;
            border-radius: 50%;
            backdrop-filter: blur(5px);
        }

        .work-content {
            transition: background-color 0.3s ease;
            margin: 10px;
            border-radius: 10px;
            margin-top: 0px;
            overflow: hidden;
        }

        .how-it-work-item:hover .work-content {
            /* background-color: #f8f9fa !important; */
        }

        .work-content h3 {
            font-size: 24px;
            font-weight: 500;
            line-height: 24px;
            letter-spacing: -2%;
            color: rgba(0, 13, 36, 1) !important;
            transition: color 0.3s ease;
            margin-bottom: 12px;
        }

        .how-it-work-item:hover .work-content h3 {
            color: #007bff !important;
        }

        .placeholder-image {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .work-image-container {
                height: 200px;
            }

            .overlay-title {
                font-size: 1.1rem;
            }

            .overlay-description {
                font-size: 0.9rem;
            }

            .step-number .badge {
                width: 40px;
                height: 40px;
                font-size: 1rem;
            }
        }

        /* Animation for page load */
        .how-it-work-item {
            animation: fadeInUp 0.6s ease forwards;
            opacity: 0;
            transform: translateY(30px);
        }

        .how-it-work-item:nth-child(1) {
            animation-delay: 0.1s;
        }

        .how-it-work-item:nth-child(2) {
            animation-delay: 0.2s;
        }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Ensure consistent square thumbnails inside .post-item */
        .post-item .pbmit-featured-container,
        .post-item .pbmit-featured-img-wrapper,
        .post-item .pbmit-featured-wrapper {
            position: relative;
            width: 100%;
            max-height: 300px;
        }

        /* Make the image area square and prevent shrinking */
        .post-item .pbmit-featured-wrapper {
            aspect-ratio: 1 / 1; /* equal width and height */
            overflow: hidden;
        }

        .post-item .pbmit-featured-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover; /* crop to fill without distortion */
            display: block;
            max-height: 300px;
        }

        /* Scroll-in sections (AOS): respect reduced motion */
        @media (prefers-reduced-motion: reduce) {
            [data-aos] {
                opacity: 1 !important;
                transform: none !important;
                transition-duration: 0.01ms !important;
            }

            .mb-reveal-wipe {
                clip-path: none !important;
                -webkit-clip-path: none !important;
            }
        }
    </style>
@endpush


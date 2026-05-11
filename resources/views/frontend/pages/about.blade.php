@extends('frontend.layouts.master')
@section('title') {{ $page->title }} - @endsection
@section('seo')
    @include('components.frontend.socials.seo', ['data' => $page])
@endsection
@section('header_background')
    <div class="pbmit-title-bar-wrapper position-relative overflow-hidden" style="background-image: url({{ asset($page->src ?: config('filemanager.default_backend_image')) }});">
        <video autoplay muted loop playsinline webkit-playsinline preload="metadata" poster="{{ asset($page->src ?: config('filemanager.default_backend_image')) }}" style="position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; z-index: 1; pointer-events: none;">
            <source src="{{ asset('assets/videos/about.mp4') }}" type="video/mp4">
        </video>
        <div class="container-fluid container-content">
            <div class="pbmit-title-bar-content">
                <div class="pbmit-title-bar-content-inner">
                    <div class="pbmit-tbar">
                        <div class="pbmit-tbar-inner container" style="position: relative; z-index: 3;">
                            <h5 class="pbmit-sub-title transform-right transform-delay-1">
                                <span>About Us</span>
                            </h5>
                            <h1 class="pbmit-tbar-title">Milestone Brokers</h1>
                            <p>A logistics brokerage built on operational discipline, verified carrier partnerships, and consistent delivery performance across domestic and export vehicle transport.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    @if(getPageById(21) !== null)
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
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    @if(isset(getPageById(19)->id) or isset(getPageById(20)->id))
        <section class="section-lg section-home-blogs service-one-bg-white pbmit-bg-color-white" data-aos="fade-up" data-aos-duration="750" data-aos-easing="ease-out">
            <div class="container">
                <div class="row align-items-center services">
                    <div class="col-md-4">
                        <div class="pbmit-heading-subheading">
                            <h4 class="pbmit-subtitle" data-aos="fade-up" data-aos-delay="80" data-aos-duration="600">
                                <span>02</span> |  Our Services
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
@endsection

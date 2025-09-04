@extends('frontend.layouts.master')
@section('title') {{ $page->title }} - @endsection
@section('seo')
    @include('components.frontend.socials.seo', ['data' => $page])
@endsection
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
    @if(getPageById(21) !== null)
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
                                            <span class="pbmit-number-rotate numinate" data-appear-animation="animateDigits" data-from="0" data-to="{{__('about_page_number')}}" data-interval="5" data-before="" data-before-style="" data-after="" data-after-style="">{{__('about_page_number')}}</span>
                                            <span class="pbmit-fid"><span>+</span></span>
                                        </h4>
                                        <span class="pbmit-fid-title">{{__('years_of_experience')}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="about-first-img">
                            <img src="{{asset(getPageById(21)->src ?: config('filemanager.default_backend_image'))}}" class="img-fluid" alt="{{getPageById(21)->title}}">
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-xl-6">
                    <div class="about-three-right-box">
                        <div class="pbmit-heading-subheading">
                            <h4 class="pbmit-subtitle">{{getPageById(21)->title}}</h4>
                            <h2 class="pbmit-title">{{getPageById(21)->slogan}}</h2>
                            <div class="pbmit-heading-desc">
                                {!! getPageById(21)->content !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif
    @if(isset(getPageById(19)->id) or isset(getPageById(20)->id))
        <section class="pbmit-element-static-box-style-1 section-md" style="padding-top: 0px;">
            <div class="container">
                <div class="pbmit-heading-subheading text-center">
                    <h4 class="pbmit-subtitle">
                        {{__('how_it_works')}}
                    </h4>
                    <h2 class="pbmit-title" style="max-width: 700px;margin: auto;">
                        {{__('home_service_title_2')}}
                    </h2>
                </div>
                <div class="row">
                    @if(isset(getPageById(19)->id))
                        <div class="col-md-6 mb-4">
                            <div class="how-it-work-item position-relative overflow-hidden rounded shadow-lg hover-effect">
                                <a href="{{ route(getPageById(19)->template) }}" class="text-decoration-none">
                                    <div class="work-image-container position-relative">
                                        @if(getPageById(19)->mainImageShow())
                                            <img src="{{ asset(getPageById(19)->mainImageShow()->src) }}"
                                                 alt="{{ getPageById(19)->getTranslation('title', app()->getLocale()) }}"
                                                 class="img-fluid work-image">
                                        @else
                                            <div class="placeholder-image bg-gradient-primary d-flex align-items-center justify-content-center" style="height: 250px;">
                                                <i class="fas fa-image text-white" style="font-size: 3rem;"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <!-- Bottom Content -->
                                    <div class="work-content p-4 bg-white">
                                        <h3 class="text-dark mb-2">{{ getPageById(19)->getTranslation('title', app()->getLocale()) }}</h3>
                                        @if(getPageById(19)->getTranslation('slogan', app()->getLocale()))
                                            <p class="text-muted mb-0">{{ getPageById(19)->getTranslation('slogan', app()->getLocale()) }}</p>
                                        @endif
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endif

                    @if(isset(getPageById(20)->id))
                        <div class="col-md-6 mb-4">
                            <div class="how-it-work-item position-relative overflow-hidden rounded shadow-lg hover-effect">
                                <a href="{{ route(getPageById(20)->template) }}" class="text-decoration-none">
                                    <div class="work-image-container position-relative">
                                        @if(getPageById(19)->mainImageShow())
                                            <img src="{{ asset(getPageById(20)->mainImageShow()->src) }}"
                                                 alt="{{ getPageById(20)->getTranslation('title', app()->getLocale()) }}"
                                                 class="img-fluid work-image">
                                        @else
                                            <div class="placeholder-image bg-gradient-primary d-flex align-items-center justify-content-center" style="height: 250px;">
                                                <i class="fas fa-image text-white" style="font-size: 3rem;"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <!-- Bottom Content -->
                                    <div class="work-content p-4 bg-white">
                                        <h3 class="text-dark mb-2">{{ getPageById(20)->getTranslation('title', app()->getLocale()) }}</h3>
                                        @if(getPageById(20)->getTranslation('slogan', app()->getLocale()))
                                            <p class="text-muted mb-0">{{ getPageById(20)->getTranslation('slogan', app()->getLocale()) }}</p>
                                        @endif
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

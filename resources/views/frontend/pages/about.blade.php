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
    @if(getPageById(155) !== null)
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
                            <img src="{{asset(getPageById(155)->src ?: config('filemanager.default_backend_image'))}}" class="img-fluid" alt="{{getPageById(155)->title}}">
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
                            <h4 class="pbmit-subtitle">{{getPageById(155)->title}}</h4>
                            <h2 class="pbmit-title">{{getPageById(155)->slogan}}</h2>
                            <div class="pbmit-heading-desc">
                                {!! getPageById(155)->content !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

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
                @foreach($serviceCategories as $key => $serviceCategory)
                    <article class="pbmit-static-box-style-1">
                        <div class="pbmit-staticbox-wrapper">
                            <div class="pbmit-bg-imgbox col-md-6" style="background-image: url({{asset($serviceCategory->src ?: config('filemanager.default_backend_image'))}});">
                                <div class="pbmit-img">
                                    <img src="{{asset($serviceCategory->src ?: config('filemanager.default_backend_image'))}}" class="img-fluid" alt="{{$serviceCategory->title}}">
                                </div>
                                <div class="pbmit-box-number">{{$key < 10 ? '0'.$key+1 : $key+1}}</div>
                                <h4 class="pbmit-static-box-title">{{$serviceCategory->title}}</h4>
                            </div>
                            <div class="pbmit-content-box col-md-6">
                                <div class="pbmit-box-number">{{$key < 10 ? '0'.$key+1 : $key+1}}</div>
                                <div class="pbmit-content-inner">
                                    <h4 class="pbmit-static-box-title">{{$serviceCategory->title}}</h4>
                                    <div class="pbmit-static-box-desc">{{$serviceCategory->slogan}} </div>
                                    <div class="pbmit-static-btn">
                                        <a class="pbmit-btn pbmit-btn-outline" href="{{ route('frontend.serviceCategories.show', ['id' => $serviceCategory->id, 'slug' => $serviceCategory->slug]) }}">
											<span class="pbmit-button-content-wrapper">
												<span class="pbmit-button-text">{{__('view_detail')}}</span>
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
    </section>
@endsection

@extends('frontend.layouts.master')
@section('title') {{ $page->title }} - @endsection
@section('seo')
    @include('components.frontend.socials.seo', ['data' => $page])
@endsection
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
                                            <h5 class="pbmit-sub-title transform-right transform-delay-1"><span>{{$slider->slogan}}</span></h5>
                                            <h2 class="pbmit-title transform-left-1 transform-delay-2"><span>{{$slider->title}}</span></h2>
                                        </div>
                                        <div class="col-md-12 col-lg-4">
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
    @if(isset(getPageById(156)->id))
    <section style="padding: 100px 0 130px 0;">
        <div class="container">
            <div class="row g-0">
                <div class="col-md-4 about-one-col1">
                    <div class="about-one-img" style="background-image: url({{getPageById(156)->src ?: config('filemanager.default_backend_image')}})">
                    </div>
                </div>
                <div class="col-md-3 about-one-col2">
                    <div class="about-one-center-box pbmit-bg-color-white">
                        <div class="pbmit-custom-heading">
                            <h2>{{getPageById(156)->title}}</h2>
                        </div>
                        <div class="align-self-end">
                            <div class="pbminfotech-ele-fid-style-3">
                                <div class="pbmit-fld-contents">
                                    <div class="pbmit-fld-wrap">
                                        <h4 class="pbmit-fid-inner">
                                            <span class="pbmit-fid-before"></span>
                                            <span class="pbmit-number-rotate numinate" data-appear-animation="animateDigits" data-from="0" data-to="{{__('home_about_number')}}" data-interval="10" data-before="" data-before-style="" data-after="" data-after-style="">{{__('home_about_number')}}</span>
                                            <span class="pbmit-fid"><span>+</span></span>
                                        </h4>
                                        <span class="pbmit-fid-title">{{getPageById(156)->slogan}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-5 about-one-col3">
                    <div class="ps-xl-5">
                        {!! getPageById(156)->content !!}
                        <a class="pbmit-btn pbmit-btn-outline mt-4" href="{{route('frontend.pages.about')}}">
                            <span class="pbmit-button-content-wrapper">
                                <span class="pbmit-button-text">{{__('about_us')}}</span>
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

    <section class="service-one-bg pbmit-bg-color-blackish">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="pbmit-heading-subheading">
                        <h4 class="pbmit-subtitle">
                            {{__('our_experience')}}
                        </h4>
                        <h2 class="pbmit-title">
                            {{__('home_service_title_1')}}
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
                    @foreach($services as $service)
                        <article class="pbmit-service-style-3 swiper-slide">
                            <div class="pbminfotech-post-item">
                                <div class="pbminfotech-box-content-desc-wraper">
                                    <div class="pbminfotech-box-content">
                                        <div class="pbmit-content-box">
                                            <div class="pbmit-serv-cat"></div>
                                            <h3 class="pbmit-service-title">
                                                <a href="{{route('frontend.services.show', ['id' => $service->id, 'slug' => $service->slug])}}">{{$service->title}}</a>
                                            </h3>
                                        </div>
                                        <div class="pbmit-service-icon">
                                            <svg enable-background="new 0 0 512 512" height="512" viewbox="0 0 512 512" width="512" xmlns="http://www.w3.org/2000/svg"><g id="_x30_6_x2C__Delivery_x2C__domestic_ems_x2C__express_x2C__global_x2C__logistics"><g id="XMLID_129_"><path id="XMLID_139_" d="m97.239 406.218c31.077 40.974 78.875 68.6 133.144 72.611-18.323-19.421-33.738-44.255-44.965-72.611z"></path><path id="XMLID_189_" d="m196.314 406.218c11.981 29.004 28.578 54.262 48.735 73.109.296-.002.59-.008.886-.011 20.152-18.846 36.745-44.099 48.723-73.098z"></path><path id="XMLID_190_" d="m164.905 300.114h-104.971c.949 35.414 11.948 68.362 30.233 96.104h91.536c-10.541-30.006-16.306-62.928-16.798-96.104z"></path><path id="XMLID_191_" d="m230.427 111.395c-54.286 3.999-102.1 31.627-133.186 72.611h88.474c11.099-28.048 26.279-52.973 44.712-72.611z"></path><path id="XMLID_192_" d="m274.606 113.628c-4.076-.588-8.519-1.148-12.911-1.608 4.773 5.147 9.33 10.646 13.644 16.485-.659-5.137-.874-10.029-.733-14.877z"></path><path id="XMLID_193_" d="m294.806 184.006c-11.874-29.064-28.313-54.311-48.273-73.08-.505-.013-.994-.022-1.475-.027-20.087 18.87-36.643 44.119-48.615 73.108h98.363z"></path><path id="XMLID_194_" d="m192.565 194.006c-10.833 29.551-17.052 62.452-17.652 96.107h141.146c-.59-33.713-6.725-66.608-17.415-96.107z"></path><path id="XMLID_195_" d="m192.431 396.218h106.11c10.826-29.55 17.004-62.455 17.526-96.104h-141.161c.521 33.649 6.699 66.555 17.525 96.104z"></path><path id="XMLID_196_" d="m181.977 194.006h-91.809c-18.286 27.743-29.286 60.692-30.235 96.107h104.981c.581-33.506 6.578-66.339 17.063-96.107z"></path><path id="XMLID_199_" d="m368.279 32.673c-46.162 0-83.717 37.554-83.717 83.713 0 56.623 50.137 70.383 82.944 131.892 16.825-39.657 65.856-74.841 75.682-94.472 27.532-54.996-12.18-121.133-74.909-121.133zm.002 131.694c-26.996 0-48.958-21.963-48.958-48.959s21.963-48.959 48.958-48.959c26.997 0 48.959 21.963 48.959 48.959s-21.963 48.959-48.959 48.959z"></path><path id="XMLID_200_" d="m368.281 76.449c-21.482 0-38.958 17.477-38.958 38.959s17.477 38.959 38.958 38.959c21.482 0 38.959-17.477 38.959-38.959s-17.477-38.959-38.959-38.959z"></path><path id="XMLID_201_" d="m428.207 290.114c-1.122-28.314-11.42-59.494-21.345-80.797-15.114 16.513-29.316 34.951-33.716 53.587-.502 2.126-2.327 3.681-4.507 3.838-2.172.158-4.207-1.116-5.01-3.152-10.688-27.086-37.395-54.794-56.762-76.294.1.274.182.556.233.85 11.659 31.238 18.349 66.185 18.959 101.969h102.148z"></path><path id="XMLID_202_" d="m309.27 396.218h88.743c18.284-27.743 29.284-60.69 30.233-96.104h-102.179c-.492 33.176-6.256 66.098-16.797 96.104z"></path><path id="XMLID_203_" d="m260.83 478.571c53.014-4.798 99.614-32.144 130.11-72.352h-85.386c-11.177 28.231-26.507 52.969-44.724 72.352z"></path></g></g></svg>
                                        </div>
                                    </div>
                                    <div class="pbmit-service-description">
                                        <p>{{$service->slogan}}</p>
                                    </div>
                                </div>
                                <div class="pbmit-service-image-wrapper">
                                    <div class="pbmit-featured-img-wrapper">
                                        <div class="pbmit-featured-wrapper">
                                            <img src="{{asset($service->src ?: config('filemanager.default_backend_image'))}}" class="img-fluid w-100" alt="{{$service->title}}">
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

    <section class="pbmit-element-static-box-style-1 section-md">
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

    <section class="section-lg" style="padding-top: 0 !important;">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="pbmit-heading-subheading">
                        <h4 class="pbmit-subtitle">
                            {{__('our_blog')}}
                        </h4>
                        <h2 class="pbmit-title">{{__('updated_blogs_news')}}</h2>
                    </div>
                </div>
                <div class="col-md-4 text-md-end mb-md-0 mb-5 d-md-block d-none">
                    <a class="pbmit-btn pbmit-btn-outline" href="{{ route('frontend.blogs.index') }}">
								<span class="pbmit-button-content-wrapper">
									<span class="pbmit-button-text">{{__('view_all_post')}}</span>
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
                                                <a href="{{ route('frontend.blogs.show', ['id' => $blog->id, 'slug' => $blog->slug]) }}" rel="category tag">{{$blog->categories->first()->title ?? "N/A"}}</a>
                                            </div>
                                        </div>
                                        <div class="pbmit-date-author-wrapper">
                                            <div class="pbmit-meta-author pbmit-meta-line">
                                                <span class="pbmit-post-author">{{$blog->created_at->format('d/m/Y')}}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="pbmit-featured-container">
                                        <div class="pbmit-featured-img-wrapper">
                                            <div class="pbmit-featured-wrapper">
                                                <img src="{{asset($blog->src ?: config('filemanager.default_backend_image'))}}" class="img-fluid" alt="{{$blog->title}}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="pbmit-content-wrapper">
                                        <h3 class="pbmit-post-title">
                                            <a href="{{ route('frontend.blogs.show', ['id' => $blog->id, 'slug' => $blog->slug]) }}">{{$blog->title}}</a>
                                        </h3>
                                        <div class="pbmit-blog-button">
                                            <a class="pbmit-button-inner" href="{{ route('frontend.blogs.show', ['id' => $blog->id, 'slug' => $blog->slug]) }}" title="{{$blog->title}}">
                                                <span class="pbmit-button-icon">{{__('read_more')}}</span>
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

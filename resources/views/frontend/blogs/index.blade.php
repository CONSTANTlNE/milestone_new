@extends('frontend.layouts.master')
@section('title')
    {{ $page->title }} -
@endsection
@section('seo')
    @include('components.frontend.socials.seo', ['data' => $page])
@endsection
@section('header_background')
    @include('components.frontend.header-banner', ['data' => $page])
@endsection
@section('content')

    <section class="section-lg section-home-blogs service-one-bg-white pbmit-bg-color-white" data-aos="fade-up" data-aos-duration="750" data-aos-easing="ease-out">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-7">
                    <div class="pbmit-heading-subheading">
                        <h4 class="pbmit-subtitle" data-aos="fade-up" data-aos-delay="80" data-aos-duration="600" style="text-align: left;">
                            <span>01</span> | Our Blog
                        </h4>
                        <h2 class="pbmit-title mb-reveal-wipe" style="text-align: left;">{{__('updated_blogs_news')}}</h2>
                    </div>
                </div>

                <div class="col-md-5 pbmit-heading-content mb-md-0 d-md-block d-none">
                    <p data-aos="fade-up" data-aos-delay="80" data-aos-duration="600"  style="text-align: right;">
                        Insights on vehicle logistics, transport planning, and industry best practices from a compliance-focused brokerage perspective.
                    </p>
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
            <div class="col-md-2 all-blog blog-page d-md-block d-none" style="margin: auto;">
                <a class="pbmit-btn" href="{{ route('frontend.blogs.index') }}">
                    <span class="pbmit-button-content-wrapper">
                        <span class="pbmit-button-text">See more</span>
                    </span>
                </a>
            </div>
        </div>
    </section>

@endsection

@push('css')
    <style>
        /* Ensure consistent square thumbnails inside .pbminfotech-box-content */
        .pbminfotech-box-content .pbmit-featured-container,
        .pbminfotech-box-content .pbmit-featured-img-wrapper,
        .pbminfotech-box-content .pbmit-featured-wrapper {
            position: relative;
            width: 100%;
        }

        /* Make the image area square and prevent shrinking */
        .pbminfotech-box-content .pbmit-featured-wrapper {
            aspect-ratio: 1 / 1; /* equal width and height */
            overflow: hidden;
        }

        .pbminfotech-box-content .pbmit-featured-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover; /* crop to fill without distortion */
            display: block;
        }
    </style>
@endpush

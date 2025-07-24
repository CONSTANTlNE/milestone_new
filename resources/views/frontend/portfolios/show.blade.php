@extends('frontend.layouts.master')
@section('title') {{ $portfolio->title }} - @endsection
@section('seo')
    @include('components.frontend.socials.seo', ['data' => $portfolio])
@endsection
@section('header_background')
    <div class="pbmit-title-bar-wrapper">
        <div class="container">
            <div class="pbmit-title-bar-content">
                <div class="pbmit-title-bar-content-inner">
                    <div class="pbmit-tbar">
                        <div class="pbmit-tbar-inner container">
                            <h1 class="pbmit-tbar-title">{{$portfolio->title}}</h1>
                        </div>
                    </div>
                    <div class="pbmit-breadcrumb">
                        <div class="pbmit-breadcrumb-inner">
								<span>
									<a title="" href="#" class="home"><span>{{__('portfolio')}}</span></a>
								</span>
                            <span class="sep">
									<i class="pbmit-base-icon-angle-right"></i>
								</span>
                            <span><span class="post-root post post-post current-item"> {{$portfolio->title}}</span></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')

    <!-- Single Detail Style 1 -->
    <section class="site-content">
        <div class="container">
            <article class="pbmit-portfolio-single">
{{--                <div class="pbmit-featured-img-wrapper">--}}
{{--                    <img src="{{asset($portfolio->src ?: config('filemanager.default_backend_image'))}}" class="img-fluid" alt="">--}}
{{--                </div>--}}
{{--                <div class="pbmit-single-project-details-list">--}}
{{--                    <h3 class="mb-4">Project info</h3>--}}
{{--                    <div class="pbmit-portfolio-lines-wrapper">--}}
{{--                        <ul class="pbmit-portfolio-lines-ul">--}}
{{--                            <li class="pbmit-portfolio-line-li">--}}
{{--                                <span class="pbmit-portfolio-line-title">Client : </span>--}}
{{--                                <span class="pbmit-portfolio-line-value">Tom Olson</span>--}}
{{--                            </li>--}}
{{--                            <li class="pbmit-portfolio-line-li">--}}
{{--                                <span class="pbmit-portfolio-line-title">Tag : </span>--}}
{{--                                <span class="pbmit-portfolio-line-value">Fast Delivery</span>--}}
{{--                            </li>--}}
{{--                            <li class="pbmit-portfolio-line-li">--}}
{{--                                <span class="pbmit-portfolio-line-title">Date : </span>--}}
{{--                                <span class="pbmit-portfolio-line-value">20 Jan 2020</span>--}}
{{--                            </li>--}}
{{--                            <li class="pbmit-portfolio-line-li">--}}
{{--                                <span class="pbmit-portfolio-line-title">Status : </span>--}}
{{--                                <span class="pbmit-portfolio-line-value">Process</span>--}}
{{--                            </li>--}}
{{--                        </ul>--}}
{{--                    </div>--}}
{{--                </div>--}}
                <div class="pbmit-entry-content">
                    <div class="pbmit-heading">
                        <h2 class="pbmit-title mb-4">{{$portfolio->title}}</h2>
                    </div>
                    {!! $portfolio->content !!}
                </div>
            </article>
        </div>
    </section>
@endsection

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
    <section class="section-lg">
        <div class="container">
            <div class="row pbmit-element-posts-wrapper">
                @foreach($portfolios as $portfolio)
                <article class="pbmit-portfolio-style-1 col-md-4">
                    <div class="pbminfotech-post-content">
                        <div class="pbmit-featured-img-wrapper">
                            <div class="pbmit-featured-wrapper">
                                <img src="{{asset($portfolio->src ?: config('filemanager.default_backend_image'))}}" class="img-fluid" alt="portfolio-01">
                            </div>
                        </div>
                        <div class="pbminfotech-box-content">
                            <div class="pbminfotech-titlebox">
                                <div class="pbmit-port-cat">
                                    <a href="{{ route('frontend.portfolios.show', ['id' => $portfolio->id, 'slug' =>$portfolio->slug]) }}" rel="tag">{{$portfolio->slogan}}</a>
                                </div>
                                <h3 class="pbmit-portfolio-title">
                                    <a href="{{ route('frontend.portfolios.show', ['id' => $portfolio->id, 'slug' =>$portfolio->slug]) }}">{{$portfolio->title}}</a>
                                </h3>
                            </div>
                        </div>
                        <div class="pbmit-portfolio-btn">
                            <a href="{{ route('frontend.portfolios.show', ['id' => $portfolio->id, 'slug' =>$portfolio->slug]) }}">
                                <i class="pbmit-base-icon-pbmit-up-arrow"></i>
                            </a>
                        </div>
                        <a class="pbmit-link" href="{{ route('frontend.portfolios.show', ['id' => $portfolio->id, 'slug' =>$portfolio->slug]) }}"></a>
                    </div>
                </article>
                @endforeach
            </div>
        </div>
    </section>
@endsection

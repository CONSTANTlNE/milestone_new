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

    <!-- Blog Classic -->
    <section class="site-content">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-xl-9 blog-left-col">
                    <div class="row pbmit-element-posts-wrapper">
                        @foreach($blogs as $blog)
                        <article class="post blog-classic">
                            <div class="pbmit-img-wrapper">
                                <div class="pbmit-featured-img-wrapper">
                                    <div class="pbmit-featured-wrapper">
                                        <a href="{{ route('frontend.blogs.show', ['id'=> $blog->id, 'slug'=> $blog->slug, ]) }}">
                                            <img src="{{asset($blog->src ?: config('filemanager.default_backend_image'))}}" class="img-fluid" alt="">
                                        </a>
                                    </div>
                                </div>
                                <span class="pbmit-meta pbmit-meta-cat">
										<i class="pbmit-base-icon-calendar-3"></i>
										<a href="{{ route('frontend.blogs.show', ['id'=> $blog->id, 'slug'=> $blog->slug, ]) }}" rel="category tag">Strategy</a>
									</span>
                            </div>
                            <div class="pbmit-blog-classic-inner">
                                <div class="pbmit-blog-meta pbmit-blog-meta-top">
                                    <div class="pbmit-meta pbmit-meta-cat">
                                        <a href="{{ route('frontend.blogs.show', ['id'=> $blog->id, 'slug'=> $blog->slug, ]) }}" rel="category tag">Strategy</a>
                                    </div>
                                    <span class="pbmit-meta pbmit-meta-date">
											<i class="pbmit-base-icon-calendar-3"></i>
											<a href="blog-single-details.html" rel="bookmark">
												<span class="entry-date">27 Dec, 2024</span>
											</a>
										</span>
                                </div>
                                <h3 class="pbmit-post-title">
                                    <a href="{{ route('frontend.blogs.show', ['id'=> $blog->id, 'slug'=> $blog->slug, ]) }}">{{$blog->title}}</a>
                                </h3>
                                <div class="pbmit-entry-content">
                                    <div class="pbmit-entry-content">
                                        <p>{{$blog->slogan}}</p>
                                    </div>
                                    <div class="pbmit-read-more-link">
                                        <a class="pbmit-btn" href="{{ route('frontend.blogs.show', ['id'=> $blog->id, 'slug'=> $blog->slug, ]) }}">
												<span class="pbmit-button-content-wrapper">
													<span class="pbmit-button-text">{{__('read_more')}}</span>
												</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </article>
                        @endforeach
                    </div>
                </div>
                <div class="col-md-12 col-xl-3 blog-right-col">
                    <aside class="sidebar">
                        <aside class="widget widget-categories">
                            <h2 class="widget-title">{{__('categories')}}</h2>
                            <ul>
                                @foreach($blogCategories as $category)
                                <li>
										<span class="pbmit-cat-li">
											<a href="{{ route('frontend.blogCategories.show', ['id'=>$category->id, 'slug'=>$category->slug]) }}">{{$category->title}}</a>
											<span class="pbmit-brackets">( {{count($category->blogs)}} )</span>
										</span>
                                </li>
                                @endforeach
                            </ul>
                        </aside>
                        <aside class="widget pbmit-service-ad">
                            <div class="pbmit-widget-ads">
                                <img
                                    src="{{asset('assets/images/bg/service-ad-bg.jpg')}}"
                                    class="bg-img"
                                    alt=""
                                />
                                <div class="pbmit-service-ad-wrapper">
                                    <div class="pbmit-service-ads">
                                        <div class="pbmit-ads-icon">
                                            <i class="pbmit-base-icon-phone-call"></i>
                                        </div>
                                        <span>{{__('contact_text_number')}}</span>
                                        @if(!empty(getContact()->phone) or !empty(getContact()->phone1))
                                            <h3 class="pbmit-ads-call">
                                                <a href="tel:{{getContact()->phone}}">{{getContact()->phone}}</a>
                                                <a href="tel:{{getContact()->phone1}}">{{getContact()->phone1}}</a>
                                            </h3>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </aside>
                    </aside>
                </div>
            </div>
        </div>
    </section>
@endsection

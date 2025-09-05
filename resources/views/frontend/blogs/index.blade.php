@extends('frontend.layouts.master')
@section('title') {{ $page->title }} - @endsection
@section('seo')
    @include('components.frontend.socials.seo', ['data' => $page])
@endsection
@section('header_background')
    @include('components.frontend.header-banner', ['data' => $page])
@endsection
@section('content')
    <section class="site-content">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-xl-9 blog-left-col">
                    <div class="row pbmit-element-posts-wrapper">
                        @foreach($blogs as $blog)
                            <article class="pbmit-ele pbmit-ele-blog pbmit-blog-style-1 col-md-6 col-lg-6 strategy pbmit-term-27 pbmit-odd pbmit-col-odd">
                                <div class="post-item">
                                    <div class="pbminfotech-box-content">
                                        <div class="pbmit-date-wraper d-flex align-items-center">
                                            <div class="pbmit-meta-category-wrapper pbmit-meta-line">
                                                <div class="pbmit-meta-category"><a href="{{ route('frontend.blogs.show', ['id' => $blog->id, 'slug' => $blog->slug]) }}" rel="category tag">{{$blog->categories->first()->title ?? "N/A"}}</a></div>
                                            </div>
                                            <div class="pbmit-date-author-wrapper">
                                                <div class="pbmit-meta-date">
                                                    <span class="pbmit-post-date">{{$blog->created_at->format('d/m/Y')}}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="pbmit-featured-container">
                                            <div class="pbmit-featured-img-wrapper">
                                                <div class="pbmit-featured-wrapper">
                                                    <img fetchpriority="high" decoding="async" src="{{asset($blog->src ?: config('filemanager.default_backend_image'))}}" class="attachment-pbmit-img-800x540 size-pbmit-img-800x540 wp-post-image" alt="{{$blog->title}}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="pbmit-content-wrapper">
                                            <h3 class="pbmit-post-title"><a href="{{ route('frontend.blogs.show', ['id' => $blog->id, 'slug' => $blog->slug]) }}">{{$blog->title}}</a></h3>
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
                    {{$blogs->links()}}
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

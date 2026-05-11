@extends('frontend.layouts.master', ['class' => 'header-style-2'])
@section('title') {{ $blog->title }} - @endsection
@section('seo')
    @include('components.frontend.socials.seo', ['data' => $blog])
@endsection
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/blog_show.css') }}">
@endpush

@section('content')

{{-- Hero --}}
<section class="bs-hero">
    <div class="bs-wrap">
        <div class="bs-hero-text">
            <p class="bs-hero-date">{{ $blog->created_at->format('M d, Y') }}</p>
            <h1 class="bs-hero-title">{{ $blog->title }}</h1>
            @if($blog->slogan)
                <p class="bs-hero-desc">{{ $blog->slogan }}</p>
            @endif
        </div>
        <div class="bs-hero-img-outer">
            <div class="bs-hero-img-wrap">
                <img src="{{ asset($blog->src ?: config('filemanager.default_backend_image')) }}"
                     alt="{{ $blog->title }}" class="bs-hero-img">
            </div>
            @if($blog->categories->isNotEmpty())
                <span class="bs-hero-badge">{{ $blog->categories->first()->title }}</span>
            @endif
        </div>
    </div>
</section>

{{-- Content --}}
<section class="bs-content-section">
    <div class="bs-wrap">
        <div class="bs-content-grid">

            {{-- Sidebar --}}
            <aside class="bs-sidebar">
                <div class="bs-sidebar-card">
                    <div class="bs-sidebar-top">
                        <p class="bs-sidebar-heading">We Offer Fast and Reliable Transport</p>
                        <div class="bs-sidebar-phone">
                            <div class="bs-phone-icon">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M17.45 14.33c-.37-.19-2.19-1.08-2.53-1.2-.34-.12-.59-.19-.84.19-.25.37-.96 1.2-1.18 1.45-.22.25-.43.28-.8.09-.37-.19-1.57-.58-2.99-1.84-1.11-.99-1.85-2.21-2.07-2.58-.22-.37-.02-.57.16-.76.17-.17.37-.43.56-.65.19-.21.25-.37.37-.62.12-.25.06-.46-.03-.65-.09-.19-.84-2.02-1.15-2.77-.3-.72-.61-.62-.84-.63-.22-.01-.46-.01-.71-.01-.25 0-.65.09-.99.46-.34.37-1.3 1.27-1.3 3.1s1.33 3.59 1.52 3.84c.19.25 2.62 4 6.35 5.61.89.38 1.58.61 2.12.78.89.28 1.7.24 2.34.15.71-.11 2.19-.9 2.5-1.76.31-.87.31-1.61.22-1.76-.09-.15-.34-.25-.71-.43z" fill="white"/>
                                </svg>
                            </div>
                            @if(!empty(getContact()->phone))
                                <a href="tel:{{ getContact()->phone }}" class="bs-phone-number">{{ getContact()->phone }}</a>
                            @endif
                        </div>
                    </div>
                    <div class="bs-sidebar-img">
                        <img src="{{ asset('assets/images/bg/service-ad-bg.jpg') }}" alt="">
                    </div>
                </div>
            </aside>

            {{-- Article --}}
            <article class="bs-article">
                <div class="bs-article-body">
                    {!! $blog->content !!}
                </div>
            </article>

        </div>
    </div>
</section>

{{-- Related Posts + CTA --}}
<section class="bs-related-section">
    <div class="bs-wrap">
        <div class="bs-related-cta">
            <h2 class="bs-related-heading">Looking for More Logistics Insights?</h2>
            <p class="bs-related-subtext">Explore transport strategies, compliance guidance, and carrier management best practices.</p>
            <div class="bs-browse-row">
                <a href="{{ route('frontend.blogs.index') }}" class="bs-browse-text-btn">Browse More</a>
                <a href="{{ route('frontend.blogs.index') }}" class="bs-browse-icon-btn" aria-label="Browse more">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                        <path d="M4.167 10h11.666M10 4.167 15.833 10 10 15.833" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>
            </div>
        </div>

        @if($relatedBlogs->isNotEmpty())
            <div class="bs-cards-grid">
                @foreach($relatedBlogs as $i => $related)
                    <a href="{{ route('frontend.blogs.show', ['id' => $related->id, 'slug' => $related->slug]) }}" class="bs-card">
                        <div class="bs-card-img-wrap">
                            <img src="{{ asset($related->src ?: config('filemanager.default_backend_image')) }}"
                                 alt="{{ $related->title }}" class="bs-card-img">
                        </div>
                        <div class="bs-card-info">
                            <div class="bs-card-text">
                                <span class="bs-card-date">{{ $related->created_at->format('M d, Y') }}</span>
                                <h3 class="bs-card-title">{{ $related->title }}</h3>
                                @if($related->slogan)
                                    <p class="bs-card-excerpt">{{ $related->slogan }}</p>
                                @endif
                            </div>
                            <div class="bs-card-arrow">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                                    <path d="M4.167 10h11.666M10 4.167 15.833 10 10 15.833" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</section>

@endsection

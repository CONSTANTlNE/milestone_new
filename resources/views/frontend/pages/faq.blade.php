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
    <section class="section-md">
        <div class="container">
            <div class="pbmit-heading-subheading text-center animation-style2">
                <h2 class="pbmit-title">{{$page->slogan}}</h2>
                <div class="pbmit-heading-desc" style="width: 50%; margin:auto">
                    {!! $page->content !!}
                </div>
            </div>
            <div class="accordion style-3" id="accordionExample2">
                @foreach($faqs as $key => $faq)
                <div class="accordion-item">
                    <h2 class="accordion-header" id="heading{{$key}}">
                        <button
                            class="accordion-button collapsed"
                            type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#collapse{{$key}}"
                            aria-expanded="false"
                            aria-controls="collapse{{$key}}"
                        >
                    <span class="pbmit-accordion-title">
                      <span class="pbmit-number">{{$key < 10 ? '0'.$key+1 : $key+1}}</span>
                      {{$faq->title}}
                    </span>
                            <span class="pbmit-accordion-icon">
                      <span class="pbmit-accordion-icon-opened">
                        <i
                            class="pbmit-shipex-icon pbmit-shipex-icon-levels"
                        ></i>
                      </span>
                      <span class="pbmit-accordion-icon-closed">
                        <i
                            class="pbmit-shipex-icon pbmit-shipex-icon-levels"
                        ></i>
                      </span>
                    </span>
                        </button>
                    </h2>
                    <div
                        id="collapse{{$key}}"
                        class="accordion-collapse collapse"
                        aria-labelledby="heading{{$key}}"
                        data-bs-parent="#accordionExample2"
                    >
                        <div class="accordion-body">
                            {!! $faq->content  !!}
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection

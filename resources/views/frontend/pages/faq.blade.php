@extends('frontend.layouts.master')
@section('title') {{ __('strings.Home') }} @endsection

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
    <!-- Faq Start -->
    <section class="section-lgb">
        <div class="container">
            <div class="pbmit-heading-subheading text-center animation-style2">
                <h2 class="pbmit-title">Frequently Asked <br />Questions</h2>
                <div class="pbmit-heading-desc">
                    You will find answers to about our various transport work and
                    transport s service and more. Please feel <br />
                    free to contact us if you don't get your question's answer in
                    below.
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
                      <span class="pbmit-number">{{$key}}</span>
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
    <!-- Faq End -->
@endsection

@extends('frontend.layouts.master')
@section('title') {{ $service->title }} - @endsection
@section('seo')
    @include('components.frontend.socials.seo', ['data' => $service])
@endsection
@section('header_background')
    <div class="pbmit-title-bar-wrapper" style="background-image: url({{asset(config('filemanager.default_backend_image'))}});">
        <div class="container">
            <div class="pbmit-title-bar-content">
                <div class="pbmit-title-bar-content-inner">
                    <div class="pbmit-tbar">
                        <div class="pbmit-tbar-inner container">
                            <h1 class="pbmit-tbar-title">{{$service->title}}</h1>
                        </div>
                    </div>
                    <div class="pbmit-breadcrumb">
                        <div class="pbmit-breadcrumb-inner">
								<span>
									<a title="" href="#" class="home"><span>{{__('service')}}</span></a>
								</span>
                            <span class="sep">
									<i class="pbmit-base-icon-angle-right"></i>
								</span>
                            <span><span class="post-root post post-post current-item"> {{$service->title}}</span></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <section class="site-content service-details">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-xl-3 service-left-col sidebar">
                    <aside class="service-sidebar">
                        <aside class="widget post-list">
                            <h2 class="widget-title">{{__('our_services')}}</h2>
                            <div class="all-post-list">
                                <ul>
                                    @foreach($services as $key => $service)
                                    <li class="post-active">
                                        <a href="{{route('frontend.services.show', ['id'=>$service->id, 'slug' => $service->slug])}}"> {{$service->title}} </a>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
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
                <div class="col-md-12 col-xl-9 service-right-col">
                    <div class="pbmit-service-feature-image">
                        <img
                            src="{{asset($service->src ?: config('filemanager.default_backend_image'))}}"
                            class="img-fluid w-100"
                            alt="{{$service->title}}"
                        />
                    </div>
                    <div class="pbmit-entry-content">
                        <div class="pbmit-service_content">
                            <div class="pbmit-heading">
                                <h3 class="pbmit-title mb-3">
                                    {{$service->title}}
                                </h3>
                            </div>
                            {!! $service->content !!}
                            @if(count($service->features))
                            <div class="row">
                                <div class="col-md-6">
                                    <ul class="list-group">
                                        @foreach($service->features as $feature)
                                        <li class="list-group-item">
													<span class="pbmit-icon-list-icon">
														<i aria-hidden="true" class="pbmit-base-icon-check-mark"></i>
													</span>
                                           {{$feature->title}}
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            @endif
                        </div>
                        @if(count($service->faqs))
                        <div class="pbmit-heading animation-style2  mt-5">
                            <h3 class="pbmit-title mb-3">{{__('faq')}}</h3>
                        </div>
                        <div class="accordion style-3" id="accordionExample1">
                            @foreach($service->faqs as $key => $faq)
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
                                        data-bs-parent="#accordionExample1"
                                    >
                                        <div class="accordion-body">
                                            {!! $faq->content  !!}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

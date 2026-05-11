@extends('frontend.layouts.master', ['class' => 'header-style-2'])
@section('title') {{ $page->title }} - @endsection
@section('seo')
    @include('components.frontend.socials.seo', ['data' => $page])
@endsection
@section('content')
    <section class="section-md contact">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-xl-12">
                    <div class="pbmit-heading-subheading contact-header text-center animation-style2">
                        <h2 class="pbmit-title">{{$page->title}}</h2>
                        <div class="pbmit-heading-desc">
                            {{$page->slogan}}
                        </div>
                        <p>{{ clear_content($page->content)}}</p>
                    </div>
                </div>
            </div>
            <div class="row">
                @if(!empty($setting->email) or !empty($setting->email1))
                    <article class="pbmit-miconheading-style-5 col-md-6 col-lg-4 col-xl-3">
                        <div class="pbmit-ihbox-style-5">
                            <div class="pbmit-ihbox-headingicon">
                                <div class="pbmit-ihbox-wrap">
                                    <div class="pbmit-ihbox-icon">
                                        <div class="pbmit-ihbox-icon-wrapper pbmit-icon-type-icon">
                                            <img src="{{asset('assets/images/mail.svg')}}" alt="{{__('e_mail')}}">
                                        </div>
                                    </div>
                                    <div class="pbmit-ihbox-contents">
                                        <h2 class="pbmit-element-title">
                                            {{__('mail_text')}}
                                        </h2>
                                        <div class="pbmit-heading-desc">
                                            @if(!empty($setting->email))
                                                <a href="mailto:{{$setting->email}}" class="__cf_email__" >{{$setting->email}}</a>
                                            @endif
                                            @if(!empty($setting->email1))
                                                <a href="mailto:{{$setting->email}}" class="__cf_email__" >{{$setting->email1}}</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </article>
                @endif
                @if(isset($setting->address) and !empty(clear($setting->address)))
                    <article class="pbmit-miconheading-style-5 col-md-6 col-lg-4 col-xl-3">
                        <div class="pbmit-ihbox-style-5">
                            <div class="pbmit-ihbox-headingicon">
                                <div class="pbmit-ihbox-wrap">
                                    <div class="pbmit-ihbox-icon">
                                        <div class="pbmit-ihbox-icon-wrapper pbmit-icon-type-icon">
                                            <img src="{{asset('assets/images/location.svg')}}" alt="{{__('location')}}">
                                        </div>
                                    </div>
                                    <div class="pbmit-ihbox-contents">
                                        <h2 class="pbmit-element-title">
                                            {{__('our_location')}}
                                        </h2>
                                        <div class="pbmit-heading-desc">{{$setting->address}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </article>
                @endif
                @if(!empty($setting->phone) or !empty($setting->phone1))
                    <article class="pbmit-miconheading-style-5 phone col-md-6 col-lg-4 col-xl-3">
                        <div class="pbmit-ihbox-style-5">
                            <div class="pbmit-ihbox-headingicon">
                                <div class="pbmit-ihbox-wrap">
                                    <div class="pbmit-ihbox-icon">
                                        <div class="pbmit-ihbox-icon-wrapper pbmit-icon-type-icon">
                                            <img src="{{asset('assets/images/call.svg')}}" alt="{{__('call')}}">
                                        </div>
                                    </div>
                                    <div class="pbmit-ihbox-contents">
                                        <h2 class="pbmit-element-title">
                                            {{__('call')}}
                                        </h2>
                                        <div class="pbmit-heading-desc">
                                            @if(!empty($setting->phone))
                                                <a href="tel:{{$setting->phone}}" class="__cf_email__" >{{__('phone')}}: {{$setting->phone}}</a>
                                            @endif
                                            @if(!empty($setting->phone1))
                                                <a href="tel:{{$setting->phone1}}" class="__cf_email__" >{{__('mobile')}}: {{$setting->phone1}}</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </article>
                @endif
                @if(!empty($setting->working_hours))
                    <article class="pbmit-miconheading-style-5 col-md-6 col-lg-4 col-xl-3">
                        <div class="pbmit-ihbox-style-5">
                            <div class="pbmit-ihbox-headingicon">
                                <div class="pbmit-ihbox-wrap">
                                    <div class="pbmit-ihbox-icon">
                                        <div class="pbmit-ihbox-icon-wrapper pbmit-icon-type-icon">
                                            <img src="{{asset('assets/images/calendar.svg')}}" alt="{{__('calendar')}}">
                                        </div>
                                    </div>
                                    <div class="pbmit-ihbox-contents">
                                        <h2 class="pbmit-element-title">
                                            {{__('working_days')}}
                                        </h2>
                                        <div class="pbmit-heading-desc">
                                            {{$setting->working_hours}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </article>
                @endif
            </div>
            <div class="row g-0">
                <div class="col-md-12 col-xl-6">
                    <div class="contact-us-left-area">
                        @if(!empty($setting->g_map))
                                    {!! $setting->g_map !!}
                        @endif
                    </div>
                </div>
                <div class="col-md-12 col-xl-6">
                    <div class="contact-form-rightbox pbmit-bg-color-white">
                        <div class="pbmit-heading animation-style2">
                            <h2 class="pbmit-title">{{__('contact_form')}}</h2>
                        </div>
                        <p>{{__('required')}}</p>
                        <form class="contact-form" method="post" id="contact-form" action="#">
                            @if(config('milestone.CLOUDFLARE_CAPTCHA')==true)
                                <div
                                    class="cf-turnstile"
                                    data-sitekey="0x4AAAAAABmcVARJuH5NYIlN"
                                    data-callback="javascriptCallback"
                                ></div>
                            @endif
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="text" class="form-control" placeholder="{{__('your_name')}}" name="name" required="">
                                </div>
                                <div class="col-md-12">
                                    <input type="email" class="form-control" placeholder="{{__('your_email')}}" name="email" required="">
                                </div>
                                <div class="col-md-12">
                                    <input type="tel" class="form-control" placeholder="{{__('your_phone')}}" name="phone" required="">
                                </div>
                                <div class="col-md-12">
                                    <input type="text" class="form-control" placeholder="{{__('subject')}}" name="subject" required="">
                                </div>
                                <div class="col-md-12">
                                    <textarea name="message" cols="40" rows="10" class="form-control" placeholder="{{__('message')}}" required=""></textarea>
                                </div>
                            </div>
                            <button class="pbmit-btn submit my-4">
                                <span class="pbmit-button-content-wrapper">
                                    <span class="pbmit-button-text">{{__('send')}}</span>
                                </span>
                                <span class="form-btn-loader d-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewbox="0 0 200 100"><circle fill="#fff" stroke="#fff" stroke-width="15" r="15" cx="40" cy="50"><animate attributename="opacity" calcmode="spline" dur="2" values="1;0;1;" keysplines=".5 0 .5 1;.5 0 .5 1" repeatcount="indefinite" begin="-.4"></animate></circle><circle fill="#fff" stroke="#fff" stroke-width="15" r="15" cx="100" cy="50"><animate attributename="opacity" calcmode="spline" dur="2" values="1;0;1;" keysplines=".5 0 .5 1;.5 0 .5 1" repeatcount="indefinite" begin="-.2"></animate></circle><circle fill="#fff" stroke="#fff" stroke-width="15" r="15" cx="160" cy="50"><animate attributename="opacity" calcmode="spline" dur="2" values="1;0;1;" keysplines=".5 0 .5 1;.5 0 .5 1" repeatcount="indefinite" begin="0"></animate></circle></svg>
                                </span>
                            </button>
                            <div class="col-md-12 col-lg-12 message-status"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@extends('frontend.layouts.master')

@section('title') {{ __('admin.auto_auctions_page') }} - @endsection

@section('seo')
    @include('components.frontend.socials.seo', ['data' => $page ?? null])
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
    <section class="pbmit-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="pbmit-heading-subheading">
                        <h2 class="pbmit-title"> {{$page->slogan}}</h2>
                        <div class="pbmit-separator"></div>
                    </div>

                    <div class="pbmit-content">
                        <div class="auto-auction-form">
                            <div class="form-header">
                                <p class="form-subtitle">{!! $page->content !!}</p>
                            </div>

                            <div class="payment-logic-section"  style="padding-bottom: 70px;    overflow: hidden;">
                                <div class="payment-tiers">
                                    @foreach($page->tiers as $tier)
                                        <article class="tier pbmit-service-style-1 col-md-12" style="float: left; margin: 5px">
                                            <div class="pbminfotech-post-item">
                                                <div class="pbmit-box-content-wrap">
                                                    <div class="pbmit-content-box">
                                                        <h3 class="pbmit-service-title">{{ $tier->title }}</h3>
                                                        <div class="pbmit-service-description">
                                                            <p style="margin-bottom:0 !important;">{!! $tier->content !!}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </article>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

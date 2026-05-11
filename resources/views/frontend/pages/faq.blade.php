@extends('frontend.layouts.master', ['class' => 'header-style-2'])
@section('title') {{ $page->title }} - @endsection
@section('seo')
    @include('components.frontend.socials.seo', ['data' => $page])
@endsection
@section('content')
    <section class="section-md faqs">
        <div class="container">
            <div class="row">
                <div class="col-lg-5 col-xl-5">
                    <div class="pbmit-heading-subheading faqs-header text-center animation-style2">
                        <h2 class="pbmit-title">{{$page->title}}</h2>
                        <div class="pbmit-heading-desc">
                            {{$page->slogan}}
                        </div>
                        <p>{{ clear_content($page->content)}}</p>
                    </div>
                </div>
                <div class="col-lg-7 col-xl-7">
                    <div class="ps-xl-5">
                        <div class="accordion style-3 mb-faq-sync-accordion" id="accordionExample1">
                            @foreach($faqs as $key => $faq)
                            <div class="accordion-item {{$key == 0 ? 'active' : ''}}">
                                <h2 class="accordion-header" id="heading{{$key}}">
                                    <button
                                        class="accordion-button"
                                        type="button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#collapse{{$key}}"
                                        aria-expanded="{{$key == 0 ? 'true' : 'false'}}"
                                        aria-controls="collapse{{$key}}"
                                    >
                                            <span class="pbmit-accordion-title">
                                                {{ $faq->title }}
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
                                    class="accordion-collapse collapse {{$key == 0 ? 'show' : 'hide'}}"
                                    aria-labelledby="heading{{$key}}"
                                    data-bs-parent="#accordionExample1"
                                >
                                    <div class="accordion-body" data-number="(0{{$key+1}})" data-name="{{$faq->title}}" data-image="">
                                        {{ clear_content($faq->content)}}
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

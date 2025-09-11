@extends('frontend.layouts.master')
@section('title') {{ $page->title }} - @endsection
@section('seo')
    @include('components.frontend.socials.seo', ['data' => $page])
@endsection
@push('css')
    <style>
        .custom-input {
            font-size: 0.85rem; /* Smaller text */
            padding: 0.25rem 0.5rem; /* Compact padding */
            border: 1px solid #ccc; /* Light gray border */
            border-radius: 4px; /* Slight rounding */
            outline: none; /* Remove focus outline */
            width: auto; /* Shrink to content if needed */
        }

        .custom-input:focus {
            border-color: #0056b3;
            box-shadow: 0 0 5px rgba(0, 91, 187, 0.5);
        }

        .custom-input::placeholder {
            color: #999;
            font-style: italic;
        }
    </style>
@endpush
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

    <section class="section-lg individual_quotation">
        <div class="container">
            <div class="pbmit-element-posts-wrapper row">
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

            </div>
        </div>

        @include('components.frontend.index_quotation')
    </section>







    <div id="turnstile-business"></div>
    {{--        <div--}}
    {{--            class="cf-turnstile"--}}
    {{--            data-sitekey="0x4AAAAAABmcVARJuH5NYIlN"--}}
    {{--            data-callback="javascriptCallback"--}}
    {{--        ></div>--}}
    <!-- Services end -->




    <div  class="individual_scripts">


    </div>


    <script>
        // Show form if turnstile is successfull
        {{--window.onloadTurnstileCallback = function () {--}}
        {{--    turnstile.render("#turnstile-business", {--}}
        {{--        sitekey: "0x4AAAAAABmcVARJuH5NYIlN",--}}
        {{--        callback: function (token) {--}}
        {{--            htmx.ajax('post', '{{route('turnstile.verify')}}', {--}}
        {{--                values: {--}}
        {{--                    cf_token: token,--}}
        {{--                    _token: '{{ csrf_token() }}'--}}
        {{--                },--}}
        {{--                target: '#turnstile-business',--}}
        {{--            });--}}
        {{--        },--}}
        {{--    });--}}
        {{--}--}}

    </script>

@endsection

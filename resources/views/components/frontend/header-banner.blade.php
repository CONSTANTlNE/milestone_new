<div class="pbmit-title-bar-wrapper position-relative overflow-hidden" style="background-image: url({{ asset($data->statusImageShow('cover') ?: config('filemanager.default_backend_image')) }});">
    <div class="container-fluid container-content">
        <div class="pbmit-title-bar-content">
            <div class="pbmit-title-bar-content-inner">
                <div class="pbmit-tbar">
                    <div class="pbmit-tbar-inner container" style="position: relative; z-index: 3;">
                        <h5 class="pbmit-sub-title transform-right transform-delay-1">
                            <span>{{$data->title}}</span>
                        </h5>
                        <h1 class="pbmit-tbar-title">{{$data->slogan}}</h1>
                        <p>{{ clear_content($data->content) }}</p>
                        @if(!empty($popup))
                            <div class="col-md-4 all-blog header d-md-block d-none">
                                <a class="pbmit-btn js-open-{{$popup}}-wizard" href="#" role="button" style="background: #fff; color: #000;">
                                <span class="pbmit-button-content-wrapper">
                                    <span class="pbmit-button-text">{{ __('calculate_now') }}</span>
                                </span>
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

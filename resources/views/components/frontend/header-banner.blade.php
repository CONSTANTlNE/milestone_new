<div class="pbmit-title-bar-wrapper" style="background-image: url({{ asset($data->statusImageShow('cover') ?? $data->src ?? config('filemanager.default_backend_image')) }});">
    <div class="container">
        <div class="pbmit-title-bar-content">
            <div class="pbmit-title-bar-content-inner">
                <div class="pbmit-tbar">
                    <div class="pbmit-tbar-inner container">
                        <h1 class="pbmit-tbar-title">{{$data->title}}</h1>
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
                        <span><span class="post-root post post-post current-item"> {{$data->title}}</span></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

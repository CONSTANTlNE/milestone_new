<div class="payment-logic-section mt-5"  style="padding-bottom: 70px;    overflow: hidden;">
    <h4>💳 Payment Logic - {{$title ?? 'no title'}}</h4>
    <div class="payment-tiers">
        @foreach($data as $tier)
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



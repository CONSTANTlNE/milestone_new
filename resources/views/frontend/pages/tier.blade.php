<div class="payment-logic-section mt-5">
    <div class="payment-tiers">
        @foreach($data as $key => $tier)
            <article class="tier pbmit-service-style-1">
                <div class="pbminfotech-box-content">
                    <div class="key">
                        <span class="number">0{{ $key + 1 }}</span>
                        <span class="line">
                            <div class="line-1"></div>
                            <div class="line-2"></div>
                            <div class="line-3"></div>
                        </span>
                    </div>
                    <div class="pbmit-content">
                        <div class="pbmit-featured-container">
                            <div class="pbmit-featured-img-wrapper">
                                <div class="pbmit-featured-wrapper">
                                     <img src="{{ asset('assets/images/tier-'.min($key + 1, 5).'.webp') }}" class="img-fluid" alt="{{ $tier->title }}">
                                </div>
                            </div>
                        </div>
                        <div class="pbmit-content-wrapper">
                            <h3 class="pbmit-service-title">{{ $tier->title }}</h3>
                            <div class="pbmit-service-description">
                                <p>{!! $tier->content !!}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </article>
        @endforeach
    </div>
</div>



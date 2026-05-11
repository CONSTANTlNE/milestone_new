<div class="pbmit-search-overlay">
    <div class="pbmit-icon-close">
        <svg class="qodef-svg--close qodef-m" xmlns="http://www.w3.org/2000/svg" width="28.163" height="28.163" viewbox="0 0 26.163 26.163">
            <rect width="36" height="1" transform="translate(0.707) rotate(45)"></rect>
            <rect width="36" height="1" transform="translate(0 25.456) rotate(-45)"></rect>
        </svg>
    </div>
    <div class="pbmit-search-outer">
        <form class="pbmit-site-searchform">
            <input type="search" class="form-control field searchform-s" name="s" placeholder="Search …">
            <button type="submit"></button>
        </form>
    </div>
</div>

<div class="pbmit-search-overlay">
    <div class="pbmit-icon-close">
        <svg class="qodef-svg--close qodef-m" xmlns="http://www.w3.org/2000/svg" width="28.163" height="28.163" viewbox="0 0 26.163 26.163">
            <rect width="36" height="1" transform="translate(0.707) rotate(45)"></rect>
            <rect width="36" height="1" transform="translate(0 25.456) rotate(-45)"></rect>
        </svg>
    </div>
    <div class="pbmit-search-outer">
        <form class="pbmit-site-searchform">
            <input type="search" class="form-control field searchform-s" name="s" placeholder="Search …">
            <button type="submit"></button>
        </form>
    </div>
</div>

<div class="pbmit-backtotop">
    <div class="pbmit-arrow">
        <i class="pbmit-base-icon-plane"></i>
    </div>
    <div class="pbmit-hover-arrow">
        <i class="pbmit-base-icon-plane"></i>
    </div>
</div>

{{--@if(getPageById(20) !== null or getPageById(19) !== null)--}}
{{--    <div class="pbmit-floating-quotation-buttons clients-buttons clients-mobile-buttons">--}}
{{--        @if(getPageById(19) !== null)--}}
{{--            <div class="pbmit-button transform-bottom transform-delay-4 mt-3">--}}
{{--                <a class="pbmit-btn" href="{{ route(getPageById(19)->template) }}">--}}
{{--                    <span class="pbmit-button-content-wrapper">--}}
{{--                        <span class="pbmit-button-text">{{getPageById(19)->title}}</span>--}}
{{--                    </span>--}}
{{--                </a>--}}
{{--            </div>--}}
{{--        @endif--}}
{{--        @if(getPageById(20) !== null)--}}
{{--            <div class="pbmit-button transform-bottom transform-delay-4 mt-3">--}}
{{--                <a class="pbmit-btn" href="{{ route(getPageById(20)->template) }}">--}}
{{--                    <span class="pbmit-button-content-wrapper">--}}
{{--                            <span class="pbmit-button-text">{{getPageById(20)->title}}</span>--}}
{{--                    </span>--}}
{{--                </a>--}}
{{--            </div>--}}
{{--        @endif--}}
{{--    </div>--}}
{{--@endif--}}

@include('frontend.layouts.consultation-drawer')
<div id="htmx-validation-errors"></div>
<script src="{{asset('assets/js/jquery.min.js')}}"></script>
<script src="{{asset('assets/js/popper.min.js')}}"></script>
<script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
<script src="{{asset('assets/js/jquery.waypoints.min.js')}}"></script>
<script src="{{asset('assets/js/jquery.appear.js')}}"></script>
<script src="{{asset('assets/js/numinate.min.js')}}"></script>
<script src="{{asset('assets/js/swiper.min.js')}}"></script>
<script src="{{asset('assets/js/jquery.magnific-popup.min.js')}}"></script>
<script src="{{asset('assets/js/circle-progress.js')}}"></script>
<script src="{{asset('assets/js/aos.js')}}"></script>
<script src="{{asset('assets/js/gsap.js')}}"></script>
<script src="{{asset('assets/js/ScrollTrigger.js')}}"></script>
<script src="{{asset('assets/js/SplitText.js')}}"></script>
<script src="{{asset('assets/js/theia-sticky-sidebar.js')}}"></script>
<script src="{{asset('assets/js/gsap-animation.js')}}"></script>
<script src="{{asset('assets/js/jquery-validate/jquery.validate.min.js')}}"></script>
<script src="{{asset('assets/js/scripts.js')}}"></script>
<script src="{{asset('assets/js/custom-htmx.js')}}"></script>
<script>
    document.body.addEventListener('htmx:afterOnLoad', function (e) {
        const reqType = e.detail.xhr.getResponseHeader('X-HTMX-Request-Type');
        if (!reqType ) return;

        const response = e.detail.xhr.responseText;
        const requestType = e.detail.elt?.dataset?.request;

        if (reqType === 'htmx_validation_errors') {
            document.getElementById('htmx-validation-errors').innerHTML = response;
        } else{
            htmxerrors=document.querySelectorAll('.htmx_errors')
            htmxerrors.forEach((error)=>{
                error.style.display='none'
            })
        }

        if(reqType === 'manual-otp'){
            if (response.includes('invalid') || response.includes('timeout')) {
                document.getElementById('code-invalid').innerHTML = response;
            } else if(response.includes('business')){
                document.getElementById('code-invalid-business').innerHTML = response;

            }

            else if(response.includes('validation')){
                document.getElementById('captcha-error').innerHTML = response;
            } else if(response.includes('resend')){
                document.getElementById('captcha-error-business').innerHTML = response;
            }
        }

        if(reqType === 'bsiness-otp-success'){
            document.getElementById('business_otp_target').innerHTML = response;
        }

        if(reqType === 'ind-quotation-success'){
            document.getElementById('adresses').innerHTML = response;
        }

    });

    document.body.addEventListener('htmx:afterSwap', function () {
        if (typeof window.initStaggerLetters === 'function') {
            window.initStaggerLetters();
        }
        if (typeof window.initRevealWipe === 'function') {
            window.initRevealWipe();
        }
    });

    // Consultation Drawer Functionality
    $(document).ready(function() {
        // Open consultation drawer
        $('#consultation-trigger').on('click', function(e) {
            e.preventDefault();
            $('#consultation-drawer').addClass('active');
            $('body').addClass('drawer-open');
        });

        // Close consultation drawer
        $('#consultation-close').on('click', function() {
            $('#consultation-drawer').removeClass('active');
            $('body').removeClass('drawer-open');
        });

        // Close drawer when clicking outside
        $('#consultation-drawer').on('click', function(e) {
            if (e.target === this) {
                $('#consultation-drawer').removeClass('active');
                $('body').removeClass('drawer-open');
            }
        });

        // Close drawer with Escape key
        $(document).on('keydown', function(e) {
            if (e.key === 'Escape' && $('#consultation-drawer').hasClass('active')) {
                $('#consultation-drawer').removeClass('active');
                $('body').removeClass('drawer-open');
            }
        });

        // Handle form submission
        $('.pbmit-consultation-form').on('submit', function(e) {
            e.preventDefault();

            // Get form data
            var formData = $(this).serialize();

            // Show loading state
            var submitBtn = $(this).find('button[type="submit"]');
            var originalText = submitBtn.find('.pbmit-button-text').text();
            submitBtn.find('.pbmit-button-text').text('Submitting...');
            submitBtn.prop('disabled', true);

            // Simulate form submission (replace with actual AJAX call)
            setTimeout(function() {
                // Reset button
                submitBtn.find('.pbmit-button-text').text(originalText);
                submitBtn.prop('disabled', false);

                // Show success message
                alert('Thank you! Your consultation request has been submitted. We will contact you soon.');

                // Close drawer
                $('#consultation-drawer').removeClass('active');
                $('body').removeClass('drawer-open');

                // Reset form
                $('.pbmit-consultation-form')[0].reset();
            }, 2000);
        });
    });

    // Floating Quotation Buttons Functionality
    $(document).ready(function() {
        var $quotationButtons = $('.pbmit-floating-quotation-buttons');
        var $window = $(window);
        var headerHeight = $('header').outerHeight() || 100;

        // Initially hide the buttons
        $quotationButtons.hide();

        // Show/hide buttons on scroll
        $window.scroll(function() {
            if ($window.scrollTop() > headerHeight) {
                $quotationButtons.fadeIn();
            } else {
                $quotationButtons.fadeOut();
            }
        });

        // Tooltip functionality
        $('.pbmit-quotation-button').hover(
            function() {
                $(this).find('.pbmit-quotation-tooltip').fadeIn(200);
            },
            function() {
                $(this).find('.pbmit-quotation-tooltip').fadeOut(200);
            }
        );
    });

    // Header Tooltip Functionality
    $(document).ready(function() {
        $('.pbmit-tooltip-container').hover(
            function() {
                $(this).find('.pbmit-custom-tooltip').fadeIn(200);
            },
            function() {
                $(this).find('.pbmit-custom-tooltip').fadeOut(200);
            }
        );
    });

</script>

@yield('scripts')
@stack('scripts')

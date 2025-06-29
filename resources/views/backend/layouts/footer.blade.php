<footer class="footer mt-auto xl:ps-[15rem]  font-normal font-inter bg-white text-defaultsize leading-normal text-[0.813] shadow-[0_0_0.4rem_rgba(0,0,0,0.1)] dark:bg-bodybg py-4 text-center">
    <div class="container">
        <span class="text-gray dark:text-defaulttextcolor/50 font-second-geo">
            © <span id="year"></span>
            <a href="{{config('app.url_footer')}}" target="_blank" class="text-defaulttextcolor font-semibold dark:text-defaulttextcolor font-second-geo">
                {{ __('admin.footer_title') }},
            </a>
            {{ __('admin.all_rights_reserved') }}
        </span>
    </div>
</footer>
<div class="scrollToTop">
    <span class="arrow"><i class="ri-arrow-up-s-fill text-xl"></i></span>
</div>
<div id="responsive-overlay"></div>

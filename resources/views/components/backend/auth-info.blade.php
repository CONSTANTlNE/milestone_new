<div class="xxl:col-span-5 xl:col-span-5 lg:col-span-5 col-span-12 xl:block hidden px-0">
    <div class="authentication-cover">
        <div class="authentication-cover-content rounded">
            <div class="keyboard-control">
                <div class="text-white text-center p-[3rem] flex items-center justify-center">
                    <div>
                        <div class="mb-[3rem]">
                            <img src="{{ asset(config('filemanager.default_auth_company_image')) }}" class="authentication-image" alt="{{ __('config.company_title') }}">
                        </div>
{{--                        <h6 class="font-semibold text-[1rem] font-first-geo">{{ __('config.company_title') }}</h6>--}}
{{--                        <p class="font-normal text-[.875rem] opacity-[0.7] font-second-geo"> {{ __('config.company_text') }} </p>--}}
                        <p class="text-[0.75rem] mt-4 font-second-geo">© {{ now()->format('Y') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if(count((array)getLocales()) > 1)
<div class="header-element py-[1rem] md:px-[0.65rem] px-2  header-country hs-dropdown ti-dropdown  hidden sm:block [--placement:bottom-left]">
    <button id="dropdown-flag" type="button"
            class="main-locale hs-dropdown-toggle ti-dropdown-toggle !p-0 flex-shrink-0  !border-0 !rounded-full !shadow-none font-second-geo">
        <img src="{{ asset(getLangName(app()->getLocale())->image ?? asset(config('filemanager.default_backend_image'))) }}" alt="logo language" title="logo language" width="30" height="30">
        {{ getLangName(app()->getLocale())->title }}
    </button>

    <div class="hs-dropdown-menu ti-dropdown-menu min-w-[10rem] hidden !-mt-3" aria-labelledby="dropdown-flag">
        <div class="ti-dropdown-divider divide-y divide-gray-200 dark:divide-white/10">
            <div class="py-2 first:pt-0 last:pb-0">
                <div class="ti-dropdown-item !p-[0.65rem] ">
                    @foreach(getLocales() as $locale)
                        @if(app()->getLocale() != $locale->code)
                            <div class="flex items-center space-x-2 rtl:space-x-reverse w-full">

{{--                                @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)--}}
{{--                                    <li>--}}
{{--                                        <a rel="alternate" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">--}}
{{--                                            {{ $properties['native'] }}--}}
{{--                                        </a>--}}
{{--                                    </li>--}}
{{--                                @endforeach--}}

                                <a href="{{ LaravelLocalization::getLocalizedURL($locale->code, null, [], true) }}" hreflang="{{ $locale->code }}" class="language-link flex">
                                    <div class="flex items-center">
                                        <img src="{{ asset($locale->image ?? asset(config('filemanager.default_backend_image'))) }}" alt="flag-img"
                                             width="30" height="30">
                                    </div>
                                    <div>
                                        <p class="!text-[0.8125rem] font-bold font-second-geo uppercase second-locale">
                                            {{ $locale->title }}
                                        </p>
                                    </div>
                                </a>
                            </div>
                        @endif
                    @endforeach
                    @can('backend.locales.index')
                    <div class="empty-header-item1 border-t mt-2">
                        <div class="grid">
                            <a href="{{route('backend.locales.index')}}" class="ti-btn ti-btn-outline-primary !m-0 w-full p-1 font-second-geo" style="font-size: 11px;padding: 5px !important;">{{ __('admin.view_all_locales') }}</a>
                        </div>
                    </div>
                    @else
                    <div class="empty-header-item1 border-t mt-2" style="max-width: 137px;">
                        <div class="grid">
                            <p class="ti-btn ti-btn-danger-full !m-0 w-full p-1 font-second-geo" style="font-size: 11px;padding: 2px 5px !important;">{{ __('admin.no_view_all_locales') }}</p>
                        </div>
                    </div>
                    @endcan
                </div>
            </div>
        </div>
    </div>
</div>
@endif

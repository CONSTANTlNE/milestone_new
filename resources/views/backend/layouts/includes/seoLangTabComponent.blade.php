<div class="border-b-0 border-gray-200 dark:border-white/10 content-seo">
    <nav class="flex space-x-2 rtl:space-x-reverse tablist" aria-label="Tabs" role="tablist">
        <button
            type="button"
            class="font-second-geo hs-tab-active:bg-white hs-tab-active:border-b-transparent hs-tab-active:text-primary dark:hs-tab-active:bg-transparent dark:hs-tab-active:border-b-white/10 dark:hs-tab-active:text-primary -mb-px py-2 px-3 inline-flex items-center gap-2 bg-gray-50 text-sm font-medium text-center border text-defaulttextcolor rounded-t-sm hover:text-primary dark:bg-black/20 dark:border-white/10 dark:text-[#8c9097] dark:text-white/50 dark:hover:text-gray-300 active"
            id="content-locale-item-{{$code}}"
            data-hs-tab="#content-locale-{{$code}}"
            aria-controls="content-locale-{{$code}}"
        >
            {{ __('admin.content') }}
        </button>
        <button
            type="button"
            class="font-second-geo hs-tab-active:bg-white hs-tab-active:border-b-transparent hs-tab-active:text-primary dark:hs-tab-active:bg-transparent dark:hs-tab-active:border-b-white/10 dark:hs-tab-active:text-primary -mb-px py-2 px-3 inline-flex items-center gap-2 bg-gray-50 text-sm font-medium text-center border text-defaulttextcolor rounded-t-sm hover:text-primary dark:bg-black/20 dark:border-white/10 dark:text-[#8c9097] dark:text-white/50 dark:hover:text-gray-300"
            id="seo-locale-item-{{$code}}"
            data-hs-tab="#seo-locale-{{$code}}"
            aria-controls="seo-locale-{{$code}}"
        >
            {{ __('admin.seo') }}
        </button>

        @if(!empty($service))
        <button
            type="button"
            class="font-second-geo hs-tab-active:bg-white hs-tab-active:border-b-transparent hs-tab-active:text-primary dark:hs-tab-active:bg-transparent dark:hs-tab-active:border-b-white/10 dark:hs-tab-active:text-primary -mb-px py-2 px-3 inline-flex items-center gap-2 bg-gray-50 text-sm font-medium text-center border text-defaulttextcolor rounded-t-sm hover:text-primary dark:bg-black/20 dark:border-white/10 dark:text-[#8c9097] dark:text-white/50 dark:hover:text-gray-300"
            id="faqs-locale-item-{{$code}}"
            data-hs-tab="#faqs-locale-{{$code}}"
            aria-controls="faqs-locale-{{$code}}"
        >
            {{ __('admin.faqs') }}
        </button>

        <button
            type="button"
            class="font-second-geo hs-tab-active:bg-white hs-tab-active:border-b-transparent hs-tab-active:text-primary dark:hs-tab-active:bg-transparent dark:hs-tab-active:border-b-white/10 dark:hs-tab-active:text-primary -mb-px py-2 px-3 inline-flex items-center gap-2 bg-gray-50 text-sm font-medium text-center border text-defaulttextcolor rounded-t-sm hover:text-primary dark:bg-black/20 dark:border-white/10 dark:text-[#8c9097] dark:text-white/50 dark:hover:text-gray-300"
            id="feature-locale-item-{{$code}}"
            data-hs-tab="#feature-locale-{{$code}}"
            aria-controls="feature-locale-{{$code}}"
        >
            {{ __('admin.feature') }}
        </button>
        @endif
    </nav>
</div>

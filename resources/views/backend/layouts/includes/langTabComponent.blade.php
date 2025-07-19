<div class="sm:flex bg-gray-200 transition p-3 dark:bg-black/20 dark:hover:bg-black/20">
    <nav class="flex space-x-2 rtl:space-x-reverse tablist" aria-label="Tabs" role="tablist">
        @foreach(getLocales() as $k => $l)
            <button
                type="button"
                class="font-second-geo hs-tab-active:bg-primary hs-tab-active:text-white dark:hs-tab-active:bg-transparent dark:hs-tab-active:text-primary -mb-px py-2 px-3 inline-flex items-center gap-2 bg-white text-lg font-medium text-center text-defaulttextcolor hover:text-primary dark:bg-black/20 dark:text-[#8c9097] dark:text-white/50 dark:hover:text-gray-300 {{(getLocaleGeneral()->code == $l->code) ? 'active' : ''}}"
                id="locale-item-{{$l->code}}"
                data-hs-tab="#locale-{{$l->code}}"
                aria-controls="locale-{{$l->code}}"
            >
                {{$l->title}}
            </button>
        @endforeach
    </nav>
</div>

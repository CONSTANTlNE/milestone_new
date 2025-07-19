

<div class="box">
    <div class="box-header">
        <h5 class="box-title">Edit Features</h5>
    </div>
    <div class="box-body">
        <div class="border-b-0 border-gray-200 dark:border-white/10">
            <nav class="flex space-x-2 rtl:space-x-reverse justify-center" aria-label="Tabs" role="tablist">
                @foreach($locales as $localeindex => $locale)
                    <button type="button"
                            class="hs-tab-active:bg-white hs-tab-active:border-b-transparent hs-tab-active:text-primary dark:hs-tab-active:bg-transparent dark:hs-tab-active:border-b-white/10 dark:hs-tab-active:text-primary -mb-px py-2 px-3 inline-flex items-center gap-2 bg-gray-50 text-sm font-medium text-center border text-defaulttextcolor rounded-t-sm hover:text-primary dark:bg-black/20 dark:border-white/10 dark:text-[#8c9097] dark:text-white/50 dark:hover:text-gray-300 {{$loop->first ? 'active' : ''}}"
                            id="hs-tab-js-behavior-item-{{$localeindex}}"
                            data-hs-tab="#hs-tab-js-behavior-{{$localeindex}}"
                            aria-controls="hs-tab-js-behavior-{{$localeindex}}">
                        {{$locale->abbr}}
                    </button>
                @endforeach
            </nav>
        </div>

        <div class="">
            @foreach($locales as $localeindex2 =>$locale2)
                <div id="hs-tab-js-behavior-{{$localeindex2}}" class="{{ !$loop->first ? 'hidden' : '' }}"
                     role="tabpanel" aria-labelledby="hs-tab-js-behavior-item-{{$localeindex2}}"
                     style="padding-top: 15px">

                    {{--   Features  --}}
                    <div class="mt-3 flex justify-center">
                        @foreach($locales as $localeindex5 =>$locale5)
                            @if($locale2->abbr==$locale5->abbr)
                                <div id="cardContainer{{$locale5->abbr}}" class="w-full">
                                    @foreach($service->features as $feature)
                                        <div class="card{{$locale5->abbr}} mt-2">
                                            <div class="flex rounded-sm gap-4">
                                                <div class="flex w-full">
                                                    <span class="px-4 inline-flex items-center min-w-fit rounded-s-sm border-e-0 border-gray-200 bg-light text-sm text-gray-500 dark:bg-black/20 dark:border-white/10 dark:text-[#8c9097] dark:text-white/50">
                                                        Feature Name - {{$locale5->abbr}}
                                                    </span>
                                                    <input form="service_form"
                                                           name="service_feature_name_{{$locale5->abbr}}[]" type="text"
                                                           class="py-2 px-3 ti-form-input rounded-none rounded-e-sm focus:z-10 !border-s-0">
                                                </div>
                                                <button data-removefeature="0" class="removebtn" style="color:red">
                                                    <i style="font-size: 2rem" class="ri-subtract-line"></i>
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach

                        @foreach($locales as $localeindex6 =>$locale6)
                            @if($locale2->abbr==$locale6->abbr)
                                <template id="cardTemplate{{$locale6->abbr}}">
                                    <div class="card{{$locale6->abbr}} mt-2">
                                        <div class="flex rounded-sm gap-4">
                                            <div class="flex w-full">
                                                    <span class="px-4 inline-flex items-center min-w-fit rounded-s-sm border-e-0 border-gray-200 bg-light text-sm text-gray-500 dark:bg-black/20 dark:border-white/10 dark:text-[#8c9097] dark:text-white/50">
                                                        Feature Name - {{$locale6->abbr}}
                                                    </span>
                                                <input form="service_form"
                                                       name="service_feature_name_{{$locale6->abbr}}[]" type="text"
                                                       class="py-2 px-3 ti-form-input rounded-none rounded-e-sm focus:z-10 !border-s-0">
                                            </div>
                                            <button data-removefeature="0" class="removebtn" style="color:red">
                                                <i style="font-size: 2rem" class="ri-subtract-line"></i>
                                            </button>
                                        </div>
                                    </div>
                                </template>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
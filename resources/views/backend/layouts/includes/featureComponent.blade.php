<div class="hidden py-2 px-3" id="feature-locale-{{$code}}" role="tabpanel" aria-labelledby="feature-locale-item-{{$code}}">
    <template id="cardTemplate{{$code}}">
        <div class="feature-section card{{$code}}">
            <div class="flex rounded-sm gap-4 mt-3">
                <div class="flex w-full">
                    <span class="px-4 inline-flex items-center min-w-fit rounded-s-sm border-e-0 border-gray-200 bg-light text-sm text-gray-500 dark:bg-black/20 dark:border-white/10 dark:text-[#8c9097] dark:text-white/50 font-second-geo">
                        {{ __('admin.feature_title') }} - {{$code}}
                    </span>
                    <input form="form"
                           name="service_feature_name_{{$code}}[]" type="text"
                           class="py-2 px-3 ti-form-input rounded-none rounded-e-sm focus:z-10 !border-s-0 font-second-geo">
                </div>
                <button data-removefeature="0" class="removebtn" style="color:red">
                    <i style="font-size: 2rem" class="ri-subtract-line"></i>
                </button>
            </div>
        </div>
    </template>
    <div id="cardContainer{{$code}}" class="w-full"></div>
    <button onclick="addCard()" type="button" class="ti-btn ti-btn-light ti-btn-wave mt-5 font-second-geo">
        {{ __('admin.add_feature') }}
    </button>
</div>

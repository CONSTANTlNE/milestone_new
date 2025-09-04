<div id="tiers-locale-{{$code}}" class="hidden py-2 px-3" role="tabpanel" aria-labelledby="tiers-locale-item-{{$code}}">
    @if(!empty($data))
        <div id="tierContainer{{$code}}" class="w-full">
            @foreach($data as $tierindex => $existingtier)
                <div class="card mt-2">
                    <div class="flex flex-col rounded-sm gap-4 existingtier{{$existingtier->id}}">
                        <div class="flex w-full">
                                <span class="px-4 inline-flex items-center min-w-fit rounded-s-sm border-e-0 border-gray-200 bg-light text-sm text-gray-500 dark:bg-black/20 dark:border-white/10 dark:text-[#8c9097] dark:text-white/50">
                                    {{ __('admin.title') }} - {{$code}}
                                </span>
                            <input form="form"
                                   name="tier_title_{{$code}}[]"
                                   type="text"
                                   value="{{$existingtier->getTranslation('title',$code)}}"
                                   class="py-2 px-3 ti-form-input rounded-none rounded-e-sm focus:z-10 !border-s-0">
                        </div>
                        <div>
                                <span class="px-4 inline-flex items-center min-w-fit rounded-s-sm border-e-0 border-gray-200 bg-light text-sm text-gray-500 dark:bg-black/20 dark:border-white/10 dark:text-[#8c9097] dark:text-white/50">
                                    {{ __('admin.content') }} -  {{$code}}
                                </span>
                            <textarea form="form"
                                      name="tier_content_{{$code}}[]"
                                      class="ti-form-input" rows="3"
                                      placeholder="">{{$existingtier->getTranslation('content',$code)}}</textarea>
                        </div>
                        <button type="button"
                                onclick="removeExistingtier({{$existingtier->id}})"
                                class="ti-btn ti-btn-danger-full ti-btn-wave removetier">
                            {{ __('admin.remove') }}
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
    <template id="tierTemplate{{$code}}">
        <div class="tiers-section card{{$code}}">
            <div class="flex flex-col rounded-sm gap-4 mt-3">
                <div class="flex w-full">
                    <span class="px-4 inline-flex items-center min-w-fit rounded-s-sm border-e-0 border-gray-200 bg-light text-sm text-gray-500 dark:bg-black/20 dark:border-white/10 dark:text-[#8c9097] dark:text-white/50">
                        {{ __('admin.title') }} - {{$code}}
                    </span>
                    <input form="form"
                           name="tier_title_{{$code}}[]" type="text"
                           class="py-2 px-3 ti-form-input rounded-none rounded-e-sm focus:z-10 !border-s-0">
                </div>
                <div>
                    <span class="px-4 inline-flex items-center min-w-fit rounded-s-sm border-e-0 border-gray-200 bg-light text-sm text-gray-500 dark:bg-black/20 dark:border-white/10 dark:text-[#8c9097] dark:text-white/50">
                        {{ __('admin.content') }} -  {{$code}}
                    </span>
                    <textarea form="form" name="tier_content_{{$code}}[]" class="ti-form-input" rows="3"
                              placeholder=""></textarea>
                </div>
                <button type="button" class="ti-btn ti-btn-danger-full ti-btn-wave removetier">{{ __('admin.remove') }}</button>
            </div>
        </div>
    </template>


    <div id="tierContainer{{$code}}" class="w-full"></div>
    <button onclick="addTier()" type="button" class="ti-btn ti-btn-light ti-btn-wave mt-5">
        {{ __('admin.add_tier') }}
    </button>
</div>

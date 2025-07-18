<div id="faqs-locale-{{$code}}" class="hidden py-2 px-3" role="tabpanel" aria-labelledby="faqs-locale-item-{{$code}}">
    <template id="faqTemplate{{$code}}">
        <div class="faqs-section card{{$code}}">
            <div class="flex flex-col rounded-sm gap-4 mt-3">
                <div class="flex w-full">
                    <span class="px-4 inline-flex items-center min-w-fit rounded-s-sm border-e-0 border-gray-200 bg-light text-sm text-gray-500 dark:bg-black/20 dark:border-white/10 dark:text-[#8c9097] dark:text-white/50">
                        {{ __('admin.question') }} - {{$code}}
                    </span>
                    <input form="form"
                           name="faq_question_{{$code}}[]" type="text"
                           class="py-2 px-3 ti-form-input rounded-none rounded-e-sm focus:z-10 !border-s-0">
                </div>
                <div>
                    <span class="px-4 inline-flex items-center min-w-fit rounded-s-sm border-e-0 border-gray-200 bg-light text-sm text-gray-500 dark:bg-black/20 dark:border-white/10 dark:text-[#8c9097] dark:text-white/50">
                        {{ __('admin.answer') }} -  {{$code}}
                    </span>
                    <textarea form="form" name="faq_answer_{{$code}}[]" class="ti-form-input" rows="3"
                              placeholder=""></textarea>
                </div>
                <button type="button" class="ti-btn ti-btn-danger-full ti-btn-wave removefaq">{{ __('admin.remove_question') }}</button>
            </div>
        </div>
    </template>
    <div id="faqContainer{{$code}}" class="w-full"></div>
    <button onclick="addFaq()" type="button" class="ti-btn ti-btn-light ti-btn-wave mt-5">
        {{ __('admin.add_faq') }}
    </button>
</div>

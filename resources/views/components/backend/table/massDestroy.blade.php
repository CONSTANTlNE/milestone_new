@props([
    'url' => ''
])
<div>
    <button type="button"
    class="ti-btn bg-danger text-white !font-medium font-second-geo"
    id="delete-selected"
    data-url="{{ $url }}"
    data-translated-plural-question ="{{ __('admin.translated_plural_question') }}"
    data-translated-plural-selected-items ="{{ __('admin.translated_plural_selected_items') }}"
    data-translated-plural-text ="{{ __('admin.translated_plural_text') }}"
    data-cancel ="{{ __('admin.cancel') }}"
    data-delete ="{{ __('admin.delete') }}"
    disabled>
        <i class="ri-delete-bin-3-line text-[.75rem]"></i>
        {{__('admin.all_deleted')}}
    </button>
</div>

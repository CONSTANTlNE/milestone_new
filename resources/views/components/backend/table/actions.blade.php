@props([
    'model' => null,
    'showView' => '',
    'showEdit' => '',
    'showDelete' => '',
    'showRemove' => '',
    'showRestore' => ''
    ])

<div class="hstack flex gap-3 text-[.9375rem]">
    @if($showView)
        <a href="{{ route($showView, $model->id) }}"
           class="ti-btn ti-btn-icon ti-btn-sm ti-btn-info-full view-item"
           title="{{ __('admin.view') }}">
            <i class="ri-eye-line"></i>
        </a>
    @endif

    @if($showEdit)
        <a href="{{ route($showEdit, $model->id) }}"
           class="ti-btn ti-btn-icon ti-btn-sm ti-btn-warning-full edit-item"
           title="{{ __('admin.edit') }}">
            <i class="ri-edit-line"></i>
        </a>
    @endif

    @if($showDelete)
        <button type="button"
                class="ti-btn ti-btn-icon ti-btn-sm ti-btn-danger-full delete-item"
                data-id="{{ $model->id }}"
                data-name="{{ $model->title }}"
                data-translated-single-question ="{{ __('admin.translated_single_question') }}"
                data-translated-single-text ="{{ __('admin.translated_single_text') }}"
                data-cancel ="{{ __('admin.cancel') }}"
                data-delete ="{{ __('admin.delete') }}"
                data-url="{{ route($showDelete, $model->id) }}"
                >
            <i class="ri-delete-bin-line"></i>
        </button>
    @endif

    @if($showRestore)
        <button type="button"
                class="ti-btn ti-btn-secondary-full label-ti-btn restore-item"
                data-id="{{ $model->id }}"
                data-name="{{ $model->title }}"
                data-translated-single-question="{{ __('admin.translated_single_restore_question') }}"
                data-translated-single-text="{{ __('admin.translated_single_restore_text') }}"
                data-cancel="{{ __('admin.cancel') }}"
                data-restore="{{ __('admin.restore') }}"
                data-url="{{ route($showRestore, $model->id) }}"
                title="{{ __('admin.restore') }}">
            <i class="ri-arrow-left-line label-ti-btn-icon me-2"></i> {{ __('admin.restore') }}
        </button>
    @endif

    @if($showRemove)
        <button type="button"
                class="ti-btn ti-btn-danger-full label-ti-btn delete-item"
                data-id="{{ $model->id }}"
                data-name="{{ $model->title }}"
                data-translated-single-question ="{{ __('admin.translated_single_last_question') }}"
                data-translated-single-text ="{{ __('admin.translated_single_last_text') }}"
                data-cancel ="{{ __('admin.cancel') }}"
                data-delete ="{{ __('admin.last_delete') }}"
                data-url="{{ route($showRemove, $model->id) }}"
                title="{{ __('admin.last_delete') }}">
            <i class="ri-delete-bin-2-fill label-ti-btn-icon me-2"></i> {{ __('admin.last_delete') }}
        </button>
    @endif
</div>

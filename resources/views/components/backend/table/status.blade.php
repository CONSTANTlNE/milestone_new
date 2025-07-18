@props([
    'model' => null,
    'statusUrl' => null,
    'showLabel' => false
])

@php
    $modelId = $model->id ?? $model;
    $status = $model->has_backend_access ? $model->has_backend_access : $model->status;
    $url = $statusUrl
@endphp

<div class="flex form-check form-switch">
    <input type="checkbox"
           id="status-toggle-{{ $modelId }}"
           class="ti-switch status-toggle"
           data-id="{{ $modelId }}"
           data-url="{{ $url }}"
           {{ $status ? 'checked' : '' }}>
    @if($showLabel)
        <label for="status-toggle-{{ $modelId }}" class="hidden text-sm text-gray-500 ms-3 dark:text-[#8c9097] dark:text-white/50 status-text-{{ $modelId }}">
            {{ $status ? __('admin.active') : __('admin.inactive') }}
        </label>
    @endif
</div>

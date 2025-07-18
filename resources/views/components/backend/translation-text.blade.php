@props([
    'model' => null,
    'field' => 'title',
    'limit' => 40,
    'locale' => null
])

@php
    $currentLocale = $locale ?: app()->getLocale();
    $translations = $model->getTranslations($field);
    $currentTranslation = Arr::get($translations, $currentLocale);
@endphp

@if ($currentTranslation === null)
    @php
        $availableKeys = array_keys($translations);
    @endphp
    {{ __('admin.translationTitle') . ' (' . __('admin.translated') . ' ' . implode(', ', $availableKeys) . ')' }}
@else
    {{ Str::limit($model->getTranslation($field, $currentLocale), $limit) }}
@endif 
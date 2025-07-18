@props([
    'src' => null,
    'alt' => 'image',
    'title' => 'image',
    'class' => '',
    'fallback' => null
])

@php
    $imageSrc = $src ?: ($fallback ?: config('filemanager.default_backend_image'));
@endphp

<img src="{{ asset($imageSrc) }}"
     alt="{{ $alt }}"
     title="{{ $title }}"
     class="{{ $class }}"
     loading="lazy">

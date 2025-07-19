@props([
    'src' => null,
    'alt' => 'image',
    'title' => 'image',
    'width' => '30',
    'height' => '30',
    'class' => '',
    'fallback' => null
])

@php
    $imageSrc = $src ?: ($fallback ?: config('filemanager.default_backend_image'));
@endphp

<img src="{{ asset($imageSrc) }}"
     alt="{{ $alt }}"
     title="{{ $title }}"
     width="{{ $width }}"
     height="{{ $height }}"
     class="{{ $class }}"
     loading="lazy"> 
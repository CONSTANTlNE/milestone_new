@props([
    'type' => 'light',
    'text' => '',
    'class' => ''
])

@php
    $typeClasses = [
        'light' => 'bg-light text-dark',
        'primary' => 'bg-primary text-white',
        'secondary' => 'bg-secondary text-white',
        'success' => 'bg-success text-white',
        'danger' => 'bg-danger text-white',
        'warning' => 'bg-warning text-white',
        'info' => 'bg-info text-white',
        'dark' => 'bg-dark text-white',
    ];
    
    $typeClass = $typeClasses[$type] ?? $typeClasses['light'];
@endphp

<span class="badge {{ $typeClass }} {{ $class }} font-second-geo">
    {{ $text }}
</span> 
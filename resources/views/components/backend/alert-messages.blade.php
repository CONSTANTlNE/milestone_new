@props([
    'success' => null,
    'error' => null,
    'warning' => null,
    'info' => null
])

<div class="alert-message">
    @if($success || session('success'))
        <x-backend.alert type="success" :message="$success ?: session('success')" />
    @endif

    @if($error || session('error'))
        <x-backend.alert type="error" :message="$error ?: session('error')" />
    @endif

    @if($warning || session('warning'))
        <x-backend.alert type="warning" :message="$warning ?: session('warning')" />
    @endif

    @if($info || session('info'))
        <x-backend.alert type="info" :message="$info ?: session('info')" />
    @endif
</div> 
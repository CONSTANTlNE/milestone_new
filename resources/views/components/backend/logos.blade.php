<div class="{{ $wrapperClass ?? 'horizontal-logo' }}">
    <a href="{{ route('backend.index') }}" class="header-logo">
        <img src="{{ asset(config('filemanager.logos.desktop')) }}" alt="logo" class="desktop-logo">
        <img src="{{ asset(config('filemanager.logos.toggle')) }}" alt="logo" class="toggle-logo">
        <img src="{{ asset(config('filemanager.logos.desktop_dark')) }}" alt="logo" class="desktop-dark">
        <img src="{{ asset(config('filemanager.logos.toggle_dark')) }}" alt="logo" class="toggle-dark">
        <img src="{{ asset(config('filemanager.logos.desktop_white')) }}" alt="logo" class="desktop-white">
        <img src="{{ asset(config('filemanager.logos.toggle_white')) }}" alt="logo" class="toggle-white">
    </a>
</div>

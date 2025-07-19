<button id="general-{{$locale->id}}"
        type="button"
        hx-post="{{ route('backend.locales.general', [app()->getLocale(), 'id'=>$locale->code]) }}"
        hx-trigger="click"
        hx-target="#general-{{$locale->id}}"
        hx-swap="outerHTML"
        class="btn btn-lg btn-toggle btn-toggle-switch {{ $locale->default === 0 ? "" : "active" }}"
        data-toggle="button"
        aria-pressed="false"
        autocomplete="off">
    <div class="switch"></div>
</button>

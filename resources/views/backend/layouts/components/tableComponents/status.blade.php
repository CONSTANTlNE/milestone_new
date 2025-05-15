@if($locale->default != 1)
    <div class="form-switch mr-3">
        <button
            id="status-{{$locale->id}}"
            type="button"
            hx-post="{{ route('backend.locales.status', [app()->getLocale(), 'id'=>$locale->id]) }}"
            hx-trigger="click"
            hx-target="#parent-{{$locale->id}}"
            hx-swap="innerHTML"
            class="btn btn-lg btn-toggle btn-toggle-switch {{ $locale->status === 1 ? "active" : "" }}"
            data-toggle="button"
            aria-pressed="false"
            autocomplete="off">
            <div class="switch"></div>
        </button>
    </div>
@else
    <span style="width: 110px;font-size: 12px;display: block;">მთავარ ენას არ ეცვლება სტატუსი</span>
@endif

@can($restoreGate)
    <a href="{{ route($restoreGate, [app()->getLocale(), $row->id]) }}"
       class="btn btn-success shadow btn-xs sharp restore" style="color: #fff">
        <i class="flaticon-381-back-2"></i>
        <span>{{ __('strings.Restore') }}</span>
    </a>
@endcan
@can($removeGate)
    <form action="{{ route($removeGate, [app()->getLocale(), $row->id]) }}" method="POST" class="action-list d-inline-block last-delete" onsubmit="return confirm('{{ __('strings.Really Final Deletion') }}');">
        @csrf
        @method('DELETE')
        <input type="hidden" name="id" value="{{ $row->id }}">
        <button class="btn btn-danger shadow btn-xs sharp">
            <i class="flaticon-381-trash-2"></i>
            <span>{{ __('strings.Final Deletion') }}</span>
        </button>
    </form>
@endcan

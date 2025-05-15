@can($restoreGate)
    <a class="btn btn-success btn-sm action-list" href="{{ route($restoreGate, [app()->getLocale(), 'id'=>$row->id]) }}">
        {{ wordKey('Recovery') }}
    </a>
@endcan
@can($removeGate)
    <form action="{{ route($removeGate, [app()->getLocale(), 'id'=>$row->id]) }}" method="POST" class="action-list" onsubmit="return confirm('ნამდვილად გსურს წაშლა!');" style="display: inline-block;">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <button class="btn btn-danger btn-sm">{{ wordKey('Delete') }}</button>
    </form>
@endcan
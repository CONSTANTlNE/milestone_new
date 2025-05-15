@if($row->rowParent)
    {{ $row->rowParent->getTranslation('title', app()->getLocale()) }}
@else
    <span>.....</span>
@endif
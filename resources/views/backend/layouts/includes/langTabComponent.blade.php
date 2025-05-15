<ul class="nav nav-pills mb-4">
    @foreach(getLocales() as $k => $l)
        <li class="nav-item">
            <a class="nav-link {{(getLocaleGeneral()->code == $l->code) ? 'active' : ''}}" data-toggle="tab" href="#locale-{{$l->code}}" role="tab">
                {{$l->name}}
            </a>
        </li>
    @endforeach
</ul>

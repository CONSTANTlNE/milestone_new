@if(count((array)getLocales()) > 1)
    <nav class="locales">
        <ul class="navigation clearfix">
            <li class="dropdown">
                <a href="#">
                    {{ getLangName(app()->getLocale())->code }}
                </a>
                <ul>
                    @foreach(getLocales() as $locale)
                        @if(app()->getLocale() != $locale->code)
                            <li>
                                <a href="{{ LaravelLocalization::getLocalizedURL($locale->code, null, [], true) }}" hreflang="{{ $locale->code }}">
                                    {{ $locale->code }}
                                </a>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </li>
        </ul>
    </nav>
@endif

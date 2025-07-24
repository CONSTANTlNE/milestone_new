@if(count((array)getLocales()) > 1)
<div class="locales-wrapper">
    <nav class="main-menu navbar-expand-xl navbar-light">
        <div class="collapse navbar-collapse clearfix show">
            <div class="pbmit-menu-wrap">
                <ul class="navigation clearfix">
                    <li class="dropdown">
                        <a href="#">
                            {{ getLangName(app()->getLocale())->title }}
                        </a>
                        <ul>
                            @foreach(getLocales() as $locale)
                                @if(app()->getLocale() != $locale->code)
                                    <li>
                                        <a href="{{ LaravelLocalization::getLocalizedURL($locale->code, null, [], true) }}" hreflang="{{ $locale->code }}">
                                            {{ $locale->title }}
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</div>
@endif

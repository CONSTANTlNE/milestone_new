<div class="site-navigation">
    <nav class="main-menu navbar-expand-xl navbar-light">
        <div class="navbar-header">
            <!-- Toggle Button -->
            <button class="navbar-toggler" type="button">
                <i class="pbmit-base-icon-menu-1"></i>
            </button>
        </div>
        <div class="pbmit-mobile-menu-bg"></div>
        <div class="collapse navbar-collapse clearfix show" id="pbmit-menu">
            <div class="pbmit-menu-wrap">
                <span class="closepanel">
                    <svg class="qodef-svg--close qodef-m" xmlns="http://www.w3.org/2000/svg" width="20.163" height="20.163" viewbox="0 0 26.163 26.163">
                        <rect width="36" height="1" transform="translate(0.707) rotate(45)"></rect>
                        <rect width="36" height="1" transform="translate(0 25.456) rotate(-45)"></rect>
                    </svg>
                </span>

                <ul class="navigation clearfix">
                    @foreach ($mainMenus as $menu)
                        <li class="{{$menu->children->isNotEmpty() ? 'dropdown' :''}}">
                            <a href="{{ $menu->is_prefix ? route($menu->route, ['id'=>$menu->model_id, 'slug'=>$menu->getTranslation('slug', app()->getLocale())]) : route($menu->route)}}">
                                {{$menu->getTranslation('title', app()->getLocale()) ?? 'N/A'}}
                            </a>
                            @if($menu->children->isNotEmpty())
                                <ul>
                                    @foreach($menu->children as $child)
                                        <li>
                                            <a href="{{ $child->is_prefix ? route($child->route, [ 'id'=>$child->model_id, 'slug'=>$child->getTranslation('slug', app()->getLocale())]) : route($child->route)}}">
                                                {{$child->getTranslation('title', app()->getLocale()) ?? 'N/A'}}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </nav>
</div>

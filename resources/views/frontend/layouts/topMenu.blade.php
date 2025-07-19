 <div class="top-menu" id="header_main_menu">
     <div class="nav-mobile"><a id="top-menu-toggle" href="#!"><span></span><span></span><span></span></a></div>
    <ul>
    	@foreach ($topMenus as $menu)
    		@unless(is_null($menu->title))
                <li class="{{$menu->children->isNotEmpty() ? 'with-sub' : ''}}">
                    <a href="{{ $menu->is_prefix ? route("frontend.".$menu->prefix, [app()->getLocale(), 'id'=>$menu->model_id, 'slug'=>$menu->getTranslation('slug', app()->getLocale())]) : route("frontend.".$menu->prefix, [app()->getLocale()])}}">
                        {{$menu->getTranslation('title', app()->getLocale())}}
                    </a>
                    @if($menu->children->isNotEmpty())
                        <ol>
                            @foreach($menu->children as $child)
                                <li>
                                    <a href="{{ $child->is_prefix ? route("frontend.".$child->prefix, [app()->getLocale(), 'id'=>$child->model_id, 'slug'=>$child->getTranslation('slug', app()->getLocale())]) : route("frontend.".$child->prefix, [app()->getLocale()])}}">
                                        {{$child->getTranslation('title', app()->getLocale())}}
                                    </a>
                                </li>
                            @endforeach
                        </ol>
                    @endif
                </li>
			@endunless
		@endforeach
    </ul>
 </div>

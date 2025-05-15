@extends('backend.layouts.master')
@section('title') {{ __('strings.All MenuTrait') }} @endsection
@push('styles')
    <link href="{{asset('admin/menu/style.css')}}" rel="stylesheet">
@endpush
@section('content')
    <?php
    $currentUrl = url()->current();
    ?>
    <div class="container-fluid">
        <div class="form-head d-md-flex mb-sm-2 mb-1 align-items-start">
            <div class="mr-auto  d-lg-block">
                <h2 class="text-black font-w600">მენიუს რედაქტირება - {{$menu->name}}</h2>
                <p class="mb-0 font-w600">{{ __('strings.Welcome') }}</p>
            </div>
            <a href="{{ route('backend.menus.edit', [app()->getLocale(), 'id'=>$menu->id]) }}" class="btn btn-primary rounded mr-3"><i class="flaticon-381-add"></i> ქეშირების შექმნა (2 კლიკი) - {{$menu->name}}</a>
            @can('backend.locales.index')
                <a href="{{ route('backend.menus.index', app()->getLocale())}}" class="btn btn-info rounded"><i class="flaticon-381-repeat-1"></i> {{ __('strings.Return Back') }} - {{ __('strings.All MenuTrait') }}</a>
            @endcan
        </div>

        @if(session('success'))
            @include('backend.layouts.components.success',[
              'success' => session('success'),
            ])
        @endif
        @if(session('error'))
            @include('backend.layouts.components.error',[
              'error' => session('error'),
            ])
        @endif


    <div id="hwpwrap">
        <div class="custom-wp-admin wp-admin wp-core-ui js   menu-max-depth-0 nav-menus-php auto-fold admin-bar">
            <div id="wpwrap">
                <div id="wpcontent">
                    <div id="wpbody">
                        <div id="wpbody-content">
                            <div class="wrap">
                                <div id="nav-menus-frame">
                                        <div id="menu-settings-column" class="metabox-holder">
                                            <div class="clear"></div>
                                            <form id="nav-menu-meta" action="" class="nav-menu-meta" method="post"
                                                  enctype="multipart/form-data">
                                                <div id="side-sortables" class="accordion-container">
                                                    <ul class="outer-border">
                                                        <li class="control-section accordion-section mb-3 add-page"
                                                            id="add-page">
                                                            <h3 class="accordion-section-title hndle"
                                                                tabindex="0"> გვერდები
                                                                <span
                                                                    class="screen-reader-text">@lang("strings.press_enter")</span>
                                                            </h3>
                                                            <div class="accordion-section-content ">
                                                                <div class="inside">
                                                                    <div class="customlinkdiv" id="customlinkdiv">
                                                                        <div class="form-group position-relative select-access">
                                                                            <label for="custom-menu-item-title-page-show" class="control-label howto" style="display:none;"></label>
                                                                            <input type="hidden" id="custom-menu-item-prefix" value="page-show">
                                                                            <input type="hidden" id="custom-menu-item-model" value="App\Models\Page">
                                                                            <select id="custom-menu-item-title-page-show" class="select2 form-control select2 page-dropdown-groups" name="title">
                                                                                <option value="0">-- აირჩიეთ გვერდი --</option>
                                                                                @foreach ($pages as $key => $val)
                                                                                    <option value="{{$val->id}}|{{ json_encode($val->getTranslations('title'), JSON_UNESCAPED_UNICODE)}}|{{ json_encode($val->getTranslations('slug'), JSON_UNESCAPED_UNICODE)}}">{{ $val->title}}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                        <p class="button-controls">
                                                                            <a href="#" onclick="addcustommenu(this)"
                                                                               class="button-secondary submit-add-to-menu right">@lang("strings.add_menu_item")</a>
                                                                            <span class="spinner" id="spincustomu"></span>
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li class="control-section accordion-section mb-3 add-page"
                                                            id="add-page">
                                                            <h3 class="accordion-section-title hndle"
                                                                tabindex="0"> სიახლეების კატეგორიები
                                                                <span
                                                                    class="screen-reader-text">@lang("strings.press_enter")</span>
                                                            </h3>
                                                            <div class="accordion-section-content ">
                                                                <div class="inside">
                                                                    <div class="customlinkdiv" id="customlinkdiv">
                                                                        <div class="form-group position-relative select-access">
                                                                            <label for="custom-menu-item-title-category" class="control-label howto" style="display:none;"></label>
                                                                            <input type="hidden" id="custom-menu-item-prefix" value="category">
                                                                            <input type="hidden" id="custom-menu-item-model" value="App\Models\ArticleCategory">
                                                                            <select id="custom-menu-item-title-category" class="select2 form-control select2 category-dropdown-groups" name="title">
                                                                                <option value="0">-- აირჩიეთ კატეგორიებია --</option>
                                                                                @foreach ($articleCategories as $key => $val)
                                                                                    <option value="{{$val->id}}|{{ json_encode($val->getTranslations('title'), JSON_UNESCAPED_UNICODE)}}|{{ json_encode($val->getTranslations('slug'), JSON_UNESCAPED_UNICODE)}}">{{ $val->title}}</option>;
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                        <p class="button-controls">
                                                                            <a href="#" onclick="addcustommenu(this)"
                                                                               class="button-secondary submit-add-to-menu right">@lang("strings.add_menu_item")</a>
                                                                            <span class="spinner" id="spincustomu"></span>
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li class="control-section accordion-section mb-3 add-page"
                                                            id="add-page">
                                                            <h3 class="accordion-section-title hndle"
                                                                tabindex="0"> პიროვნებები/ორგანიზაციები
                                                                <span
                                                                    class="screen-reader-text">@lang("strings.press_enter")</span>
                                                            </h3>
                                                            <div class="accordion-section-content ">
                                                                <div class="inside">
                                                                    <div class="customlinkdiv" id="customlinkdiv">
                                                                        <div class="form-group position-relative select-access">
                                                                            <label for="custom-menu-item-title-persons-show" class="control-label howto" style="display:none;"></label>
                                                                            <input type="hidden" id="custom-menu-item-prefix" value="persons-show">
                                                                            <input type="hidden" id="custom-menu-item-model" value="App\Models\Person">
                                                                            <select id="custom-menu-item-title-persons-show" class="select2 form-control select2 person-dropdown-groups" name="title">
                                                                                <option value="0">-- აირჩიეთ პიროვნება/ორგანიზაცია --</option>
                                                                                @foreach ($persons as $key => $val)
                                                                                    <option value="{{$val->id}}|{{ json_encode($val->getTranslations('title'), JSON_UNESCAPED_UNICODE)}}|{{ json_encode($val->getTranslations('slug'), JSON_UNESCAPED_UNICODE)}}">{{ $val->title}}</option>;
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                        <p class="button-controls">
                                                                            <a href="#" onclick="addcustommenu(this)"
                                                                               class="button-secondary submit-add-to-menu right">@lang("strings.add_menu_item")</a>
                                                                            <span class="spinner" id="spincustomu"></span>
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li class="control-section accordion-section mb-3 add-page"
                                                            id="add-page">
                                                            <h3 class="accordion-section-title hndle"
                                                                tabindex="0"> ვერდიქტები
                                                                <span
                                                                    class="screen-reader-text">@lang("strings.press_enter")</span>
                                                            </h3>
                                                            <div class="accordion-section-content ">
                                                                <div class="inside">
                                                                    <div class="customlinkdiv" id="customlinkdiv">
                                                                        <div class="form-group position-relative select-access">
                                                                            <label for="custom-menu-item-title-verdicts-show" class="control-label howto" style="display:none;"></label>
                                                                            <input type="hidden" id="custom-menu-item-prefix" value="verdicts-show">
                                                                            <input type="hidden" id="custom-menu-item-model" value="App\Models\Verdict">
                                                                            <select id="custom-menu-item-title-verdicts-show" class="form-control verdict-dropdown-groups" name="title">
                                                                                <option value="0">-- აირჩიეთ ვერდიქტი --</option>
                                                                                @foreach ($verdicts as $key => $val)
                                                                                    <option value="{{$val->id}}|{{ json_encode($val->getTranslations('title'), JSON_UNESCAPED_UNICODE)}}|{{ json_encode($val->getTranslations('slug'), JSON_UNESCAPED_UNICODE)}}">{{ $val->title}}</option>;
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                        <p class="button-controls">
                                                                            <a href="#" onclick="addcustommenu(this)"
                                                                               class="button-secondary submit-add-to-menu right">@lang("strings.add_menu_item")</a>
                                                                            <span class="spinner" id="spincustomu"></span>
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li class="control-section accordion-section mb-3 add-page"
                                                            id="add-page">
                                                            <h3 class="accordion-section-title hndle"
                                                                tabindex="0"> რეგიონები
                                                                <span
                                                                    class="screen-reader-text">@lang("strings.press_enter")</span>
                                                            </h3>
                                                            <div class="accordion-section-content ">
                                                                <div class="inside">
                                                                    <div class="customlinkdiv" id="customlinkdiv">
                                                                        <div class="form-group position-relative select-access">
                                                                            <label for="custom-menu-item-title-regions-show" class="control-label howto" style="display:none;"></label>
                                                                            <input type="hidden" id="custom-menu-item-prefix" value="regions-show">
                                                                            <input type="hidden" id="custom-menu-item-model" value="App\Models\Region">
                                                                            <select id="custom-menu-item-title-regions-show" class="form-control region-dropdown-groups" name="title">
                                                                                <option value="0">-- აირჩიეთ რეგიონი --</option>
                                                                                @foreach ($regions as $key => $val)
                                                                                    <option value="{{$val->id}}|{{ json_encode($val->getTranslations('title'), JSON_UNESCAPED_UNICODE)}}|{{ json_encode($val->getTranslations('slug'), JSON_UNESCAPED_UNICODE)}}">{{ $val->title}}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                        <p class="button-controls">
                                                                            <a href="#" onclick="addcustommenu(this)"
                                                                               class="button-secondary submit-add-to-menu right">@lang("strings.add_menu_item")</a>
                                                                            <span class="spinner" id="spincustomu"></span>
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </form>
                                        </div>






                                    <div id="menu-management-liquid">
                                        <div id="menu-management">
                                            <form id="update-nav-menu" action="" method="post"
                                                  enctype="multipart/form-data">
                                                <div class="menu-edit ">
                                                    <div id="nav-menu-header">
                                                        <div class="major-publishing-actions">
                                                            <label class="menu-name-label howto open-label" for="menu-name">
                                                                <span>მენიუს დასახელება</span>
                                                                <input name="menu-name" id="menu-name" type="text"
                                                                       class="menu-name regular-text menu-item-textbox"
                                                                       title="@lang("strings.enter_menu_name")"
                                                                       value="@if(isset($menu->id)){{$menu->name}}@endif">
                                                                <input type="hidden" id="idmenu"
                                                                       value="@if(isset($menu->id)){{$menu->id}}@endif"/>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div id="post-body">
                                                        <div id="post-body-content">

                                                            <h3>{{$menu->name}}-ს სტრუქტურა</h3>
                                                            <ul class="menu ui-sortable" id="menu-to-edit"
                                                                style="display: block;">
                                                                @if(isset($menuItems))
                                                                    @foreach($menuItems as $m)
                                                                        <li id="menu-item-{{$m->id}}"
                                                                            class="menu-item menu-item-depth-{{$m->depth}} menu-item-page menu-item-edit-inactive pending"
                                                                            style="display: list-item;">
                                                                            <dl class="menu-item-bar">
                                                                                <dt class="menu-item-handle">
                                                                                <span class="item-title"> <span
                                                                                        class="menu-item-title"> <span
                                                                                            id="menutitletemp_{{$m->id}}">{{$m->getTranslation('title', app()->getLocale())}}</span> <span
                                                                                            style="color: transparent;">|{{$m->id}}|</span> </span> <span
                                                                                        class="is-submenu"
                                                                                        style="@if($m->depth==0)display: none;@endif">@lang("strings.subelement")</span> </span>
                                                                                    <span class="item-controls"> <span
                                                                                            class="item-type">{{$m->prefix}}</span> <span
                                                                                            class="item-order hide-if-js"> <a
                                                                                                href="{{ $currentUrl }}?action=move-up-menu-item&menu-item={{$m->id}}&_wpnonce=8b3eb7ac44"
                                                                                                class="item-move-up"><abbr
                                                                                                    title="@lang("strings.move_up")">↑</abbr></a> | <a
                                                                                                href="{{ $currentUrl }}?action=move-down-menu-item&menu-item={{$m->id}}&_wpnonce=8b3eb7ac44"
                                                                                                class="item-move-down"><abbr
                                                                                                    title="@lang("strings.move_down")">↓</abbr></a> </span> <a
                                                                                            class="item-edit"
                                                                                            id="edit-{{$m->id}}" title=" "
                                                                                            href="{{ $currentUrl }}?edit-menu-item={{$m->id}}#menu-item-settings-{{$m->id}}"> </a> </span>
                                                                                </dt>
                                                                            </dl>

                                                                            <div class="menu-item-settings"
                                                                                 id="menu-item-settings-{{$m->id}}">
                                                                                <input type="hidden"
                                                                                       class="edit-menu-item-id"
                                                                                       name="menuid_{{$m->id}}"
                                                                                       value="{{$m->id}}"/>


                                                                                <p class="field-css-classes description description-thin">
                                                                                    <label
                                                                                        for="edit-menu-item-classes-{{$m->id}}"> @lang("strings.class_css")
                                                                                        <br>
                                                                                        <input type="text"
                                                                                               id="clases_menu_{{$m->id}}"
                                                                                               class="widefat code edit-menu-item-classes"
                                                                                               name="clases_menu_{{$m->id}}"
                                                                                               value="{{$m->class}}">
                                                                                    </label>
                                                                                </p>

                                                                                <p class="field-css-url description description-wide">
                                                                                    <label
                                                                                        for="edit-menu-item-url-{{$m->id}}">
                                                                                        Prefix
                                                                                        <br>
                                                                                        <input type="text" id="url_menu_{{$m->id}}" name="url_menu_{{$m->id}}" class="widefat code edit-menu-item-url" value="{{$m->prefix}}" disabled>
                                                                                    </label>
                                                                                </p>

                                                                                <p class="field-move hide-if-no-js description description-wide">
                                                                                    <label>
                                                                                        <span>@lang("strings.move")</span>
                                                                                        <a href="{{ $currentUrl }}"
                                                                                           class="menus-move-up"
                                                                                           style="display: none;">@lang("strings.move_up")</a>
                                                                                        <a href="{{ $currentUrl }}"
                                                                                           class="menus-move-down"
                                                                                           title="Mover uno abajo"
                                                                                           style="display: inline;">@lang("strings.move_down")</a>
                                                                                        <a href="{{ $currentUrl }}"
                                                                                           class="menus-move-left"
                                                                                           style="display: none;"></a> <a
                                                                                            href="{{ $currentUrl }}"
                                                                                            class="menus-move-right"
                                                                                            style="display: none;"></a> <a
                                                                                            href="{{ $currentUrl }}"
                                                                                            class="menus-move-top"
                                                                                            style="display: none;">@lang("strings.top")</a>
                                                                                    </label>
                                                                                </p>

                                                                                <div
                                                                                    class="menu-item-actions description-wide submitbox">

                                                                                    <a class="item-delete submitdelete deletion"
                                                                                       id="delete-{{$m->id}}"
                                                                                       href="{{ $currentUrl }}?action=delete-menu-item&menu-item={{$m->id}}&_wpnonce=2844002501">@lang("strings.delete")</a>
                                                                                    <span
                                                                                        class="meta-sep hide-if-no-js"> | </span>
                                                                                    <a class="item-cancel submitcancel hide-if-no-js button-secondary"
                                                                                       id="cancel-{{$m->id}}"
                                                                                       href="{{ $currentUrl }}?edit-menu-item={{$m->id}}&cancel=1424297719#menu-item-settings-{{$m->id}}">@lang("strings.cancel")</a>
                                                                                    <span
                                                                                        class="meta-sep hide-if-no-js"> | </span>
                                                                                    <a onclick="getmenus()"
                                                                                       class="button button-primary updatemenu"
                                                                                       id="update-{{$m->id}}"
                                                                                       href="javascript:void(0)">@lang("strings.update_item")</a>

                                                                                </div>

                                                                            </div>
                                                                            <ul class="menu-item-transport"></ul>
                                                                        </li>
                                                                    @endforeach
                                                                @endif
                                                            </ul>
                                                            <div class="menu-settings">

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="nav-menu-footer">
                                                        <div class="major-publishing-actions">
                                                                <div class="publishing-action">
                                                                    <a onclick="getmenus()" name="save_menu"
                                                                       id="save_menu_header"
                                                                       class="button button-primary menu-save">მენიუს განახლება</a>
                                                                    <span class="spinner" id="spincustomu2"></span>
                                                                </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="clear"></div>
                        </div>

                        <div class="clear"></div>
                    </div>
                    <div class="clear"></div>
                </div>

                <div class="clear"></div>
            </div>
        </div>
    </div>
    </div>
@endsection
@push('scripts')
    <script>
        var menus = {
            "oneThemeLocationNoMenus": "",
            "moveUp": '{{__("strings.move_up")}}',
            "moveDown": '{{__("strings.move_down")}}',
            "moveToTop": '{{__("strings.move_top")}}',
            "moveUnder": '{{__("strings.move_under")}}',
            "moveOutFrom": '{{__("strings.move_out_from")}}',
            "under": '{{__("strings.under")}}',
            "outFrom": '{{__("strings.out_from")}}',
            "menuFocus": '{{__("strings.menu_focus")}}',
            "deleteMenu": '{{__("strings.deleting_this_menu")}}',
            "enterMenuName": '{{__("strings.enter_menu_name")}}',
            "subMenuFocus" : '{{__("strings.submenu_focus")}}'
        };
        var arraydata = [];
        var addcustommenur = '{{ route("backend.menus.items.create", app()->getLocale()) }}';
        var updateitemr = '{{ route("backend.menus.items.update", app()->getLocale())}}';
        var deleteitemmenur = '{{ route("backend.menus.items.delete", app()->getLocale()) }}';
        var generatemenucontrolr = '{{ route("backend.menus.updateMenu", app()->getLocale()) }}';
        var deletemenugr = '{{ route("backend.menus.deleteMenu", app()->getLocale()) }}';
        var createnewmenur = '{{ route("backend.menus.store", app()->getLocale()) }}';
        var csrftoken = "{{ csrf_token() }}";
        var menuwr = "{{ url()->current() }}";

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': csrftoken
            }
        });
    </script>
    <script type="text/javascript" src="{{asset('admin/menu/scripts.js')}}"></script>
    <script type="text/javascript" src="{{asset('admin/menu/scripts2.js')}}"></script>
    <script type="text/javascript" src="{{asset('admin/menu/menu.js')}}"></script>
    <script type="text/javascript" src="{{asset('/js/additional/select2.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('/js/plugins-init/select2-init.js')}}"></script>

@endpush

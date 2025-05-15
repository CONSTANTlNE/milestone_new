@extends('backend.layouts.master')
@section('title') {{ __('strings.All Languages') }} @endsection
@push('styles')
    <link href="{{asset('admin/menu/style.css')}}" rel="stylesheet">
@endpush
@section('content')
    <?php
    $currentUrl = url()->current();
    ?>
    <div id="hwpwrap">
        <div class="custom-wp-admin wp-admin wp-core-ui js   menu-max-depth-0 nav-menus-php auto-fold admin-bar">
            <div id="wpwrap">
                <div id="wpcontent">
                    <div id="wpbody">
                        <div id="wpbody-content">
                            <div class="wrap">
                                <div id="nav-menus-frame">
                                    @if(request()->has('menu')  && !empty(request()->input("menu")))
                                        <div id="menu-settings-column" class="metabox-holder">

                                            <div class="clear"></div>

                                            <form id="nav-menu-meta" action="" class="nav-menu-meta" method="post"
                                                  enctype="multipart/form-data">
                                                <div id="side-sortables" class="accordion-container">
                                                    <ul class="outer-border">
                                                        <li class="control-section accordion-section open add-page"
                                                            id="add-page">
                                                            <h3 class="accordion-section-title hndle"
                                                                tabindex="0"> @lang("strings.custom_link")
                                                                <span
                                                                    class="screen-reader-text">@lang("strings.press_enter")</span>
                                                            </h3>
                                                            <div class="accordion-section-content ">
                                                                <div class="inside">
                                                                    <div class="customlinkdiv" id="customlinkdiv">
                                                                        <p id="menu-item-url-wrap">
                                                                            <label class="howto" for="custom-menu-item-url">
                                                                                <span>URL</span>&nbsp;&nbsp;&nbsp;
                                                                                <input id="custom-menu-item-url" name="url"
                                                                                       type="text"
                                                                                       class="menu-item-textbox "
                                                                                       placeholder="URL">
                                                                            </label>
                                                                        </p>

                                                                        <p id="menu-item-name-wrap">
                                                                            <label class="howto"
                                                                                   for="custom-menu-item-name">
                                                                                <span>@lang("strings.label")</span>&nbsp;
                                                                                <input id="custom-menu-item-name"
                                                                                       name="label" type="text"
                                                                                       class="regular-text menu-item-textbox input-with-default-title"
                                                                                       title="@lang("strings.menu_label")">
                                                                            </label>
                                                                        </p>

                                                                        <p class="button-controls">

                                                                            <a href="#" onclick="addcustommenu()"
                                                                               class="button-secondary submit-add-to-menu right">@lang("strings.add_menu_item")</a>
                                                                            <span class="spinner" id="spincustomu"></span>
                                                                        </p>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li class="control-section accordion-section open add-page"
                                                            id="add-page">
                                                            <h3 class="accordion-section-title hndle"
                                                                tabindex="1"> გვერდები
                                                                <span
                                                                    class="screen-reader-text">@lang("strings.press_enter")</span>
                                                            </h3>
                                                            <div class="accordion-section-content ">
                                                                <div class="inside">
                                                                    <div class="customlinkdiv" id="customlinkdiv">

                                                                        <p id="menu-item-page-name-wrap">
                                                                            <label class="howto"
                                                                                   for="custom-menu-page-item-name">
                                                                                <span>@lang("strings.label")</span>&nbsp;
                                                                                <select name="title" id="custom-menu-page-item-name">
                                                                                    @foreach ($pages as $key => $page)
                                                                                        <option value="{{$page->id}}">{{$page->title}} </option>;
                                                                                    @endforeach
                                                                                </select>
                                                                            </label>
                                                                        </p>

                                                                        <p class="button-controls">

                                                                            <a href="#" onclick="addcustommenu()"
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
                                    @endif
                                    <div id="menu-management-liquid">
                                        <div id="menu-management">
                                            <form id="update-nav-menu" action="" method="post"
                                                  enctype="multipart/form-data">
                                                <div class="menu-edit ">
                                                    <div id="nav-menu-header">
                                                        <div class="major-publishing-actions">
                                                            <label class="menu-name-label howto open-label" for="menu-name">
                                                                <span>@lang("strings.name")</span>
                                                                <input name="menu-name" id="menu-name" type="text"
                                                                       class="menu-name regular-text menu-item-textbox"
                                                                       title="@lang("strings.enter_menu_name")"
                                                                       value="@if(isset($indmenu)){{$indmenu->name}}@endif">
                                                                <input type="hidden" id="idmenu"
                                                                       value="@if(isset($indmenu)){{$indmenu->id}}@endif"/>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div id="post-body">
                                                        <div id="post-body-content">

                                                            <h3>@lang("strings.menu_structure")</h3>
                                                            <div class="drag-instructions post-body-plain" style="">
                                                                <p>
                                                                    @lang("strings.menu_structure_text")
                                                                </p>
                                                            </div>

                                                            <ul class="menu ui-sortable" id="menu-to-edit"
                                                                style="display: block;">
                                                                @if(isset($menus))
                                                                    @foreach($menus as $m)
                                                                        <li id="menu-item-{{$m->id}}"
                                                                            class="menu-item menu-item-depth-{{$m->depth}} menu-item-page menu-item-edit-inactive pending"
                                                                            style="display: list-item;">
                                                                            <dl class="menu-item-bar">
                                                                                <dt class="menu-item-handle">
                                                                                <span class="item-title"> <span
                                                                                        class="menu-item-title"> <span
                                                                                            id="menutitletemp_{{$m->id}}">{{$m->label}}</span> <span
                                                                                            style="color: transparent;">|{{$m->id}}|</span> </span> <span
                                                                                        class="is-submenu"
                                                                                        style="@if($m->depth==0)display: none;@endif">@lang("strings.subelement")</span> </span>
                                                                                    <span class="item-controls"> <span
                                                                                            class="item-type">Link</span> <span
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
                                                                                <p class="description description-thin">
                                                                                    <label
                                                                                        for="edit-menu-item-title-{{$m->id}}"> @lang("strings.label")
                                                                                        <br>
                                                                                        <input type="text"
                                                                                               id="idlabelmenu_{{$m->id}}"
                                                                                               class="widefat edit-menu-item-title"
                                                                                               name="idlabelmenu_{{$m->id}}"
                                                                                               value="{{$m->label}}">
                                                                                    </label>
                                                                                </p>

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
                                                                                        URL
                                                                                        <br>
                                                                                        <input type="text"
                                                                                               id="url_menu_{{$m->id}}"
                                                                                               class="widefat code edit-menu-item-url"
                                                                                               id="url_menu_{{$m->id}}"
                                                                                               value="{{$m->link}}">
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
                                                                   class="button button-primary menu-save">@lang("strings.save_menu")</a>
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

        var csrftoken = "{{ csrf_token() }}";
        var menuwr = "{{ url()->current() }}";

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': csrftoken
            }
        });
    </script>
    <script type="text/javascript" src="{{asset('admin/menu/scripts.js')}}"></script>
    {{--    <script type="text/javascript" src="{{asset('admin/menu/scripts2.js')}}"></script>--}}
    <script type="text/javascript" src="{{asset('admin/menu/menu.js')}}"></script>
@endpush

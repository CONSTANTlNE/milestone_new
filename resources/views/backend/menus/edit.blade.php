@extends('backend.layouts.master')
@section('title') {{ __('admin.edit_menu') }} @endsection
@section('styles')
    <link href="{{asset('admin/menu/menu-vanilla.css')}}" rel="stylesheet">
@endsection
@section('content')
    <?php
    $currentUrl = url()->current();
    ?>
    <div class="content">
        <div class="main-content">
                <div class="block justify-between page-header md:flex">
                <div>
                    <h3 class="!text-defaulttextcolor dark:!text-defaulttextcolor/70 dark:text-white dark:hover:text-white text-[1.375rem] font-semibold font-first-geo">{{ __('admin.edit_menu') }} - {{$menu->name}}</h3>
                    <p class="font-second-geo text-defaulttextcolor/70">{{ __('admin.welcome') }}</p>
                </div>
                <ol class="flex items-center whitespace-nowrap min-w-0 gap-3 header-nav-links">
                    @can('backend.menus.index')
                        <li class="text-[0.813rem] ps-[0.5rem]">
                            <a href="{{ route('backend.menus.index') }}" class="ti-btn bg-secondary text-white !font-medium font-second-geo">
                                <i class="ri-arrow-go-back-line text-[1.375rem]"></i>
                                {{ __('admin.return_back') }} - {{ __('admin.all_menus') }}
                            </a>
                        </li>
                    @endcan
                </ol>
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

        <div class="grid grid-cols-12 gap-6 white-bg">
            <div class="xl:col-span-3 col-span-12">
                <div class="box">
                    <div class="box-body">
                        <div id="menu-settings-column" class="metabox-holder">
                            <div class="clear"></div>
                            <form id="nav-menu-meta" action="" class="nav-menu-meta" method="post" enctype="multipart/form-data">
                                <div id="side-sortables" class="accordion-container">
                                    <ul class="outer-border">
                                        <li class="control-section accordion-section mb-3 add-page" id="add-page">
                                            <h3 class="accordion-section-title hndle" tabindex="0">
                                                {{__('admin.sidebar_pages')}}
                                            </h3>
                                            <div class="accordion-section-content ">
                                                <div class="inside">
                                                    <div class="customlinkdiv" id="customlinkdiv">
                                                        <div class="form-group position-relative select-access">
                                                            <label class="control-label howto">{{__('admin.choose_multi_page')}}</label>
                                                            <input type="hidden" id="custom-menu-item-prefix" name="custom-menu-item-prefix" value="pages-show">
                                                            <input type="hidden" id="custom-menu-item-model" name="custom-menu-item-model" value="App\Models\Page">

                                                            <div class="page-checkboxes">
                                                                @foreach ($pages as $key => $val)
                                                                    <div class="checkbox-item">
                                                                        <label>
                                                                            <input type="checkbox"
                                                                                   class="page-checkbox"
                                                                                   name="page-checkbox[]"
                                                                                   value="{{$val->id}}|{{ json_encode($val->getTranslations('title'), JSON_UNESCAPED_UNICODE)}}|{{ json_encode($val->getTranslations('slug'), JSON_UNESCAPED_UNICODE)}}|{{ $val->template }}">
                                                                            <span>{{ $val->title}}</span>
                                                                        </label>
                                                                    </div>
                                                                @endforeach
                                                            </div>

                                                            <div class="selection-controls">
                                                                <button type="button" class="button-secondary" onclick="selectAllPages()">{{__('admin.all_choose')}}</button>
                                                                <button type="button" class="button-secondary" onclick="deselectAllPages()">{{__('admin.all_cancel')}}</button>
                                                            </div>
                                                        </div>
                                                        <p class="button-controls">
                                                            <a href="#" onclick="addMultiplePages(this)"
                                                               class="button-secondary submit-add-to-menu right">{{__("admin.add_menu_item")}}</a>
                                                            <span class="spinner" id="spincustomu"></span>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="control-section accordion-section mb-3 add-page" id="add-page">
                                                <h3 class="accordion-section-title hndle" tabindex="0">
                                                    {{__('admin.blogCategories')}}
                                                    <span class="screen-reader-text">@lang("strings.press_enter")</span>
                                                </h3>
                                            <div class="accordion-section-content ">
                                                <div class="inside">
                                                    <div class="customlinkdiv" id="customlinkdiv">
                                                        <div class="form-group position-relative select-access">
                                                            <label class="control-label howto">{{__('admin.choose_multi_category')}}:</label>
                                                            <input type="hidden" id="custom-menu-item-prefix" name="custom-menu-item-prefix" value="frontend.blogCategories.show">
                                                            <input type="hidden" id="custom-menu-item-model" name="custom-menu-item-model" value="App\Models\BlogCategory">
                                                            <div class="page-checkboxes">
                                                                @foreach ($blogCategories as $key => $val)
                                                                    <div class="checkbox-item">
                                                                        <label>
                                                                            <input type="checkbox"
                                                                                   class="category-checkbox"
                                                                                   name="category-checkbox[]"
                                                                                   value="{{$val->id}}|{{ json_encode($val->getTranslations('title'), JSON_UNESCAPED_UNICODE)}}|{{ json_encode($val->getTranslations('slug'), JSON_UNESCAPED_UNICODE)}}">
                                                                            <span>{{ $val->title}}</span>
                                                                        </label>
                                                                    </div>
                                                                @endforeach
                                                            </div>

                                                            <div class="selection-controls">
                                                                <button type="button" class="button-secondary" onclick="selectAllCategories()">{{__('admin.all_choose')}}</button>
                                                                <button type="button" class="button-secondary" onclick="deselectAllCategories()">{{__('admin.all_cancel')}}</button>
                                                            </div>
                                                        </div>
                                                        <p class="button-controls">
                                                            <a href="#" onclick="addMultipleCategories(this)"
                                                               class="button-secondary submit-add-to-menu right">{{__("admin.add_menu_item")}}</a>
                                                            <span class="spinner" id="spincustomu"></span>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="control-section accordion-section mb-3 add-page" id="add-page">
                                            <h3 class="accordion-section-title hndle" tabindex="0">
                                                {{__('admin.serviceCategories')}}
                                                <span class="screen-reader-text">@lang("strings.press_enter")</span>
                                            </h3>
                                            <div class="accordion-section-content ">
                                                <div class="inside">
                                                    <div class="customlinkdiv" id="customlinkdiv">
                                                        <div class="form-group position-relative select-access">
                                                            <label class="control-label howto">{{__('admin.choose_multi_category')}}</label>
                                                            <input type="hidden" id="custom-menu-item-prefix" name="custom-menu-item-prefix" value="frontend.serviceCategories.show">
                                                            <input type="hidden" id="custom-menu-item-model" name="custom-menu-item-model" value="App\Models\ServiceCategory">

                                                            <div class="page-checkboxes">
                                                                @foreach ($serviceCategories as $key => $val)
                                                                    <div class="checkbox-item">
                                                                        <label>
                                                                            <input type="checkbox"
                                                                                   class="service-category-checkbox"
                                                                                   name="service-category-checkbox[]"
                                                                                   value="{{$val->id}}|{{ json_encode($val->getTranslations('title'), JSON_UNESCAPED_UNICODE)}}|{{ json_encode($val->getTranslations('slug'), JSON_UNESCAPED_UNICODE)}}">
                                                                            <span>{{ $val->title}}</span>
                                                                        </label>
                                                                    </div>
                                                                @endforeach
                                                            </div>

                                                            <div class="selection-controls">
                                                                <button type="button" class="button-secondary" onclick="selectAllServiceCategories()">{{__('admin.all_choose')}}</button>
                                                                <button type="button" class="button-secondary" onclick="deselectAllServiceCategories()">{{__('admin.all_cancel')}}</button>
                                                            </div>
                                                        </div>
                                                        <p class="button-controls">
                                                            <a href="#" onclick="addMultipleServiceCategories(this)"
                                                               class="button-secondary submit-add-to-menu right">{{__("admin.add_menu_item")}}</a>
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
                    </div>
                </div>
            </div>
                    <div class="xl:col-span-9 col-span-12">
                        <div class="box">
                            <div class="box-body">
                                <div id="menu-management-liquid">
                                    <div id="menu-management">
                                        <form id="update-nav-menu" action="" method="post" enctype="multipart/form-data">
                                            <div class="menu-edit ">
                                                <div id="nav-menu-header" class="mb-5">
                                                    <div class="major-publishing-actions">
                                                        <label class="menu-name-label howto open-label" for="menu-name">
                                                            <div class="flex w-full">
                                                                <span class="px-4 inline-flex items-center min-w-fit rounded-s-sm border-e-0 border-gray-200 bg-light text-sm text-gray-500 dark:bg-black/20 dark:border-white/10 dark:text-[#8c9097] dark:text-white/50 font-second-geo">
                                                                    {{__('admin.menu_title')}}
                                                                </span>
                                                                <input name="menu-name" id="menu-name" type="text"
                                                                       class="font-second-geo menu-name regular-text menu-item-textbox py-2 px-3 ti-form-input rounded-none rounded-e-sm focus:z-10 !border-s-0"
                                                                       title="@lang("strings.enter_menu_name")"
                                                                       value="@if(isset($menu->id)){{$menu->name}}@endif">
                                                                <input type="hidden" id="idmenu"
                                                                       value="@if(isset($menu->id)){{$menu->id}}@endif"/>
                                                            </div>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div id="post-body">
                                                    <div id="post-body-content">
                                                        <h3>{{$menu->name}}{{__('admin.menu_structure')}}</h3>
                                                        <ul class="menu ui-sortable" id="menu-to-edit"
                                                            style="display: block;">
                                                            @if(isset($menuItems))
                                                                @php
                                                                    $menuTree = $menuItems->where('parent_id', 0);

                                                                    // Debug: Log the structure to help identify issues
                                                                    \Log::info('Menu Tree Structure', [
                                                                        'root_items_count' => $menuTree->count(),
                                                                        'total_items_count' => $menuItems->count(),
                                                                        'root_items' => $menuTree->map(function($item) {
                                                                            return [
                                                                                'id' => $item->id,
                                                                                'title' => $item->title,
                                                                                'children_count' => $item->children ? $item->children->count() : 0
                                                                            ];
                                                                        })->toArray()
                                                                    ]);

                                                                    // Recursive function to render menu items
                                                                    function renderMenuItem($item, $depth = 0) {
                                                                        $html = '<li id="menu-item-' . $item->id . '" class="menu-item menu-item-depth-' . $depth . ' menu-item-page menu-item-edit-inactive pending" style="display: list-item;">';
                                                                        $html .= '<dl class="menu-item-bar">';
                                                                        $html .= '<dt class="menu-item-handle">';
                                                                        $html .= '<span class="item-title">';
                                                                        $html .= '<span class="menu-item-title">';
                                                                        $html .= '<span id="menutitletemp_' . $item->id . '">' . $item->getTranslation('title', app()->getLocale()) . '</span>';
                                                                        $html .= '<span style="color: transparent;">|' . $item->id . '|</span>';
                                                                        $html .= '</span>';
                                                                        if ($depth > 0) {
                                                                            $html .= '<span class="is-submenu">' . __('admin.sub_element') . '</span>';
                                                                        }
                                                                        $html .= '</span>';
                                                                        $html .= '<span class="item-controls">';
                                                                        $html .= '<span class="item-type">' . $item->prefix . '</span>';
                                                                        $html .= '<a class="item-edit" id="edit-' . $item->id . '" title=" " href="' . url()->current() . '?edit-menu-item=' . $item->id . '#menu-item-settings-' . $item->id . '"><i class="ri-edit-fill"></i></a>';
                                                                        $html .= '<a class="item-delete-quick" id="delete-quick-' . $item->id . '" title="' . __('admin.delete') . '" href="javascript:void(0)"><i class="ri-delete-bin-2-fill"></i></a>';
                                                                        $html .= '</span>';
                                                                        $html .= '</dt>';
                                                                        $html .= '</dl>';

                                                                        $html .= '<div class="menu-item-settings" id="menu-item-settings-' . $item->id . '">';
                                                                        $html .= '<input type="hidden" class="edit-menu-item-id" name="menuid_' . $item->id . '" value="' . $item->id . '"/>';
                                                                        $html .= '<p class="field-css-classes description description-thin">';
                                                                        $html .= '<label for="clases_menu_' . $item->id . '">' . __('admin.class_css') . '<br>';
                                                                        $html .= '<input type="text" id="clases_menu_' . $item->id . '" class="widefat code edit-menu-item-classes" name="clases_menu_' . $item->id . '" value="' . $item->class . '">';
                                                                        $html .= '</label>';
                                                                        $html .= '</p>';
                                                                        $html .= '<p class="field-css-url description description-wide">';
                                                                        $html .= '<label for="url_menu_' . $item->id . '">Prefix<br>';
                                                                        $html .= '<input type="text" id="url_menu_' . $item->id . '" name="url_menu_' . $item->id . '" class="widefat code edit-menu-item-url" value="' . $item->prefix . '" disabled>';
                                                                        $html .= '</label>';
                                                                        $html .= '</p>';

                                                                        $html .= '<div class="menu-item-actions description-wide submitbox">';
                                                                        $html .= '<a class="item-delete submitdelete deletion" id="delete-' . $item->id . '" href="javascript:void(0)" onclick="window.menuManager.deleteMenuItem(' . $item->id . ')">' . __('admin.delete') . '</a>';
                                                                        $html .= '<span class="meta-sep hide-if-no-js"> | </span>';
                                                                        $html .= '<a class="item-cancel submitcancel hide-if-no-js button-secondary" id="cancel-' . $item->id . '" href="' . url()->current() . '?edit-menu-item=' . $item->id . '&cancel=1424297719#menu-item-settings-' . $item->id . '">' . __('admin.cancel') . '</a>';
                                                                        $html .= '<span class="meta-sep hide-if-no-js"> | </span>';
                                                                                                                                                        $html .= '<a onclick="window.menuManager.getMenus()" class="button button-primary updatemenu" id="update-' . $item->id . '" href="javascript:void(0)">' . __('admin.update_item') . '</a>';
                                                                        $html .= '</div>';
                                                                        $html .= '</div>';
                                                                        $html .= '<ul class="menu-item-transport"></ul>';

                                                                        // If this item has children, render them in a submenu
                                                                        if ($item->children && $item->children->count() > 0) {
                                                                            $html .= '<ul class="menu submenu">';
                                                                            foreach ($item->children as $child) {
                                                                                $html .= renderMenuItem($child, $depth + 1);
                                                                            }
                                                                            $html .= '</ul>';
                                                                        }

                                                                        $html .= '</li>';
                                                                        return $html;
                                                                    }
                                                                @endphp

                                                                @foreach($menuTree as $item)
                                                                    {!! renderMenuItem($item) !!}
                                                                @endforeach
                                                            @endif
                                                        </ul>
                                                        <div class="menu-settings">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="nav-menu-footer" class="mt-5">
                                                    <div class="major-publishing-actions">
                                                        <div class="publishing-action">
                                                            <a onclick="window.menuManager.getMenus()" name="save_menu"
                                                                       id="save_menu_header"
                                                                       class="button button-primary menu-save">{{ __('admin.update_menu') }}</a>
                                                            <span class="spinner" id="spincustomu2"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        // Menu configuration for vanilla JS
        window.menuConfig = {
            menus: {
                "oneThemeLocationNoMenus": "",
                "moveUnder": '{{__("strings.move_under")}}',
                "moveOutFrom": '{{__("strings.move_out_from")}}',
                "under": '{{__("strings.under")}}',
                "outFrom": '{{__("strings.out_from")}}',
                "menuFocus": '{{__("strings.menu_focus")}}',
                "deleteMenu": '{{__("strings.deleting_this_menu")}}',
                "enterMenuName": '{{__("strings.enter_menu_name")}}',
                "subMenuFocus" : '{{__("strings.submenu_focus")}}'
            },
            routes: {
                addCustomMenu: '{{ route("backend.menus.items.create") }}',
                updateItem: '{{ route("backend.menus.items.update")}}',
                deleteItem: '{{ route("backend.menus.items.delete") }}',
                generateMenu: '{{ route("backend.menus.updateMenu") }}',
                deleteMenu: '{{ route("backend.menus.deleteMenu") }}',
                createNewMenu: '{{ route("backend.menus.store") }}'
            },
            csrfToken: "{{ csrf_token() }}",
            currentUrl: "{{ url()->current() }}"
        };
    </script>
    <script type="text/javascript" src="{{asset('admin/menu/menu-vanilla.js')}}"></script>

    <script>
        // Global functions for page selection
        function selectAllPages() {
            const checkboxes = document.querySelectorAll('.page-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = true;
            });
        }

        function deselectAllPages() {
            const checkboxes = document.querySelectorAll('.page-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = false;
            });
        }

        // Global function for adding multiple pages
        function addMultiplePages(element) {
            window.menuManager.addMultiplePages(element);
        }

        // Global functions for category selection
        function selectAllCategories() {
            const checkboxes = document.querySelectorAll('.category-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = true;
            });
        }

        function deselectAllCategories() {
            const checkboxes = document.querySelectorAll('.category-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = false;
            });
        }

                // Global function for adding multiple categories
        function addMultipleCategories(element) {
            window.menuManager.addMultipleCategories(element);
        }

        // Global functions for service category selection
        function selectAllServiceCategories() {
            const checkboxes = document.querySelectorAll('.service-category-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = true;
            });
        }

        function deselectAllServiceCategories() {
            const checkboxes = document.querySelectorAll('.service-category-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = false;
            });
        }

        // Global function for adding multiple service categories
        function addMultipleServiceCategories(element) {
            window.menuManager.addMultipleServiceCategories(element);
        }

        // Global function for backward compatibility
        function getmenus() {
            if (window.menuManager) {
                window.menuManager.getMenus();
            }
        }
    </script>
@endpush

<aside class="app-sidebar" id="sidebar">
    <x-backend.logos wrapperClass="main-sidebar-header" />
    <div class="main-sidebar" id="sidebar-scroll">
        <nav class="main-menu-container nav nav-pills flex-column sub-open">
            <div class="slide-left" id="slide-left">
                <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24">
                    <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z"></path>
                </svg>
            </div>
            <ul class="main-menu">
                <li class="slide__category font-second-geo"><span class="category-name">{{ __('admin.sidebar_main') }}</span></li>

                <li class="slide">
                    <a href="{{ route('backend.index') }}" class="side-menu__item font-first-geo">
                        <i class="ri ri-home-4-line side-menu__icon"></i>
                        <span class="side-menu__label font-bold">{{ __('admin.sidebar_dashboard') }}</span>
                    </a>
                </li>

                <li class="slide">
                    <a href="#" class="side-menu__item font-first-geo">
                        <i class="ri ri-pie-chart-line side-menu__icon"></i>
                        <span class="side-menu__label font-bold">{{ __('admin.sidebar_analytics') }} </span>
                    </a>
                </li>

                <li class="slide">
                    <a href="#" class="side-menu__item font-first-geo">
                        <i class="ri ri-menu-line side-menu__icon"></i>
                        <span class="side-menu__label font-bold">{{ __('admin.sidebar_menu') }} </span>
                    </a>
                </li>

                <li class="slide">
                    <a href="#" class="side-menu__item font-first-geo">
                        <i class="ri ri-folders-line side-menu__icon"></i>
                        <span class="side-menu__label font-bold">{{ __('admin.sidebar_file_manager') }} </span>
                    </a>
                </li>

                <li class="slide__category font-second-geo"><span class="category-name">{{ __('admin.sidebar_content') }}</span></li>
                <li class="slide">
                    <a href="#" class="side-menu__item font-first-geo">
                        <i class="ri ri-pages-line side-menu__icon"></i>
                        <span class="side-menu__label font-bold">{{ __('admin.sidebar_pages') }} </span>
                    </a>
                </li>

                <li class="slide has-sub">
                    <a href="javascript:void(0);" class="side-menu__item font-first-geo">
                        <i class="ri ri-newspaper-line side-menu__icon"></i>
                        <span class="side-menu__label font-bold">{{ __('admin.sidebar_blogs') }}</span>
                        <i class="ri ri-arrow-right-s-line side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1">
                        <li class="slide"><a href="#" class="side-menu__item font-second-geo">{{ __('admin.sidebar_all_blogs') }}</a></li>
                        <li class="slide"><a href="#" class="side-menu__item font-second-geo">{{ __('admin.sidebar_categories_blog') }}</a></li>
                        <li class="slide"><a href="#" class="side-menu__item font-second-geo">{{ __('admin.sidebar_tags_blog') }}</a></li>
                    </ul>
                </li>

                <li class="slide has-sub">
                    <a href="javascript:void(0);" class="side-menu__item font-first-geo">
                        <i class="ri ri-store-line side-menu__icon"></i>
                        <span class="side-menu__label font-bold">{{ __('admin.sidebar_products') }}</span>
                        <i class="ri ri-arrow-right-s-line side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1">
                        <li class="slide"><a href="#" class="side-menu__item font-second-geo">{{ __('admin.sidebar_all_products') }}</a></li>
                        <li class="slide"><a href="#" class="side-menu__item font-second-geo">{{ __('admin.sidebar_categories_product') }}</a></li>
                        <li class="slide"><a href="#" class="side-menu__item font-second-geo">{{ __('admin.sidebar_tags_product') }}</a></li>
                        <li class="slide"><a href="#" class="side-menu__item font-second-geo">{{ __('admin.sidebar_orders') }}</a></li>
                        <li class="slide"><a href="#" class="side-menu__item font-second-geo">{{ __('admin.sidebar_payments') }}</a></li>
                    </ul>
                </li>

                <li class="slide">
                    <a href="#" class="side-menu__item font-first-geo">
                        <i class="ri ri-equalizer-line side-menu__icon"></i>
                        <span class="side-menu__label font-bold">{{ __('admin.sidebar_sliders') }} </span>
                    </a>
                </li>

                <li class="slide__category font-second-geo"><span class="category-name">{{ __('admin.sidebar_additionally_setting') }}</span></li>
                <li class="slide has-sub">
                    <a href="javascript:void(0);" class="side-menu__item font-first-geo">
                        <i class="ri ri-group-line side-menu__icon"></i>
                        <span class="side-menu__label font-bold">{{ __('admin.sidebar_users') }}</span>
                        <i class="ri ri-arrow-right-s-line side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1">
                        <li class="slide"><a href="#" class="side-menu__item font-second-geo">{{ __('admin.sidebar_customers') }}</a></li>
                        <li class="slide"><a href="#" class="side-menu__item font-second-geo">{{ __('admin.sidebar_administrators') }}</a></li>
                        <li class="slide"><a href="#" class="side-menu__item font-second-geo">{{ __('admin.sidebar_subscribers') }}</a></li>
                        <li class="slide"><a href="#" class="side-menu__item font-second-geo">{{ __('admin.sidebar_roles') }}</a></li>
                        <li class="slide"><a href="#" class="side-menu__item font-second-geo">{{ __('admin.sidebar_permissions') }}</a></li>
                    </ul>
                </li>

                <li class="slide has-sub">
                    <a href="javascript:void(0);" class="side-menu__item font-first-geo">
                        <i class="ri ri-global-line side-menu__icon"></i>
                        <span class="side-menu__label font-bold">{{ __('admin.sidebar_locales') }}</span>
                        <i class="ri ri-arrow-right-s-line side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1">
                        <li class="slide"><a href="#" class="side-menu__item font-second-geo">{{ __('admin.sidebar_all_locales') }}</a></li>
                        <li class="slide"><a href="#" class="side-menu__item font-second-geo">{{ __('admin.sidebar_static_words') }}</a></li>
                    </ul>
                </li>

                <li class="slide has-sub">
                    <a href="javascript:void(0);" class="side-menu__item font-first-geo">
                        <i class="ri ri-settings-5-line side-menu__icon"></i>
                        <span class="side-menu__label font-bold">{{ __('admin.sidebar_site_settings') }}</span>
                        <i class="ri ri-arrow-right-s-line side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1">
                        <li class="slide"><a href="#" class="side-menu__item font-second-geo">{{ __('admin.sidebar_settings') }}</a></li>
                        <li class="slide"><a href="#" class="side-menu__item font-second-geo">{{ __('admin.sidebar_social_networks') }}</a></li>
                        <li class="slide"><a href="#" class="side-menu__item font-second-geo">{{ __('admin.sidebar_backups') }}</a></li>
                    </ul>
                </li>
                <li class="slide">
                    <a href="{{ route('backend.logout') }}" aria-expanded="false" class="side-menu__item font-first-geo !bg-secondary/10 text-danger" onclick="event.preventDefault();
                                     document.getElementById('logout-form').submit();">
                        <i class="ri ri-logout-circle-line side-menu__icon text-danger"></i>
                        <span class="side-menu__label font-bold text-danger">{{ __('admin.sidebar_logout') }} </span>
                    </a>
                    <form id="logout-form" action="{{ route('backend.logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>
            <div class="slide-right" id="slide-right">
                <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24">
                    <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z"></path>
                </svg>
            </div>
        </nav>
    </div>
</aside>

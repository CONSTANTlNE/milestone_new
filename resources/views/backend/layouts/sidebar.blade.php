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
                    <a href="{{ route('backend.index') }}" class="side-menu__item font-first-geo {{ request()->routeIs('backend.index') ? 'active' : '' }}">
                        <i class="ri ri-home-4-line side-menu__icon"></i>
                        <span class="side-menu__label font-bold">{{ __('admin.sidebar_dashboard') }}</span>
                    </a>
                </li>

                @can('backend.dashboard.analytics')
                <li class="slide">
                    <a href="{{ route('backend.dashboard.analytics') }}" class="side-menu__item font-first-geo {{ request()->routeIs('backend.dashboard.analytics') ? 'active' : '' }}">
                        <i class="ri ri-pie-chart-line side-menu__icon"></i>
                        <span class="side-menu__label font-bold">{{ __('admin.sidebar_analytics') }} </span>
                    </a>
                </li>
                @endcan
                @can('backend.menus.index')
                <li class="slide">
                    <a href="{{ route('backend.menus.index') }}" class="side-menu__item font-first-geo {{ request()->routeIs('backend.menus.*') ? 'active' : '' }}">
                        <i class="ri ri-menu-line side-menu__icon"></i>
                        <span class="side-menu__label font-bold">{{ __('admin.sidebar_menu') }} </span>
                    </a>
                </li>
                @endcan
                @can('backend.files.index')
                <li class="slide">
                    <a href="{{ route('backend.files.index') }}" class="side-menu__item font-first-geo {{ request()->routeIs('backend.files.*') ? 'active' : '' }}">
                        <i class="ri ri-folders-line side-menu__icon"></i>
                        <span class="side-menu__label font-bold">{{ __('admin.sidebar_file_manager') }} </span>
                    </a>
                </li>
                @endcan
                @can('backend.pages.index')
                <li class="slide__category font-second-geo"><span class="category-name">{{ __('admin.sidebar_content') }}</span></li>
                <li class="slide {{ request()->routeIs('backend.pages.*') ? 'is-expanded' : '' }}">
                    <a href="{{ route('backend.pages.index') }}" class="side-menu__item font-first-geo {{ request()->routeIs('backend.pages.*') ? 'active' : '' }}">
                        <i class="ri ri-pages-line side-menu__icon"></i>
                        <span class="side-menu__label font-bold">{{ __('admin.sidebar_pages') }} </span>
                    </a>
                </li>
                @endcan
                @can('backend.sliders.index')
                    <li class="slide has-sub {{ request()->routeIs('backend.sliders.*') || request()->routeIs('backend.portfolios.*') || request()->routeIs('backend.faqs.*') || request()->routeIs('backend.services.*') || request()->routeIs('backend.payments.*') ? 'open' : '' }}">
                        <a href="javascript:void(0);" class="side-menu__item font-first-geo {{ request()->routeIs('backend.sliders.*') || request()->routeIs('backend.portfolios.*') || request()->routeIs('backend.productTags.*') || request()->routeIs('backend.orders.*') || request()->routeIs('backend.payments.*') ? 'active' : '' }}">
                            <i class="ri ri-folder-chart-line side-menu__icon"></i>
                            <span class="side-menu__label font-bold">{{ __('admin.sidebar_content') }}</span>
                            <i class="ri ri-arrow-right-s-line side-menu__angle"></i>
                        </a>
                        <ul class="slide-menu child1">
                            @can('backend.sliders.index')
                                <li class="slide"><a href="{{ route('backend.sliders.index') }}" class="side-menu__item font-second-geo {{ request()->routeIs('backend.sliders.*') ? 'active' : '' }}">{{ __('admin.sidebar_sliders') }}</a></li>
                            @endcan
                            @can('backend.portfolios.index')
                                <li class="slide"><a href="{{ route('backend.portfolios.index') }}" class="side-menu__item font-second-geo {{ request()->routeIs('backend.portfolios.*') ? 'active' : '' }}">{{ __('admin.sidebar_portfolios') }}</a></li>
                            @endcan
                            @can('backend.services.index')
                                <li class="slide"><a href="{{ route('backend.services.index') }}" class="side-menu__item font-second-geo {{ request()->routeIs('backend.services.*') ? 'active' : '' }}">{{ __('admin.sidebar_services') }}</a></li>
                            @endcan
                            @can('backend.faqs.index')
                                <li class="slide"><a href="{{ route('backend.faqs.index') }}" class="side-menu__item font-second-geo {{ request()->routeIs('backend.faqs.*') ? 'active' : '' }}">{{ __('admin.sidebar_faqs') }}</a></li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can('backend.blogs.index')
                <li class="slide has-sub {{ request()->routeIs('backend.blogs.*') || request()->routeIs('backend.blogCategories.*') || request()->routeIs('backend.blogTags.*') ? 'open' : '' }}">
                    <a href="javascript:void(0);" class="side-menu__item font-first-geo {{ request()->routeIs('backend.blogs.*') || request()->routeIs('backend.blogCategories.*') || request()->routeIs('backend.tags.*') ? 'active' : '' }}">
                        <i class="ri ri-newspaper-line side-menu__icon"></i>
                        <span class="side-menu__label font-bold">{{ __('admin.sidebar_blogs') }}</span>
                        <i class="ri ri-arrow-right-s-line side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1">
                        <li class="slide"><a href="{{ route('backend.blogs.index') }}" class="side-menu__item font-second-geo {{ request()->routeIs('backend.blogs.*') ? 'active' : '' }}">{{ __('admin.sidebar_all_blogs') }}</a></li>
                        @can('backend.blogCategories.index')
                        <li class="slide"><a href="{{ route('backend.blogCategories.index') }}" class="side-menu__item font-second-geo {{ request()->routeIs('backend.blogCategories.*') ? 'active' : '' }}">{{ __('admin.sidebar_categories_blog') }}</a></li>
                        @endcan
{{--                        @can('backend.tags.index')--}}
{{--                        <li class="slide"><a href="{{ route('backend.tags.index') }}" class="side-menu__item font-second-geo {{ request()->routeIs('backend.tags.*') ? 'active' : '' }}">{{ __('admin.sidebar_tags') }}</a></li>--}}
{{--                        @endcan--}}
                    </ul>
                </li>
                @endcan
                @can('backend.products.index')
                <li class="slide has-sub {{ request()->routeIs('backend.products.*') || request()->routeIs('backend.productCategory.*') || request()->routeIs('backend.productTags.*') || request()->routeIs('backend.orders.*') || request()->routeIs('backend.payments.*') ? 'is-expanded' : '' }}">
                    <a href="javascript:void(0);" class="side-menu__item font-first-geo {{ request()->routeIs('backend.products.*') || request()->routeIs('backend.productCategory.*') || request()->routeIs('backend.productTags.*') || request()->routeIs('backend.orders.*') || request()->routeIs('backend.payments.*') ? 'active' : '' }}">
                        <i class="ri ri-store-line side-menu__icon"></i>
                        <span class="side-menu__label font-bold">{{ __('admin.sidebar_products') }}</span>
                        <i class="ri ri-arrow-right-s-line side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1">
                        <li class="slide"><a href="{{ route('backend.products.index') }}" class="side-menu__item font-second-geo {{ request()->routeIs('backend.products.*') ? 'active' : '' }}">{{ __('admin.sidebar_all_products') }}</a></li>
                        @can('backend.productCategory.index')
                        <li class="slide"><a href="{{ route('backend.productCategory.index') }}" class="side-menu__item font-second-geo {{ request()->routeIs('backend.productCategory.*') ? 'active' : '' }}">{{ __('admin.sidebar_categories_product') }}</a></li>
                        @endcan
                        @can('backend.productTags.index')
                        <li class="slide"><a href="{{ route('backend.productTags.index') }}" class="side-menu__item font-second-geo {{ request()->routeIs('backend.productTags.*') ? 'active' : '' }}">{{ __('admin.sidebar_tags_product') }}</a></li>
                        @endcan
                        @can('backend.orders.index')
                        <li class="slide"><a href="{{ route('backend.orders.index') }}" class="side-menu__item font-second-geo {{ request()->routeIs('backend.orders.*') ? 'active' : '' }}">{{ __('admin.sidebar_orders') }}</a></li>
                        @endcan
                        @can('backend.payments.index')
                        <li class="slide"><a href="{{ route('backend.payments.index') }}" class="side-menu__item font-second-geo {{ request()->routeIs('backend.payments.*') ? 'active' : '' }}">{{ __('admin.sidebar_payments') }}</a></li>
                        @endcan
                    </ul>
                </li>
                @endcan

                @can('backend.users.index')
                <li class="slide__category font-second-geo"><span class="category-name">{{ __('admin.sidebar_additionally_setting') }}</span></li>
                <li class="slide has-sub {{ request()->routeIs('backend.users.*') || request()->routeIs('backend.customers.*') || request()->routeIs('backend.subscribers.*') || request()->routeIs('backend.roles.*') || request()->routeIs('backend.permissions.*') ? 'open' : '' }}">
                    <a href="javascript:void(0);" class="side-menu__item font-first-geo {{ request()->routeIs('backend.users.*') || request()->routeIs('backend.customers.*') || request()->routeIs('backend.subscribers.*') || request()->routeIs('backend.roles.*') || request()->routeIs('backend.permissions.*') ? 'active' : '' }}">
                        <i class="ri ri-group-line side-menu__icon"></i>
                        <span class="side-menu__label font-bold">{{ __('admin.sidebar_users') }}</span>
                        <i class="ri ri-arrow-right-s-line side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1">
                        @can('backend.customers.index')
                        <li class="slide"><a href="{{ route('backend.customers.index') }}" class="side-menu__item font-second-geo {{ request()->routeIs('backend.customers.*') ? 'active' : '' }}">{{ __('admin.sidebar_customers') }}</a></li>
                        @endcan
                        <li class="slide"><a href="{{ route('backend.users.index') }}" class="side-menu__item font-second-geo {{ request()->routeIs('backend.users.*') ? 'active' : '' }}">{{ __('admin.sidebar_administrators') }}</a></li>
                        @can('backend.subscribers.index')
                        <li class="slide"><a href="{{ route('backend.subscribers.index') }}" class="side-menu__item font-second-geo {{ request()->routeIs('backend.subscribers.*') ? 'active' : '' }}">{{ __('admin.sidebar_subscribers') }}</a></li>
                        @endcan
                        @can('backend.roles.index')
                        <li class="slide"><a href="{{ route('backend.roles.index') }}" class="side-menu__item font-second-geo {{ request()->routeIs('backend.roles.*') ? 'active' : '' }}">{{ __('admin.sidebar_roles') }}</a></li>
                        @endcan
                        @can('backend.permissions.index')
                        <li class="slide"><a href="{{ route('backend.permissions.index') }}" class="side-menu__item font-second-geo {{ request()->routeIs('backend.permissions.*') ? 'active' : '' }}">{{ __('admin.sidebar_permissions') }}</a></li>
                        @endcan
                    </ul>
                </li>
                @endcan
                @can('backend.locales.index')
                <li class="slide has-sub {{ request()->routeIs('backend.locales.*') ? 'open' : '' }}">
                    <a href="javascript:void(0);" class="side-menu__item font-first-geo {{ request()->routeIs('backend.locales.*') ? 'active' : '' }}">
                        <i class="ri ri-global-line side-menu__icon"></i>
                        <span class="side-menu__label font-bold">{{ __('admin.sidebar_locales') }}</span>
                        <i class="ri ri-arrow-right-s-line side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1">
                        <li class="slide"><a href="{{ route('backend.locales.index') }}" class="side-menu__item font-second-geo {{ request()->routeIs('backend.locales.index') ? 'active' : '' }}">{{ __('admin.sidebar_all_locales') }}</a></li>
                        @can('backend.locales.static')
                        <li class="slide"><a href="{{ route('backend.locales.static.index') }}" class="side-menu__item font-second-geo {{ request()->routeIs('backend.locales.static.*') ? 'active' : '' }}">{{ __('admin.sidebar_static_words') }}</a></li>
                        @endcan
                    </ul>
                </li>
                @endcan
                @can('backend.settings.show')
                <li class="slide has-sub {{ request()->routeIs('backend.settings.*') || request()->routeIs('backend.socials.*') || request()->routeIs('backend.backups.*') ? 'open' : '' }}">
                    <a href="javascript:void(0);" class="side-menu__item font-first-geo {{ request()->routeIs('backend.settings.*') || request()->routeIs('backend.socials.*') || request()->routeIs('backend.backups.*') ? 'active' : '' }}">
                        <i class="ri ri-settings-5-line side-menu__icon"></i>
                        <span class="side-menu__label font-bold">{{ __('admin.sidebar_site_settings') }}</span>
                        <i class="ri ri-arrow-right-s-line side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1">
                        <li class="slide"><a href="{{ route('backend.settings.edit') }}" class="side-menu__item font-second-geo {{ request()->routeIs('backend.settings.*') ? 'active' : '' }}">{{ __('admin.sidebar_settings') }}</a></li>
                        @can('backend.socials.index')
                        <li class="slide"><a href="{{ route('backend.socials.index') }}" class="side-menu__item font-second-geo {{ request()->routeIs('backend.socials.*') ? 'active' : '' }}">{{ __('admin.sidebar_social_networks') }}</a></li>
                        @endcan
                        @can('backend.backups.index')
                        <li class="slide"><a href="{{ route('backend.backups.index') }}" class="side-menu__item font-second-geo {{ request()->routeIs('backend.backups.*') ? 'active' : '' }}">{{ __('admin.sidebar_backups') }}</a></li>
                        @endcan
                    </ul>
                </li>
                @endcan
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

<div class="profile header-element md:!px-[0.65rem] px-2 hs-dropdown !items-center ti-dropdown [--placement:bottom-left]">
    <button id="dropdown-profile" type="button"
            class="text-image !gap-2 !p-0 flex-shrink-0 sm:me-2 me-0 !rounded-full !shadow-none text-xs align-middle !border-0 !shadow-transparent ">
        @if(Auth::user()->src)
            <div>
                <img class="inline-block" src="{{ asset(Auth::user()->src ?? config('filemanager.default_backend_avatar_image')) }}" width="44" height="44" alt="Image Avatar">
            </div>
        @else
             <span>{{ get_name_initials(Auth::user()->name) }}</span>
        @endif
    </button>
    <div id="dropdown-profile"  class="cursor-pointer md:block hidden dropdown-profile hs-dropdown-toggle ti-dropdown-toggle !gap-2 !p-0 flex-shrink-0 sm:me-2 me-0 !rounded-full !shadow-none text-xs align-middle !border-0 !shadow-transparent">
        <p class="font-first-geo font-bold mb-0 leading-none text-[#536485] text-[0.813rem] hover-title">
            @if(Arr::get(Auth::user()->getTranslations('title'), app()->getLocale()) === null)
                {{ Auth::user()->getTranslation('title', array_keys(Auth::user()->getTranslations('title'))[0]) }}
            @else
                {{Auth::user()->title}}
            @endif
        </p>
        <span class="font-second-geo text-[#536485] block hover-role dropdown-profile">
            @if(!empty(Auth::user()->roles()->pluck('id')->implode(' ')))
                {{ __('admin.role') }} : <span class="font-bold">{{ Auth::user()->roles()->pluck('name')->implode(' ') }}</span>
            @endif
        </span>
    </div>
    <div
        class="hs-dropdown-menu ti-dropdown-menu !-mt-3 border-0 w-[11rem] !p-0 border-defaultborder hidden main-header-dropdown  pt-0 overflow-hidden header-profile-dropdown dropdown-menu-end"
        aria-labelledby="dropdown-profile">

        <ul class="text-defaulttextcolor font-medium dark:text-[#8c9097] dark:text-white/50">
            @can('backend.users.edit')
            <li>
                <a class="w-full ti-dropdown-item !text-[0.8125rem] !gap-x-0  !p-[0.65rem] !inline-flex font-second-geo" href="#">
                    <i class="ri ri-user-settings-line text-[1.125rem] me-2 opacity-[0.7] margin-top-min"></i>{{ __('admin.profile') }}
                </a>
            </li>
            @endcan
            @can('backend.settings.show')
            <li>
                <a class="w-full ti-dropdown-item !text-[0.8125rem] !gap-x-0 !p-[0.65rem] !inline-flex font-second-geo" href="#">
                    <i class="ri ri-settings-5-line text-[1.125rem] me-2 opacity-[0.7] margin-top-min"></i>{{ __('admin.sidebar_setting') }}
                </a>
            </li>
            @endcan
            @can('backend.dashboard.information')
            <li>
                <a class="w-full ti-dropdown-item !text-[0.8125rem] !p-[0.65rem] !gap-x-0 !inline-flex font-second-geo" href="#">
                    <i class="ri ri-information-line text-[1.125rem] me-2 opacity-[0.7] margin-top-min"></i>{{ __('admin.information') }}
                </a>
            </li>
            @endcan
            <li>
                <a href="{{ route('backend.logout') }}" aria-expanded="false" class="w-full ti-dropdown-item !text-[0.8125rem] !p-[0.65rem] !gap-x-0 !inline-flex font-second-geo bg-danger login" onclick="event.preventDefault();
                                     document.getElementById('logout-form').submit();">
                    <i class="ri ri-logout-circle-line text-[1.125rem] me-2 opacity-[0.7] margin-top-min"></i> {{ __('admin.sidebar_logout') }}
                </a>
                <form id="logout-form" action="{{ route('backend.logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
        </ul>
    </div>
</div>

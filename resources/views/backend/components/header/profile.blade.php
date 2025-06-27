<div class="header-element md:!px-[0.65rem] px-2 hs-dropdown !items-center ti-dropdown [--placement:bottom-left]">
    <button id="dropdown-profile" type="button"
            class="hs-dropdown-toggle ti-dropdown-toggle !gap-2 !p-0 flex-shrink-0 sm:me-2 me-0 !rounded-full !shadow-none text-xs align-middle !border-0 !shadow-transparent ">
        @if(Auth::user()->src)
            <img class="inline-block rounded-full " src="../assets/images/faces/9.jpg"  width="32" height="32" alt="Image Description">
        @else
            {{ get_name_initials(Auth::user()->name) }}
        @endif
    </button>
    <div class="md:block hidden dropdown-profile">
        <p class="font-semibold mb-0 leading-none text-[#536485] text-[0.813rem] ">
            @if(Arr::get(Auth::user()->getTranslations('title'), app()->getLocale()) === null)
                {{ Auth::user()->getTranslation('title', array_keys(Auth::user()->getTranslations('title'))[0]) }}
            @else
                {{Auth::user()->title}}
            @endif
        </p>
        <span class="opacity-[0.7] font-normal text-[#536485] block text-[0.6875rem] ">
            @if(!empty(Auth::user()->roles()->pluck('id')->implode(' ')))
                {{ Auth::user()->roles()->pluck('name')->implode(' ') }}
            @endif
        </span>
    </div>
    <div
        class="hs-dropdown-menu ti-dropdown-menu !-mt-3 border-0 w-[11rem] !p-0 border-defaultborder hidden main-header-dropdown  pt-0 overflow-hidden header-profile-dropdown dropdown-menu-end"
        aria-labelledby="dropdown-profile">

        <ul class="text-defaulttextcolor font-medium dark:text-[#8c9097] dark:text-white/50">
{{--            @can('backend.users.edit')--}}
            <li>
                <a class="w-full ti-dropdown-item !text-[0.8125rem] !gap-x-0  !p-[0.65rem] !inline-flex" href="#">
                    <i class="bx bx-user text-[1.125rem] me-2 opacity-[0.7]"></i>Profile
                </a>
            </li>
{{--            @endcan--}}
{{--            @can('backend.users.edit')--}}
            <li>
                <a class="w-full ti-dropdown-item !text-[0.8125rem] !gap-x-0 !p-[0.65rem] !inline-flex" href="#">
                    <i class="ti ti-adjustments-horizontal text-[1.125rem] me-2 opacity-[0.7]"></i>Settings
                </a>
            </li>
{{--            @endcan--}}
{{--            @can('backend.users.edit')--}}
            <li>
                <a class="w-full ti-dropdown-item !text-[0.8125rem] !p-[0.65rem] !gap-x-0 !inline-flex" href="#">
                    <i class="ti ti-headset text-[1.125rem] me-2 opacity-[0.7]"></i>Information
                </a>
            </li>
{{--            @endcan--}}
            <li>
                <a class="w-full ti-dropdown-item !text-[0.8125rem] !p-[0.65rem] !gap-x-0 !inline-flex" href="#">
                    <i class="ti ti-logout text-[1.125rem] me-2 opacity-[0.7]"></i>Log Out
                </a>
            </li>
        </ul>
    </div>
</div>
<!-- End Header Profile -->

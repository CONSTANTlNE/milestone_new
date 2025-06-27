<div class="header-element header-apps dark:text-[#8c9097] dark:text-white/50 py-[1rem] md:px-[0.65rem] px-2 hs-dropdown ti-dropdown md:!block !hidden [--placement:bottom-left]">

    <button aria-label="button" id="dropdown-apps" type="button"
            class="hs-dropdown-toggle ti-dropdown-toggle !p-0 !border-0 flex-shrink-0  !rounded-full !shadow-none text-xs">
        <i class="bx bx-grid-alt header-link-icon text-[1.125rem]"></i>
    </button>

    <div
        class="main-header-dropdown !-mt-3 hs-dropdown-menu ti-dropdown-menu !w-[22rem] border-0 border-defaultborder   hidden"
        aria-labelledby="dropdown-apps">

        <div class="divide-gray-200 dark:divide-white/10 main-header-shortcuts p-2">
            <div class="grid grid-cols-2 gap-2">
                <x-backend.cache-button
                    icon="🧠"
                    label="App Cache"
                    command="cache:clear"
                    :route="route('backend.clear-cache')" />

                <x-backend.cache-button
                    icon="📦"
                    label="Optimize Class"
                    command="optimize"
                    :route="route('backend.optimize')" />

                <x-backend.cache-button
                    icon="🔁"
                    label="Routes Cache"
                    command="route:clear"
                    :route="route('backend.clear-route')" />

                <x-backend.cache-button
                    icon="🔁"
                    label="Routes Cache"
                    command="route:cache"
                    :route="route('backend.cache-route')" />

                <x-backend.cache-button
                    icon="🧭"
                    label="Config Clear"
                    command="config:clear"
                    :route="route('backend.clear-config')" />

                <x-backend.cache-button
                    icon="🧭"
                    label="Config Cache"
                    command="config:cache"
                    :route="route('backend.cache-config')" />

                <x-backend.cache-button
                    icon="🎨"
                    label="View Cache"
                    command="view:clear"
                    :route="route('backend.clear-view')" />

                <x-backend.cache-button
                    icon="🎨"
                    label="View Cache"
                    command="view:cache"
                    :route="route('backend.cache-view')" />
            </div>
        </div>
    </div>
</div>

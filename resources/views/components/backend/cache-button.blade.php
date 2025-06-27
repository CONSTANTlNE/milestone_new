@props([
    'command' => '',
    'label' => '',
    'icon' => '',
    'route' => '#'
])
<div>
    <a href="{{ $route }}" class="p-4 items-center related-app block text-center rounded-sm hover:bg-gray-50 dark:hover:bg-black/20">
        <div>
            <div class="!h-[1.75rem] !w-[1.75rem] text-2xl avatar text-primary flex justify-center items-center mx-auto">{{ $icon }}</div>
            <div class="text-[0.75rem] text-defaulttextcolor dark:text-[#8c9097] dark:text-white/50">
                {{ $label }} <br>
                <span class="border-t border-dashed border-black dark:border-white/40">{{ $command }}</span>
            </div>
        </div>
    </a>
</div>

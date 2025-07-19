@props([
    'icon' => 'ri-shield-keyhole-line',
    'title' => __('admin.no_found_title'),
    'description' => __('admin.no_found_description'),
    'actionText' => null,
    'actionIcon' => 'ri-add-line',
    'permission' => null
])

<div class="empty-state">
    <i class="{{ $icon }} text-4xl text-gray-400 mb-2"></i>
    <h5 class="text-gray-500 font-second-geo">{{ $title }}</h5>
    <p class="text-gray-400 font-second-geo">{{ $description }}</p>
    
    @can($permission)
        <a href="{{ route($permission) }}" class="ti-btn bg-primary text-white !font-medium font-second-geo mt-2">
            <i class="{{ $actionIcon }} text-[1.375rem]"></i>
            {{ $actionText }}
        </a>
    @endcan
</div> 
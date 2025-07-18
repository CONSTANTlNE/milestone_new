@props([
    'status' => false,
])
<div class="filter-controls">
    <div class="flex items-center gap-3">
        @if($status)
        <div class="filterSelect">
            <select class="form-select js-choices" id="filterSelect" name="status">
                <option value="all" {{ request('status', 'all') == 'all' ? 'selected' : '' }}>{{ __('admin.status') }}</option>
                <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>{{ __('admin.active') }}</option>
                <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>{{ __('admin.disable') }}</option>
            </select>
        </div>
        @endif
        <div class="flex items-center gap-3" role="search">
            <input class="form-control w-full !rounded-none pr-12" type="search" placeholder="{{__('admin.search')}}..." id="searchInput" value="{{ request('search') }}">
            <button class="ti-btn ti-btn-light !mb-0" type="submit"><i class="ri-search-line"></i></button>
        </div>
        <div>
            <button type="button" class="ti-btn ti-btn-light" id="clearFilters">
                <i class="ri-refresh-line"></i>
            </button>
        </div>
    </div>
</div>

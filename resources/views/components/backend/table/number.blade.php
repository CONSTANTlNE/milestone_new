<div class="box-show-number">
    {{ __('admin.number_show') }}
    <div class="show-number show-number font-second-geo">
        <label for="table-number" class="hidden">{{ __('admin.number_entries') }}</label>
        <select class="form-control w-full !rounded-md js-choices" name="per_page" id="table-number">
            <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10</option>
            <option value="25" {{ request('per_page', 10) == 25 ? 'selected' : '' }}>25</option>
            <option value="50" {{ request('per_page', 10) == 50 ? 'selected' : '' }}>50</option>
        </select>
    </div>
    {{ __('admin.number_entries') }}
</div>
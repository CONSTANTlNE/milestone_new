@extends('backend.layouts.master')
@section('title') {{ __('admin.create_role') }} @endsection
@section('content')
    <div class="content">
        <div class="main-content">

            <div class="block justify-between page-header md:flex">
                <div>
                    <h3 class="!text-defaulttextcolor dark:!text-defaulttextcolor/70 dark:text-white dark:hover:text-white text-[1.375rem] font-semibold font-first-geo">
                        {{ __('admin.create_role') }}
                    </h3>
                    <p class="font-second-geo text-defaulttextcolor/70">{{ __('admin.welcome') }}</p>
                </div>
                <ol class="flex items-center whitespace-nowrap min-w-0 gap-3 header-nav-links">
                    @can('backend.roles.index')
                        <li class="text-[0.813rem] ps-[0.5rem]">
                            <a href="{{ route('backend.roles.index') }}" class="ti-btn bg-secondary text-white !font-medium font-second-geo">
                                <i class="ri-arrow-go-back-line text-[1.375rem]"></i>
                                {{ __('admin.return_back') }} - {{ __('admin.all_roles') }}
                            </a>
                        </li>
                    @endcan
                    @can('backend.roles.trash')
                        <li class="text-[0.813rem] text-defaulttextcolor font-semibold hover:text-danger dark:text-[#8c9097] dark:text-white/50">
                            <a href="{{ route('backend.roles.trash') }}" class="ti-btn bg-danger text-white !font-medium font-second-geo">
                                <i class="ri-delete-bin-2-line text-[1.375rem]"></i>
                                {{__('admin.deleted_roles')}}
                            </a>
                        </li>
                    @endcan
                </ol>
            </div>

            @include('backend.layouts.components.errors',[
              'errors' => $errors,
            ])

            <form method="post" action="{{ route('backend.roles.store') }}" novalidate enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-12 gap-6 white-bg">
                    <div class="xl:col-span-9 col-span-12">
                        <div class="box">
                            <div class="box-body">
                                @include('backend.layouts.includes.langTabComponent')
                                <div class="tab-content">
                                    @foreach(getLocales() as $key => $lang)
                                        <div
                                            class="{{($key == 0) ? '' : 'hidden'}}"
                                            id="locale-{{$lang->code}}"
                                            role="tabpanel"
                                            aria-labelledby="locale-item-{{$lang->code}}"
                                        >
                                            <div class=""
                                                 id="content-locale-{{$lang->code}}"
                                                 role="tabpanel"
                                                 aria-labelledby="content-locale-item-{{$lang->code}}">
                                                <div class="p-5 border rounded-ss-none rounded-sm dark:border-white/10 border-gray-200 content-section">

                                                    <x-backend.input
                                                        type="text"
                                                        :lang="$lang"
                                                        :data="null"
                                                        label="title"
                                                        column="title"
                                                        place-holder="holder_title"
                                                        success-text="success_field"
                                                        help-text="error_field"
                                                        :required="true"
                                                        :disabled="false"
                                                    />


                                                </div>
                                            </div>

                                        </div>
                                    @endforeach
                                    <div class="mt-4">
                                        <x-backend.input
                                            type="text"
                                            :lang="null"
                                            :data="null"
                                            label="role_code"
                                            column="name"
                                            place-holder="role_example"
                                            success-text="success_field"
                                            help-text="error_field"
                                            :required="true"
                                            :disabled="false"
                                        />
                                    </div>
                                </div>




                                <div class="form-group position-relative select-access mt-4">
                                    <div class="block text-sm text-gray-600 font-medium dark:text-white font-second-geo">
                                        <div class="py-1">
                                            <input type="checkbox" id="select-all-global">
                                            <label for="select-all-global" style="font-weight: normal;">
                                                მონიშნეთ ყველა უფლება ან {{ __('admin.choose_permissions') }}</label>
                                        </div>
                                    </div>

                                    @php
                                        // In your controller method
                                        $permissions = \App\Models\Permission::all();

                                        // Group by the second segment (e.g., 'pages' in 'backend.pages.index')
                                        $groupedPermissions = $permissions->groupBy(function($permission) {
                                            $parts = explode('.', $permission->name);
                                            return $parts[1] ?? $permission->name; // fallback to name if not enough parts
                                        });
                                    @endphp
                                    <div class="grid grid-cols-12 gap-6 white-bg">
                                    @foreach($groupedPermissions as $group => $permissions)
                                        <div class="permission-group-box md:col-span-4 mb-4 p-3 border rounded">
                                            <div class="font-bold mb-2 text-primary flex items-center gap-2">
                                                {{ ucfirst($group) }}
                                                <input type="checkbox" class="select-all-group" data-group="{{ $group }}" id="select-all-{{ $group }}">
                                                <label for="select-all-{{ $group }}" style="font-weight: normal;">{{__('admin.select_all')}}</label>
                                            </div>
                                            @foreach($permissions as $permission)
                                                <div class="form-check">
                                                    <input class="form-check-input permission-checkbox permission-checkbox-{{ $group }}" type="checkbox" name="permission[]" value="{{ $permission->id }}" id="checkebox-{{$permission->id}}">
                                                    <label class="form-check-label" for="checkebox-{{$permission->id}}">
                                                        {{ $permission->getTranslation('title', app()->getLocale()) }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="box-footer text-end">
                                <button type="submit" class="ti-btn bg-primary text-white font-second-geo">
                                    <i class="ri-add-line"></i>
                                    {{__('admin.create')}}
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="xl:col-span-3 col-span-12">
                        <div class="box">
                            <div class="box-body">

                                <x-backend.publishDate
                                    :data="null"
                                    column="published_at"
                                    label="published_at"
                                    place-holder=""
                                    success-text="success_field"
                                    help-text="error_field"
                                    :required="false"
                                    :disabled="false"
                                    :staticData="false"
                                    width="12"
                                />

                                <x-backend.selectStatic
                                    :data="config('crm.status')"
                                    column="has_backend_access"
                                    label="has_backend_access"
                                    place-holder=""
                                    success-text="success_field"
                                    help-text="error_field"
                                    :required="true"
                                    :disabled="false"
                                    :staticData="false"
                                    hidden="show-search-hidden"
                                    width="12"
                                />

                            </div>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>
@endsection
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Group select all
            document.querySelectorAll('.select-all-group').forEach(function(selectAllCheckbox) {
                selectAllCheckbox.addEventListener('change', function() {
                    var group = this.getAttribute('data-group');
                    var checkboxes = document.querySelectorAll('.permission-checkbox-' + group);
                    checkboxes.forEach(function(checkbox) {
                        checkbox.checked = selectAllCheckbox.checked;
                    });
                });
            });

            // Global select all
            var globalSelectAll = document.getElementById('select-all-global');
            globalSelectAll.addEventListener('change', function() {
                var allCheckboxes = document.querySelectorAll('.permission-checkbox');
                allCheckboxes.forEach(function(checkbox) {
                    checkbox.checked = globalSelectAll.checked;
                });
                // Also update all group select-alls
                document.querySelectorAll('.select-all-group').forEach(function(groupCheckbox) {
                    groupCheckbox.checked = globalSelectAll.checked;
                });
            });

            // If any permission is unchecked, uncheck global select all
            document.querySelectorAll('.permission-checkbox').forEach(function(checkbox) {
                checkbox.addEventListener('change', function() {
                    var all = document.querySelectorAll('.permission-checkbox');
                    var allChecked = Array.from(all).every(cb => cb.checked);
                    globalSelectAll.checked = allChecked;
                });
            });
        });
    </script>
@endpush

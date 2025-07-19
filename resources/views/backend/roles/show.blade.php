@extends('backend.layouts.master')
@section('title') {{ __('admin.view_role') }} @endsection
@section('content')
    <div class="content">
        <div class="main-content">
            <div class="block justify-between page-header md:flex">
                <div>
                    <h3 class="!text-defaulttextcolor dark:!text-defaulttextcolor/70 dark:text-white dark:hover:text-white text-[1.375rem] font-semibold font-first-geo">
                        {{ __('admin.view_role') }}
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
                    @can('backend.roles.update')
                        <li class="text-[0.813rem] ps-[0.5rem]">
                            <a href="{{ route('backend.roles.edit', $role->id) }}" class="ti-btn bg-warning text-white !font-medium font-second-geo">
                                <i class="ri-edit-line text-[1.375rem]"></i>
                                {{__('admin.edit_role')}}
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

            <div class="grid grid-cols-12 gap-6 white-bg">
                <div class="xl:col-span-9 col-span-12">
                    <div class="box">
                        <div class="box-body">
                            <div class="flex items-center space-x-4 p-4 bg-primary/5 rounded-lg">
                                <div class="w-12 h-12 bg-primary/10 rounded-full flex items-center justify-center">
                                    <i class="ri-shield-keyhole-line text-2xl text-primary"></i>
                                </div>
                                <div class="mx-3">
                                    <h4 class="text-lg font-semibold text-gray-900 dark:text-white">
                                        {{ $role->getTranslation('title', app()->getLocale()) ?: $role->getTranslation('title', 'en') }}
                                    </h4>
                                    <p class="text-sm text-gray-500 font-second-geo">
                                        {{ __('admin.role_id') }}: #{{ $role->id }} | {{ __('admin.has_backend_access') }}
                                        <span class="text-white badge {{ $role->has_backend_access ? 'bg-success' : 'bg-secondary' }}">
                                            {{ $role->has_backend_access ? __('admin.active') : __('admin.inactive') }}
                                        </span>
                                    </p>
                                </div>
                            </div>
                            <div class="form-group position-relative select-access mt-4">
                                <div class="block text-sm text-gray-600 font-medium dark:text-white font-second-geo">
                                    <div class="py-1">
                                        <label for="select-all-global" style="font-weight: normal;">
                                           {{ __('admin.all_permissions') }}</label>
                                    </div>
                                </div>

                                @php
                                    $groupedPermissions = $role->permissions->groupBy(function($permission) {
                                        $parts = explode('.', $permission->name);
                                        return $parts[1] ?? $permission->name; // fallback to name if not enough parts
                                    });
                                @endphp
                                <div class="grid grid-cols-12 gap-6 white-bg">
                                    @foreach($groupedPermissions as $group => $permissions)
                                        <div class="permission-group-box md:col-span-4 mb-4 p-3 border rounded">
                                            <div class="font-bold mb-2 text-primary flex items-center gap-2">
                                                {{ ucfirst($group) }}
                                            </div>
                                            @foreach($permissions as $permission)
                                                <div class="form-check">
                                                    <label class="form-check-label" for="checkebox-{{$permission->id}}">
                                                        {{ $permission->name }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="xl:col-span-3 col-span-12">
                    <div class="box">
                        <div class="box-body">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="bg-gray-50 dark:bg-gray-800 p-4 rounded-lg">
                                    <h6 class="font-medium text-gray-900 dark:text-white mb-2">
                                        <i class="ri-user-line me-2"></i>
                                        {{ __('admin.role_code') }}
                                    </h6>
                                    <p class="card-text"> {{$role->name}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

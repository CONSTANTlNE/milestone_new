@extends('backend.layouts.master')
@section('title') {{ __('admin.view_permission') }} @endsection
@section('content')
    <div class="content">
        <div class="main-content">
            <div class="block justify-between page-header md:flex">
                <div>
                    <h3 class="!text-defaulttextcolor dark:!text-defaulttextcolor/70 dark:text-white dark:hover:text-white text-[1.375rem] font-semibold font-first-geo">
                        {{ __('admin.view_permission') }}
                    </h3>
                    <p class="font-second-geo text-defaulttextcolor/70">{{ __('admin.welcome') }}</p>
                </div>
                <ol class="flex items-center whitespace-nowrap min-w-0 gap-3 header-nav-links">
                    @can('backend.permissions.index')
                        <li class="text-[0.813rem] ps-[0.5rem]">
                            <a href="{{ route('backend.permissions.index') }}" class="ti-btn bg-secondary text-white !font-medium font-second-geo">
                                <i class="ri-arrow-go-back-line text-[1.375rem]"></i>
                                {{ __('admin.return_back') }} - {{ __('admin.all_permissions') }}
                            </a>
                        </li>
                    @endcan
                    @can('backend.permissions.update')
                        <li class="text-[0.813rem] ps-[0.5rem]">
                            <a href="{{ route('backend.permissions.edit', $permission->id) }}" class="ti-btn bg-warning text-white !font-medium font-second-geo">
                                <i class="ri-edit-line text-[1.375rem]"></i>
                                {{__('admin.edit_permission')}}
                            </a>
                        </li>
                    @endcan
                    @can('backend.permissions.trash')
                        <li class="text-[0.813rem] text-defaulttextcolor font-semibold hover:text-danger dark:text-[#8c9097] dark:text-white/50">
                            <a href="{{ route('backend.permissions.trash') }}" class="ti-btn bg-danger text-white !font-medium font-second-geo">
                                <i class="ri-delete-bin-2-line text-[1.375rem]"></i>
                                {{__('admin.deleted_permissions')}}
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
                                    <h4 class="text-lg font-semibold text-gray-900 dark:text-white font-second-geo">
                                        {{ $permission->getTranslation('title', app()->getLocale()) ?: $permission->getTranslation('title', 'en') }}
                                    </h4>
                                    <p class="text-sm text-gray-500 font-second-geo">
                                        {{ __('admin.permission_id') }}: #{{ $permission->id }} | {{ __('admin.status') }}
                                        <span class="text-white badge {{ $permission->status ? 'bg-success' : 'bg-secondary' }}">
                                            {{ $permission->status ? __('admin.active') : __('admin.inactive') }}
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="xl:col-span-3 col-span-12">
                    <div class="box">
                        <div class="box-body">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <h6 class="font-medium text-gray-900 dark:text-white mb-2 font-second-geo">
                                        <i class="ri-route-line me-2"></i>
                                        {{ __('admin.route_information') }}
                                    </h6>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 font-second-geo">
                                        {{ str_replace('.', '/', $permission->name) }}
                                    </p>
                                    <p class="text-xs text-gray-500 font-second-geo">
                                        ({{ $permission->name }})
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

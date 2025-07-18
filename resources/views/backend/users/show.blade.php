@extends('backend.layouts.master')
@section('title') {{ __('admin.view_user') }} @endsection
@section('content')
    <div class="content">
        <div class="main-content">
            <div class="block justify-between page-header md:flex">
                <div>
                    <h3 class="!text-defaulttextcolor dark:!text-defaulttextcolor/70 dark:text-white dark:hover:text-white text-[1.375rem] font-semibold font-first-geo">
                        {{ __('admin.view_user') }}
                    </h3>
                    <p class="font-second-geo text-defaulttextcolor/70">{{ __('admin.welcome') }}</p>
                </div>
                <ol class="flex items-center whitespace-nowrap min-w-0 gap-3 header-nav-links">
                    @can('backend.users.index')
                        <li class="text-[0.813rem] ps-[0.5rem]">
                            <a href="{{ route('backend.users.index') }}" class="ti-btn bg-secondary text-white !font-medium font-second-geo">
                                <i class="ri-arrow-go-back-line text-[1.375rem]"></i>
                                {{ __('admin.return_back') }} - {{ __('admin.all_users') }}
                            </a>
                        </li>
                    @endcan
                    @can('backend.users.update')
                        <li class="text-[0.813rem] ps-[0.5rem]">
                            <a href="{{ route('backend.users.edit', $user->id) }}" class="ti-btn bg-warning text-white !font-medium font-second-geo">
                                <i class="ri-edit-line text-[1.375rem]"></i>
                                {{__('admin.edit_users')}}
                            </a>
                        </li>
                    @endcan
                    @can('backend.users.trash')
                        <li class="text-[0.813rem] text-defaulttextcolor font-semibold hover:text-danger dark:text-[#8c9097] dark:text-white/50">
                            <a href="{{ route('backend.users.trash') }}" class="ti-btn bg-danger text-white !font-medium font-second-geo">
                                <i class="ri-delete-bin-2-line text-[1.375rem]"></i>
                                {{__('admin.deleted_users')}}
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
                                    <i class="ri ri-user-line text-2xl text-primary"></i>
                                </div>
                                <div class="mx-3">
                                    <h4 class="text-lg font-semibold text-gray-900 dark:text-white">
                                        {{ $user->getTranslation('title', app()->getLocale()) ?: $user->getTranslation('title', 'en') }} | {{ $user->email }}
                                    </h4>
                                    <p class="text-sm text-gray-500 font-second-geo">
                                        {{ __('admin.user_id') }}: #{{ $user->id }} | {{ __('admin.status') }}
                                        <span class="text-white badge {{ $user->status ? 'bg-success' : 'bg-secondary' }}">
                                            {{ $user->status ? __('admin.active') : __('admin.inactive') }}
                                        </span>
                                    </p>
                                    <hr>
                                </div>
                            </div>

                            <div class="items-center space-x-4 p-4 bg-primary/5 rounded-lg mt-4 text-sm text-gray-500 font-second-geo">
                                <p>
                                    {{ __('admin.about') }}: {!! $user->content !!}
                                </p>
                            </div>

                            @if(count($user->roles))
                                <div class="items-center space-x-4 p-4 bg-primary/5 rounded-lg mt-4 text-sm text-gray-500 font-second-geo">
                                    {{ __('admin.role') }}: {{$user->roles->first()->name}}
                                </div>
                            @endif

                            <div class="items-center space-x-4 p-4 bg-primary/5 rounded-lg mt-4 text-sm text-gray-500 font-second-geo">
                                {{ __('admin.phone') }}: {{$user->phone ?? ' --- '}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="xl:col-span-3 col-span-12">
                    <div class="box">
                        <div class="box-body">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="bg-gray-50 dark:bg-gray-800 rounded-lg">
                                    <h6 class="font-medium text-gray-900 dark:text-white mb-2">
                                        <i class="ri-image-line me-2"></i>
                                        {{ __('admin.image') }}
                                    </h6>
                                    <p class="card-text">
                                        <x-backend.imageDefault :src="$user->src" />
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

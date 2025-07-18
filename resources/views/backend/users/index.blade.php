@extends('backend.layouts.master')
@section('title') {{ __('admin.sidebar_users') }} @endsection
@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin-table.css') }}">
@endsection
@section('content')
    <div class="content">
        <div class="main-content">

            <div class="block justify-between page-header md:flex">
                <div>
                    <h3 class="!text-defaulttextcolor dark:!text-defaulttextcolor/70 dark:text-white dark:hover:text-white text-[1.375rem] font-semibold font-first-geo">{{ __('admin.all_users') }}</h3>
                    <p class="font-second-geo text-defaulttextcolor/70">{{ __('admin.welcome') }}</p>
                </div>
                <ol class="flex items-center whitespace-nowrap min-w-0 gap-3 header-nav-links">
                    @can('backend.users.create')
                        <li class="text-[0.813rem] ps-[0.5rem]">
                            <a href="{{ route('backend.users.create') }}" class="ti-btn bg-primary text-white !font-medium font-second-geo">
                                <i class="ri-add-circle-line text-[1.375rem]"></i>
                                {{__('admin.create_new_users')}}
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

            <x-backend.alert-messages />

            <div class="grid grid-cols-12 gap-6 index-table-page white-bg">
                <div class="xl:col-span-12 col-span-12">
                    <div class="box custom-box">
                        <div class="box-header justify-between">
                            <div class="box-title box-show-number gap-5">
                                <x-backend.table.number />
                                @can('backend.users.massDestroy')
                                    <x-backend.table.massDestroy
                                        :url="route('backend.users.massDestroy')"
                                    />
                                @endcan
                            </div>

                            <x-backend.table.filter :status="true"/>
                        </div>

                        <div class="box-body">
                            <div class="table-responsive">
                                <table class="table whitespace-nowrap table-bordered min-w-full" id="datatablesTable">
                                    <thead class="bg-primary/10">
                                    <tr class="border-b border-primary/10">
                                        @can('backend.users.massDestroy')
                                            <th scope="col" class="select-number !text-start">
                                                <input class="form-check-input cursor-pointer" type="checkbox" id="select-all">
                                            </th>
                                        @endcan
                                        <th scope="col" class="id text-start sortable" data-sort="id">{{ __('admin.id') }}</th>
                                        <th scope="col" class="title text-start">{{ __('admin.title') }}</th>
                                        <th scope="col" class="role text-start">{{ __('admin.role') }}</th>
                                        <th scope="col" class="image text-start">{{ __('admin.image') }}</th>
                                        <th scope="col" class="created-time text-start sortable" data-sort="created_at">{{ __('admin.created_at') }}</th>
                                        <th scope="col" class="status text-start">{{ __('admin.status') }}</th>
                                        <th scope="col" class="actions text-start">{{ __('admin.actions') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($users as $user)
                                        <tr class="product-list border-b border-primary/10" data-id="{{$user->id}}">
                                            @can('backend.users.massDestroy')
                                                <td class="text-center">
                                                    <input class="form-check-input list-checkbox-item cursor-pointer" type="checkbox" value="{{$user->id}}">
                                                </td>
                                            @endcan
                                            <td>
                                                {{$user->id}}
                                            </td>
                                            <td>
                                                <x-backend.translation-text :model="$user" field="title" :limit="40" />
                                            </td>
                                            <td>
                                                {{$user->roles->first()->name}}
                                            </td>
                                            <td class="flex justify-center">
                                                <x-backend.image :src="$user->src" />
                                            </td>
                                            <td>
                                                <x-backend.badge type="light" :text="$user->created_at->format('d/m/Y H:i')" />
                                            </td>
                                            <td>
                                                <x-backend.table.status
                                                    :model="$user"
                                                    :statusUrl="route('backend.users.status')"
                                                />
                                            </td>
                                            <td>
                                                <x-backend.table.actions
                                                    :model="$user"
                                                    show-view="backend.users.show"
                                                    show-edit="backend.users.edit"
                                                    show-delete="backend.users.delete"
                                                />
                                            </td>
                                        </tr>
                                    @empty
                                        <tr class="empty-state">
                                            <td colspan="8" class="text-center py-8">
                                                <x-backend.table.empty-state
                                                    :actionText="__('admin.create_first_user')"
                                                    permission="backend.users.create"
                                                />
                                            </td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <x-backend.pagination :paginator="$users" />
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="{{ asset('js/admin-table.js') }}"></script>
@endpush

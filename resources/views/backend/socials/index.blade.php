@extends('backend.layouts.master')
@section('title') {{ __('admin.all_social_network') }} @endsection
@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin-table.css') }}">
@endsection
@section('content')
<div class="content">
    <div class="main-content">
        <!-- Header -->
        <div class="block justify-between page-header md:flex">
            <div>
                <h3 class="!text-defaulttextcolor dark:!text-defaulttextcolor/70 dark:text-white dark:hover:text-white text-[1.375rem] font-semibold font-first-geo">
                    {{ __('admin.all_social_network') }}
                </h3>
                <p class="font-second-geo text-defaulttextcolor/70">{{ __('admin.welcome') }}</p>
            </div>
            <ol class="flex items-center whitespace-nowrap min-w-0 gap-3 header-nav-links">
                @can('backend.socials.create')
                    <li class="text-[0.813rem] ps-[0.5rem]">
                        <a href="{{ route('backend.socials.create') }}" class="ti-btn bg-primary text-white !font-medium font-second-geo">
                            <i class="ri-add-circle-line text-[1.375rem]"></i>
                            {{__('admin.create_new_social_network')}}
                        </a>
                    </li>
                @endcan
                @can('backend.socials.trash')
                    <li class="text-[0.813rem] text-defaulttextcolor font-semibold hover:text-danger dark:text-[#8c9097] dark:text-white/50">
                        <a href="{{ route('backend.socials.trash') }}" class="ti-btn bg-danger text-white !font-medium font-second-geo">
                            <i class="ri-delete-bin-2-line text-[1.375rem]"></i>
                            {{__('admin.deleted_social_network')}}
                        </a>
                    </li>
                @endcan
                <li class="text-[0.813rem]">
                    <button id="order-toggle" class="ti-btn bg-warning text-white !font-medium font-second-geo"
                            data-reorder-url="{{ route('backend.socials.reorder') }}">
                        <i class="ri-drag-move-2-line text-[1.375rem]"></i>

                    </button>
                </li>
            </ol>
        </div>

        <x-backend.alert-messages />

        <div class="grid grid-cols-12 gap-6 index-table-page white-bg">
            <div class="xl:col-span-12 col-span-12">
                <div class="box custom-box">
                    <div class="box-header justify-between">
                        <div class="box-title box-show-number gap-5">
                            <x-backend.table.number />
                            @can('backend.socials.massDestroy')
                                <x-backend.table.massDestroy
                                    :url="route('backend.socials.massDestroy')"
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
                                    <th id="move-th" scope="col" class="move bg-warning text-center hidden">
                                        <i class="ri-drag-move-2-line text-white"></i>
                                    </th>
                                    @can('backend.socials.massDestroy')
                                        <th scope="col" class="select-number !text-start">
                                            <input class="form-check-input cursor-pointer" type="checkbox" id="select-all">
                                        </th>
                                    @endcan
                                    <th scope="col" class="id text-start sortable" data-sort="id">{{ __('admin.id') }}</th>
                                    <th scope="col" class="title text-start">{{ __('admin.title') }}</th>
                                    <th scope="col" class="icon text-start">{{ __('admin.icon') }}</th>
                                    <th scope="col" class="created-time text-start sortable" data-sort="created_at">{{ __('admin.created_at') }}</th>
                                    <th scope="col" class="status text-start">{{ __('admin.status') }}</th>
                                    <th scope="col" class="actions text-start">{{ __('admin.actions') }}</th>
                                </tr>
                                </thead>
                                <tbody id="socials-tbody">
                                @forelse($socials as $social)
                                    <tr class="product-list border-b border-primary/10" data-id="{{$social->id}}">
                                        <td class="drag-handle-cell text-center hidden">
                                            <span class="drag-handle" style="display:none;">&#9776;</span>
                                        </td>
                                        @can('backend.permissions.massDestroy')
                                            <td class="text-center">
                                                <input class="form-check-input list-checkbox-item cursor-pointer" type="checkbox" value="{{$social->id}}">
                                            </td>
                                        @endcan
                                        <td>
                                            {{$social->id}}
                                        </td>
                                        <td>
                                            {{$social->title}}
                                        </td>
                                        <td>
                                            {{ $social->icon }}
                                        </td>
                                        <td>
                                            <x-backend.badge type="light" :text="$social->created_at->format('d/m/Y H:i')" />
                                        </td>
                                        <td>
                                            <x-backend.table.status
                                                :model="$social"
                                                :statusUrl="route('backend.socials.status')"
                                            />
                                        </td>
                                        <td>
                                            <x-backend.table.actions
                                                :model="$social"
                                                show-view="backend.socials.show"
                                                show-edit="backend.socials.edit"
                                                show-delete="backend.socials.delete"
                                            />
                                        </td>
                                    </tr>
                                @empty
                                    <tr class="empty-state">
                                        <td colspan="7" class="text-center py-8">
                                            <x-backend.table.empty-state
                                                :actionText="__('admin.create_first_social')"
                                                permission="backend.socials.create"
                                            />
                                        </td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <x-backend.pagination :paginator="$socials" />
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
    <script src="{{ asset('js/admin-table.js') }}"></script>
@endpush

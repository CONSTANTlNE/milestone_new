@extends('backend.layouts.master')
@section('title') {{ __('admin.sidebar_sliders') }} @endsection
@section('styles')
<link rel="stylesheet" href="{{ asset('css/admin-table.css') }}">
@endsection
@section('content')
    <div class="content">
        <div class="main-content">

            <div class="block justify-between page-header md:flex">
                <div>
                    <h3 class="!text-defaulttextcolor dark:!text-defaulttextcolor/70 dark:text-white dark:hover:text-white text-[1.375rem] font-semibold font-first-geo">{{ __('admin.all_sliders') }}</h3>
                    <p class="font-second-geo text-defaulttextcolor/70">{{ __('admin.welcome') }}</p>
                </div>
                <ol class="flex items-center whitespace-nowrap min-w-0 gap-3 header-nav-links">
                    @can('backend.sliders.create')
                    <li class="text-[0.813rem] ps-[0.5rem]">
                        <a href="{{ route('backend.sliders.create') }}" class="ti-btn bg-primary text-white !font-medium font-second-geo">
                            <i class="ri-add-circle-line text-[1.375rem]"></i>
                            {{__('admin.create_new_slider')}}
                        </a>
                    </li>
                    @endcan
                    @can('backend.sliders.trash')
                    <li class="text-[0.813rem] text-defaulttextcolor font-semibold hover:text-danger dark:text-[#8c9097] dark:text-white/50">
                        <a href="{{ route('backend.sliders.trash') }}" class="ti-btn bg-danger text-white !font-medium font-second-geo">
                            <i class="ri-delete-bin-2-line text-[1.375rem]"></i>
                            {{__('admin.deleted_sliders')}}
                        </a>
                    </li>
                    @endcan
                    <li class="text-[0.813rem]">
                        <button id="order-toggle" class="ti-btn bg-warning text-white !font-medium font-second-geo"
                                data-reorder-url="{{ route('backend.sliders.reorder') }}">
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
                                @can('backend.sliders.massDestroy')
                                    <x-backend.table.massDestroy
                                        :url="route('backend.sliders.massDestroy')"
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
                                        @can('backend.sliders.massDestroy')
                                        <th scope="col" class="select-number !text-start">
                                            <input class="form-check-input cursor-pointer" type="checkbox" id="select-all">
                                        </th>
                                        @endcan
                                        <th scope="col" class="id text-start sortable" data-sort="id">{{ __('admin.id') }}</th>
                                        <th scope="col" class="title text-start">{{ __('admin.title') }}</th>
                                        <th scope="col" class="image text-start">{{ __('admin.image') }}</th>
                                        <th scope="col" class="created-time text-start sortable" data-sort="created_at">{{ __('admin.created_at') }}</th>
                                        <th scope="col" class="status text-start">{{ __('admin.status') }}</th>
                                        <th scope="col" class="actions text-start">{{ __('admin.actions') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody id="socials-tbody">
                                    @forelse($sliders as $slider)
                                        <tr class="product-list border-b border-primary/10" data-id="{{$slider->id}}">
                                            <td class="drag-handle-cell text-center hidden">
                                                <span class="drag-handle" style="display:none;">&#9776;</span>
                                            </td>
                                            @can('backend.sliders.massDestroy')
                                            <td class="text-center">
                                                <input class="form-check-input list-checkbox-item cursor-pointer" type="checkbox" value="{{$slider->id}}">
                                            </td>
                                            @endcan
                                            <td>
                                                {{$slider->id}}
                                            </td>
                                            <td>
                                                <x-backend.translation-text :model="$slider" field="title" :limit="40" />
                                            </td>
                                            <td class="flex justify-center">
                                                <x-backend.image :src="$slider->src" />
                                            </td>
                                            <td>
                                                <x-backend.badge type="light" :text="$slider->created_at->format('d/m/Y H:i')" />
                                            </td>
                                            <td>
                                                <x-backend.table.status
                                                :model="$slider"
                                                :statusUrl="route('backend.sliders.status')"
                                                />
                                            </td>
                                            <td>
                                                <x-backend.table.actions
                                                    :model="$slider"
                                                    show-view="backend.sliders.show"
                                                    show-edit="backend.sliders.edit"
                                                    show-delete="backend.sliders.delete"
                                                />
                                            </td>
                                        </tr>
                                    @empty
                                        <tr class="empty-state">
                                            <td colspan="7" class="text-center py-8">
                                                <x-backend.table.empty-state
                                                    :actionText="__('admin.create_first_slider')"
                                                    permission="backend.sliders.create"
                                                />
                                            </td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <x-backend.pagination :paginator="$sliders" />
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="{{ asset('js/admin-table.js') }}"></script>
@endpush


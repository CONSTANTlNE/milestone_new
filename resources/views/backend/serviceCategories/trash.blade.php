@extends('backend.layouts.master')
@section('title') {{ __('admin.deleted_serviceCategories') }} @endsection
@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin-table.css') }}">
@endsection
@section('content')
    <div class="content">
        <div class="main-content">

            <div class="block justify-between page-header md:flex">
                <div>
                    <h3 class="!text-defaulttextcolor dark:!text-defaulttextcolor/70 dark:text-white dark:hover:text-white text-[1.375rem] font-semibold font-first-geo">{{ __('admin.deleted_serviceCategories') }}</h3>
                    <p class="font-second-geo text-defaulttextcolor/70">{{ __('admin.welcome') }}</p>
                </div>
                <ol class="flex items-center whitespace-nowrap min-w-0 gap-3 header-nav-links">
                    @can('backend.serviceCategories.index')
                        <li class="text-[0.813rem] ps-[0.5rem]">
                            <a href="{{ route('backend.serviceCategories.index') }}" class="ti-btn bg-secondary text-white !font-medium font-second-geo">
                                <i class="ri-arrow-go-back-line text-[1.375rem]"></i>
                                {{ __('admin.return_back') }} - {{ __('admin.all_serviceCategories') }}
                            </a>
                        </li>
                    @endcan
                    @can('backend.serviceCategories.create')
                        <li class="text-[0.813rem] ps-[0.5rem]">
                            <a href="{{ route('backend.serviceCategories.create') }}" class="ti-btn bg-primary text-white !font-medium font-second-geo">
                                <i class="ri-add-circle-line text-[1.375rem]"></i>
                                {{__('admin.create_new_serviceCategories')}}
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
                                @can('backend.serviceCategories.massRemove')
                                    <x-backend.table.massRemove
                                        :url="route('backend.serviceCategories.massRemove')"
                                    />
                                @endcan
                            </div>

                            <x-backend.table.filter :status='false' />
                        </div>

                        <div class="box-body">
                            <div class="table-responsive">
                                <table class="table whitespace-nowrap table-bordered min-w-full" id="datatablesTable">
                                    <thead class="bg-primary/10">
                                    <tr class="border-b border-primary/10">
                                        @can('backend.serviceCategories.massDestroy')
                                            <th scope="col" class="select-number !text-start">
                                                <input class="form-check-input cursor-pointer" type="checkbox" id="select-all">
                                            </th>
                                        @endcan
                                        <th scope="col" class="id text-start sortable" data-sort="id">{{ __('admin.id') }}</th>
                                        <th scope="col" class="title text-start">{{ __('admin.title') }}</th>
                                        <th scope="col" class="created-time text-start sortable" data-sort="created_at">{{ __('admin.created_at') }}</th>
                                        <th scope="col" class="actions text-start">{{ __('admin.actions') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($serviceCategories as $serviceCategory)
                                        <tr class="product-list border-b border-primary/10" data-id="{{$serviceCategory->id}}">
                                            @can('backend.serviceCategories.massRemove')
                                                <td class="text-center">
                                                    <input class="form-check-input list-checkbox-item cursor-pointer" type="checkbox" value="{{$serviceCategory->id}}">
                                                </td>
                                            @endcan
                                            <td>
                                                {{$serviceCategory->id}}
                                            </td>
                                            <td>
                                                <x-backend.translation-text :model="$serviceCategory" field="title" :limit="40" />
                                            </td>
                                            <td>
                                                <x-backend.badge type="light" :text="$serviceCategory->created_at->format('d/m/Y H:i')" />
                                            </td>
                                            <td>
                                                <x-backend.table.actions
                                                    :model="$serviceCategory"
                                                    show-remove="backend.serviceCategories.remove"
                                                    show-restore="backend.serviceCategories.restore"
                                                />
                                            </td>
                                        </tr>
                                    @empty
                                        <tr class="empty-state">
                                            <td colspan="7" class="text-center py-8">
                                                <x-backend.table.empty-state
                                                    :actionText="__('admin.all_serviceCategories')"
                                                    :trash="true"
                                                    permission="backend.serviceCategories.index"
                                                />
                                            </td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <x-backend.pagination :paginator="$serviceCategories" />
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="{{ asset('js/admin-table.js') }}"></script>
@endpush

@extends('backend.layouts.master')
@section('title') {{ __('admin.auto_auctions') }} @endsection
@section('styles')
<link rel="stylesheet" href="{{ asset('css/admin-table.css') }}">
@endsection
@section('content')
    <div class="content">
        <div class="main-content">

            <div class="block justify-between page-header md:flex">
                <div>
                    <h3 class="!text-defaulttextcolor dark:!text-defaulttextcolor/70 dark:text-white dark:hover:text-white text-[1.375rem] font-semibold font-first-geo">{{ __('admin.all_auto_auctions') }}</h3>
                    <p class="font-second-geo text-defaulttextcolor/70">{{ __('admin.welcome') }}</p>
                </div>
            </div>

            <x-backend.alert-messages />

            <div class="grid grid-cols-12 gap-6 index-table-page white-bg">
                <div class="xl:col-span-12 col-span-12">
                    <div class="box custom-box">
                        <div class="box-header justify-between">
                            <div class="box-title box-show-number gap-5">
                                <x-backend.table.number />
                                <x-backend.table.massDestroy
                                    :url="route('backend.autoAuctions.massDestroy')"
                                />
                                <a href="{{ route('backend.autoAuctions.export') }}"
                                   class="ti-btn bg-success text-white !font-medium font-second-geo">
                                    <i class="fas fa-file-excel me-1"></i>
                                    {{ __('admin.export_excel') }}
                                </a>
                            </div>

                            <x-backend.table.filter :status="false"/>
                        </div>

                        <div class="box-body">
                            <div class="table-responsive">
                                <table class="table whitespace-nowrap table-bordered min-w-full" id="datatablesTable">
                                    <thead class="bg-primary/10">
                                    <tr class="border-b border-primary/10">
                                        <th scope="col" class="select-number !text-start">
                                            <input class="form-check-input cursor-pointer" type="checkbox" id="select-all">
                                        </th>
                                        <th scope="col" class="id text-start sortable" data-sort="id">{{ __('admin.id') }}</th>
                                        <th scope="col" class="legal_business_name text-start">{{ __('admin.legal_business_name') }}</th>
                                        <th scope="col" class="contact_name text-start">{{ __('admin.contact_name') }}</th>
                                        <th scope="col" class="contact_email text-start">{{ __('admin.contact_email') }}</th>
                                        <th scope="col" class="contact_phone text-start">{{ __('admin.contact_phone') }}</th>
                                        <th scope="col" class="business_type text-start">{{ __('admin.business_type') }}</th>
                                        <th scope="col" class="years_operation text-start">{{ __('admin.years_operation') }}</th>
                                        <th scope="col" class="documents text-start">{{ __('admin.documents') }}</th>
                                        <th scope="col" class="created-time text-start sortable" data-sort="created_at">{{ __('admin.created_at') }}</th>
                                        <th scope="col" class="actions text-start">{{ __('admin.actions') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($autoAuctions as $autoAuction)
                                        <tr class="product-list border-b border-primary/10" data-id="{{$autoAuction->id}}">
                                            <td class="text-center">
                                                <input class="form-check-input list-checkbox-item cursor-pointer" type="checkbox" value="{{$autoAuction->id}}">
                                            </td>
                                            <td>
                                                {{$autoAuction->id}}
                                            </td>
                                            <td>
                                                {{$autoAuction->legal_business_name}}
                                            </td>
                                            <td>
                                                {{$autoAuction->contact_name}}
                                            </td>
                                            <td>
                                                <a href="mailto:{{$autoAuction->contact_email}}" class="text-primary">{{$autoAuction->contact_email}}</a>
                                            </td>
                                            <td>
                                                <a href="tel:{{$autoAuction->contact_phone}}" class="text-primary">{{$autoAuction->contact_phone}}</a>
                                            </td>
                                            <td>
                                                <x-backend.badge type="light" :text="$autoAuction->business_type" />
                                            </td>
                                            <td>
                                                <x-backend.badge type="info" :text="$autoAuction->years_operation . ' years'" />
                                            </td>
                                            <td>
                                                <div class="flex flex-wrap gap-1">
                                                    <a href="{{ Storage::url($autoAuction->w9_upload) }}" target="_blank" class="ti-btn ti-btn-sm ti-btn-primary">
                                                        W9
                                                    </a>
                                                    <a href="{{ Storage::url($autoAuction->insurance_certificate) }}" target="_blank" class="ti-btn ti-btn-sm ti-btn-success">
                                                        IN
                                                    </a>
                                                    <a href="{{ Storage::url($autoAuction->vehicle_list) }}" target="_blank" class="ti-btn ti-btn-sm ti-btn-warning">
                                                       VL
                                                    </a>
                                                </div>
                                            </td>
                                            <td>
                                                <x-backend.badge type="light" :text="$autoAuction->created_at->format('d/m/Y H:i')" />
                                            </td>
                                            <td>
                                                <x-backend.table.actions
                                                    :model="$autoAuction"
                                                    show-view="backend.autoAuctions.show"
                                                    show-delete="backend.autoAuctions.delete"
                                                />
                                            </td>
                                        </tr>
                                    @empty
                                        <tr class="empty-state">
                                            <td colspan="12" class="text-center py-8">
                                               {{__('admin.no_auto_auctions_found')}}
                                            </td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <x-backend.pagination :paginator="$autoAuctions" />
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="{{ asset('js/admin-table.js') }}"></script>
@endpush


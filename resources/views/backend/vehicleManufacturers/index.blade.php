@extends('backend.layouts.master')
@section('title') {{ __('admin.vehicle_manufacturers') }} @endsection
@section('styles')
<link rel="stylesheet" href="{{ asset('css/admin-table.css') }}">
@endsection
@section('content')
    <div class="content">
        <div class="main-content">

            <div class="block justify-between page-header md:flex">
                <div>
                    <h3 class="!text-defaulttextcolor dark:!text-defaulttextcolor/70 dark:text-white dark:hover:text-white text-[1.375rem] font-semibold font-first-geo">{{ __('admin.all_vehicle_manufacturers') }}</h3>
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
                                    :url="route('backend.vehicleManufacturers.massDestroy')"
                                />
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
                                    @forelse($vehicleManufacturers as $vehicleManufacturer)
                                        <tr class="product-list border-b border-primary/10" data-id="{{$vehicleManufacturer->id}}">
                                            <td class="text-center">
                                                <input class="form-check-input list-checkbox-item cursor-pointer" type="checkbox" value="{{$vehicleManufacturer->id}}">
                                            </td>
                                            <td>
                                                {{$vehicleManufacturer->id}}
                                            </td>
                                            <td>
                                                <span class="font-medium">{{$vehicleManufacturer->legal_business_name}}</span>
                                                @if($vehicleManufacturer->dba)
                                                    <br><small class="text-muted">DBA: {{$vehicleManufacturer->dba}}</small>
                                                @endif
                                            </td>
                                            <td>
                                                {{$vehicleManufacturer->contact_name}}
                                                <br><small class="text-muted">{{$vehicleManufacturer->contact_title}}</small>
                                            </td>
                                            <td>
                                                <a href="mailto:{{$vehicleManufacturer->contact_email}}" class="text-primary">{{$vehicleManufacturer->contact_email}}</a>
                                            </td>
                                            <td>
                                                <a href="tel:{{$vehicleManufacturer->contact_phone}}" class="text-primary">{{$vehicleManufacturer->contact_phone}}</a>
                                            </td>
                                            <td>
                                                <x-backend.badge type="light" :text="$vehicleManufacturer->business_type" />
                                            </td>
                                            <td>
                                                <x-backend.badge type="info" :text="$vehicleManufacturer->years_operation . ' years'" />
                                            </td>
                                            <td>
                                                <div class="flex flex-wrap gap-1">
                                                        <a href="{{ Storage::url($vehicleManufacturer->w9_upload) }}" target="_blank" class="ti-btn ti-btn-sm ti-btn-primary">
                                                            W9
                                                        </a>
                                                        <a href="{{ Storage::url($vehicleManufacturer->insurance_certificate) }}" target="_blank" class="ti-btn ti-btn-sm ti-btn-success">
                                                            IN
                                                        </a>
                                                        <a href="{{ Storage::url($vehicleManufacturer->business_registration) }}" target="_blank" class="ti-btn ti-btn-sm ti-btn-warning">
                                                           BR
                                                        </a>
                                                </div>
                                            </td>
                                            <td>
                                                <x-backend.badge type="light" :text="$vehicleManufacturer->created_at->format('d/m/Y H:i')" />
                                            </td>
                                            <td>
                                                <x-backend.table.actions
                                                    :model="$vehicleManufacturer"
                                                    show-view="backend.vehicleManufacturers.show"
                                                    show-delete="backend.vehicleManufacturers.delete"
                                                />
                                            </td>
                                        </tr>
                                    @empty
                                        <tr class="empty-state">
                                            <td colspan="12" class="text-center py-8">
                                                {{__('admin.no_vehicle_manufacturers_found')}}
                                            </td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <x-backend.pagination :paginator="$vehicleManufacturers" />
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="{{ asset('js/admin-table.js') }}"></script>
@endpush

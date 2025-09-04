@extends('backend.layouts.master')
@section('title') {{ __('admin.vehicle_manufacturer_details') }} @endsection
@section('content')
    <div class="content">
        <div class="main-content">
            <div class="block justify-between page-header md:flex">
                <div>
                    <h3 class="!text-defaulttextcolor dark:!text-defaulttextcolor/70 dark:text-white dark:hover:text-white text-[1.375rem] font-semibold font-first-geo">{{ __('admin.vehicle_manufacturer_details') }}</h3>
                    <p class="font-second-geo text-defaulttextcolor/70">{{ __('admin.welcome') }}</p>
                </div>
                <ol class="flex items-center whitespace-nowrap min-w-0 gap-3 header-nav-links">
                    <li class="text-[0.813rem] ps-[0.5rem]">
                        <a href="{{ route('backend.vehicleManufacturers.index') }}" class="ti-btn bg-primary text-white !font-medium font-second-geo">
                            <i class="ri-arrow-left-line text-[1.375rem]"></i>
                            {{__('admin.back_to_list')}}
                        </a>
                    </li>
                </ol>
            </div>

            <x-backend.alert-messages />

            <div class="grid grid-cols-12 gap-6">
                <div class="xl:col-span-12 col-span-12">
                    <div class="box custom-box">
                        <div class="box-header">
                            <h5 class="box-title">{{ __('admin.vehicle_manufacturer_information') }}</h5>
                        </div>
                        <div class="box-body">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Organization Information -->
                                <div class="space-y-4">
                                    <h6 class="text-lg font-semibold text-primary">{{ __('admin.organization_information') }}</h6>

                                    <div class="space-y-3">
                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.legal_business_name') }}</label>
                                            <p class="text-base">{{ $vehicleManufacturer->legal_business_name }}</p>
                                        </div>

                                        @if($vehicleManufacturer->dba)
                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.dba') }}</label>
                                            <p class="text-base">{{ $vehicleManufacturer->dba }}</p>
                                        </div>
                                        @endif

                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.business_type') }}</label>
                                            <p class="text-base">{{ $vehicleManufacturer->formatted_business_type }}</p>
                                        </div>

                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.years_operation') }}</label>
                                            <p class="text-base">{{ $vehicleManufacturer->years_operation }} years</p>
                                        </div>

                                        @if($vehicleManufacturer->website_url)
                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.website_url') }}</label>
                                            <p class="text-base">
                                                <a href="{{ $vehicleManufacturer->website_url }}" target="_blank" class="text-primary hover:underline">{{ $vehicleManufacturer->website_url }}</a>
                                            </p>
                                        </div>
                                        @endif

                                        @if($vehicleManufacturer->us_office_location)
                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.us_office_location') }}</label>
                                            <p class="text-base">{{ $vehicleManufacturer->us_office_location }}</p>
                                        </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Contact Information -->
                                <div class="space-y-4">
                                    <h6 class="text-lg font-semibold text-primary">{{ __('admin.contact_information') }}</h6>

                                    <div class="space-y-3">
                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.contact_name') }}</label>
                                            <p class="text-base">{{ $vehicleManufacturer->contact_name }}</p>
                                        </div>

                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.contact_title') }}</label>
                                            <p class="text-base">{{ $vehicleManufacturer->contact_title }}</p>
                                        </div>

                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.contact_phone') }}</label>
                                            <p class="text-base">
                                                <a href="tel:{{ $vehicleManufacturer->contact_phone }}" class="text-primary">{{ $vehicleManufacturer->contact_phone }}</a>
                                            </p>
                                        </div>

                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.contact_email') }}</label>
                                            <p class="text-base">
                                                <a href="mailto:{{ $vehicleManufacturer->contact_email }}" class="text-primary">{{ $vehicleManufacturer->contact_email }}</a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Factory & Logistics Details -->
                            <div class="mt-8 space-y-4">
                                <h6 class="text-lg font-semibold text-primary">{{ __('admin.factory_logistics_details') }}</h6>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="space-y-3">
                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.primary_port_factory') }}</label>
                                            <p class="text-base">{{ $vehicleManufacturer->primary_port_factory }}</p>
                                        </div>

                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.us_distribution_centers') }}</label>
                                            <p class="text-base">{{ $vehicleManufacturer->us_distribution_centers }}</p>
                                        </div>

                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.delivery_frequency') }}</label>
                                            <p class="text-base">{{ $vehicleManufacturer->formatted_delivery_frequency }}</p>
                                        </div>

                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.monthly_volume') }}</label>
                                            <p class="text-base">{{ $vehicleManufacturer->monthly_volume }} vehicles/month</p>
                                        </div>
                                    </div>

                                    <div class="space-y-3">
                                        @if($vehicleManufacturer->vin_batching_format)
                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.vin_batching_format') }}</label>
                                            <p class="text-base">{{ $vehicleManufacturer->vin_batching_format }}</p>
                                        </div>
                                        @endif

                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.new_car_prep') }}</label>
                                            <p class="text-base">{{ $vehicleManufacturer->new_car_prep }}</p>
                                        </div>

                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.transport_type') }}</label>
                                            <p class="text-base">{{ ucfirst($vehicleManufacturer->transport_type) }}</p>
                                        </div>

                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.vehicle_types') }}</label>
                                            <p class="text-base">{{ $vehicleManufacturer->formatted_vehicle_types }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Transport & Delivery Details -->
                            <div class="mt-8 space-y-4">
                                <h6 class="text-lg font-semibold text-primary">{{ __('admin.transport_delivery_details') }}</h6>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="space-y-3">
                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.load_prep_protocols') }}</label>
                                            <p class="text-base">{{ $vehicleManufacturer->load_prep_protocols }}</p>
                                        </div>

                                        @if($vehicleManufacturer->special_handling)
                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.special_handling') }}</label>
                                            <p class="text-base">{{ $vehicleManufacturer->special_handling }}</p>
                                        </div>
                                        @endif

                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.delivery_destinations') }}</label>
                                            <p class="text-base">{{ $vehicleManufacturer->delivery_destinations }}</p>
                                        </div>
                                    </div>

                                    <div class="space-y-3">
                                        @if($vehicleManufacturer->compliance_procedures)
                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.compliance_procedures') }}</label>
                                            <p class="text-base">{{ $vehicleManufacturer->compliance_procedures }}</p>
                                        </div>
                                        @endif

                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.vendor_management_system') }}</label>
                                            <p class="text-base">{{ ucfirst($vehicleManufacturer->vendor_management_system) }}</p>
                                        </div>

                                        @if($vehicleManufacturer->system_name)
                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.system_name') }}</label>
                                            <p class="text-base">{{ $vehicleManufacturer->system_name }}</p>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Billing Information -->
                            <div class="mt-8 space-y-4">
                                <h6 class="text-lg font-semibold text-primary">{{ __('admin.billing_information') }}</h6>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="space-y-3">
                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.billing_contact') }}</label>
                                            <p class="text-base">{{ $vehicleManufacturer->billing_contact }}</p>
                                        </div>

                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.billing_email') }}</label>
                                            <p class="text-base">
                                                <a href="mailto:{{ $vehicleManufacturer->billing_email }}" class="text-primary">{{ $vehicleManufacturer->billing_email }}</a>
                                            </p>
                                        </div>

                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.payment_method') }}</label>
                                            <p class="text-base">
                                                @if(is_array($vehicleManufacturer->payment_method))
                                                    {{ implode(', ', array_map('ucfirst', $vehicleManufacturer->payment_method)) }}
                                                @else
                                                    {{ ucfirst($vehicleManufacturer->payment_method) }}
                                                @endif
                                            </p>
                                        </div>
                                    </div>

                                    <div class="space-y-3">
                                        @if($vehicleManufacturer->trade_references)
                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.trade_references') }}</label>
                                            <p class="text-base">{{ $vehicleManufacturer->trade_references }}</p>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Documents -->
                            <div class="mt-8 space-y-4">
                                <h6 class="text-lg font-semibold text-primary">{{ __('admin.documents') }}</h6>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    @if($vehicleManufacturer->w9_upload)
                                    <div>
                                        <label class="text-sm font-medium text-gray-600">{{ __('admin.w9_upload') }}</label>
                                        <p class="text-base">
                                            <a href="{{ Storage::url($vehicleManufacturer->w9_upload) }}" target="_blank" class="text-primary hover:underline">
                                                <i class="ri-file-text-line"></i> View W9 Document
                                            </a>
                                        </p>
                                    </div>
                                    @endif

                                    @if($vehicleManufacturer->insurance_certificate)
                                    <div>
                                        <label class="text-sm font-medium text-gray-600">{{ __('admin.insurance_certificate') }}</label>
                                        <p class="text-base">
                                            <a href="{{ Storage::url($vehicleManufacturer->insurance_certificate) }}" target="_blank" class="text-primary hover:underline">
                                                <i class="ri-file-text-line"></i> View Insurance Certificate
                                            </a>
                                        </p>
                                    </div>
                                    @endif

                                    @if($vehicleManufacturer->business_registration)
                                    <div>
                                        <label class="text-sm font-medium text-gray-600">{{ __('admin.business_registration') }}</label>
                                        <p class="text-base">
                                            <a href="{{ Storage::url($vehicleManufacturer->business_registration) }}" target="_blank" class="text-primary hover:underline">
                                                <i class="ri-file-text-line"></i> View Business Registration
                                            </a>
                                        </p>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Status and Notes -->
                            <div class="mt-8 space-y-4">
                                <h6 class="text-lg font-semibold text-primary">{{ __('admin.status_and_notes') }}</h6>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label class="text-sm font-medium text-gray-600">{{ __('admin.status') }}</label>
                                        <div class="mt-1">
                                            {!! $vehicleManufacturer->status_badge !!}
                                        </div>
                                    </div>

                                    @if($vehicleManufacturer->admin_notes)
                                    <div>
                                        <label class="text-sm font-medium text-gray-600">{{ __('admin.admin_notes') }}</label>
                                        <p class="text-base">{{ $vehicleManufacturer->admin_notes }}</p>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Timestamps -->
                            <div class="mt-8 pt-6 border-t border-gray-200">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm text-gray-600">
                                    <div>
                                        <label class="font-medium">{{ __('admin.created_at') }}</label>
                                        <p>{{ $vehicleManufacturer->created_at }}</p>
                                    </div>
                                    <div>
                                        <label class="font-medium">{{ __('admin.updated_at') }}</label>
                                        <p>{{ $vehicleManufacturer->updated_at }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('backend.layouts.master')
@section('title') {{ __('admin.car_retailer_details') }} @endsection
@section('content')
    <div class="content">
        <div class="main-content">
            <div class="block justify-between page-header md:flex">
                <div>
                    <h3 class="!text-defaulttextcolor dark:!text-defaulttextcolor/70 dark:text-white dark:hover:text-white text-[1.375rem] font-semibold font-first-geo">{{ __('admin.car_retailer_details') }}</h3>
                    <p class="font-second-geo text-defaulttextcolor/70">{{ __('admin.welcome') }}</p>
                </div>
                <ol class="flex items-center whitespace-nowrap min-w-0 gap-3 header-nav-links">
                    <li class="text-[0.813rem] ps-[0.5rem]">
                        <a href="{{ route('backend.carRetailers.index') }}" class="ti-btn bg-primary text-white !font-medium font-second-geo">
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
                            <h5 class="box-title">{{ __('admin.car_retailer_information') }}</h5>
                        </div>
                        <div class="box-body">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Company Information -->
                                <div class="space-y-4">
                                    <h6 class="text-lg font-semibold text-primary">{{ __('admin.company_information') }}</h6>

                                    <div class="space-y-3">
                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.legal_business_name') }}</label>
                                            <p class="text-base">{{ $carRetailer->legal_business_name }}</p>
                                        </div>

                                        @if($carRetailer->dba)
                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.dba') }}</label>
                                            <p class="text-base">{{ $carRetailer->dba }}</p>
                                        </div>
                                        @endif

                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.business_type') }}</label>
                                            <p class="text-base">{{ $carRetailer->business_type }}</p>
                                        </div>

                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.years_operation') }}</label>
                                            <p class="text-base">
                                                @if($carRetailer->years_operation)
                                                    {{ $carRetailer->years_operation }} years
                                                @else
                                                    N/A
                                                @endif
                                            </p>
                                        </div>

                                        @if($carRetailer->website_url)
                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.website_url') }}</label>
                                            <p class="text-base">
                                                <a href="{{ $carRetailer->website_url }}" target="_blank" class="text-primary hover:underline">{{ $carRetailer->website_url }}</a>
                                            </p>
                                        </div>
                                        @endif

                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.platform_type') }}</label>
                                            <p class="text-base">
                                                @if($carRetailer->platform_type)
                                                    {{ $carRetailer->formatted_platform_type }}
                                                @else
                                                    N/A
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Contact Information -->
                                <div class="space-y-4">
                                    <h6 class="text-lg font-semibold text-primary">{{ __('admin.contact_information') }}</h6>

                                    <div class="space-y-3">
                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.contact_name') }}</label>
                                            <p class="text-base">{{ $carRetailer->contact_name }}</p>
                                        </div>

                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.contact_title') }}</label>
                                            <p class="text-base">{{ $carRetailer->contact_title }}</p>
                                        </div>

                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.contact_phone') }}</label>
                                            <p class="text-base">
                                                <a href="tel:{{ $carRetailer->contact_phone }}" class="text-primary">{{ $carRetailer->contact_phone }}</a>
                                            </p>
                                        </div>

                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.contact_email') }}</label>
                                            <p class="text-base">
                                                <a href="mailto:{{ $carRetailer->contact_email }}" class="text-primary">{{ $carRetailer->contact_email }}</a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Logistics & Operations -->
                            <div class="mt-8 space-y-4">
                                <h6 class="text-lg font-semibold text-primary">{{ __('admin.logistics_and_operations') }}</h6>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="space-y-3">
                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.fulfillment_address') }}</label>
                                            <p class="text-base">{{ $carRetailer->fulfillment_address }}</p>
                                        </div>

                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.multiple_warehouses') }}</label>
                                            <p class="text-base">{{ ucfirst($carRetailer->multiple_warehouses) }}</p>
                                        </div>

                                        @if($carRetailer->shipping_nodes)
                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.shipping_nodes') }}</label>
                                            <p class="text-base">{{ $carRetailer->shipping_nodes }}</p>
                                        </div>
                                        @endif

                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.inventory_api_access') }}</label>
                                            <p class="text-base">{{ ucfirst($carRetailer->inventory_api_access) }}</p>
                                        </div>

                                        @if($carRetailer->api_url_docs)
                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.api_url_docs') }}</label>
                                            <p class="text-base">
                                                <a href="{{ $carRetailer->api_url_docs }}" target="_blank" class="text-primary hover:underline">{{ $carRetailer->api_url_docs }}</a>
                                            </p>
                                        </div>
                                        @endif
                                    </div>

                                    <div class="space-y-3">
                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.cars_shipped') }}</label>
                                            <p class="text-base">
                                                @if($carRetailer->cars_shipped)
                                                    {{ $carRetailer->cars_shipped }} cars/month
                                                @else
                                                    N/A
                                                @endif
                                            </p>
                                        </div>

                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.vehicle_types') }}</label>
                                            <p class="text-base">
                                                @if($carRetailer->vehicle_types)
                                                    {{ $carRetailer->formatted_vehicle_types }}
                                                @else
                                                    N/A
                                                @endif
                                            </p>
                                        </div>

                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.transport_type') }}</label>
                                            <p class="text-base">{{ ucfirst($carRetailer->transport_type) }}</p>
                                        </div>

                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.preferred_delivery') }}</label>
                                            <p class="text-base">{{ $carRetailer->formatted_preferred_delivery }}</p>
                                        </div>

                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.unattended_pickup') }}</label>
                                            <p class="text-base">{{ ucfirst($carRetailer->unattended_pickup) }}</p>
                                        </div>
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
                                            <p class="text-base">{{ $carRetailer->billing_contact }}</p>
                                        </div>

                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.billing_email') }}</label>
                                            <p class="text-base">
                                                <a href="mailto:{{ $carRetailer->billing_email }}" class="text-primary">{{ $carRetailer->billing_email }}</a>
                                            </p>
                                        </div>

                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.payment_method') }}</label>
                                            <p class="text-base">
                                                @if($carRetailer->payment_method)
                                                    @if(is_array($carRetailer->payment_method))
                                                        {{ implode(', ', array_map('ucfirst', $carRetailer->payment_method)) }}
                                                    @else
                                                        {{ ucfirst($carRetailer->payment_method) }}
                                                    @endif
                                                @else
                                                    N/A
                                                @endif
                                            </p>
                                        </div>

                                        @if($carRetailer->vendor_platforms)
                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.vendor_platforms') }}</label>
                                            <p class="text-base">{{ $carRetailer->vendor_platforms }}</p>
                                        </div>
                                        @endif
                                    </div>

                                    <div class="space-y-3">
                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.ein_tax_id') }}</label>
                                            <p class="text-base">{{ $carRetailer->ein_tax_id }}</p>
                                        </div>

                                        @if($carRetailer->nda_required)
                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.nda_required') }}</label>
                                            <p class="text-base">{{ ucfirst($carRetailer->nda_required) }}</p>
                                        </div>
                                        @endif

                                        @if($carRetailer->trade_references)
                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.trade_references') }}</label>
                                            <p class="text-base">{{ $carRetailer->trade_references }}</p>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Documents -->
                            <div class="mt-8 space-y-4">
                                <h6 class="text-lg font-semibold text-primary">{{ __('admin.documents') }}</h6>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    @if($carRetailer->w9_upload)
                                    <div>
                                        <label class="text-sm font-medium text-gray-600">{{ __('admin.w9_upload') }}</label>
                                        <p class="text-base">
                                            <a href="{{ Storage::url($carRetailer->w9_upload) }}" target="_blank" class="text-primary hover:underline">
                                                <i class="ri-file-text-line"></i> View W9 Document
                                            </a>
                                        </p>
                                    </div>
                                    @endif

                                    @if($carRetailer->insurance_certificate)
                                    <div>
                                        <label class="text-sm font-medium text-gray-600">{{ __('admin.insurance_certificate') }}</label>
                                        <p class="text-base">
                                            <a href="{{ Storage::url($carRetailer->insurance_certificate) }}" target="_blank" class="text-primary hover:underline">
                                                <i class="ri-file-text-line"></i> View Insurance Certificate
                                            </a>
                                        </p>
                                    </div>
                                    @endif

                                    @if($carRetailer->vehicle_list)
                                    <div>
                                        <label class="text-sm font-medium text-gray-600">{{ __('admin.vehicle_list') }}</label>
                                        <p class="text-base">
                                            <a href="{{ Storage::url($carRetailer->vehicle_list) }}" target="_blank" class="text-primary hover:underline">
                                                <i class="ri-file-text-line"></i> View Vehicle List
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
                                            {!! $carRetailer->status_badge !!}
                                        </div>
                                    </div>

                                    @if($carRetailer->admin_notes)
                                    <div>
                                        <label class="text-sm font-medium text-gray-600">{{ __('admin.admin_notes') }}</label>
                                        <p class="text-base">{{ $carRetailer->admin_notes }}</p>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Timestamps -->
                            <div class="mt-8 pt-6 border-t border-gray-200">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm text-gray-600">
                                    <div>
                                        <label class="font-medium">{{ __('admin.created_at') }}</label>
                                        <p>
                                            @if($carRetailer->created_at)
                                                {{ $carRetailer->created_at->format('F j, Y \a\t g:i A') }}
                                            @else
                                                N/A
                                            @endif
                                        </p>
                                    </div>
                                    <div>
                                        <label class="font-medium">{{ __('admin.updated_at') }}</label>
                                        <p>
                                            @if($carRetailer->updated_at)
                                                {{ $carRetailer->updated_at->format('F j, Y \a\t g:i A') }}
                                            @else
                                                N/A
                                            @endif
                                        </p>
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

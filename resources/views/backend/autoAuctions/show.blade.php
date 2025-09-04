@extends('backend.layouts.master')
@section('title') {{ __('admin.auto_auction_details') }} @endsection
@section('content')
    <div class="content">
        <div class="main-content">
            <div class="block justify-between page-header md:flex">
                <div>
                    <h3 class="!text-defaulttextcolor dark:!text-defaulttextcolor/70 dark:text-white dark:hover:text-white text-[1.375rem] font-semibold font-first-geo">{{ __('admin.auto_auction_details') }}</h3>
                    <p class="font-second-geo text-defaulttextcolor/70">{{ __('admin.welcome') }}</p>
                </div>
                <ol class="flex items-center whitespace-nowrap min-w-0 gap-3 header-nav-links">
                    <li class="text-[0.813rem] ps-[0.5rem]">
                        <a href="{{ route('backend.autoAuctions.index') }}" class="ti-btn bg-primary text-white !font-medium font-second-geo">
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
                            <h5 class="box-title">{{ __('admin.auto_auction_information') }}</h5>
                        </div>
                        <div class="box-body">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Company Information -->
                                <div class="space-y-4">
                                    <h6 class="text-lg font-semibold text-primary">{{ __('admin.company_information') }}</h6>

                                    <div class="space-y-3">
                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.legal_business_name') }}</label>
                                            <p class="text-base">{{ $autoAuction->legal_business_name }}</p>
                                        </div>

                                        @if($autoAuction->dba)
                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.dba') }}</label>
                                            <p class="text-base">{{ $autoAuction->dba }}</p>
                                        </div>
                                        @endif

                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.business_type') }}</label>
                                            <p class="text-base">{{ $autoAuction->business_type }}</p>
                                        </div>

                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.years_operation') }}</label>
                                            <p class="text-base">{{ $autoAuction->years_operation }} years</p>
                                        </div>

                                        @if($autoAuction->website_url)
                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.website_url') }}</label>
                                            <p class="text-base">
                                                <a href="{{ $autoAuction->website_url }}" target="_blank" class="text-primary hover:underline">{{ $autoAuction->website_url }}</a>
                                            </p>
                                        </div>
                                        @endif

                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.platform_type') }}</label>
                                            <p class="text-base">{{ $autoAuction->formatted_platform_type }}</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Contact Information -->
                                <div class="space-y-4">
                                    <h6 class="text-lg font-semibold text-primary">{{ __('admin.contact_information') }}</h6>

                                    <div class="space-y-3">
                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.contact_name') }}</label>
                                            <p class="text-base">{{ $autoAuction->contact_name }}</p>
                                        </div>

                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.contact_title') }}</label>
                                            <p class="text-base">{{ $autoAuction->contact_title }}</p>
                                        </div>

                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.contact_phone') }}</label>
                                            <p class="text-base">
                                                <a href="tel:{{ $autoAuction->contact_phone }}" class="text-primary">{{ $autoAuction->contact_phone }}</a>
                                            </p>
                                        </div>

                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.contact_email') }}</label>
                                            <p class="text-base">
                                                <a href="mailto:{{ $autoAuction->contact_email }}" class="text-primary">{{ $autoAuction->contact_email }}</a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Auction Logistics -->
                            <div class="mt-8 space-y-4">
                                <h6 class="text-lg font-semibold text-primary">{{ __('admin.auction_logistics') }}</h6>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="space-y-3">
                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.main_address') }}</label>
                                            <p class="text-base">{{ $autoAuction->main_address }}</p>
                                        </div>

                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.multiple_locations') }}</label>
                                            <p class="text-base">{{ ucfirst($autoAuction->multiple_locations) }}</p>
                                        </div>

                                        @if($autoAuction->additional_locations)
                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.additional_locations') }}</label>
                                            <p class="text-base">{{ $autoAuction->additional_locations }}</p>
                                        </div>
                                        @endif

                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.primary_auction_days') }}</label>
                                            <p class="text-base">{{ $autoAuction->primary_auction_days }}</p>
                                        </div>

                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.lot_numbers') }}</label>
                                            <p class="text-base">{{ $autoAuction->lot_numbers }} lots per auction</p>
                                        </div>
                                    </div>

                                    <div class="space-y-3">
                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.inventory_system') }}</label>
                                            <p class="text-base">{{ ucfirst($autoAuction->inventory_system) }}</p>
                                        </div>

                                        @if($autoAuction->unattended_pickup)
                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.unattended_pickup') }}</label>
                                            <p class="text-base">{{ ucfirst($autoAuction->unattended_pickup) }}</p>
                                        </div>
                                        @endif

                                        @if($autoAuction->vehicles_shipped)
                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.vehicles_shipped') }}</label>
                                            <p class="text-base">{{ $autoAuction->vehicles_shipped }} vehicles/month</p>
                                        </div>
                                        @endif

                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.vehicle_types') }}</label>
                                            <p class="text-base">{{ $autoAuction->formatted_vehicle_types }}</p>
                                        </div>

                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.transport_type') }}</label>
                                            <p class="text-base">{{ ucfirst($autoAuction->transport_type) }}</p>
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
                                            <p class="text-base">{{ $autoAuction->billing_contact }}</p>
                                        </div>

                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.billing_email') }}</label>
                                            <p class="text-base">
                                                <a href="mailto:{{ $autoAuction->billing_email }}" class="text-primary">{{ $autoAuction->billing_email }}</a>
                                            </p>
                                        </div>

                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.payment_method') }}</label>
                                            <p class="text-base">
                                                @if(is_array($autoAuction->payment_method))
                                                    {{ implode(', ', array_map('ucfirst', $autoAuction->payment_method)) }}
                                                @else
                                                    {{ ucfirst($autoAuction->payment_method) }}
                                                @endif
                                            </p>
                                        </div>

                                        @if($autoAuction->vendor_platforms)
                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.vendor_platforms') }}</label>
                                            <p class="text-base">{{ $autoAuction->vendor_platforms }}</p>
                                        </div>
                                        @endif
                                    </div>

                                    <div class="space-y-3">
                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.ein_tax_id') }}</label>
                                            <p class="text-base">{{ $autoAuction->ein_tax_id }}</p>
                                        </div>

                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.dealer_license') }}</label>
                                            <p class="text-base">{{ $autoAuction->dealer_license }}</p>
                                        </div>

                                        @if($autoAuction->trade_references)
                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.trade_references') }}</label>
                                            <p class="text-base">{{ $autoAuction->trade_references }}</p>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Documents -->
                            <div class="mt-8 space-y-4">
                                <h6 class="text-lg font-semibold text-primary">{{ __('admin.documents') }}</h6>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    @if($autoAuction->w9_upload)
                                    <div>
                                        <label class="text-sm font-medium text-gray-600">{{ __('admin.w9_upload') }}</label>
                                        <p class="text-base">
                                            <a href="{{ Storage::url($autoAuction->w9_upload) }}" target="_blank" class="text-primary hover:underline">
                                                <i class="ri-file-text-line"></i> View W9 Document
                                            </a>
                                        </p>
                                    </div>
                                    @endif

                                    @if($autoAuction->insurance_certificate)
                                    <div>
                                        <label class="text-sm font-medium text-gray-600">{{ __('admin.insurance_certificate') }}</label>
                                        <p class="text-base">
                                            <a href="{{ Storage::url($autoAuction->insurance_certificate) }}" target="_blank" class="text-primary hover:underline">
                                                <i class="ri-file-text-line"></i> View Insurance Certificate
                                            </a>
                                        </p>
                                    </div>
                                    @endif

                                    @if($autoAuction->vehicle_list)
                                    <div>
                                        <label class="text-sm font-medium text-gray-600">{{ __('admin.vehicle_list') }}</label>
                                        <p class="text-base">
                                            <a href="{{ Storage::url($autoAuction->vehicle_list) }}" target="_blank" class="text-primary hover:underline">
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
                                            {!! $autoAuction->status_badge !!}
                                        </div>
                                    </div>

                                    @if($autoAuction->admin_notes)
                                    <div>
                                        <label class="text-sm font-medium text-gray-600">{{ __('admin.admin_notes') }}</label>
                                        <p class="text-base">{{ $autoAuction->admin_notes }}</p>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Timestamps -->
                            <div class="mt-8 pt-6 border-t border-gray-200">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm text-gray-600">
                                    <div>
                                        <label class="font-medium">{{ __('admin.created_at') }}</label>
                                        <p>{{ $autoAuction->created_at }}</p>
                                    </div>
                                    <div>
                                        <label class="font-medium">{{ __('admin.updated_at') }}</label>
                                        <p>{{ $autoAuction->updated_at }}</p>
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

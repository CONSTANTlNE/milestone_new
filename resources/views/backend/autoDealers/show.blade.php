@extends('backend.layouts.master')
@section('title') {{ __('admin.auto_dealer_details') }} @endsection
@section('content')
    <div class="content">
        <div class="main-content">
            <div class="block justify-between page-header md:flex">
                <div>
                    <h3 class="!text-defaulttextcolor dark:!text-defaulttextcolor/70 dark:text-white dark:hover:text-white text-[1.375rem] font-semibold font-first-geo">{{ __('admin.auto_dealer_details') }}</h3>
                    <p class="font-second-geo text-defaulttextcolor/70">{{ __('admin.welcome') }}</p>
                </div>
                <ol class="flex items-center whitespace-nowrap min-w-0 gap-3 header-nav-links">
                    <li class="text-[0.813rem] ps-[0.5rem]">
                        <a href="{{ route('backend.autoDealers.index') }}" class="ti-btn bg-primary text-white !font-medium font-second-geo">
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
                            <h5 class="box-title">{{ __('admin.auto_dealer_information') }}</h5>
                        </div>
                        <div class="box-body">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Company Information -->
                                <div class="space-y-4">
                                    <h6 class="text-lg font-semibold text-primary">{{ __('admin.company_information') }}</h6>

                                    <div class="space-y-3">
                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.legal_business_name') }}</label>
                                            <p class="text-base">{{ $autoDealer->legal_business_name }}</p>
                                        </div>

                                        @if($autoDealer->dba)
                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.dba') }}</label>
                                            <p class="text-base">{{ $autoDealer->dba }}</p>
                                        </div>
                                        @endif

                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.business_type') }}</label>
                                            <p class="text-base">{{ $autoDealer->business_type }}</p>
                                        </div>

                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.years_operation') }}</label>
                                            <p class="text-base">{{ $autoDealer->years_operation }} years</p>
                                        </div>

                                        @if($autoDealer->website_url)
                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.website_url') }}</label>
                                            <p class="text-base">
                                                <a href="{{ $autoDealer->website_url }}" target="_blank" class="text-primary hover:underline">{{ $autoDealer->website_url }}</a>
                                            </p>
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
                                            <p class="text-base">{{ $autoDealer->contact_name }}</p>
                                        </div>

                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.contact_title') }}</label>
                                            <p class="text-base">{{ $autoDealer->contact_title }}</p>
                                        </div>

                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.contact_phone') }}</label>
                                            <p class="text-base">
                                                <a href="tel:{{ $autoDealer->contact_phone }}" class="text-primary">{{ $autoDealer->contact_phone }}</a>
                                            </p>
                                        </div>

                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.contact_email') }}</label>
                                            <p class="text-base">
                                                <a href="mailto:{{ $autoDealer->contact_email }}" class="text-primary">{{ $autoDealer->contact_email }}</a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                                <!-- Location & Operations -->
                                <div class="space-y-4">
                                    <h6 class="text-lg font-semibold text-primary">{{ __('admin.location_operations') }}</h6>

                                    <div class="space-y-3">
                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.main_address') }}</label>
                                            <p class="text-base">{{ $autoDealer->main_address }}</p>
                                        </div>

                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.multiple_locations') }}</label>
                                            <p class="text-base">{{ ucfirst($autoDealer->multiple_locations) }}</p>
                                        </div>

                                        @if($autoDealer->additional_addresses)
                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.additional_addresses') }}</label>
                                            <p class="text-base">{{ $autoDealer->additional_addresses }}</p>
                                        </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Licenses & IDs -->
                                <div class="space-y-4">
                                    <h6 class="text-lg font-semibold text-primary">{{ __('admin.licenses_ids') }}</h6>

                                    <div class="space-y-3">
                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.dealer_license') }}</label>
                                            <p class="text-base">{{ $autoDealer->dealer_license }}</p>
                                        </div>

                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.federal_tax_id') }}</label>
                                            <p class="text-base">{{ $autoDealer->federal_tax_id }}</p>
                                        </div>

                                        @if($autoDealer->duns_number)
                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.duns_number') }}</label>
                                            <p class="text-base">{{ $autoDealer->duns_number }}</p>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                                <!-- Vehicle Transport Details -->
                                <div class="space-y-4">
                                    <h6 class="text-lg font-semibold text-primary">{{ __('admin.vehicle_transport_details') }}</h6>

                                    <div class="space-y-3">
                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.cars_per_month') }}</label>
                                            <p class="text-base">{{ $autoDealer->cars_per_month }} cars</p>
                                        </div>

                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.vehicle_types') }}</label>
                                            <p class="text-base">{{ $autoDealer->formatted_vehicle_types }}</p>
                                        </div>

                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.transport_preference') }}</label>
                                            <p class="text-base">{{ $autoDealer->formatted_transport_preference }}</p>
                                        </div>

                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.delivery_type') }}</label>
                                            <p class="text-base">{{ $autoDealer->formatted_delivery_type }}</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Logistics Preferences -->
                                <div class="space-y-4">
                                    <h6 class="text-lg font-semibold text-primary">{{ __('admin.logistics_preferences') }}</h6>

                                    <div class="space-y-3">
                                        @if($autoDealer->inventory_contact)
                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.inventory_contact') }}</label>
                                            <p class="text-base">{{ $autoDealer->inventory_contact }}</p>
                                        </div>
                                        @endif

                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.pickup_times') }}</label>
                                            <p class="text-base">{{ $autoDealer->pickup_times }}</p>
                                        </div>

                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.delivery_days') }}</label>
                                            <p class="text-base">{{ $autoDealer->delivery_days }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                                <!-- Billing & Payment -->
                                <div class="space-y-4">
                                    <h6 class="text-lg font-semibold text-primary">{{ __('admin.billing_payment') }}</h6>

                                    <div class="space-y-3">
                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.billing_contact') }}</label>
                                            <p class="text-base">{{ $autoDealer->billing_contact }}</p>
                                        </div>

                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.billing_email') }}</label>
                                            <p class="text-base">
                                                <a href="mailto:{{ $autoDealer->billing_email }}" class="text-primary">{{ $autoDealer->billing_email }}</a>
                                            </p>
                                        </div>

                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.payment_method') }}</label>
                                            <p class="text-base">{{ ucfirst($autoDealer->payment_method) }}</p>
                                        </div>

                                        @if($autoDealer->vendor_platforms)
                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.vendor_platforms') }}</label>
                                            <p class="text-base">{{ $autoDealer->vendor_platforms }}</p>
                                        </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Verification & Optional Docs -->
                                <div class="space-y-4">
                                    <h6 class="text-lg font-semibold text-primary">{{ __('admin.verification_optional_docs') }}</h6>

                                    <div class="space-y-3">
                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.nda_required') }}</label>
                                            <p class="text-base">{{ ucfirst($autoDealer->nda_required) }}</p>
                                        </div>

                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.trade_reference') }}</label>
                                            <p class="text-base">{{ ucfirst($autoDealer->trade_reference) }}</p>
                                        </div>

                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.documents') }}</label>
                                            <div class="flex flex-wrap gap-2 mt-2">
                                                <a href="{{ Storage::url($autoDealer->w9_upload) }}" target="_blank" class="ti-btn ti-btn-sm ti-btn-primary">
                                                    <i class="ri-file-text-line"></i> W9 Form
                                                </a>
                                                @if($autoDealer->insurance_certificate)
                                                <a href="{{ Storage::url($autoDealer->insurance_certificate) }}" target="_blank" class="ti-btn ti-btn-sm ti-btn-success">
                                                    <i class="ri-file-text-line"></i> Insurance Certificate
                                                </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Status and Admin Notes -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                                <div class="space-y-4">
                                    <h6 class="text-lg font-semibold text-primary">{{ __('admin.status_information') }}</h6>

                                    <div class="space-y-3">
                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.status') }}</label>
                                            <div class="mt-1">{!! $autoDealer->status_badge !!}</div>
                                        </div>

                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.created_at') }}</label>
                                            <p class="text-base">{{ $autoDealer->created_at }}</p>
                                        </div>

                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.updated_at') }}</label>
                                            <p class="text-base">{{ $autoDealer->updated_at }}</p>
                                        </div>
                                    </div>
                                </div>

                                @if($autoDealer->admin_notes)
                                <div class="space-y-4">
                                    <h6 class="text-lg font-semibold text-primary">{{ __('admin.admin_notes') }}</h6>

                                    <div class="space-y-3">
                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.notes') }}</label>
                                            <p class="text-base">{{ $autoDealer->admin_notes }}</p>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

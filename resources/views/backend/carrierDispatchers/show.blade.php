@extends('backend.layouts.master')
@section('title') {{ __('admin.carrier_dispatcher_details') }} @endsection
@section('content')
    <div class="content">
        <div class="main-content">
            <div class="block justify-between page-header md:flex">
                <div>
                    <h3 class="!text-defaulttextcolor dark:!text-defaulttextcolor/70 dark:text-white dark:hover:text-white text-[1.375rem] font-semibold font-first-geo">{{ __('admin.carrier_dispatcher_details') }}</h3>
                    <p class="font-second-geo text-defaulttextcolor/70">{{ __('admin.welcome') }}</p>
                </div>
                <ol class="flex items-center whitespace-nowrap min-w-0 gap-3 header-nav-links">
                    <li class="text-[0.813rem] ps-[0.5rem]">
                        <a href="{{ route('backend.carrierDispatchers.index') }}" class="ti-btn bg-primary text-white !font-medium font-second-geo">
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
                            <h5 class="box-title">{{ __('admin.carrier_dispatcher_information') }}</h5>
                        </div>
                        <div class="box-body">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Basic Information -->
                                <div class="space-y-4">
                                    <h6 class="text-lg font-semibold text-primary">{{ __('admin.basic_information') }}</h6>

                                    <div class="space-y-3">
                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.mc_number') }}</label>
                                            <p class="text-base">{{ $carrierDispatcher->mc_number }}</p>
                                        </div>

                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.dot_number') }}</label>
                                            <p class="text-base">{{ $carrierDispatcher->dot_number }}</p>
                                        </div>

                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.cars_under_management') }}</label>
                                            <p class="text-base">{{ $carrierDispatcher->cars_under_management }} cars</p>
                                        </div>

                                        @if($carrierDispatcher->website_url)
                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.website_url') }}</label>
                                            <p class="text-base">
                                                <a href="{{ $carrierDispatcher->website_url }}" target="_blank" class="text-primary hover:underline">{{ $carrierDispatcher->website_url }}</a>
                                            </p>
                                        </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Company Information -->
                                <div class="space-y-4">
                                    <h6 class="text-lg font-semibold text-primary">{{ __('admin.company_information') }}</h6>

                                    <div class="space-y-3">
                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.legal_business_name') }}</label>
                                            <p class="text-base">{{ $carrierDispatcher->legal_business_name }}</p>
                                        </div>

                                        @if($carrierDispatcher->dba)
                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.dba') }}</label>
                                            <p class="text-base">{{ $carrierDispatcher->dba }}</p>
                                        </div>
                                        @endif

                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.business_type') }}</label>
                                            <p class="text-base">{{ $carrierDispatcher->business_type }}</p>
                                        </div>

                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.years_operation') }}</label>
                                            <p class="text-base">{{ $carrierDispatcher->years_operation }} years</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                                <!-- Contact Information -->
                                <div class="space-y-4">
                                    <h6 class="text-lg font-semibold text-primary">{{ __('admin.primary_contact') }}</h6>

                                    <div class="space-y-3">
                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.contact_name') }}</label>
                                            <p class="text-base">{{ $carrierDispatcher->contact_name }}</p>
                                        </div>

                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.contact_title') }}</label>
                                            <p class="text-base">{{ $carrierDispatcher->contact_title }}</p>
                                        </div>

                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.contact_phone') }}</label>
                                            <p class="text-base">
                                                <a href="tel:{{ $carrierDispatcher->contact_phone }}" class="text-primary">{{ $carrierDispatcher->contact_phone }}</a>
                                            </p>
                                        </div>

                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.contact_email') }}</label>
                                            <p class="text-base">
                                                <a href="mailto:{{ $carrierDispatcher->contact_email }}" class="text-primary">{{ $carrierDispatcher->contact_email }}</a>
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Location & Operations -->
                                <div class="space-y-4">
                                    <h6 class="text-lg font-semibold text-primary">{{ __('admin.location_operations') }}</h6>

                                    <div class="space-y-3">
                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.main_address') }}</label>
                                            <p class="text-base">{{ $carrierDispatcher->main_address }}</p>
                                        </div>

                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.multiple_locations') }}</label>
                                            <p class="text-base">{{ ucfirst($carrierDispatcher->multiple_locations) }}</p>
                                        </div>

                                        @if($carrierDispatcher->additional_addresses)
                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.additional_addresses') }}</label>
                                            <p class="text-base">{{ $carrierDispatcher->additional_addresses }}</p>
                                        </div>
                                        @endif
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
                                            <p class="text-base">{{ $carrierDispatcher->billing_contact }}</p>
                                        </div>

                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.billing_email') }}</label>
                                            <p class="text-base">
                                                <a href="mailto:{{ $carrierDispatcher->billing_email }}" class="text-primary">{{ $carrierDispatcher->billing_email }}</a>
                                            </p>
                                        </div>

                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.payment_method') }}</label>
                                            <p class="text-base">{{ $carrierDispatcher->payment_method_text }}</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Verification & Documents -->
                                <div class="space-y-4">
                                    <h6 class="text-lg font-semibold text-primary">{{ __('admin.verification_documents') }}</h6>

                                    <div class="space-y-3">
                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.nda_required') }}</label>
                                            <p class="text-base">{{ ucfirst($carrierDispatcher->nda_required) }}</p>
                                        </div>

                                        <div>
                                            <label class="text-sm font-medium text-gray-600">{{ __('admin.submitted_at') }}</label>
                                            <p class="text-base">{{ $carrierDispatcher->created_at }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- File Downloads -->
                            <div class="mt-8 space-y-4">
                                <h6 class="text-lg font-semibold text-primary">{{ __('admin.uploaded_files') }}</h6>

                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                                    @if($carrierDispatcher->presentation_file)
                                    <div>
                                        <a href="{{ route('backend.carrier_dispatchers.download', [$carrierDispatcher->id, 'presentation']) }}"
                                           class="ti-btn ti-btn-outline-primary w-full">
                                            <i class="ri-file-pdf-line"></i> {{ __('admin.presentation_file') }}
                                        </a>
                                    </div>
                                    @endif

                                    @if($carrierDispatcher->vehicle_list_file)
                                    <div>
                                        <a href="{{ route('backend.carrier_dispatchers.download', [$carrierDispatcher->id, 'vehicle_list']) }}"
                                           class="ti-btn ti-btn-outline-primary w-full">
                                            <i class="ri-file-pdf-line"></i> {{ __('admin.vehicle_list_file') }}
                                        </a>
                                    </div>
                                    @endif

                                    @if($carrierDispatcher->w9_upload)
                                    <div>
                                        <a href="{{ route('backend.carrier_dispatchers.download', [$carrierDispatcher->id, 'w9']) }}"
                                           class="ti-btn ti-btn-outline-success w-full">
                                            <i class="ri-file-pdf-line"></i> {{ __('admin.w9_form') }}
                                        </a>
                                    </div>
                                    @endif

                                    @if($carrierDispatcher->insurance_certificate)
                                    <div>
                                        <a href="{{ route('backend.carrier_dispatchers.download', [$carrierDispatcher->id, 'insurance']) }}"
                                           class="ti-btn ti-btn-outline-info w-full">
                                            <i class="ri-file-pdf-line"></i> {{ __('admin.insurance_certificate') }}
                                        </a>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Admin Notes -->
                            @if($carrierDispatcher->admin_notes)
                            <div class="mt-8 space-y-4">
                                <h6 class="text-lg font-semibold text-primary">{{ __('admin.admin_notes') }}</h6>

                                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                                    <div class="flex items-start">
                                        <i class="ri-sticky-note-line text-yellow-500 text-xl mr-2 mt-0.5"></i>
                                        <p class="text-yellow-800">{{ $carrierDispatcher->admin_notes }}</p>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <!-- Timestamps -->
                            <div class="mt-8 pt-6 border-t border-gray-200">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm text-gray-600">
                                    <div>
                                        <label class="font-medium">{{ __('admin.created_at') }}</label>
                                        <p>{{ $carrierDispatcher->created_at }}</p>
                                    </div>
                                    <div>
                                        <label class="font-medium">{{ __('admin.updated_at') }}</label>
                                        <p>{{ $carrierDispatcher->updated_at }}</p>
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

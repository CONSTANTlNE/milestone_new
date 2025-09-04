@extends('backend.layouts.master')
@section('title') {{ __('admin.corporate_government_fleet_details') }} @endsection
@section('content')
    <div class="content">
        <div class="main-content">
            <div class="block justify-between page-header md:flex">
                <div>
                    <h3 class="!text-defaulttextcolor dark:!text-defaulttextcolor/70 dark:text-white dark:hover:text-white text-[1.375rem] font-semibold font-first-geo">{{ __('admin.corporate_government_fleet_details') }}</h3>
                    <p class="font-second-geo text-defaulttextcolor/70">{{ __('admin.welcome') }}</p>
                </div>
                <ol class="flex items-center whitespace-nowrap min-w-0 gap-3 header-nav-links">
                    <li class="text-[0.813rem] text-defaulttextcolor font-semibold hover:text-primary dark:text-[#8c9097] dark:text-white/50">
                        <a href="{{ route('backend.corporateGovernmentFleets.index') }}" class="ti-btn bg-primary text-white !font-medium font-second-geo">
                            <i class="ri-arrow-left-line text-[1.375rem]"></i>
                            {{ __('admin.back_to_list') }}
                        </a>
                    </li>
                    <li class="text-[0.813rem] text-defaulttextcolor font-semibold hover:text-warning dark:text-[#8c9097] dark:text-white/50">
                        <a href="{{ route('backend.corporateGovernmentFleets.edit', $corporateGovernmentFleet) }}" class="ti-btn bg-warning text-white !font-medium font-second-geo">
                            <i class="ri-edit-line text-[1.375rem]"></i>
                            {{ __('admin.edit_corporate_government_fleet') }}
                        </a>
                    </li>
                </ol>
            </div>

            <x-backend.alert-messages />

            <div class="grid grid-cols-12 gap-6">
                <div class="xl:col-span-12 col-span-12">
                    <div class="box custom-box">
                        <div class="box-header">
                            <div class="box-title">
                                <h5 class="card-title mb-0">{{ __('admin.corporate_government_fleet_information') }}</h5>
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                <!-- Organization Information -->
                                <div class="col-span-full">
                                    <h6 class="text-lg font-semibold mb-4 text-primary">{{ __('admin.organization_information') }}</h6>
                                </div>
                                <div>
                                    <label class="form-label font-semibold">{{ __('admin.legal_organization_name') }}</label>
                                    <p class="text-defaulttextcolor">{{ $corporateGovernmentFleet->legal_organization_name }}</p>
                                </div>
                                <div>
                                    <label class="form-label font-semibold">{{ __('admin.dba') }}</label>
                                    <p class="text-defaulttextcolor">{{ $corporateGovernmentFleet->dba ?: __('admin.not_provided') }}</p>
                                </div>
                                <div>
                                    <label class="form-label font-semibold">{{ __('admin.business_type') }}</label>
                                    <p class="text-defaulttextcolor">{{ ucfirst($corporateGovernmentFleet->business_type) }}</p>
                                </div>
                                <div>
                                    <label class="form-label font-semibold">{{ __('admin.department') }}</label>
                                    <p class="text-defaulttextcolor">{{ $corporateGovernmentFleet->department ?: __('admin.not_provided') }}</p>
                                </div>
                                <div>
                                    <label class="form-label font-semibold">{{ __('admin.years_operation') }}</label>
                                    <p class="text-defaulttextcolor">{{ $corporateGovernmentFleet->years_operation }} years</p>
                                </div>
                                <div>
                                    <label class="form-label font-semibold">{{ __('admin.website_url') }}</label>
                                    <p class="text-defaulttextcolor">
                                        @if($corporateGovernmentFleet->website_url)
                                            <a href="{{ $corporateGovernmentFleet->website_url }}" target="_blank" class="text-primary">{{ $corporateGovernmentFleet->website_url }}</a>
                                        @else
                                            {{ __('admin.not_provided') }}
                                        @endif
                                    </p>
                                </div>

                                <!-- Primary Contact -->
                                <div class="col-span-full">
                                    <h6 class="text-lg font-semibold mb-4 text-primary">{{ __('admin.primary_contact') }}</h6>
                                </div>
                                <div>
                                    <label class="form-label font-semibold">{{ __('admin.contact_name') }}</label>
                                    <p class="text-defaulttextcolor">{{ $corporateGovernmentFleet->contact_name }}</p>
                                </div>
                                <div>
                                    <label class="form-label font-semibold">{{ __('admin.contact_title') }}</label>
                                    <p class="text-defaulttextcolor">{{ $corporateGovernmentFleet->contact_title }}</p>
                                </div>
                                <div>
                                    <label class="form-label font-semibold">{{ __('admin.contact_phone') }}</label>
                                    <p class="text-defaulttextcolor">
                                        <a href="tel:{{ $corporateGovernmentFleet->contact_phone }}" class="text-primary">{{ $corporateGovernmentFleet->contact_phone }}</a>
                                    </p>
                                </div>
                                <div>
                                    <label class="form-label font-semibold">{{ __('admin.contact_email') }}</label>
                                    <p class="text-defaulttextcolor">
                                        <a href="mailto:{{ $corporateGovernmentFleet->contact_email }}" class="text-primary">{{ $corporateGovernmentFleet->contact_email }}</a>
                                    </p>
                                </div>

                                <!-- Fleet Logistics & Operations -->
                                <div class="col-span-full">
                                    <h6 class="text-lg font-semibold mb-4 text-primary">{{ __('admin.location_operations') }}</h6>
                                </div>
                                <div>
                                    <label class="form-label font-semibold">{{ __('admin.fulfillment_address') }}</label>
                                    <p class="text-defaulttextcolor">{{ $corporateGovernmentFleet->fulfillment_address }}</p>
                                </div>
                                <div>
                                    <label class="form-label font-semibold">{{ __('admin.fleet_locations') }}</label>
                                    <p class="text-defaulttextcolor">{{ $corporateGovernmentFleet->fleet_locations }} locations</p>
                                </div>
                                <div>
                                    <label class="form-label font-semibold">{{ __('admin.vehicle_release_contact') }}</label>
                                    <p class="text-defaulttextcolor">{{ $corporateGovernmentFleet->vehicle_release_contact }}</p>
                                </div>
                                <div>
                                    <label class="form-label font-semibold">{{ __('admin.fleet_management_software') }}</label>
                                    <p class="text-defaulttextcolor">{{ $corporateGovernmentFleet->fleet_management_software ?: __('admin.not_provided') }}</p>
                                </div>
                                <div>
                                    <label class="form-label font-semibold">{{ __('admin.usage_type') }}</label>
                                    <p class="text-defaulttextcolor">{{ $corporateGovernmentFleet->formatted_usage_type }}</p>
                                </div>
                                <div>
                                    <label class="form-label font-semibold">{{ __('admin.vehicle_condition') }}</label>
                                    <p class="text-defaulttextcolor">{{ $corporateGovernmentFleet->formatted_vehicle_condition }}</p>
                                </div>

                                <!-- Transport Needs & Preferences -->
                                <div class="col-span-full">
                                    <h6 class="text-lg font-semibold mb-4 text-primary">{{ __('admin.transport_delivery_details') }}</h6>
                                </div>
                                <div>
                                    <label class="form-label font-semibold">{{ __('admin.vehicles_per_month') }}</label>
                                    <p class="text-defaulttextcolor">{{ $corporateGovernmentFleet->vehicles_per_month }} vehicles/month</p>
                                </div>
                                <div>
                                    <label class="form-label font-semibold">{{ __('admin.transport_type') }}</label>
                                    <p class="text-defaulttextcolor">{{ ucfirst($corporateGovernmentFleet->transport_type) }}</p>
                                </div>
                                <div>
                                    <label class="form-label font-semibold">{{ __('admin.transport_scope') }}</label>
                                    <p class="text-defaulttextcolor">{{ $corporateGovernmentFleet->formatted_transport_scope }}</p>
                                </div>
                                <div>
                                    <label class="form-label font-semibold">{{ __('admin.security_requirements') }}</label>
                                    <p class="text-defaulttextcolor">{{ $corporateGovernmentFleet->security_requirements ?: __('admin.not_provided') }}</p>
                                </div>
                                <div class="col-span-full">
                                    <label class="form-label font-semibold">{{ __('admin.pickup_protocols') }}</label>
                                    <p class="text-defaulttextcolor">{{ $corporateGovernmentFleet->pickup_protocols }}</p>
                                </div>
                                <div class="col-span-full">
                                    <label class="form-label font-semibold">{{ __('admin.special_handling') }}</label>
                                    <p class="text-defaulttextcolor">{{ $corporateGovernmentFleet->special_handling ?: __('admin.not_provided') }}</p>
                                </div>

                                <!-- Billing & Payment -->
                                <div class="col-span-full">
                                    <h6 class="text-lg font-semibold mb-4 text-primary">{{ __('admin.billing_payment') }}</h6>
                                </div>
                                <div>
                                    <label class="form-label font-semibold">{{ __('admin.billing_contact') }}</label>
                                    <p class="text-defaulttextcolor">{{ $corporateGovernmentFleet->billing_contact }}</p>
                                </div>
                                <div>
                                    <label class="form-label font-semibold">{{ __('admin.billing_email') }}</label>
                                    <p class="text-defaulttextcolor">
                                        <a href="mailto:{{ $corporateGovernmentFleet->billing_email }}" class="text-primary">{{ $corporateGovernmentFleet->billing_email }}</a>
                                    </p>
                                </div>
                                <div>
                                    <label class="form-label font-semibold">{{ __('admin.payment_method') }}</label>
                                    <p class="text-defaulttextcolor">{{ ucfirst(str_replace('_', ' ', $corporateGovernmentFleet->payment_method)) }}</p>
                                </div>
                                <div>
                                    <label class="form-label font-semibold">{{ __('admin.vendor_portal_invoicing') }}</label>
                                    <p class="text-defaulttextcolor">{{ ucfirst($corporateGovernmentFleet->vendor_portal_invoicing) }}</p>
                                </div>
                                <div>
                                    <label class="form-label font-semibold">{{ __('admin.payment_platform') }}</label>
                                    <p class="text-defaulttextcolor">{{ $corporateGovernmentFleet->payment_platform ?: __('admin.not_provided') }}</p>
                                </div>

                                <!-- Verification Documents -->
                                <div class="col-span-full">
                                    <h6 class="text-lg font-semibold mb-4 text-primary">{{ __('admin.verification_documents') }}</h6>
                                </div>
                                <div>
                                    <label class="form-label font-semibold">{{ __('admin.government_corporate_id') }}</label>
                                    <p class="text-defaulttextcolor">
                                        <a href="{{ Storage::url($corporateGovernmentFleet->government_corporate_id) }}" target="_blank" class="text-primary">
                                            <i class="ri-file-pdf-line"></i> View Document
                                        </a>
                                    </p>
                                </div>
                                <div>
                                    <label class="form-label font-semibold">{{ __('admin.w9_form') }}</label>
                                    <p class="text-defaulttextcolor">
                                        <a href="{{ Storage::url($corporateGovernmentFleet->w9_upload) }}" target="_blank" class="text-primary">
                                            <i class="ri-file-pdf-line"></i> View Document
                                        </a>
                                    </p>
                                </div>
                                <div>
                                    <label class="form-label font-semibold">{{ __('admin.insurance_certificate') }}</label>
                                    <p class="text-defaulttextcolor">
                                        <a href="{{ Storage::url($corporateGovernmentFleet->insurance_certificate) }}" target="_blank" class="text-primary">
                                            <i class="ri-file-pdf-line"></i> View Document
                                        </a>
                                    </p>
                                </div>
                                <div>
                                    <label class="form-label font-semibold">{{ __('admin.purchase_order_format') }}</label>
                                    <p class="text-defaulttextcolor">
                                        @if($corporateGovernmentFleet->purchase_order_format)
                                            <a href="{{ Storage::url($corporateGovernmentFleet->purchase_order_format) }}" target="_blank" class="text-primary">
                                                <i class="ri-file-pdf-line"></i> View Document
                                            </a>
                                        @else
                                            {{ __('admin.not_provided') }}
                                        @endif
                                    </p>
                                </div>
                                <div class="col-span-full">
                                    <label class="form-label font-semibold">{{ __('admin.references_contractors') }}</label>
                                    <p class="text-defaulttextcolor">{{ $corporateGovernmentFleet->references_contractors ?: __('admin.not_provided') }}</p>
                                </div>

                                <!-- Status and Admin Notes -->
                                <div class="col-span-full">
                                    <h6 class="text-lg font-semibold mb-4 text-primary">{{ __('admin.status_tracking') }}</h6>
                                </div>
                                <div>
                                    <label class="form-label font-semibold">{{ __('admin.current_status') }}</label>
                                    <p class="text-defaulttextcolor">
                                        <x-backend.badge type="{{ $corporateGovernmentFleet->status === 'approved' ? 'success' : ($corporateGovernmentFleet->status === 'rejected' ? 'danger' : 'warning') }}" :text="ucfirst($corporateGovernmentFleet->status)" />
                                    </p>
                                </div>
                                <div>
                                    <label class="form-label font-semibold">{{ __('admin.submitted_at') }}</label>
                                    <p class="text-defaulttextcolor">{{ $corporateGovernmentFleet->created_at->format('d/m/Y H:i') }}</p>
                                </div>
                                <div class="col-span-full">
                                    <label class="form-label font-semibold">{{ __('admin.admin_notes') }}</label>
                                    <p class="text-defaulttextcolor">{{ $corporateGovernmentFleet->admin_notes ?: __('admin.not_provided') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

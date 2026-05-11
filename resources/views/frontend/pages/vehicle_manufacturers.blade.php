@extends('frontend.layouts.master')

@section('title') {{ __('admin.vehicle_manufacturers_page') }} - @endsection

@section('seo')
    @include('components.frontend.socials.seo', ['data' => $page ?? null])
@endsection

@section('styles')
    <style>
        .auto-auction-form {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            padding: 30px;
            margin: 20px 0;
        }

        .form-header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #f0f0f0;
        }

        .form-header h3 {
            color: #2c3e50;
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .form-subtitle {
            color: #7f8c8d;
            font-size: 16px;
            margin: 0;
        }

        .form-section.form-row-group {
            padding: 0;
            border-radius: 8px;
        }

        .form-section h4 {
            color: rgba(0, 13, 36, 1);
            margin-bottom: 20px;
            font-weight: 500;
            font-size: 24px;
            line-height: 24px;
            letter-spacing: -2%;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            font-size: 16px;
            line-height: 24px;
            letter-spacing: -1%;
            text-transform: capitalize;
            color: rgba(0, 13, 36, 0.8);
        }

        .manufacturer-form .form-control {
            width: 100%;
            padding: 12px 15px;
            border-radius: 12px;
            transition: border-color 0.3s ease;
            gap: 10px;
            padding-top: 12px;
            padding-right: 16px;
            padding-bottom: 12px;
            padding-left: 16px;
            background: rgba(245, 245, 245, 1);
            font-weight: 400;
            font-size: 16px;
            line-height: 24px;
            letter-spacing: -1%;
            color: rgba(79, 98, 130, 0.6);
        }

        .form-control:focus {
            outline: none;
            border-color: #3498db;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
        }

        .checkbox-group, .radio-group {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-top: 10px;
        }

        .checkbox-item, .radio-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            color: #2c3e50;
            cursor: pointer;
        }

        .checkbox-item input, .radio-item input {
            margin: 0;
            cursor: pointer;
        }

        .form-group .checkbox-item {
            position: relative;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 44px;
            margin: 0;
            padding: 10px 16px;
            border-radius: 20px;
            background: rgba(245, 245, 245, 1);
            color: rgba(79, 98, 130, 0.8);
            transition: background 0.2s ease, color 0.2s ease;
        }

        .form-group .checkbox-item input[type="checkbox"] {
            position: absolute;
            width: 1px;
            height: 1px;
            opacity: 0;
            pointer-events: none;
        }

        .form-group .checkbox-item:has(input[type="checkbox"]:checked) {
            background: rgba(79, 98, 130, 1);
            color: #fff;
        }

        .form-text {
            font-size: 12px;
            color: #6c757d;
            margin-top: 5px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #3498db, #2980b9);
            border: none;
            padding: 15px 40px;
            font-size: 16px;
            font-weight: 600;
            border-radius: 8px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(52, 152, 219, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(52, 152, 219, 0.4);
        }

        .alert {
            border-radius: 8px;
            border: none;
            padding: 15px 20px;
            margin-bottom: 20px;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border-left: 4px solid #28a745;
        }

        .alert-danger {
            background: #f8d7da;
            color: #721c24;
            border-left: 4px solid #dc3545;
        }

        .btn-close {
            background: none;
            border: none;
            font-size: 18px;
            cursor: pointer;
            float: right;
            color: inherit;
        }

        .vehicle-manufacturer-wizard-overlay {
            display: none;
            position: fixed;
            inset: 0;
            z-index: 10050;
            align-items: center;
            justify-content: center;
            padding: max(16px, env(safe-area-inset-top)) max(16px, env(safe-area-inset-right)) max(16px, env(safe-area-inset-bottom)) max(16px, env(safe-area-inset-left));
            box-sizing: border-box;
            background: rgba(0, 0, 0, 0.62);
        }

        .vehicle-manufacturer-wizard-overlay.is-open {
            display: flex;
        }

        .vehicle-manufacturer-wizard-shell {
            display: flex;
            flex-direction: column;
            width: 100%;
            max-width: 640px;
            max-height: min(88vh, 820px);
            min-height: 0;
            background: #fff;
            margin: 0;
            border-radius: 14px;
            overflow: hidden;
            box-shadow:
                0 24px 64px rgba(0, 0, 0, 0.5),
                0 0 0 1px rgba(255, 255, 255, 0.06);
        }

        .vehicle-manufacturer-wizard-header {
            flex-shrink: 0;
            gap: 16px;
            padding: 30px;
            border-bottom: 1px solid #e9ecef;
        }

        .vehicle-manufacturer-wizard-header-text h2 {
            margin: 0;
            font-weight: 500;
            font-size: 32px;
            line-height: 32px;
            letter-spacing: -2%;
            color: rgba(0, 13, 36, 1);
        }

        .vehicle-manufacturer-wizard-close {
            background: transparent;
            border: none;
            font-size: 1.75rem;
            line-height: 1;
            padding: 12px 18px;
            cursor: pointer;
            color: #64748b;
            background: rgba(245, 245, 245, 1);
            border-radius: 10px;
        }

        .vehicle-manufacturer-wizard-close:hover {
            color: #0f172a;
        }

        #vehicleManufacturerWizardMainPanel {
            display: flex;
            flex-direction: column;
            flex: 1 1 auto;
            min-height: 0;
            overflow: hidden;
        }

        #vehicleManufacturerWizardMainPanel > form.manufacturer-form {
            display: flex;
            flex-direction: column;
            flex: 1 1 auto;
            min-height: 0;
            overflow: hidden;
        }

        .vehicle-manufacturer-wizard-overlay .manufacturer-form {
            display: flex;
            flex-direction: column;
            flex: 1 1 auto;
            min-height: 0;
            overflow: hidden;
        }

        .vehicle-manufacturer-wizard-overlay .accordion-header {
            display: none;
        }

        .vehicle-manufacturer-wizard-overlay .accordion-collapse {
            display: flex !important;
            flex: 1 1 auto;
            min-height: 0;
            height: auto !important;
            visibility: visible !important;
            overflow: hidden;
        }

        .vehicle-manufacturer-wizard-overlay .accordion-body {
            padding: 0;
        }

        .vehicle-manufacturer-wizard-progress-wrap {
            margin-top: 4px;
            max-width: 100%;
        }

        .vehicle-manufacturer-wizard-step-label {
            margin: 0 0 5px;
            font-weight: 500;
            font-size: 14px;
            line-height: 24px;
            letter-spacing: -2%;
            color: rgba(0, 13, 36, 1);
        }

        .vehicle-manufacturer-wizard-progress-bar {
            position: relative;
            height: 17px;
            border-radius: 999px;
            background: rgba(0, 50, 133, 0.1);
            overflow: hidden;
            box-sizing: border-box;
        }

        .vehicle-manufacturer-wizard-progress-fill {
            width: 16.666667%;
            height: 100%;
            border-radius: inherit;
            background: rgba(0, 50, 133, 1);
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.25);
            transition: width 0.35s ease;
        }

        .vehicle-manufacturer-wizard-notification {
            flex-shrink: 0;
            margin: 20px 30px 0;
            padding: 12px 16px;
            border-radius: 12px;
            background: rgba(255, 244, 230, 1);
            color: rgba(126, 72, 11, 1);
            font-size: 14px;
            font-weight: 500;
            line-height: 20px;
        }

        .vehicle-manufacturer-wizard-body {
            flex: 1 1 auto;
            min-height: 0;
            max-height: 100%;
            overflow-y: auto;
            padding: 30px;
            -webkit-overflow-scrolling: touch;
        }

        .vehicle-manufacturer-wizard-step {
            display: none;
        }

        .vehicle-manufacturer-wizard-step.is-active {
            display: block;
        }

        .vehicle-manufacturer-wizard-footer {
            padding: 16px 24px;
            border-top: 1px solid #e9ecef;
            background: #fff;
        }

        .vehicle-manufacturer-wizard-footer .wizard-actions {
            display: flex;
            justify-content: space-between;
        }

        .vehicle-manufacturer-wizard-footer .btn-wizard-close,
        .vehicle-manufacturer-wizard-footer .btn-wizard-back {
            border: none;
            border-radius: 100px;
            background: rgba(245, 245, 245, 1);
            color: rgba(31, 31, 31, 1);
            padding: 12px 24px;
            font-weight: 600;
            cursor: pointer;
        }

        .vehicle-manufacturer-wizard-footer .btn-wizard-close:hover,
        .vehicle-manufacturer-wizard-footer .btn-wizard-back:hover {
            background: #dee2e6;
        }

        .vehicle-manufacturer-wizard-footer .btn-wizard-next,
        .vehicle-manufacturer-wizard-footer .btn-wizard-submit {
            border: none;
            border-radius: 100px;
            background: rgba(0, 50, 133, 1);
            color: #fff;
            padding: 12px 24px;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(52, 152, 219, 0.35);
            line-height: 22px;
            letter-spacing: 0%;
        }

        .vehicle-manufacturer-wizard-footer .btn-wizard-next:hover,
        .vehicle-manufacturer-wizard-footer .btn-wizard-submit:hover {
            transform: translateY(-1px);
        }

        body.vehicle-manufacturer-wizard-open {
            overflow: hidden;
        }

        .vehicle-manufacturer-wizard-success-panel {
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            flex: 1;
            min-height: 260px;
            padding: 36px 28px 28px;
            text-align: center;
        }

        .vehicle-manufacturer-wizard-success-inner {
            width: 100%;
            max-width: 400px;
        }

        .vehicle-manufacturer-success-icon-wrap {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }

        .vehicle-manufacturer-success-icon {
            width: 72px;
            height: 72px;
        }

        .vehicle-manufacturer-wizard-success-panel.is-error .vehicle-manufacturer-success-heading {
            color: #991b1b;
        }

        .vehicle-manufacturer-success-heading {
            margin: 0 0 12px;
            font-size: 1.35rem;
            font-weight: 700;
            color: #2c3e50;
            line-height: 1.3;
        }

        .vehicle-manufacturer-success-text {
            margin: 0 0 28px;
            font-size: 1rem;
            line-height: 1.55;
            color: #64748b;
        }

        .vehicle-manufacturer-success-close-btn {
            width: 100%;
            max-width: 280px;
        }

        .vehicle-manufacturer-wizard-success-dismiss {
            position: absolute;
            top: 12px;
            right: 12px;
        }

        label.checkbox-item {
            font-weight: 500;
            font-size: 14px;
            line-height: 18px;
            letter-spacing: 0%;
            background: rgba(79, 98, 130, 0.1);
            padding: 10px 15px;
            border-radius: 20px;
            color: rgba(79, 98, 130, 1);
        }

        .vehicle-manufacturer-form-intro {
            margin-top: 24px;
        }

        @media (max-width: 768px) {
            .auto-auction-form {
                padding: 20px;
                margin: 10px 0;
            }

            .form-section {
                padding: 20px;
            }

            .checkbox-group, .radio-group {
                flex-direction: column;
                gap: 10px;
            }
        }
    </style>
@endsection

@section('header_background')
    @include('components.frontend.header-banner', ['data' => $page, 'popup' => 'vehicle-manufacturer'])
@endsection

@section('content')
    <section class="section-lg section-home-blogs service-one-bg-white pbmit-bg-color-white" data-aos="fade-up" data-aos-duration="750" data-aos-easing="ease-out">
        <div class="container">
            <div class="row services-content">
                @if(getPageById(29) !== null)
                    <div class="col-md-5 mb-4 services-content-left">
                        <div class="pbmit-heading-subheading">
                            <h4 class="pbmit-subtitle" data-aos="fade-up" data-aos-delay="80" data-aos-duration="600" style="text-align: left;">
                                <span>01</span> | {{ __('process') }}
                            </h4>
                            <h2 class="pbmit-title mb-reveal-wipe" style="text-align: left;">{{ getPageById(29)->slogan }}</h2>
                            <p class="pbmit-title"> {!! getPageById(29)->content !!}</p>
                            <div class="pbmit-separator"></div>
                            <div class="col-md-4 all-blog d-md-block d-none">
                                <a class="pbmit-btn js-open-vehicle-manufacturer-wizard" href="#" role="button">
                                <span class="pbmit-button-content-wrapper">
                                    <span class="pbmit-button-text">{{ __('calculate_now') }}</span>
                                </span>
                                </a>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="col-md-7 mb-4 services-content-right">
                    @if(count($page->tiers))
                        @include('frontend.pages.tier', ['data' => $page->tiers])
                    @endif
                </div>
            </div>
        </div>
    </section>


    <div id="vehicleManufacturerWizardOverlay" class="vehicle-manufacturer-wizard-overlay" aria-modal="true" role="dialog" aria-labelledby="vehicleManufacturerWizardTitle" aria-hidden="true">
        <div class="vehicle-manufacturer-wizard-shell">
            <div id="vehicleManufacturerWizardMainPanel" class="@if(session('success') || session('error') || $errors->any()) d-none @endif">
                <div class="vehicle-manufacturer-wizard-header">
                    <div class="vehicle-manufacturer-wizard-header-text">
                        <div class="header-title">
                            <h2 id="vehicleManufacturerWizardTitle">Vehicle Manufacturers Application</h2>
                            <button type="button" class="vehicle-manufacturer-wizard-close" id="vehicleManufacturerWizardClose" aria-label="{{ __('admin.close') }}">&times;</button>
                        </div>
                        <div class="header-progress-bar">
                            <p class="vehicle-manufacturer-wizard-step-label" id="vehicleManufacturerWizardStepLabel">{{ __('admin.vehicle_manufacturer_wizard_step_prefix', ['current' => 1]) }} <span>{{ __('admin.vehicle_manufacturer_wizard_step_total', ['total' => 6]) }}</span></p>
                            <div class="vehicle-manufacturer-wizard-progress-wrap">
                                <div
                                    class="vehicle-manufacturer-wizard-progress-bar"
                                    id="vehicleManufacturerWizardProgress"
                                    role="progressbar"
                                    aria-valuemin="1"
                                    aria-valuemax="6"
                                    aria-valuenow="1"
                                    aria-valuetext="{{ __('admin.vehicle_manufacturer_wizard_step_count', ['current' => 1, 'total' => 6]) }}"
                                    aria-labelledby="vehicleManufacturerWizardStepLabel"
                                >
                                    <div class="vehicle-manufacturer-wizard-progress-fill" id="vehicleManufacturerWizardProgressFill"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <form class="manufacturer-form" method="POST" action="{{ route('frontend.vehicle_manufacturer.store') }}" enctype="multipart/form-data" id="vehicleManufacturerWizardForm" novalidate>
                    @csrf
                    <div class="vehicle-manufacturer-wizard-notification d-none" id="vehicleManufacturerWizardNotification" role="status" aria-live="polite"></div>
                    <div class="vehicle-manufacturer-wizard-body">
                        <div class="vehicle-manufacturer-wizard-step is-active" data-step="1">
                            <div class="form-section form-row-group">
                                <h4>Organization Information</h4>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="legal_business_name">Legal Business Name *</label>
                                            <input type="text" class="form-control" id="legal_business_name" name="legal_business_name" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="dba">DBA (If Any)</label>
                                            <input type="text" class="form-control" id="dba" name="dba">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="website_url">Website URL</label>
                                            <input type="url" class="form-control" id="website_url" name="website_url" placeholder="https://example.com">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="years_operation">Years in Operation *</label>
                                            <input type="number" class="form-control" id="years_operation" name="years_operation" min="0" max="100" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Business Type *</label>
                                            <div class="radio-group">
                                                <label class="radio-item">
                                                    <input type="radio" name="business_type" value="manufacturer" required> Manufacturer
                                                </label>
                                                <label class="radio-item">
                                                    <input type="radio" name="business_type" value="distributor" required> Distributor
                                                </label>
                                                <label class="radio-item">
                                                    <input type="radio" name="business_type" value="oem_partner" required> OEM Partner
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="us_office_location">U.S. Office or Representative Location (if global)</label>
                                            <input type="text" class="form-control" id="us_office_location" name="us_office_location" placeholder="City, State or Address">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="vehicle-manufacturer-wizard-step" data-step="2">
                            <div class="form-section form-row-group">
                                <h4>Primary Contact</h4>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="contact_name">Full Name *</label>
                                            <input type="text" class="form-control" id="contact_name" name="contact_name" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="contact_title">Title/Position *</label>
                                            <input type="text" class="form-control" id="contact_title" name="contact_title" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="contact_phone">Phone Number *</label>
                                            <input type="tel" class="form-control" id="contact_phone" name="contact_phone" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="contact_email">Email Address *</label>
                                            <input type="email" class="form-control" id="contact_email" name="contact_email" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="vehicle-manufacturer-wizard-step" data-step="3">
                            <div class="form-section form-row-group">
                                <h4>Factory & Logistics Details</h4>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="primary_port_factory">Primary Port/Factory Address *</label>
                                            <input type="text" class="form-control" id="primary_port_factory" name="primary_port_factory" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="us_distribution_centers">U.S. Distribution Center(s) *</label>
                                            <input type="text" class="form-control" id="us_distribution_centers" name="us_distribution_centers" placeholder="List all distribution center locations" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="delivery_frequency">Delivery Frequency (Daily/Weekly/Monthly) *</label>
                                            <select class="form-control" id="delivery_frequency" name="delivery_frequency" required>
                                                <option value="">Select Frequency</option>
                                                <option value="daily">Daily</option>
                                                <option value="weekly">Weekly</option>
                                                <option value="monthly">Monthly</option>
                                                <option value="varies">Varies</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="monthly_volume">Expected Monthly Volume *</label>
                                            <input type="number" class="form-control" id="monthly_volume" name="monthly_volume" min="1" placeholder="Number of vehicles" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="vin_batching_format">VIN Batching Format (if any)</label>
                                            <input type="text" class="form-control" id="vin_batching_format" name="vin_batching_format" placeholder="e.g., Sequential, Date-based, Model-based">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="new_car_prep">New Car Prep Requirements (e.g. PDI, wrapping) *</label>
                                            <input type="text" class="form-control" id="new_car_prep" name="new_car_prep" placeholder="Describe any preparation requirements for new vehicles" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Upload a file with the list of Vehicles (Optional)</label>
                                            <input type="file" class="form-control" id="vehicle_list" name="vehicle_list" accept=".pdf,.doc,.docx">
                                            <small class="form-text text-muted">Accepted formats: PDF, DOC, DOCX, Excel</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="vehicle-manufacturer-wizard-step" data-step="4">
                            <div class="form-section form-row-group">
                                <h4>Vehicle & Transport Preferences</h4>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Transport Type *</label>
                                            <div class="radio-group">
                                                <label class="radio-item">
                                                    <input type="radio" name="transport_type" value="open" required> Open
                                                </label>
                                                <label class="radio-item">
                                                    <input type="radio" name="transport_type" value="enclosed" required> Enclosed
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Vehicle Types *</label>
                                            <div class="checkbox-group">
                                                <label class="checkbox-item">
                                                    <input type="checkbox" name="vehicle_types[]" value="new"> New
                                                </label>
                                                <label class="checkbox-item">
                                                    <input type="checkbox" name="vehicle_types[]" value="ev"> EV
                                                </label>
                                                <label class="checkbox-item">
                                                    <input type="checkbox" name="vehicle_types[]" value="high_end"> High-End
                                                </label>
                                                <label class="checkbox-item">
                                                    <input type="checkbox" name="vehicle_types[]" value="fleet"> Fleet
                                                </label>
                                                <label class="checkbox-item">
                                                    <input type="checkbox" name="vehicle_types[]" value="prototypes"> Prototypes
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="load_prep_protocols">Load Prep Protocols (e.g. documents, manuals, parts) *</label>
                                            <input type="text" class="form-control" id="load_prep_protocols" name="load_prep_protocols" placeholder="Describe preparation requirements for each load" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="special_handling">Special Handling Instructions (if any)</label>
                                            <input type="text" class="form-control" id="special_handling" name="special_handling" placeholder="Any special handling requirements">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="delivery_destinations">Delivery Destinations *</label>
                                            <input type="text" class="form-control" id="delivery_destinations" name="delivery_destinations" placeholder="List typical delivery destinations or regions" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="compliance_procedures">Compliance or Inspection Procedures Required</label>
                                            <input type="text" class="form-control" id="compliance_procedures" name="compliance_procedures" placeholder="Any compliance or inspection requirements">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="vehicle-manufacturer-wizard-step" data-step="5">
                            <div class="form-section form-row-group">
                                <h4>Billing & Payment</h4>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="billing_contact">Billing Contact Name *</label>
                                            <input type="text" class="form-control" id="billing_contact" name="billing_contact" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="billing_email">Billing Email *</label>
                                            <input type="email" class="form-control" id="billing_email" name="billing_email" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="system_name">System Name (if applicable)</label>
                                            <input type="text" class="form-control" id="system_name" name="system_name" placeholder="e.g., Ariba, Coupa, Jaggaer, Other">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Preferred Payment Method *</label>
                                            <div class="checkbox-group">
                                                <label class="checkbox-item">
                                                    <input type="checkbox" name="payment_method[]" value="ach"> ACH
                                                </label>
                                                <label class="checkbox-item">
                                                    <input type="checkbox" name="payment_method[]" value="credit_card"> Credit Card
                                                </label>
                                                <label class="checkbox-item">
                                                    <input type="checkbox" name="payment_method[]" value="government_po"> Government PO
                                                </label>
                                                <label class="checkbox-item">
                                                    <input type="checkbox" name="payment_method[]" value="net_terms"> Net Terms
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Do You Use a Vendor Management System (e.g., Ariba, Coupa)? *</label>
                                            <div class="radio-group">
                                                <label class="radio-item">
                                                    <input type="radio" name="vendor_management_system" value="yes" required> Yes
                                                </label>
                                                <label class="radio-item">
                                                    <input type="radio" name="vendor_management_system" value="no" required> No
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="vehicle-manufacturer-wizard-step" data-step="6">
                            <div class="form-section form-row-group">
                                <h4>Verification Documents</h4>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="w9_upload">W9 Upload *</label>
                                            <input type="file" class="form-control" id="w9_upload" name="w9_upload" accept=".pdf,.doc,.docx" required>
                                            <small class="form-text text-muted">Accepted formats: PDF, DOC, DOCX</small>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="insurance_certificate">Certificate of Insurance *</label>
                                            <input type="file" class="form-control" id="insurance_certificate" name="insurance_certificate" accept=".pdf,.doc,.docx" required>
                                            <small class="form-text text-muted">Accepted formats: PDF, DOC, DOCX</small>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="business_registration">Business Registration or Incorporation Certificate *</label>
                                            <input type="file" class="form-control" id="business_registration" name="business_registration" accept=".pdf,.doc,.docx" required>
                                            <small class="form-text text-muted">Accepted formats: PDF, DOC, DOCX</small>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="trade_references">Trade References</label>
                                            <textarea class="form-control" id="trade_references" name="trade_references" rows="3" placeholder="List any trade references or business relationships"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="vehicle-manufacturer-wizard-footer">
                        <div class="wizard-actions ms-auto">
                            <button type="button" class="btn-wizard-close" id="wizardBtnClose">{{ __('admin.close') }}</button>
                            <button type="button" class="btn-wizard-back" id="wizardBtnBack" style="display:none;">{{ __('admin.back') }}</button>
                            <button type="button" class="btn-wizard-next" id="wizardBtnNext">{{ __('admin.next') }}</button>
                            <button type="submit" class="btn-wizard-submit d-none" id="wizardBtnSubmit">{{ __('admin.submit_application') }}</button>
                        </div>
                    </div>
                </form>
            </div>
            <div
                id="vehicleManufacturerWizardSuccessPanel"
                class="vehicle-manufacturer-wizard-success-panel @if(!session('success') && !session('error') && !$errors->any()) d-none @endif @if(session('error') || $errors->any()) is-error @endif"
                role="alertdialog"
                aria-modal="true"
                aria-labelledby="vehicleManufacturerSuccessHeading"
                aria-describedby="vehicleManufacturerSuccessText"
            >
                <button type="button" class="vehicle-manufacturer-wizard-close vehicle-manufacturer-wizard-success-dismiss" id="vehicleManufacturerWizardSuccessDismissX" aria-label="{{ __('admin.close') }}">&times;</button>
                <div class="vehicle-manufacturer-wizard-success-inner">
                    <div class="vehicle-manufacturer-success-icon-wrap">
                        @if(session('success'))
                            <svg class="vehicle-manufacturer-success-icon" viewBox="0 0 72 72" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <circle cx="36" cy="36" r="34" stroke="#22c55e" stroke-width="3" fill="#ecfdf5"/>
                                <path d="M22 37l10 10 18-22" stroke="#16a34a" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                            </svg>
                        @else
                            <svg class="vehicle-manufacturer-success-icon" viewBox="0 0 72 72" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <circle cx="36" cy="36" r="34" stroke="#ef4444" stroke-width="3" fill="#fef2f2"/>
                                <path d="M25 25l22 22M47 25L25 47" stroke="#dc2626" stroke-width="3.5" stroke-linecap="round" fill="none"/>
                            </svg>
                        @endif
                    </div>
                    <h3 id="vehicleManufacturerSuccessHeading" class="vehicle-manufacturer-success-heading">
                        {{ session('success') ? __('admin.application_submitted') : __('admin.application_not_submitted') }}
                    </h3>
                    <p id="vehicleManufacturerSuccessText" class="vehicle-manufacturer-success-text">
                        {{ session('success') ? __('admin.application_submitted_text') : __('admin.application_not_submitted_text') }}
                    </p>
                    <button type="button" class="btn-wizard-next vehicle-manufacturer-success-close-btn" id="vehicleManufacturerWizardSuccessCloseBtn">{{ __('admin.close') }}</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        (function () {
            function initVehicleManufacturerWizard() {
                var overlay = document.getElementById('vehicleManufacturerWizardOverlay');
                if (!overlay) return;

                var bodyEl = document.body;
                var mainPanel = document.getElementById('vehicleManufacturerWizardMainPanel');
                var successPanel = document.getElementById('vehicleManufacturerWizardSuccessPanel');
                var closeBtn = document.getElementById('vehicleManufacturerWizardClose');
                var form = document.getElementById('vehicleManufacturerWizardForm');
                var notification = document.getElementById('vehicleManufacturerWizardNotification');
                var stepLabel = document.getElementById('vehicleManufacturerWizardStepLabel');
                var progressBar = document.getElementById('vehicleManufacturerWizardProgress');
                var progressFill = document.getElementById('vehicleManufacturerWizardProgressFill');
                var btnClose = document.getElementById('wizardBtnClose');
                var btnBack = document.getElementById('wizardBtnBack');
                var btnNext = document.getElementById('wizardBtnNext');
                var btnSubmit = document.getElementById('wizardBtnSubmit');
                var totalSteps = 6;
                var currentStep = 1;
                var stepCountText = @json(__('admin.vehicle_manufacturer_wizard_step_count'));
                var stepPrefixText = @json(__('admin.vehicle_manufacturer_wizard_step_prefix'));
                var stepTotalText = @json(__('admin.vehicle_manufacturer_wizard_step_total'));

                function showFormPanel() {
                    if (successPanel) successPanel.classList.add('d-none');
                    if (mainPanel) mainPanel.classList.remove('d-none');
                }

                function showNotification(message) {
                    if (!notification) return;

                    notification.textContent = message;
                    notification.classList.remove('d-none');
                    notification.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                }

                function hideNotification() {
                    if (!notification) return;

                    notification.textContent = '';
                    notification.classList.add('d-none');
                }

                function clearFormFields() {
                    if (!form) return;

                    form.querySelectorAll('input, select, textarea').forEach(function (field) {
                        if (field.name === '_token') return;

                        if (field.type === 'checkbox' || field.type === 'radio') {
                            field.checked = false;
                            return;
                        }

                        if (field.type === 'file') {
                            field.value = '';
                            return;
                        }

                        if (field.tagName === 'SELECT') {
                            field.selectedIndex = 0;
                            return;
                        }

                        field.value = '';
                    });

                    form.querySelectorAll('.is-invalid, .is-valid').forEach(function (el) {
                        el.classList.remove('is-invalid', 'is-valid');
                    });
                }

                function resetWizard() {
                    hideNotification();
                    clearFormFields();

                    if (typeof setStep === 'function' && typeof totalSteps === 'number') {
                        setStep(1);
                    }
                }

                function setStep(step) {
                    hideNotification();
                    currentStep = Math.max(1, Math.min(totalSteps, step));

                    overlay.querySelectorAll('.vehicle-manufacturer-wizard-step').forEach(function (panel) {
                        var panelStep = parseInt(panel.getAttribute('data-step'), 10);
                        panel.classList.toggle('is-active', panelStep === currentStep);
                    });

                    if (stepLabel) {
                        stepLabel.textContent = '';
                        stepLabel.appendChild(document.createTextNode(stepPrefixText.replace(':current', currentStep) + ' '));
                        var stepTotal = document.createElement('span');
                        stepTotal.textContent = stepTotalText.replace(':total', totalSteps);
                        stepLabel.appendChild(stepTotal);
                    }

                    var pct = (100 * currentStep) / totalSteps;
                    if (progressFill) {
                        progressFill.style.width = pct + '%';
                    }

                    if (progressBar) {
                        progressBar.setAttribute('aria-valuenow', String(currentStep));
                        progressBar.setAttribute('aria-valuetext', stepCountText
                            .replace(':current', currentStep)
                            .replace(':total', totalSteps));
                    }

                    overlay.querySelectorAll('[data-step-chip]').forEach(function (chip) {
                        var sn = parseInt(chip.getAttribute('data-step-chip'), 10);
                        chip.classList.toggle('is-complete', sn < currentStep);
                        chip.classList.toggle('is-active', sn === currentStep);
                        chip.classList.toggle('is-pending', sn > currentStep);
                    });

                    if (btnClose) btnClose.classList.toggle('d-none', currentStep !== 1);
                    if (btnBack) btnBack.style.display = currentStep === 1 ? 'none' : '';
                    if (btnNext) btnNext.classList.toggle('d-none', currentStep === totalSteps);
                    if (btnSubmit) btnSubmit.classList.toggle('d-none', currentStep !== totalSteps);

                    var scrollBody = overlay.querySelector('.vehicle-manufacturer-wizard-body');
                    if (scrollBody) scrollBody.scrollTop = 0;
                    overlay.setAttribute('aria-hidden', 'false');
                }

                function validateStep(step) {
                    var panel = overlay.querySelector('.vehicle-manufacturer-wizard-step[data-step="' + step + '"]');
                    if (!panel) return false;

                    if (step === 4 && !panel.querySelectorAll('input[name="vehicle_types[]"]:checked').length) {
                        showNotification(@json(__('admin.select_at_least_one_vehicle_type')));
                        return false;
                    }

                    if (step === 5 && !panel.querySelectorAll('input[name="payment_method[]"]:checked').length) {
                        showNotification(@json(__('admin.select_at_least_one_preferred_payment_method')));
                        return false;
                    }

                    var controls = panel.querySelectorAll('input, select, textarea');
                    for (var i = 0; i < controls.length; i++) {
                        var el = controls[i];
                        if (el.disabled) continue;

                        if (el.type === 'checkbox') {
                            if (el.name === 'vehicle_types[]' || el.name === 'payment_method[]') continue;
                            if (el.required && !el.checked) {
                                el.reportValidity();
                                return false;
                            }
                            continue;
                        }

                        if (el.type === 'file') {
                            if (el.hasAttribute('required') && (!el.files || !el.files.length)) {
                                if (typeof el.reportValidity === 'function') el.reportValidity();
                                else showNotification(@json(__('admin.please_upload_required_files')));
                                return false;
                            }
                            continue;
                        }

                        if (!el.checkValidity()) {
                            el.reportValidity();
                            return false;
                        }
                    }

                    return true;
                }

                function openWizard(e, keepCurrentPanel) {
                    if (e) e.preventDefault();
                    if (!keepCurrentPanel) showFormPanel();
                    overlay.classList.add('is-open');
                    bodyEl.classList.add('vehicle-manufacturer-wizard-open');
                    overlay.setAttribute('aria-hidden', 'false');
                    setStep(keepCurrentPanel ? currentStep : 1);
                }

                function closeWizard() {
                    resetWizard();
                    showFormPanel();
                    overlay.classList.remove('is-open');
                    bodyEl.classList.remove('vehicle-manufacturer-wizard-open');
                    overlay.setAttribute('aria-hidden', 'true');
                }

                document.addEventListener('click', function (e) {
                    var trigger = e.target && e.target.closest && e.target.closest('.js-open-vehicle-manufacturer-wizard');
                    if (!trigger) return;

                    openWizard(e);
                }, true);

                if (closeBtn) closeBtn.addEventListener('click', closeWizard);
                if (btnClose) btnClose.addEventListener('click', closeWizard);
                var successDismiss = document.getElementById('vehicleManufacturerWizardSuccessDismissX');
                var successClose = document.getElementById('vehicleManufacturerWizardSuccessCloseBtn');
                if (successDismiss) successDismiss.addEventListener('click', closeWizard);
                if (successClose) successClose.addEventListener('click', closeWizard);

                overlay.addEventListener('click', function (e) {
                    if (e.target === overlay) closeWizard();
                });

                if (btnNext) {
                    btnNext.addEventListener('click', function () {
                        if (!validateStep(currentStep)) return;
                        setStep(currentStep + 1);
                    });
                }

                if (btnBack) {
                    btnBack.addEventListener('click', function () {
                        setStep(currentStep - 1);
                    });
                }

                if (form) {
                    form.addEventListener('submit', function (e) {
                        if (!validateStep(totalSteps)) {
                            e.preventDefault();
                        }
                    });
                }

                document.addEventListener('keydown', function (e) {
                    if (e.key === 'Escape' && overlay.classList.contains('is-open')) {
                        closeWizard();
                    }
                });

                setStep(1);

                @if(session('success') || session('error') || $errors->any())
                    openWizard(null, true);
                @endif
            }

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', initVehicleManufacturerWizard);
            } else {
                initVehicleManufacturerWizard();
            }
        })();
    </script>
@endsection

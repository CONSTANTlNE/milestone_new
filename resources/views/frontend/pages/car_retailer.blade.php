@extends('frontend.layouts.master')

@section('title') {{ __('admin.car_retailers_page') }} - @endsection

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

        .retailer-form .form-control {
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

        .car-retailer-wizard-overlay {
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

        .car-retailer-wizard-overlay.is-open {
            display: flex;
        }

        .car-retailer-wizard-shell {
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

        .car-retailer-wizard-header {
            flex-shrink: 0;
            gap: 16px;
            padding: 30px;
            border-bottom: 1px solid #e9ecef;
        }

        .car-retailer-wizard-header-text h2 {
            margin: 0;
            font-weight: 500;
            font-size: 32px;
            line-height: 32px;
            letter-spacing: -2%;
            color: rgba(0, 13, 36, 1);
        }

        .car-retailer-wizard-close {
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

        .car-retailer-wizard-close:hover {
            color: #0f172a;
        }

        #carRetailerWizardMainPanel {
            display: flex;
            flex-direction: column;
            flex: 1 1 auto;
            min-height: 0;
            overflow: hidden;
        }

        #carRetailerWizardMainPanel > form.retailer-form {
            display: flex;
            flex-direction: column;
            flex: 1 1 auto;
            min-height: 0;
            overflow: hidden;
        }

        .car-retailer-wizard-overlay .retailer-form {
            display: flex;
            flex-direction: column;
            flex: 1 1 auto;
            min-height: 0;
            overflow: hidden;
        }

        .car-retailer-wizard-overlay .accordion-header {
            display: none;
        }

        .car-retailer-wizard-overlay .accordion-collapse {
            display: flex !important;
            flex: 1 1 auto;
            min-height: 0;
            height: auto !important;
            visibility: visible !important;
            overflow: hidden;
        }

        .car-retailer-wizard-overlay .accordion-body {
            padding: 0;
        }

        .car-retailer-wizard-progress-wrap {
            margin-top: 4px;
            max-width: 100%;
        }

        .car-retailer-wizard-step-label {
            margin: 0 0 5px;
            font-weight: 500;
            font-size: 14px;
            line-height: 24px;
            letter-spacing: -2%;
            color: rgba(0, 13, 36, 1);
        }

        .car-retailer-wizard-progress-bar {
            position: relative;
            height: 17px;
            border-radius: 999px;
            background: rgba(0, 50, 133, 0.1);
            overflow: hidden;
            box-sizing: border-box;
        }

        .car-retailer-wizard-progress-fill {
            width: 16.666667%;
            height: 100%;
            border-radius: inherit;
            background: rgba(0, 50, 133, 1);
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.25);
            transition: width 0.35s ease;
        }

        .car-retailer-wizard-notification {
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

        .car-retailer-wizard-body {
            flex: 1 1 auto;
            min-height: 0;
            max-height: 100%;
            overflow-y: auto;
            padding: 30px;
            -webkit-overflow-scrolling: touch;
        }

        .retailer-wizard-step {
            display: none;
        }

        .retailer-wizard-step.is-active {
            display: block;
        }

        .car-retailer-wizard-footer {
            padding: 16px 24px;
            border-top: 1px solid #e9ecef;
            background: #fff;
        }

        .car-retailer-wizard-footer .wizard-actions {
            display: flex;
            justify-content: space-between;
        }

        .car-retailer-wizard-footer .btn-wizard-close,
        .car-retailer-wizard-footer .btn-wizard-back {
            border: none;
            border-radius: 100px;
            background: rgba(245, 245, 245, 1);
            color: rgba(31, 31, 31, 1);
            padding: 12px 24px;
            font-weight: 600;
            cursor: pointer;
        }

        .car-retailer-wizard-footer .btn-wizard-close:hover,
        .car-retailer-wizard-footer .btn-wizard-back:hover {
            background: #dee2e6;
        }

        .car-retailer-wizard-footer .btn-wizard-next,
        .car-retailer-wizard-footer .btn-wizard-submit {
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

        .car-retailer-wizard-footer .btn-wizard-next:hover,
        .car-retailer-wizard-footer .btn-wizard-submit:hover {
            transform: translateY(-1px);
        }

        body.car-retailer-wizard-open {
            overflow: hidden;
        }

        .car-retailer-wizard-success-panel {
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

        .car-retailer-wizard-success-inner {
            width: 100%;
            max-width: 400px;
        }

        .car-retailer-success-icon-wrap {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }

        .car-retailer-success-icon {
            width: 72px;
            height: 72px;
        }

        .car-retailer-wizard-success-panel.is-error .car-retailer-success-heading {
            color: #991b1b;
        }

        .car-retailer-success-heading {
            margin: 0 0 12px;
            font-size: 1.35rem;
            font-weight: 700;
            color: #2c3e50;
            line-height: 1.3;
        }

        .car-retailer-success-text {
            margin: 0 0 28px;
            font-size: 1rem;
            line-height: 1.55;
            color: #64748b;
        }

        .car-retailer-success-close-btn {
            width: 100%;
            max-width: 280px;
        }

        .car-retailer-wizard-success-dismiss {
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

        .car-retailer-form-intro {
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
    @include('components.frontend.header-banner', ['data' => $page, 'popup' => 'car-retailer'])
@endsection

@section('content')
    <section class="section-lg section-home-blogs service-one-bg-white pbmit-bg-color-white" data-aos="fade-up" data-aos-duration="750" data-aos-easing="ease-out">
        <div class="container">
            <div class="row services-content">
                @if(getPageById(26) !== null)
                    <div class="col-md-5 mb-4 services-content-left">
                        <div class="pbmit-heading-subheading">
                            <h4 class="pbmit-subtitle" data-aos="fade-up" data-aos-delay="80" data-aos-duration="600" style="text-align: left;">
                                <span>01</span> | {{ __('process') }}
                            </h4>
                            <h2 class="pbmit-title mb-reveal-wipe" style="text-align: left;">{{ getPageById(26)->slogan }}</h2>
                            <p class="pbmit-title"> {!! getPageById(26)->content !!}</p>
                            <div class="pbmit-separator"></div>
                            <div class="col-md-4 all-blog d-md-block d-none">
                                <a class="pbmit-btn js-open-car-retailer-wizard" href="#" role="button">
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

    <div id="carRetailerWizardOverlay" class="car-retailer-wizard-overlay" aria-modal="true" role="dialog" aria-labelledby="carRetailerWizardTitle" aria-hidden="true">
        <div class="car-retailer-wizard-shell">
            <div id="carRetailerWizardMainPanel" class="@if(session('success') || session('error') || $errors->any()) d-none @endif">
                <div class="car-retailer-wizard-header">
                    <div class="car-retailer-wizard-header-text">
                        <div class="header-title">
                            <h2 id="carRetailerWizardTitle">Car Retailers Application</h2>
                            <button type="button" class="car-retailer-wizard-close" id="carRetailerWizardClose" aria-label="{{ __('admin.close') }}">&times;</button>
                        </div>
                        <div class="header-progress-bar">
                            <p class="car-retailer-wizard-step-label" id="carRetailerWizardStepLabel">{{ __('admin.car_retailer_wizard_step_prefix', ['current' => 1]) }} <span>{{ __('admin.car_retailer_wizard_step_total', ['total' => 6]) }}</span></p>
                            <div class="car-retailer-wizard-progress-wrap">
                                <div
                                    class="car-retailer-wizard-progress-bar"
                                    id="carRetailerWizardProgress"
                                    role="progressbar"
                                    aria-valuemin="1"
                                    aria-valuemax="6"
                                    aria-valuenow="1"
                                    aria-valuetext="{{ __('admin.car_retailer_wizard_step_count', ['current' => 1, 'total' => 6]) }}"
                                    aria-labelledby="carRetailerWizardStepLabel"
                                >
                                    <div class="car-retailer-wizard-progress-fill" id="carRetailerWizardProgressFill"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <form class="retailer-form" method="POST" action="{{ route('frontend.car_retailer.store') }}" enctype="multipart/form-data" id="carRetailerWizardForm" novalidate>
                    @csrf
                    <div class="car-retailer-wizard-notification d-none" id="carRetailerWizardNotification" role="status" aria-live="polite"></div>
                    <div class="car-retailer-wizard-body">
                        <div class="retailer-wizard-step is-active" data-step="1">
                            <div class="form-section form-row-group">
                                <h4>Company Information</h4>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="legal_business_name">Legal Business Name *</label>
                                            <input type="text" class="form-control" id="legal_business_name" name="legal_business_name" value="{{ old('legal_business_name') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="dba">DBA (If Any)</label>
                                            <input type="text" class="form-control" id="dba" name="dba" value="{{ old('dba') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="years_operation">Years in Operation *</label>
                                            <input type="number" class="form-control" id="years_operation" name="years_operation" min="0" max="100" value="{{ old('years_operation') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="website_url">Website URL</label>
                                            <input type="url" class="form-control" id="website_url" name="website_url" placeholder="https://example.com" value="{{ old('website_url') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="business_type">Business Type (LLC, Corp, etc.) *</label>
                                            <input type="text" class="form-control" id="business_type" name="business_type" placeholder="e.g., LLC, Corporation, Sole Proprietorship" value="{{ old('business_type') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Platform Type *</label>
                                            <div class="checkbox-group">
                                                <label class="checkbox-item">
                                                    <input type="checkbox" name="platform_type[]" value="marketplace" {{ in_array('marketplace', old('platform_type', [])) ? 'checked' : '' }}> Marketplace (e.g., Carvana, Vroom)
                                                </label>
                                                <label class="checkbox-item">
                                                    <input type="checkbox" name="platform_type[]" value="direct_seller" {{ in_array('direct_seller', old('platform_type', [])) ? 'checked' : '' }}> Direct Seller
                                                </label>
                                                <label class="checkbox-item">
                                                    <input type="checkbox" name="platform_type[]" value="hybrid" {{ in_array('hybrid', old('platform_type', [])) ? 'checked' : '' }}> Hybrid
                                                </label>
                                                <label class="checkbox-item">
                                                    <input type="checkbox" name="platform_type[]" value="other" {{ in_array('other', old('platform_type', [])) ? 'checked' : '' }}> Other
                                                </label>
                                            </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                        <div class="retailer-wizard-step" data-step="2">
                            <div class="form-section form-row-group">
                                <h4>Primary Contact</h4>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="contact_name">Full Name *</label>
                                            <input type="text" class="form-control" id="contact_name" name="contact_name" value="{{ old('contact_name') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="contact_title">Title/Position *</label>
                                            <input type="text" class="form-control" id="contact_title" name="contact_title" value="{{ old('contact_title') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="contact_phone">Phone Number *</label>
                                            <input type="tel" class="form-control" id="contact_phone" name="contact_phone" value="{{ old('contact_phone') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="contact_email">Email Address *</label>
                                            <input type="email" class="form-control" id="contact_email" name="contact_email" value="{{ old('contact_email') }}" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="retailer-wizard-step" data-step="3">
                            <div class="form-section form-row-group">
                                <h4>Logistics & Operations</h4>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="fulfillment_address">Main Auction Address *</label>
                                            <input type="text" class="form-control" id="fulfillment_address" name="fulfillment_address" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Inventory API/Webhook Access? *</label>
                                            <div class="radio-group">
                                                <label class="radio-item">
                                                    <input type="radio" name="inventory_api_access" value="yes" {{ old('inventory_api_access') == 'yes' ? 'checked' : '' }} required> Yes
                                                </label>
                                                <label class="radio-item">
                                                    <input type="radio" name="inventory_api_access" value="no" {{ old('inventory_api_access') == 'no' ? 'checked' : '' }} required> No (If Yes, attach API URL/Docs)
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="api_url_docs">API URL or Documentation (if applicable)</label>
                                            <input type="text" class="form-control" id="api_url_docs" name="api_url_docs" placeholder="https://api.example.com or attach documentation" value="{{ old('api_url_docs') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="vehicle_list">Upload a file with the list of Vehicles</label>
                                            <input type="file" class="form-control" id="vehicle_list" name="vehicle_list" accept=".pdf,.doc,.docx,.xls,.xlsx" style="margin-bottom: 0">
                                            <small class="form-text text-muted">Accepted formats: PDF, DOC, DOCX, EXCEL</small>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Do You Have Multiple Warehouses? *</label>
                                            <div class="radio-group">
                                                <label class="radio-item">
                                                    <input type="radio" name="multiple_warehouses" value="yes" {{ old('multiple_warehouses') == 'yes' ? 'checked' : '' }} required> Yes
                                                </label>
                                                <label class="radio-item">
                                                    <input type="radio" name="multiple_warehouses" value="no" {{ old('multiple_warehouses') == 'no' ? 'checked' : '' }} required> No
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="shipping_nodes">If Yes, List All Shipping Nodes</label>
                                            <textarea class="form-control" id="shipping_nodes" name="shipping_nodes" rows="3">{{ old('shipping_nodes') }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="retailer-wizard-step" data-step="4">
                            <div class="form-section form-row-group">
                                <h4>Transport Preferences</h4>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="cars_shipped">Avg. # of Cars Shipped/Month *</label>
                                            <input type="number" class="form-control" id="cars_shipped" name="cars_shipped" min="1" value="{{ old('cars_shipped') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Vehicle Types *</label>
                                            <div class="checkbox-group">
                                                <label class="checkbox-item">
                                                    <input type="checkbox" name="vehicle_types[]" value="new" {{ in_array('new', old('vehicle_types', [])) ? 'checked' : '' }}> New
                                                </label>
                                                <label class="checkbox-item">
                                                    <input type="checkbox" name="vehicle_types[]" value="used" {{ in_array('used', old('vehicle_types', [])) ? 'checked' : '' }}> Used
                                                </label>
                                                <label class="checkbox-item">
                                                    <input type="checkbox" name="vehicle_types[]" value="evs" {{ in_array('evs', old('vehicle_types', [])) ? 'checked' : '' }}> EVs
                                                </label>
                                                <label class="checkbox-item">
                                                    <input type="checkbox" name="vehicle_types[]" value="luxury" {{ in_array('luxury', old('vehicle_types', [])) ? 'checked' : '' }}> Luxury
                                                </label>
                                                <label class="checkbox-item">
                                                    <input type="checkbox" name="vehicle_types[]" value="oversized" {{ in_array('oversized', old('vehicle_types', [])) ? 'checked' : '' }}> Oversized
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Transport Type *</label>
                                            <div class="radio-group">
                                                <label class="radio-item">
                                                    <input type="radio" name="transport_type" value="open" {{ old('transport_type') == 'open' ? 'checked' : '' }} required> Open
                                                </label>
                                                <label class="radio-item">
                                                    <input type="radio" name="transport_type" value="enclosed" {{ old('transport_type') == 'enclosed' ? 'checked' : '' }} required> Enclosed
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Preferred Delivery *</label>
                                            <div class="radio-group">
                                                <label class="radio-item">
                                                    <input type="radio" name="preferred_delivery" value="door_to_door" {{ old('preferred_delivery') == 'door_to_door' ? 'checked' : '' }} required> Door-to-Door
                                                </label>
                                                <label class="radio-item">
                                                    <input type="radio" name="preferred_delivery" value="terminal_to_terminal" {{ old('preferred_delivery') == 'terminal_to_terminal' ? 'checked' : '' }} required> Terminal-to-Terminal
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Can Vehicles be Picked up Unattended (Key Box)? *</label>
                                            <div class="radio-group">
                                                <label class="radio-item">
                                                    <input type="radio" name="unattended_pickup" value="yes" {{ old('unattended_pickup') == 'yes' ? 'checked' : '' }} required> Yes
                                                </label>
                                                <label class="radio-item">
                                                    <input type="radio" name="unattended_pickup" value="no" {{ old('unattended_pickup') == 'no' ? 'checked' : '' }} required> No
                                                </label>
                                            </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                        <div class="retailer-wizard-step" data-step="5">
                            <div class="form-section form-row-group">
                                <h4>Billing & Payment</h4>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="billing_contact">Billing Contact Name *</label>
                                            <input type="text" class="form-control" id="billing_contact" name="billing_contact" value="{{ old('billing_contact') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="billing_email">Billing Email *</label>
                                            <input type="email" class="form-control" id="billing_email" name="billing_email" value="{{ old('billing_email') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="vendor_platforms">Do You Use Vendor Platforms?</label>
                                            <input type="text" class="form-control" id="vendor_platforms" name="vendor_platforms" placeholder="e.g., QuickBooks, BILL, PayPal" value="{{ old('vendor_platforms') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Preferred Payment Method *</label>
                                            <div class="radio-group">
                                                <label class="radio-item">
                                                    <input type="radio" name="payment_method" value="ach" {{ old('payment_method') == 'ach' ? 'checked' : '' }} required> ACH
                                                </label>
                                                <label class="radio-item">
                                                    <input type="radio" name="payment_method" value="credit_card" {{ old('payment_method') == 'credit_card' ? 'checked' : '' }} required> Credit Card
                                                </label>
                                                <label class="radio-item">
                                                    <input type="radio" name="payment_method" value="check" {{ old('payment_method') == 'check' ? 'checked' : '' }} required> Check
                                                </label>
                                                <label class="radio-item">
                                                    <input type="radio" name="payment_method" value="other" {{ old('payment_method') == 'other' ? 'checked' : '' }} required> Other
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="retailer-wizard-step" data-step="6">
                            <div class="form-section form-row-group">
                                <h4>Verification Documents</h4>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="ein_tax_id">EIN or Federal Tax ID *</label>
                                            <input type="text" class="form-control" id="ein_tax_id" name="ein_tax_id" placeholder="XX-XXXXXXX" value="{{ old('ein_tax_id') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="trade_references">Trade References</label>
                                            <input type="text" class="form-control" id="trade_references" name="trade_references" placeholder="List any trade references" value="{{ old('trade_references') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="w9_upload">W9 Upload *</label>
                                            <input type="file" class="form-control" id="w9_upload" name="w9_upload" accept=".pdf,.doc,.docx" required>
                                            <small class="form-text text-muted">Accepted formats: PDF, DOC, DOCX</small>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="insurance_certificate">Insurance Certificate Upload</label>
                                            <input type="file" class="form-control" id="insurance_certificate" name="insurance_certificate" accept=".pdf,.doc,.docx">
                                            <small class="form-text text-muted">Accepted formats: PDF, DOC, DOCX</small>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>NDA/Service Agreement Required? *</label>
                                            <div class="radio-group">
                                                <label class="radio-item">
                                                    <input type="radio" name="nda_required" value="yes" {{ old('nda_required') == 'yes' ? 'checked' : '' }} required> Yes
                                                </label>
                                                <label class="radio-item">
                                                    <input type="radio" name="nda_required" value="no" {{ old('nda_required') == 'no' ? 'checked' : '' }} required> No
                                                </label>
                                            </div>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="car-retailer-wizard-footer">
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
                id="carRetailerWizardSuccessPanel"
                class="car-retailer-wizard-success-panel @if(!session('success') && !session('error') && !$errors->any()) d-none @endif @if(session('error') || $errors->any()) is-error @endif"
                role="alertdialog"
                aria-modal="true"
                aria-labelledby="carRetailerSuccessHeading"
                aria-describedby="carRetailerSuccessText"
            >
                <button type="button" class="car-retailer-wizard-close car-retailer-wizard-success-dismiss" id="carRetailerWizardSuccessDismissX" aria-label="{{ __('admin.close') }}">&times;</button>
                <div class="car-retailer-wizard-success-inner">
                    <div class="car-retailer-success-icon-wrap">
                        @if(session('success'))
                            <svg class="car-retailer-success-icon" viewBox="0 0 72 72" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <circle cx="36" cy="36" r="34" stroke="#22c55e" stroke-width="3" fill="#ecfdf5"/>
                                <path d="M22 37l10 10 18-22" stroke="#16a34a" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                            </svg>
                        @else
                            <svg class="car-retailer-success-icon" viewBox="0 0 72 72" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <circle cx="36" cy="36" r="34" stroke="#ef4444" stroke-width="3" fill="#fef2f2"/>
                                <path d="M25 25l22 22M47 25L25 47" stroke="#dc2626" stroke-width="3.5" stroke-linecap="round" fill="none"/>
                            </svg>
                        @endif
                    </div>
                    <h3 id="carRetailerSuccessHeading" class="car-retailer-success-heading">
                        {{ session('success') ? __('admin.application_submitted') : __('admin.application_not_submitted') }}
                    </h3>
                    <p id="carRetailerSuccessText" class="car-retailer-success-text">
                        {{ session('success') ? __('admin.application_submitted_text') : __('admin.application_not_submitted_text') }}
                    </p>
                    <button type="button" class="btn-wizard-next car-retailer-success-close-btn" id="carRetailerWizardSuccessCloseBtn">{{ __('admin.close') }}</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        (function () {
            function initCarRetailerWizard() {
                var overlay = document.getElementById('carRetailerWizardOverlay');
                if (!overlay) return;

                var bodyEl = document.body;
                var mainPanel = document.getElementById('carRetailerWizardMainPanel');
                var successPanel = document.getElementById('carRetailerWizardSuccessPanel');
                var closeBtn = document.getElementById('carRetailerWizardClose');
                var form = document.getElementById('carRetailerWizardForm');
                var notification = document.getElementById('carRetailerWizardNotification');
                var stepLabel = document.getElementById('carRetailerWizardStepLabel');
                var progressBar = document.getElementById('carRetailerWizardProgress');
                var progressFill = document.getElementById('carRetailerWizardProgressFill');
                var btnClose = document.getElementById('wizardBtnClose');
                var btnBack = document.getElementById('wizardBtnBack');
                var btnNext = document.getElementById('wizardBtnNext');
                var btnSubmit = document.getElementById('wizardBtnSubmit');
                var totalSteps = 6;
                var currentStep = 1;
                var stepCountText = @json(__('admin.car_retailer_wizard_step_count'));
                var stepPrefixText = @json(__('admin.car_retailer_wizard_step_prefix'));
                var stepTotalText = @json(__('admin.car_retailer_wizard_step_total'));

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

                    overlay.querySelectorAll('.retailer-wizard-step').forEach(function (panel) {
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

                    var scrollBody = overlay.querySelector('.car-retailer-wizard-body');
                    if (scrollBody) scrollBody.scrollTop = 0;
                    overlay.setAttribute('aria-hidden', 'false');
                }

                function validateStep(step) {
                    var panel = overlay.querySelector('.retailer-wizard-step[data-step="' + step + '"]');
                    if (!panel) return false;

                    if (step === 1 && !panel.querySelectorAll('input[name="platform_type[]"]:checked').length) {
                        showNotification(@json(__('admin.select_at_least_one_platform_type')));
                        return false;
                    }

                    if (step === 4 && !panel.querySelectorAll('input[name="vehicle_types[]"]:checked').length) {
                        showNotification(@json(__('admin.select_at_least_one_vehicle_type')));
                        return false;
                    }

                    var controls = panel.querySelectorAll('input, select, textarea');
                    for (var i = 0; i < controls.length; i++) {
                        var el = controls[i];
                        if (el.disabled) continue;

                        if (el.type === 'checkbox') {
                            if (el.name === 'platform_type[]' || el.name === 'vehicle_types[]') continue;
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
                    bodyEl.classList.add('car-retailer-wizard-open');
                    overlay.setAttribute('aria-hidden', 'false');
                    setStep(keepCurrentPanel ? currentStep : 1);
                }

                function closeWizard() {
                    resetWizard();
                    showFormPanel();
                    overlay.classList.remove('is-open');
                    bodyEl.classList.remove('car-retailer-wizard-open');
                    overlay.setAttribute('aria-hidden', 'true');
                }

                document.addEventListener('click', function (e) {
                    var trigger = e.target && e.target.closest && e.target.closest('.js-open-car-retailer-wizard');
                    if (!trigger) return;

                    openWizard(e);
                }, true);

                if (closeBtn) closeBtn.addEventListener('click', closeWizard);
                if (btnClose) btnClose.addEventListener('click', closeWizard);
                var successDismiss = document.getElementById('carRetailerWizardSuccessDismissX');
                var successClose = document.getElementById('carRetailerWizardSuccessCloseBtn');
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
                document.addEventListener('DOMContentLoaded', initCarRetailerWizard);
            } else {
                initCarRetailerWizard();
            }
        })();
    </script>
@endsection

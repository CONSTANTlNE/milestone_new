@extends('frontend.layouts.master')

@section('title') {{ __('admin.carrier_dispatchers_page') }} - @endsection

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

        .carrier-dispatcher-form .form-control {
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

        .carrier-dispatcher-wizard-overlay {
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

        .carrier-dispatcher-wizard-overlay.is-open {
            display: flex;
        }

        .carrier-dispatcher-wizard-shell {
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

        .carrier-dispatcher-wizard-header {
            flex-shrink: 0;
            gap: 16px;
            padding: 30px;
            border-bottom: 1px solid #e9ecef;
        }

        .carrier-dispatcher-wizard-header-text h2 {
            margin: 0;
            font-weight: 500;
            font-size: 32px;
            line-height: 32px;
            letter-spacing: -2%;
            color: rgba(0, 13, 36, 1);
        }

        .carrier-dispatcher-wizard-close {
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

        .carrier-dispatcher-wizard-close:hover {
            color: #0f172a;
        }

        #carrierDispatcherWizardMainPanel {
            display: flex;
            flex-direction: column;
            flex: 1 1 auto;
            min-height: 0;
            overflow: hidden;
        }

        #carrierDispatcherWizardMainPanel > form.carrier-dispatcher-form {
            display: flex;
            flex-direction: column;
            flex: 1 1 auto;
            min-height: 0;
            overflow: hidden;
        }

        .carrier-dispatcher-wizard-overlay .carrier-dispatcher-form {
            display: flex;
            flex-direction: column;
            flex: 1 1 auto;
            min-height: 0;
            overflow: hidden;
        }

        .carrier-dispatcher-wizard-overlay .accordion-header {
            display: none;
        }

        .carrier-dispatcher-wizard-overlay .accordion-collapse {
            display: flex !important;
            flex: 1 1 auto;
            min-height: 0;
            height: auto !important;
            visibility: visible !important;
            overflow: hidden;
        }

        .carrier-dispatcher-wizard-overlay .accordion-body {
            padding: 0;
        }

        .carrier-dispatcher-wizard-progress-wrap {
            margin-top: 4px;
            max-width: 100%;
        }

        .carrier-dispatcher-wizard-step-label {
            margin: 0 0 5px;
            font-weight: 500;
            font-size: 14px;
            line-height: 24px;
            letter-spacing: -2%;
            color: rgba(0, 13, 36, 1);
        }

        .carrier-dispatcher-wizard-progress-bar {
            position: relative;
            height: 17px;
            border-radius: 999px;
            background: rgba(0, 50, 133, 0.1);
            overflow: hidden;
            box-sizing: border-box;
        }

        .carrier-dispatcher-wizard-progress-fill {
            width: 16.666667%;
            height: 100%;
            border-radius: inherit;
            background: rgba(0, 50, 133, 1);
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.25);
            transition: width 0.35s ease;
        }

        .carrier-dispatcher-wizard-notification {
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

        .carrier-dispatcher-wizard-body {
            flex: 1 1 auto;
            min-height: 0;
            max-height: 100%;
            overflow-y: auto;
            padding: 30px;
            -webkit-overflow-scrolling: touch;
        }

        .carrier-dispatcher-wizard-step {
            display: none;
        }

        .carrier-dispatcher-wizard-step.is-active {
            display: block;
        }

        .carrier-dispatcher-wizard-footer {
            padding: 16px 24px;
            border-top: 1px solid #e9ecef;
            background: #fff;
        }

        .carrier-dispatcher-wizard-footer .wizard-actions {
            display: flex;
            justify-content: space-between;
        }

        .carrier-dispatcher-wizard-footer .btn-wizard-close,
        .carrier-dispatcher-wizard-footer .btn-wizard-back {
            border: none;
            border-radius: 100px;
            background: rgba(245, 245, 245, 1);
            color: rgba(31, 31, 31, 1);
            padding: 12px 24px;
            font-weight: 600;
            cursor: pointer;
        }

        .carrier-dispatcher-wizard-footer .btn-wizard-close:hover,
        .carrier-dispatcher-wizard-footer .btn-wizard-back:hover {
            background: #dee2e6;
        }

        .carrier-dispatcher-wizard-footer .btn-wizard-next,
        .carrier-dispatcher-wizard-footer .btn-wizard-submit {
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

        .carrier-dispatcher-wizard-footer .btn-wizard-next:hover,
        .carrier-dispatcher-wizard-footer .btn-wizard-submit:hover {
            transform: translateY(-1px);
        }

        body.carrier-dispatcher-wizard-open {
            overflow: hidden;
        }

        .carrier-dispatcher-wizard-success-panel {
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

        .carrier-dispatcher-wizard-success-inner {
            width: 100%;
            max-width: 400px;
        }

        .carrier-dispatcher-success-icon-wrap {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }

        .carrier-dispatcher-success-icon {
            width: 72px;
            height: 72px;
        }

        .carrier-dispatcher-wizard-success-panel.is-error .carrier-dispatcher-success-heading {
            color: #991b1b;
        }

        .carrier-dispatcher-success-heading {
            margin: 0 0 12px;
            font-size: 1.35rem;
            font-weight: 700;
            color: #2c3e50;
            line-height: 1.3;
        }

        .carrier-dispatcher-success-text {
            margin: 0 0 28px;
            font-size: 1rem;
            line-height: 1.55;
            color: #64748b;
        }

        .carrier-dispatcher-success-close-btn {
            width: 100%;
            max-width: 280px;
        }

        .carrier-dispatcher-wizard-success-dismiss {
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

        .carrier-dispatcher-form-intro {
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
    @include('components.frontend.header-banner', ['data' => $page, 'popup' => 'carrier-dispatcher'])
@endsection

@section('content')

    <section class="section-lg section-home-blogs service-one-bg-white pbmit-bg-color-white" data-aos="fade-up" data-aos-duration="750" data-aos-easing="ease-out">
        <div class="container">
            <div class="row services-content">
                @if(getPageById(27) !== null)
                    <div class="col-md-5 mb-4 services-content-left">
                        <div class="pbmit-heading-subheading">
                            <h4 class="pbmit-subtitle" data-aos="fade-up" data-aos-delay="80" data-aos-duration="600" style="text-align: left;">
                                <span>01</span> | {{ __('process') }}
                            </h4>
                            <h2 class="pbmit-title mb-reveal-wipe" style="text-align: left;">{{ getPageById(27)->slogan }}</h2>
                            <p class="pbmit-title"> {!! getPageById(27)->content !!}</p>
                            <div class="pbmit-separator"></div>
                            <div class="col-md-4 all-blog d-md-block d-none">
                                <a class="pbmit-btn js-open-carrier-dispatcher-wizard" href="#" role="button">
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

    <div id="carrierDispatcherWizardOverlay" class="carrier-dispatcher-wizard-overlay" aria-modal="true" role="dialog" aria-labelledby="carrierDispatcherWizardTitle" aria-hidden="true">
        <div class="carrier-dispatcher-wizard-shell">
            <div id="carrierDispatcherWizardMainPanel" class="@if(session('success') || session('error') || $errors->any()) d-none @endif">
                <div class="carrier-dispatcher-wizard-header">
                    <div class="carrier-dispatcher-wizard-header-text">
                        <div class="header-title">
                            <h2 id="carrierDispatcherWizardTitle">Car Carrier & Dispatcher Application</h2>
                            <button type="button" class="carrier-dispatcher-wizard-close" id="carrierDispatcherWizardClose" aria-label="{{ __('admin.close') }}">&times;</button>
                        </div>
                        <div class="header-progress-bar">
                            <p class="carrier-dispatcher-wizard-step-label" id="carrierDispatcherWizardStepLabel">{{ __('admin.carrier_dispatcher_wizard_step_prefix', ['current' => 1]) }} <span>{{ __('admin.carrier_dispatcher_wizard_step_total', ['total' => 6]) }}</span></p>
                            <div class="carrier-dispatcher-wizard-progress-wrap">
                                <div
                                    class="carrier-dispatcher-wizard-progress-bar"
                                    id="carrierDispatcherWizardProgress"
                                    role="progressbar"
                                    aria-valuemin="1"
                                    aria-valuemax="6"
                                    aria-valuenow="1"
                                    aria-valuetext="{{ __('admin.carrier_dispatcher_wizard_step_count', ['current' => 1, 'total' => 6]) }}"
                                    aria-labelledby="carrierDispatcherWizardStepLabel"
                                >
                                    <div class="carrier-dispatcher-wizard-progress-fill" id="carrierDispatcherWizardProgressFill"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <form class="carrier-dispatcher-form" method="POST" action="{{ route('frontend.carrier_dispatcher.store') }}" enctype="multipart/form-data" id="carrierDispatcherWizardForm" novalidate>
                    @csrf
                    <div class="carrier-dispatcher-wizard-notification d-none" id="carrierDispatcherWizardNotification" role="status" aria-live="polite"></div>
                    <div class="carrier-dispatcher-wizard-body">
                        <div class="carrier-dispatcher-wizard-step is-active" data-step="1">
                            <div class="form-section form-row-group">
                                <h4>Basic Information</h4>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="mc_number">MC Number *</label>
                                            <input type="text" id="mc_number" name="mc_number"
                                                   class="form-control @error('mc_number') is-invalid @enderror"
                                                   placeholder="e.g., 123456"
                                                   value="{{ old('mc_number') }}" required>
                                            @error('mc_number')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="form-text text-muted">Motor Carrier number from FMCSA</small>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="dot_number">DOT Number *</label>
                                            <input type="text" id="dot_number" name="dot_number"
                                                   class="form-control @error('dot_number') is-invalid @enderror"
                                                   placeholder="e.g., 1234567"
                                                   value="{{ old('dot_number') }}" required>
                                            @error('dot_number')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="form-text text-muted">Department of Transportation number</small>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="cars_under_management">Number of cars under management *</label>
                                            <input type="number" id="cars_under_management" name="cars_under_management"
                                                   class="form-control @error('cars_under_management') is-invalid @enderror"
                                                   min="1" max="10000" step="1"
                                                   placeholder="e.g., 25"
                                                   value="{{ old('cars_under_management') }}" required>
                                            @error('cars_under_management')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="website_url">Website URL</label>
                                            <input type="url" id="website_url" name="website_url"
                                                   class="form-control @error('website_url') is-invalid @enderror"
                                                   placeholder="https://www.yourcompany.com"
                                                   value="{{ old('website_url') }}">
                                            @error('website_url')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="presentation_file">Upload Presentation File (Optional)</label>
                                            <input type="file" class="form-control @error('presentation_file') is-invalid @enderror"
                                                   id="presentation_file" name="presentation_file"
                                                   accept=".pdf,.doc,.docx,.xls,.xlsx">
                                            @error('presentation_file')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="form-text text-muted">Accepted formats: PDF, DOC, DOCX, Excel (max 10MB)</small>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="vehicle_list_file">Upload Vehicle List (Optional)</label>
                                            <input type="file" class="form-control @error('vehicle_list_file') is-invalid @enderror"
                                                   id="vehicle_list_file" name="vehicle_list_file"
                                                   accept=".pdf,.doc,.docx">
                                            @error('vehicle_list_file')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="form-text text-muted">Accepted formats: PDF, DOC, DOCX (max 10MB)</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="carrier-dispatcher-wizard-step" data-step="2">
                            <div class="form-section form-row-group">
                                <h4>Company Information</h4>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="legal_business_name">Legal Business Name *</label>
                                            <input type="text" class="form-control @error('legal_business_name') is-invalid @enderror"
                                                   id="legal_business_name" name="legal_business_name"
                                                   placeholder="Your Company Name LLC"
                                                   value="{{ old('legal_business_name') }}" required>
                                            @error('legal_business_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="dba">DBA (If Any)</label>
                                            <input type="text" class="form-control @error('dba') is-invalid @enderror"
                                                   id="dba" name="dba"
                                                   placeholder="Doing Business As name"
                                                   value="{{ old('dba') }}">
                                            @error('dba')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="business_type">Business Type *</label>
                                            <select class="form-control @error('business_type') is-invalid @enderror"
                                                    id="business_type" name="business_type" required>
                                                <option value="">Select Business Type</option>
                                                <option value="LLC" {{ old('business_type') == 'LLC' ? 'selected' : '' }}>LLC</option>
                                                <option value="Corporation" {{ old('business_type') == 'Corporation' ? 'selected' : '' }}>Corporation</option>
                                                <option value="Sole Proprietorship" {{ old('business_type') == 'Sole Proprietorship' ? 'selected' : '' }}>Sole Proprietorship</option>
                                                <option value="Partnership" {{ old('business_type') == 'Partnership' ? 'selected' : '' }}>Partnership</option>
                                                <option value="S-Corporation" {{ old('business_type') == 'S-Corporation' ? 'selected' : '' }}>S-Corporation</option>
                                                <option value="Other" {{ old('business_type') == 'Other' ? 'selected' : '' }}>Other</option>
                                            </select>
                                            @error('business_type')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="years_operation">Years in Operation *</label>
                                            <input type="number" class="form-control @error('years_operation') is-invalid @enderror"
                                                   id="years_operation" name="years_operation"
                                                   min="0" max="100"
                                                   placeholder="e.g., 5"
                                                   value="{{ old('years_operation') }}" required>
                                            @error('years_operation')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="carrier-dispatcher-wizard-step" data-step="3">
                            <div class="form-section form-row-group">
                                <h4> Primary Contact</h4>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="contact_name">Full Name *</label>
                                            <input type="text" class="form-control @error('contact_name') is-invalid @enderror"
                                                   id="contact_name" name="contact_name"
                                                   placeholder="John Doe"
                                                   value="{{ old('contact_name') }}" required>
                                            @error('contact_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="contact_title">Title/Position *</label>
                                            <input type="text" class="form-control @error('contact_title') is-invalid @enderror"
                                                   id="contact_title" name="contact_title"
                                                   placeholder="e.g., Operations Manager"
                                                   value="{{ old('contact_title') }}" required>
                                            @error('contact_title')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="contact_phone">Phone Number *</label>
                                            <input type="tel" class="form-control @error('contact_phone') is-invalid @enderror"
                                                   id="contact_phone" name="contact_phone"
                                                   placeholder="(555) 123-4567"
                                                   value="{{ old('contact_phone') }}" required>
                                            @error('contact_phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="contact_email">Email Address *</label>
                                            <input type="email" class="form-control @error('contact_email') is-invalid @enderror"
                                                   id="contact_email" name="contact_email"
                                                   placeholder="contact@yourcompany.com"
                                                   value="{{ old('contact_email') }}" required>
                                            @error('contact_email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="carrier-dispatcher-wizard-step" data-step="4">
                            <div class="form-section form-row-group">
                                <h4>Location & Operations</h4>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="main_address">Main Business Address *</label>
                                            <input type="text" class="form-control" id="main_address" name="main_address" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Do You Have Multiple Locations? *</label>
                                            <div class="radio-group">
                                                <label class="radio-item">
                                                    <input type="radio" name="multiple_locations" value="yes"
                                                           {{ old('multiple_locations') == 'yes' ? 'checked' : '' }} required>
                                                    <span class="radio-custom"></span> Yes
                                                </label>
                                                <label class="radio-item">
                                                    <input type="radio" name="multiple_locations" value="no"
                                                           {{ old('multiple_locations') == 'no' ? 'checked' : '' }} required>
                                                    <span class="radio-custom"></span> No
                                                </label>
                                            </div>
                                            @error('multiple_locations')
                                            <div class="text-danger small">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="additional_addresses">If Yes, List Additional Addresses</label>
                                            <textarea class="form-control @error('additional_addresses') is-invalid @enderror"
                                                      id="additional_addresses" name="additional_addresses"
                                                      rows="3"
                                                      placeholder="List any additional business locations">{{ old('additional_addresses') }}</textarea>
                                            @error('additional_addresses')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="carrier-dispatcher-wizard-step" data-step="5">
                            <div class="form-section form-row-group">
                                <h4>Billing & Payment</h4>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="billing_contact">Billing Contact Person *</label>
                                            <input type="text" class="form-control @error('billing_contact') is-invalid @enderror"
                                                   id="billing_contact" name="billing_contact"
                                                   placeholder="Billing contact name"
                                                   value="{{ old('billing_contact') }}" required>
                                            @error('billing_contact')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="billing_email">Billing Email *</label>
                                            <input type="email" class="form-control @error('billing_email') is-invalid @enderror"
                                                   id="billing_email" name="billing_email"
                                                   placeholder="billing@yourcompany.com"
                                                   value="{{ old('billing_email') }}" required>
                                            @error('billing_email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Preferred Payment Method *</label>
                                            <div class="checkbox-group">
                                                <label class="checkbox-item">
                                                    <input type="checkbox" name="payment_method[]" value="ach"
                                                        {{ in_array('ach', old('payment_method', [])) ? 'checked' : '' }}>
                                                    <span class="checkbox-custom"></span> ACH
                                                </label>
                                                <label class="checkbox-item">
                                                    <input type="checkbox" name="payment_method[]" value="credit_card"
                                                        {{ in_array('credit_card', old('payment_method', [])) ? 'checked' : '' }}>
                                                    <span class="checkbox-custom"></span> Credit Card
                                                </label>
                                                <label class="checkbox-item">
                                                    <input type="checkbox" name="payment_method[]" value="check"
                                                        {{ in_array('check', old('payment_method', [])) ? 'checked' : '' }}>
                                                    <span class="checkbox-custom"></span> Check
                                                </label>
                                                <label class="checkbox-item">
                                                    <input type="checkbox" name="payment_method[]" value="other"
                                                        {{ in_array('other', old('payment_method', [])) ? 'checked' : '' }}>
                                                    <span class="checkbox-custom"></span> Other
                                                </label>
                                            </div>
                                            @error('payment_method')
                                            <div class="text-danger small">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="carrier-dispatcher-wizard-step" data-step="6">
                            <div class="form-section form-row-group">
                                <h4>Verification & Documents</h4>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Do You Require an NDA or Service Agreement? *</label>
                                            <div class="radio-group">
                                                <label class="radio-item">
                                                    <input type="radio" name="nda_required" value="yes"
                                                           {{ old('nda_required') == 'yes' ? 'checked' : '' }} required>
                                                    <span class="radio-custom"></span> Yes
                                                </label>
                                                <label class="radio-item">
                                                    <input type="radio" name="nda_required" value="no"
                                                           {{ old('nda_required') == 'no' ? 'checked' : '' }} required>
                                                    <span class="radio-custom"></span> No
                                                </label>
                                            </div>
                                            @error('nda_required')
                                            <div class="text-danger small">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="w9_upload">Upload W-9 Form *</label>
                                            <input type="file" class="form-control @error('w9_upload') is-invalid @enderror"
                                                   id="w9_upload" name="w9_upload"
                                                   accept=".pdf,.doc,.docx" required>
                                            @error('w9_upload')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="form-text text-muted">Accepted formats: PDF, DOC, DOCX (max 10MB)</small>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="insurance_certificate">Upload Insurance Certificate (Optional)</label>
                                            <input type="file" class="form-control @error('insurance_certificate') is-invalid @enderror"
                                                   id="insurance_certificate" name="insurance_certificate"
                                                   accept=".pdf,.doc,.docx">
                                            @error('insurance_certificate')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="form-text text-muted">Accepted formats: PDF, DOC, DOCX (max 10MB)</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="carrier-dispatcher-wizard-footer">
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
                id="carrierDispatcherWizardSuccessPanel"
                class="carrier-dispatcher-wizard-success-panel @if(!session('success') && !session('error') && !$errors->any()) d-none @endif @if(session('error') || $errors->any()) is-error @endif"
                role="alertdialog"
                aria-modal="true"
                aria-labelledby="carrierDispatcherSuccessHeading"
                aria-describedby="carrierDispatcherSuccessText"
            >
                <button type="button" class="carrier-dispatcher-wizard-close carrier-dispatcher-wizard-success-dismiss" id="carrierDispatcherWizardSuccessDismissX" aria-label="{{ __('admin.close') }}">&times;</button>
                <div class="carrier-dispatcher-wizard-success-inner">
                    <div class="carrier-dispatcher-success-icon-wrap">
                        @if(session('success'))
                            <svg class="carrier-dispatcher-success-icon" viewBox="0 0 72 72" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <circle cx="36" cy="36" r="34" stroke="#22c55e" stroke-width="3" fill="#ecfdf5"/>
                                <path d="M22 37l10 10 18-22" stroke="#16a34a" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                            </svg>
                        @else
                            <svg class="carrier-dispatcher-success-icon" viewBox="0 0 72 72" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <circle cx="36" cy="36" r="34" stroke="#ef4444" stroke-width="3" fill="#fef2f2"/>
                                <path d="M25 25l22 22M47 25L25 47" stroke="#dc2626" stroke-width="3.5" stroke-linecap="round" fill="none"/>
                            </svg>
                        @endif
                    </div>
                    <h3 id="carrierDispatcherSuccessHeading" class="carrier-dispatcher-success-heading">
                        {{ session('success') ? __('admin.application_submitted') : __('admin.application_not_submitted') }}
                    </h3>
                    <p id="carrierDispatcherSuccessText" class="carrier-dispatcher-success-text">
                        {{ session('success') ? __('admin.application_submitted_text') : __('admin.application_not_submitted_text') }}
                    </p>
                    <button type="button" class="btn-wizard-next carrier-dispatcher-success-close-btn" id="carrierDispatcherWizardSuccessCloseBtn">{{ __('admin.close') }}</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        (function () {
            function initCarrierDispatcherWizard() {
                var overlay = document.getElementById('carrierDispatcherWizardOverlay');
                if (!overlay) return;

                var bodyEl = document.body;
                var mainPanel = document.getElementById('carrierDispatcherWizardMainPanel');
                var successPanel = document.getElementById('carrierDispatcherWizardSuccessPanel');
                var closeBtn = document.getElementById('carrierDispatcherWizardClose');
                var form = document.getElementById('carrierDispatcherWizardForm');
                var notification = document.getElementById('carrierDispatcherWizardNotification');
                var stepLabel = document.getElementById('carrierDispatcherWizardStepLabel');
                var progressBar = document.getElementById('carrierDispatcherWizardProgress');
                var progressFill = document.getElementById('carrierDispatcherWizardProgressFill');
                var btnClose = document.getElementById('wizardBtnClose');
                var btnBack = document.getElementById('wizardBtnBack');
                var btnNext = document.getElementById('wizardBtnNext');
                var btnSubmit = document.getElementById('wizardBtnSubmit');
                var totalSteps = 6;
                var currentStep = 1;
                var stepCountText = @json(__('admin.carrier_dispatcher_wizard_step_count'));
                var stepPrefixText = @json(__('admin.carrier_dispatcher_wizard_step_prefix'));
                var stepTotalText = @json(__('admin.carrier_dispatcher_wizard_step_total'));

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

                    overlay.querySelectorAll('.carrier-dispatcher-wizard-step').forEach(function (panel) {
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

                    var scrollBody = overlay.querySelector('.carrier-dispatcher-wizard-body');
                    if (scrollBody) scrollBody.scrollTop = 0;
                    overlay.setAttribute('aria-hidden', 'false');
                }

                function validateStep(step) {
                    var panel = overlay.querySelector('.carrier-dispatcher-wizard-step[data-step="' + step + '"]');
                    if (!panel) return false;

                    if (step === 5 && !panel.querySelectorAll('input[name="payment_method[]"]:checked').length) {
                        showNotification(@json(__('admin.select_at_least_one_preferred_payment_method')));
                        return false;
                    }

                    var controls = panel.querySelectorAll('input, select, textarea');
                    for (var i = 0; i < controls.length; i++) {
                        var el = controls[i];
                        if (el.disabled) continue;

                        if (el.type === 'checkbox') {
                            if (el.name === 'payment_method[]') continue;
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
                    bodyEl.classList.add('carrier-dispatcher-wizard-open');
                    overlay.setAttribute('aria-hidden', 'false');
                    setStep(keepCurrentPanel ? currentStep : 1);
                }

                function closeWizard() {
                    resetWizard();
                    showFormPanel();
                    overlay.classList.remove('is-open');
                    bodyEl.classList.remove('carrier-dispatcher-wizard-open');
                    overlay.setAttribute('aria-hidden', 'true');
                }

                document.addEventListener('click', function (e) {
                    var trigger = e.target && e.target.closest && e.target.closest('.js-open-carrier-dispatcher-wizard');
                    if (!trigger) return;

                    openWizard(e);
                }, true);

                if (closeBtn) closeBtn.addEventListener('click', closeWizard);
                if (btnClose) btnClose.addEventListener('click', closeWizard);
                var successDismiss = document.getElementById('carrierDispatcherWizardSuccessDismissX');
                var successClose = document.getElementById('carrierDispatcherWizardSuccessCloseBtn');
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

                var phoneInput = document.getElementById('contact_phone');
                if (phoneInput) {
                    phoneInput.addEventListener('input', function (e) {
                        var value = e.target.value.replace(/\D/g, '');
                        if (value.length >= 6) {
                            value = value.replace(/(\d{3})(\d{3})(\d{4})/, '($1) $2-$3');
                        } else if (value.length >= 3) {
                            value = value.replace(/(\d{3})(\d{0,3})/, '($1) $2');
                        }
                        e.target.value = value;
                    });
                }

                overlay.querySelectorAll('input[type="file"]').forEach(function (input) {
                    input.addEventListener('change', function (e) {
                        var file = e.target.files[0];
                        if (file && file.size > 10 * 1024 * 1024) {
                            showNotification(@json(__('admin.file_size_must_be_less_than_10mb')));
                            e.target.value = '';
                        }
                    });
                });

                setStep(1);

                @if(session('success') || session('error') || $errors->any())
                    openWizard(null, true);
                @endif
            }

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', initCarrierDispatcherWizard);
            } else {
                initCarrierDispatcherWizard();
            }
        })();
    </script>
@endsection

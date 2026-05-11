@extends('frontend.layouts.master')

@section('title') {{ __('admin.auto_auctions_page') }} - @endsection

@section('seo')
    @include('components.frontend.socials.seo', ['data' => $page ?? null])
@endsection

@section('styles')
    <style>
        .b2b-form {
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
            /* margin-bottom: 40px; */
            padding: 0px;
            /* background: #f8f9fa; */
            border-radius: 8px;
            /* border-left: 4px solid #3498db; */
        }

        .form-section h4 {
            color: rgba(0, 13, 36, 1);
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 20px;
            /* padding-bottom: 10px; */
            /* border-bottom: 1px solid #e9ecef; */
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
            font-weight: 600;
            color: #2c3e50;
            font-size: 14px;
            font-weight: 500;
            font-size: 16px;
            line-height: 24px;
            letter-spacing: -1%;
            text-transform: capitalize;
            color: rgba(0, 13, 36, 0.8);
        }

        .auction-form .form-control {
            width: 100%;
            padding: 12px 15px;
            border-radius: 6px;
            font-size: 14px;
            transition: border-color 0.3s ease;
            border-radius: 12px;
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

        /* Medium modal + dark blurred backdrop */
        .auto-auction-wizard-overlay {
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

        .auto-auction-wizard-overlay.is-open {
            display: flex;
        }

        .auto-auction-wizard-shell {
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

        #autoAuctionWizardMainPanel {
            display: flex;
            flex-direction: column;
            flex: 1 1 auto;
            min-height: 0;
            overflow: hidden;
        }

        #autoAuctionWizardMainPanel > form.auction-form {
            display: flex;
            flex-direction: column;
            flex: 1 1 auto;
            min-height: 0;
            overflow: hidden;
        }

        .auto-auction-wizard-header {
            flex-shrink: 0;
            /* display: flex; */
            /* align-items: flex-start; */
            /* justify-content: space-between; */
            gap: 16px;
            padding: 30px;
            border-bottom: 1px solid #e9ecef;
        }

        .auto-auction-wizard-header-text h2 {
            margin: 0;
            font-weight: 500;
            font-size: 32px;
            line-height: 32px;
            letter-spacing: -2%;
            color: rgba(0, 13, 36, 1);
        }

        .auto-auction-wizard-step-label {
            margin: 0 0 5px;
            font-weight: 500;
            font-size: 14px;
            line-height: 24px;
            letter-spacing: -2%;
            color: rgba(0, 13, 36, 1);
        }

        .auto-auction-wizard-progress-wrap {
            margin-top: 4px;
            max-width: 100%;
        }

        .auto-auction-wizard-progress-bar {
            position: relative;
            height: 17px;
            border-radius: 999px;
            /* border: 2px solid #dde3ea; */
            background: #fff;
            background: rgba(0, 50, 133, 0.1);
            overflow: hidden;
            box-sizing: border-box;
        }

        .auto-auction-wizard-progress-fill {
            height: 100%;
            width: 16.666667%;
            border-radius: inherit;
            background: rgba(0, 50, 133, 1);
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.25);
            transition: width 0.35s ease;
        }

        .auto-auction-wizard-progress-steps {
            display: flex;
            justify-content: space-between;
            gap: 6px;
            margin-top: 10px;
        }

        .auto-auction-wizard-step-chip {
            flex: 1;
            min-width: 0;
            text-align: center;
            font-size: 0.72rem;
            font-weight: 700;
            line-height: 1;
            padding: 8px 4px;
            border-radius: 8px;
            border: 2px solid #dde3ea;
            background: #fff;
            color: #94a3b8;
            transition: border-color 0.25s ease, background 0.25s ease, color 0.25s ease, box-shadow 0.25s ease;
        }

        .auto-auction-wizard-step-chip.is-complete {
            border-color: #3498db;
            background: linear-gradient(135deg, #3498db, #2980b9);
            color: #fff;
        }

        .auto-auction-wizard-step-chip.is-active {
            border-color: #2980b9;
            background: #fff;
            color: #2980b9;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.22);
        }

        .auto-auction-wizard-step-chip.is-pending {
            border-color: #e2e8f0;
            background: #f8fafc;
            color: #94a3b8;
        }

        .auto-auction-wizard-close {
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

        .auto-auction-wizard-close:hover {
            color: #0f172a;
        }

        .auto-auction-wizard-body {
            flex: 1 1 auto;
            min-height: 0;
            max-height: 100%;
            overflow-y: auto;
            padding: 30px;
            -webkit-overflow-scrolling: touch;
        }

        .auto-auction-wizard-notification {
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

        .auction-wizard-step {
            display: none;
        }

        .auction-wizard-step.is-active {
            display: block;
        }

        .auto-auction-wizard-footer {
            /* flex-shrink: 0; */
            /* display: flex; */
            /* flex-wrap: wrap; */
            /* align-items: center; */
            /* justify-content: space-between; */
            /* gap: 12px; */
            padding: 16px 24px;
            border-top: 1px solid #e9ecef;
            background: #fff;
        }

        .auto-auction-wizard-footer .wizard-actions {
            display: flex;
            /* gap: 10px; */
            /* flex-wrap: wrap; */
            justify-content: space-between;
        }

        .auto-auction-wizard-footer .btn-wizard-close,
        .auto-auction-wizard-footer .btn-wizard-back {
            background: #e9ecef;
            background: rgba(245, 245, 245, 1);
            color: #2c3e50;
            color: rgba(31, 31, 31, 1);
            border: none;
            padding: 12px 24px;
            font-weight: 600;
            cursor: pointer;
            border-radius: 100px;
        }

        .auto-auction-wizard-footer .btn-wizard-close:hover,
        .auto-auction-wizard-footer .btn-wizard-back:hover {
            background: #dee2e6;
        }

        .auto-auction-wizard-footer .btn-wizard-next {
            background: rgba(0, 50, 133, 1);
            color: #fff;
            border: none;
            padding: 12px 22px;
            font-weight: 600;
            border-radius: 100px;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(52, 152, 219, 0.35);
            font-weight: 600;
            font-size: 18px;
            line-height: 22px;
            letter-spacing: 0%;
        }

        .auto-auction-wizard-footer .btn-wizard-next:hover {
            transform: translateY(-1px);
        }

        .auto-auction-wizard-footer .btn-wizard-submit {
            background: rgba(0, 50, 133, 1);
            color: #fff;
            border: none;
            padding: 12px 22px;
            font-weight: 600;
            border-radius: 100px;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(52, 152, 219, 0.35);
            font-weight: 600;
            font-size: 18px;
            line-height: 22px;
            letter-spacing: 0%;
        }

        .auto-auction-wizard-footer .btn-wizard-submit:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(52, 152, 219, 0.4);
        }

        body.auto-auction-wizard-open {
            overflow: hidden;
        }

        .auto-auction-wizard-success-panel {
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

        .auto-auction-wizard-success-inner {
            width: 100%;
            max-width: 400px;
        }

        .auto-auction-success-icon-wrap {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }

        .auto-auction-success-icon {
            width: 72px;
            height: 72px;
        }

        .auto-auction-wizard-success-panel.is-error .auto-auction-success-heading {
            color: #991b1b;
        }

        .auto-auction-success-heading {
            margin: 0 0 12px;
            font-size: 1.35rem;
            font-weight: 700;
            color: #2c3e50;
            line-height: 1.3;
        }

        .auto-auction-success-text {
            margin: 0 0 28px;
            font-size: 1rem;
            line-height: 1.55;
            color: #64748b;
        }

        .auto-auction-success-close-btn {
            width: 100%;
            max-width: 280px;
        }

        .auto-auction-wizard-success-dismiss {
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
    </style>
@endsection

@section('header_background')
    @include('components.frontend.header-banner', ['data' => $page, 'popup' => 'auto-auction'])
@endsection

@section('content')
    <section class="section-lg section-home-blogs service-one-bg-white pbmit-bg-color-white" data-aos="fade-up" data-aos-duration="750" data-aos-easing="ease-out">
        <div class="container">
            <div class="row services-content">
                @if(getPageById(24) !== null)
                <div class="col-md-5 mb-4 services-content-left">
                    <div class="pbmit-heading-subheading">
                        <h4 class="pbmit-subtitle" data-aos="fade-up" data-aos-delay="80" data-aos-duration="600" style="text-align: left;">
                            <span>01</span> | {{ __('process') }}
                        </h4>
                        <h2 class="pbmit-title mb-reveal-wipe" style="text-align: left;">{{ getPageById(24)->slogan }}</h2>
                        <p class="pbmit-title"> {!! getPageById(24)->content !!}</p>
                        <div class="pbmit-separator"></div>
                        <div class="col-md-4 all-blog d-md-block d-none">
                            <a class="pbmit-btn js-open-auto-auction-wizard" href="#" role="button">
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

{{--    <section class="pbmit-section">--}}
{{--        <div class="container">--}}
{{--            <div class="row">--}}
{{--                <div class="col-md-12">--}}
{{--                    <div class="pbmit-heading-subheading">--}}
{{--                        <p class="pbmit-title"> {!!$page->content!!}</p>--}}
{{--                        <div class="pbmit-separator"></div>--}}
{{--                    </div>--}}

{{--                    <div class="pbmit-content">--}}
{{--                        <div class="b2b-form">--}}
{{--                            @if(session('success'))--}}
{{--                                <div class="alert alert-success alert-dismissible fade show" role="alert">--}}
{{--                                    {{ session('success') }}--}}
{{--                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>--}}
{{--                                </div>--}}
{{--                            @endif--}}

{{--                            @if(session('error'))--}}
{{--                                <div class="alert alert-danger alert-dismissible fade show" role="alert">--}}
{{--                                    {{ session('error') }}--}}
{{--                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>--}}
{{--                                </div>--}}
{{--                            @endif--}}

{{--                            @if($errors->any())--}}
{{--                                <div class="alert alert-danger alert-dismissible fade show" role="alert">--}}
{{--                                    <ul class="mb-0">--}}
{{--                                        @foreach($errors->all() as $error)--}}
{{--                                            <li>{{ $error }}</li>--}}
{{--                                        @endforeach--}}
{{--                                    </ul>--}}
{{--                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>--}}
{{--                                </div>--}}
{{--                            @endif--}}

{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </section>--}}

    <div id="autoAuctionWizardOverlay" class="auto-auction-wizard-overlay" aria-modal="true" role="dialog" aria-labelledby="autoAuctionWizardTitle" aria-hidden="true">
        <div class="auto-auction-wizard-shell">
            <div id="autoAuctionWizardMainPanel" class="@if(session('success') || session('error') || $errors->any()) d-none @endif">
                <div class="auto-auction-wizard-header">
                <div class="auto-auction-wizard-header-text">
                    <div class="header-title">
                        <h2 id="autoAuctionWizardTitle">{{ __('admin.auto_auction_application') }}</h2>
                        <button type="button" class="auto-auction-wizard-close" id="autoAuctionWizardClose" aria-label="{{ __('admin.close') }}">&times;</button>
                    </div>
                    <div class="header-progress-bar">
                        <p class="auto-auction-wizard-step-label" id="autoAuctionWizardStepLabel">{{ __('admin.auto_auction_wizard_step_prefix', ['current' => 1]) }} <span>{{ __('admin.auto_auction_wizard_step_total', ['total' => 6]) }}</span></p>
                        <div class="auto-auction-wizard-progress-wrap">
                            <div
                                class="auto-auction-wizard-progress-bar"
                                id="autoAuctionWizardProgress"
                                role="progressbar"
                                aria-valuemin="1"
                                aria-valuemax="6"
                                aria-valuenow="1"
                                aria-valuetext="{{ __('admin.auto_auction_wizard_step_count', ['current' => 1, 'total' => 6]) }}"
                                aria-labelledby="autoAuctionWizardStepLabel"
                            >
                                <div class="auto-auction-wizard-progress-fill" id="autoAuctionWizardProgressFill"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                <form class="auction-form" method="POST" action="{{ route('frontend.auto_auction.store') }}" enctype="multipart/form-data" id="autoAuctionWizardForm" novalidate>
                @csrf
                <div class="auto-auction-wizard-notification d-none" id="autoAuctionWizardNotification" role="status" aria-live="polite"></div>
                <div class="auto-auction-wizard-body">
                    <div class="auction-wizard-step is-active" data-step="1">
                        <div class="form-section form-row-group mb-0">
                            <h4>{{ __('admin.company_information') }}</h4>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="legal_business_name">{{ __('admin.legal_business_name') }} *</label>
                                        <input type="text" class="form-control" id="legal_business_name" name="legal_business_name" placeholder="{{ __('admin.enter_legal_business_name') }}" value="{{ old('legal_business_name') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="dba">{{ __('admin.dba_if_any') }}</label>
                                        <input type="text" class="form-control" id="dba" name="dba" placeholder="{{ __('admin.enter_dba_name_if_applicable') }}" value="{{ old('dba') }}">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="years_operation">{{ __('admin.years_operation') }} *</label>
                                        <input type="number" class="form-control" id="years_operation" name="years_operation" min="0" max="100" placeholder="{{ __('admin.example_years_operation') }}" value="{{ old('years_operation') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="website_url">{{ __('admin.website_url') }}</label>
                                        <input type="url" class="form-control" id="website_url" name="website_url" placeholder="https://example.com" value="{{ old('website_url') }}">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="business_type">{{ __('admin.business_type') }} *</label>
                                        <select class="form-control" id="business_type" name="business_type" required>
                                            <option value="">{{ __('admin.select_business_type') }}</option>
                                            <option value="LLC" {{ old('business_type') == 'LLC' ? 'selected' : '' }}>{{ __('admin.business_type_llc') }}</option>
                                            <option value="Corporation" {{ old('business_type') == 'Corporation' ? 'selected' : '' }}>{{ __('admin.business_type_corporation') }}</option>
                                            <option value="Sole Proprietorship" {{ old('business_type') == 'Sole Proprietorship' ? 'selected' : '' }}>{{ __('admin.business_type_sole_proprietorship') }}</option>
                                            <option value="Partnership" {{ old('business_type') == 'Partnership' ? 'selected' : '' }}>{{ __('admin.business_type_partnership') }}</option>
                                            <option value="Other" {{ old('business_type') == 'Other' ? 'selected' : '' }}>{{ __('admin.other') }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>{{ __('admin.auction_platform_type') }} *</label>
                                        <div class="checkbox-group">
                                            <label class="checkbox-item">
                                                <input type="checkbox" name="platform_type[]" value="physical" {{ is_array(old('platform_type')) && in_array('physical', old('platform_type')) ? 'checked' : '' }}> {{ __('admin.physical') }}
                                            </label>
                                            <label class="checkbox-item">
                                                <input type="checkbox" name="platform_type[]" value="online" {{ is_array(old('platform_type')) && in_array('online', old('platform_type')) ? 'checked' : '' }}> {{ __('admin.online') }}
                                            </label>
                                            <label class="checkbox-item">
                                                <input type="checkbox" name="platform_type[]" value="hybrid" {{ is_array(old('platform_type')) && in_array('hybrid', old('platform_type')) ? 'checked' : '' }}> {{ __('admin.hybrid') }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="auction-wizard-step" data-step="2">
                        <div class="form-section form-row-group mb-0">
                            <h4>{{ __('admin.primary_contact') }}</h4>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="contact_name">{{ __('admin.full_name') }} *</label>
                                        <input type="text" class="form-control" id="contact_name" name="contact_name" placeholder="Enter full name" value="{{ old('contact_name') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="contact_title">{{ __('admin.title_position') }} *</label>
                                        <input type="text" class="form-control" id="contact_title" name="contact_title"  placeholder="e.g., Operations Manager" value="{{ old('contact_title') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="contact_phone">{{ __('admin.phone_number') }} *</label>
                                        <input type="tel" class="form-control" id="contact_phone" name="contact_phone" placeholder="(555) 123-4567" value="{{ old('contact_phone') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="contact_email">{{ __('admin.email_address') }} *</label>
                                        <input type="email" class="form-control" id="contact_email" name="contact_email" placeholder="email@example.com" value="{{ old('contact_email') }}" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="auction-wizard-step" data-step="3">
                        <div class="form-section form-row-group mb-0">
                            <h4>{{ __('admin.auction_logistics_operations') }}</h4>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="main_address">{{ __('admin.main_auction_address') }} *</label>
                                        <input type="text" class="form-control" id="main_address" name="main_address" value="{{ old('main_address') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="primary_auction_days">{{ __('admin.primary_auction_days') }} *</label>
                                        <input type="text" class="form-control" id="primary_auction_days" name="primary_auction_days" placeholder="{{ __('admin.example_primary_auction_days') }}" value="{{ old('primary_auction_days') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="lot_numbers">{{ __('admin.typical_lot_numbers_per_auction') }} *</label>
                                        <input type="number" class="form-control" id="lot_numbers" name="lot_numbers" min="1" value="{{ old('lot_numbers') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>{{ __('admin.do_you_operate_multiple_locations') }} *</label>
                                        <div class="radio-group">
                                            <label class="radio-item">
                                                <input type="radio" name="multiple_locations" value="yes" {{ old('multiple_locations') == 'yes' ? 'checked' : '' }} required> {{ __('admin.yes') }}
                                            </label>
                                            <label class="radio-item">
                                                <input type="radio" name="multiple_locations" value="no" {{ old('multiple_locations') == 'no' ? 'checked' : '' }}> {{ __('admin.no') }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="additional_locations">{{ __('admin.if_yes_list_additional_locations') }}</label>
                                        <textarea class="form-control" id="additional_locations" name="additional_locations" rows="3">{{ old('additional_locations') }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>{{ __('admin.inventory_management_system_or_api_access') }} *</label>
                                        <div class="radio-group">
                                            <label class="radio-item">
                                                <input type="radio" name="inventory_system" value="yes" {{ old('inventory_system') == 'yes' ? 'checked' : '' }} required> {{ __('admin.yes') }}
                                            </label>
                                            <label class="radio-item">
                                                <input type="radio" name="inventory_system" value="no" {{ old('inventory_system') == 'no' ? 'checked' : '' }}> {{ __('admin.no') }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>{{ __('admin.can_vehicles_be_picked_up_unattended') }}</label>
                                        <div class="radio-group">
                                            <label class="radio-item">
                                                <input type="radio" name="unattended_pickup" value="yes" {{ old('unattended_pickup') == 'yes' ? 'checked' : '' }}> {{ __('admin.yes') }}
                                            </label>
                                            <label class="radio-item">
                                                <input type="radio" name="unattended_pickup" value="no" {{ old('unattended_pickup') == 'no' ? 'checked' : '' }}> {{ __('admin.no') }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="vehicle_list">{{ __('admin.upload_vehicle_list_optional') }}</label>
                                        <input type="file" class="form-control" id="vehicle_list" name="vehicle_list" accept=".pdf,.doc,.docx">
                                        <small class="form-text text-muted">Accepted formats: CSV, XLSX, XLS, PDF (Max 10MB)</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="auction-wizard-step" data-step="4">
                        <div class="form-section form-row-group mb-0">
                            <h4>{{ __('admin.vehicle_transport_preferences') }}</h4>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="vehicles_shipped">{{ __('admin.average_vehicles_shipped_month_optional') }}</label>
                                        <input type="number" class="form-control" id="vehicles_shipped" name="vehicles_shipped" min="1" value="{{ old('vehicles_shipped') }}">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>{{ __('admin.vehicle_types') }} *</label>
                                        <div class="checkbox-group">
                                            @php $vtOld = old('vehicle_types', []); @endphp
                                            <label class="checkbox-item"><input type="checkbox" name="vehicle_types[]" value="new" {{ is_array($vtOld) && in_array('new', $vtOld) ? 'checked' : '' }}> {{ __('admin.new') }}</label>
                                            <label class="checkbox-item"><input type="checkbox" name="vehicle_types[]" value="used" {{ is_array($vtOld) && in_array('used', $vtOld) ? 'checked' : '' }}> {{ __('admin.used') }}</label>
                                            <label class="checkbox-item"><input type="checkbox" name="vehicle_types[]" value="salvage" {{ is_array($vtOld) && in_array('salvage', $vtOld) ? 'checked' : '' }}> {{ __('admin.salvage') }}</label>
                                            <label class="checkbox-item"><input type="checkbox" name="vehicle_types[]" value="luxury" {{ is_array($vtOld) && in_array('luxury', $vtOld) ? 'checked' : '' }}> {{ __('admin.luxury') }}</label>
                                            <label class="checkbox-item"><input type="checkbox" name="vehicle_types[]" value="inoperable" {{ is_array($vtOld) && in_array('inoperable', $vtOld) ? 'checked' : '' }}> {{ __('admin.inoperable') }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>{{ __('admin.transport_type') }} *</label>
                                        <div class="radio-group">
                                            <label class="radio-item"><input type="radio" name="transport_type" value="open" {{ old('transport_type') == 'open' ? 'checked' : '' }} required> {{ __('admin.open') }}</label>
                                            <label class="radio-item"><input type="radio" name="transport_type" value="enclosed" {{ old('transport_type') == 'enclosed' ? 'checked' : '' }}> {{ __('admin.enclosed') }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="pickup_protocols">{{ __('admin.pickup_protocols_example') }} *</label>
                                        <textarea class="form-control" id="pickup_protocols" name="pickup_protocols" rows="3" required>{{ old('pickup_protocols') }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>{{ __('admin.do_vehicles_require_condition_reports') }} *</label>
                                        <div class="radio-group">
                                            <label class="radio-item"><input type="radio" name="condition_reports" value="yes" {{ old('condition_reports') == 'yes' ? 'checked' : '' }} required> {{ __('admin.yes') }}</label>
                                            <label class="radio-item"><input type="radio" name="condition_reports" value="no" {{ old('condition_reports') == 'no' ? 'checked' : '' }}> {{ __('admin.no') }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>{{ __('admin.do_you_allow_carrier_preloading') }} *</label>
                                        <div class="radio-group">
                                            <label class="radio-item"><input type="radio" name="carrier_preloading" value="yes" {{ old('carrier_preloading') == 'yes' ? 'checked' : '' }} required> {{ __('admin.yes') }}</label>
                                            <label class="radio-item"><input type="radio" name="carrier_preloading" value="no" {{ old('carrier_preloading') == 'no' ? 'checked' : '' }}> {{ __('admin.no') }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="auction-wizard-step" data-step="5">
                        <div class="form-section form-row-group mb-0">
                            <h4>{{ __('admin.billing_payment') }}</h4>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="billing_contact">{{ __('admin.billing_contact_name') }} *</label>
                                        <input type="text" class="form-control" id="billing_contact" name="billing_contact" value="{{ old('billing_contact') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="billing_email">{{ __('admin.billing_email') }} *</label>
                                        <input type="email" class="form-control" id="billing_email" name="billing_email" value="{{ old('billing_email') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>{{ __('admin.preferred_payment_method') }} *</label>
                                        @php $pmOld = old('payment_method', []); @endphp
                                        <div class="checkbox-group">
                                            <label class="checkbox-item"><input type="checkbox" name="payment_method[]" value="ach" {{ is_array($pmOld) && in_array('ach', $pmOld) ? 'checked' : '' }}> {{ __('admin.ach') }}</label>
                                            <label class="checkbox-item"><input type="checkbox" name="payment_method[]" value="credit_card" {{ is_array($pmOld) && in_array('credit_card', $pmOld) ? 'checked' : '' }}> {{ __('admin.credit_card') }}</label>
                                            <label class="checkbox-item"><input type="checkbox" name="payment_method[]" value="check" {{ is_array($pmOld) && in_array('check', $pmOld) ? 'checked' : '' }}> {{ __('admin.check') }}</label>
                                            <label class="checkbox-item"><input type="checkbox" name="payment_method[]" value="other" {{ is_array($pmOld) && in_array('other', $pmOld) ? 'checked' : '' }}> {{ __('admin.other') }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="vendor_platforms">{{ __('admin.do_you_use_vendor_platforms') }}</label>
                                        <input type="text" class="form-control" id="vendor_platforms" name="vendor_platforms" placeholder="{{ __('admin.example_vendor_platforms') }}" value="{{ old('vendor_platforms') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="auction-wizard-step" data-step="6">
                        <div class="form-section form-row-group mb-0">
                            <h4>{{ __('admin.verification_documents') }}</h4>
                            @if(config('milestone.CLOUDFLARE_CAPTCHA') == true)
                                <div class="form-group">
                                    <div class="cf-turnstile" data-sitekey="{{ config('milestone.CLOUDFLARE_SITE_KEY') }}"></div>
                                </div>
                            @endif
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="ein_tax_id">{{ __('admin.ein_or_federal_tax_id') }} *</label>
                                        <input type="text" class="form-control" id="ein_tax_id" name="ein_tax_id" placeholder="XX-XXXXXXX" value="{{ old('ein_tax_id') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="dealer_license">{{ __('admin.dealer_auction_license_number') }} *</label>
                                        <input type="text" class="form-control" id="dealer_license" name="dealer_license" value="{{ old('dealer_license') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="w9_upload">{{ __('admin.w9_upload') }} *</label>
                                        <input type="file" class="form-control" id="w9_upload" name="w9_upload" accept=".pdf,.doc,.docx" required>
                                        <small class="form-text text-muted">Accepted formats: PDF, DOC, DOCX (Max 5MB)</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="insurance_certificate">{{ __('admin.insurance_certificate_upload') }} *</label>
                                        <input type="file" class="form-control" id="insurance_certificate" name="insurance_certificate" accept=".pdf,.doc,.docx" required>
                                        <small class="form-text text-muted">Accepted formats: PDF, DOC, DOCX (Max 5MB)</small>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="trade_references">{{ __('admin.trade_references') }}</label>
                                        <textarea class="form-control" id="trade_references" name="trade_references" rows="3" placeholder="{{ __('admin.list_trade_references_or_business_relationships') }}">{{ old('trade_references') }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="auto-auction-wizard-footer">
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
                id="autoAuctionWizardSuccessPanel"
                class="auto-auction-wizard-success-panel @if(!session('success') && !session('error') && !$errors->any()) d-none @endif @if(session('error') || $errors->any()) is-error @endif"
                role="alertdialog"
                aria-modal="true"
                aria-labelledby="autoAuctionSuccessHeading"
                aria-describedby="autoAuctionSuccessText"
            >
                <button type="button" class="auto-auction-wizard-close auto-auction-wizard-success-dismiss" id="autoAuctionWizardSuccessDismissX" aria-label="{{ __('admin.close') }}">&times;</button>
                <div class="auto-auction-wizard-success-inner">
                    <div class="auto-auction-success-icon-wrap">
                        @if(session('success'))
                            <svg class="auto-auction-success-icon" viewBox="0 0 72 72" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <circle cx="36" cy="36" r="34" stroke="#22c55e" stroke-width="3" fill="#ecfdf5"/>
                                <path d="M22 37l10 10 18-22" stroke="#16a34a" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                            </svg>
                        @else
                            <svg class="auto-auction-success-icon" viewBox="0 0 72 72" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <circle cx="36" cy="36" r="34" stroke="#ef4444" stroke-width="3" fill="#fef2f2"/>
                                <path d="M25 25l22 22M47 25L25 47" stroke="#dc2626" stroke-width="3.5" stroke-linecap="round" fill="none"/>
                            </svg>
                        @endif
                    </div>
                    <h3 id="autoAuctionSuccessHeading" class="auto-auction-success-heading">
                        {{ session('success') ? __('admin.application_submitted') : __('admin.application_not_submitted') }}
                    </h3>
                    <p id="autoAuctionSuccessText" class="auto-auction-success-text">
                        {{ session('success') ? __('admin.application_submitted_text') : __('admin.application_not_submitted_text') }}
                    </p>
                    <button type="button" class="btn-wizard-next auto-auction-success-close-btn" id="autoAuctionWizardSuccessCloseBtn">{{ __('admin.close') }}</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
    (function () {
        function initAutoAuctionWizard() {
            var overlay = document.getElementById('autoAuctionWizardOverlay');
            if (!overlay) return;

            var bodyEl = document.body;
            var mainPanel = document.getElementById('autoAuctionWizardMainPanel');
            var successPanel = document.getElementById('autoAuctionWizardSuccessPanel');
            var form = document.getElementById('autoAuctionWizardForm');
            var notification = document.getElementById('autoAuctionWizardNotification');

            function showFormPanel() {
                if (successPanel) successPanel.classList.add('d-none');
                if (mainPanel) mainPanel.classList.remove('d-none');
            }

            function closeWizard() {
                resetWizard();
                showFormPanel();
                overlay.classList.remove('is-open');
                bodyEl.classList.remove('auto-auction-wizard-open');
                overlay.setAttribute('aria-hidden', 'true');
            }

            if (successPanel && !successPanel.classList.contains('d-none')) {
                overlay.classList.add('is-open');
                bodyEl.classList.add('auto-auction-wizard-open');
                overlay.setAttribute('aria-hidden', 'false');
                var sx = document.getElementById('autoAuctionWizardSuccessDismissX');
                var sb = document.getElementById('autoAuctionWizardSuccessCloseBtn');
                if (sx) sx.addEventListener('click', closeWizard);
                if (sb) sb.addEventListener('click', closeWizard);
                overlay.addEventListener('click', function (e) {
                    if (e.target === overlay) closeWizard();
                });
                document.addEventListener('keydown', function (e) {
                    if (e.key === 'Escape' && overlay.classList.contains('is-open')) closeWizard();
                });
            }

            var totalSteps = 6;
            var currentStep = 1;
            var stepCountText = @json(__('admin.auto_auction_wizard_step_count'));
            var stepPrefixText = @json(__('admin.auto_auction_wizard_step_prefix'));
            var stepTotalText = @json(__('admin.auto_auction_wizard_step_total'));

            var stepLabel = document.getElementById('autoAuctionWizardStepLabel');
            var progressFill = document.getElementById('autoAuctionWizardProgressFill');
            var progressBar = document.getElementById('autoAuctionWizardProgress');
            var btnClose = document.getElementById('wizardBtnClose');
            var btnBack = document.getElementById('wizardBtnBack');
            var btnNext = document.getElementById('wizardBtnNext');
            var btnSubmit = document.getElementById('wizardBtnSubmit');

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
            }

            function resetWizard() {
                hideNotification();
                clearFormFields();

                if (typeof setStep === 'function' && typeof totalSteps === 'number') {
                    setStep(1);
                }
            }

            function setStep(n) {
                hideNotification();
                currentStep = Math.max(1, Math.min(totalSteps, n));
                overlay.querySelectorAll('.auction-wizard-step').forEach(function (el) {
                    var s = parseInt(el.getAttribute('data-step'), 10);
                    el.classList.toggle('is-active', s === currentStep);
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
                var scrollBody = overlay.querySelector('.auto-auction-wizard-body');
                if (scrollBody) scrollBody.scrollTop = 0;
                overlay.setAttribute('aria-hidden', 'false');
            }

            function validateStep(step) {
                var panel = overlay.querySelector('.auction-wizard-step[data-step="' + step + '"]');
                if (!panel) return false;

                if (step === 1) {
                    if (!panel.querySelectorAll('input[name="platform_type[]"]:checked').length) {
                        showNotification(@json(__('admin.select_at_least_one_auction_platform_type')));
                        return false;
                    }
                }
                if (step === 4) {
                    if (!panel.querySelectorAll('input[name="vehicle_types[]"]:checked').length) {
                        showNotification(@json(__('admin.select_at_least_one_vehicle_type')));
                        return false;
                    }
                }
                if (step === 5) {
                    if (!panel.querySelectorAll('input[name="payment_method[]"]:checked').length) {
                        showNotification(@json(__('admin.select_at_least_one_preferred_payment_method')));
                        return false;
                    }
                }

                var controls = panel.querySelectorAll('input, select, textarea');
                for (var i = 0; i < controls.length; i++) {
                    var el = controls[i];
                    if (el.disabled) continue;
                    if (el.type === 'file') {
                        if (el.hasAttribute('required') && (!el.files || !el.files.length)) {
                            if (typeof el.reportValidity === 'function') el.reportValidity();
                            else showNotification(@json(__('admin.please_upload_required_files')));
                            return false;
                        }
                        continue;
                    }
                    if (el.type === 'checkbox') {
                        if (el.name === 'platform_type[]' || el.name === 'vehicle_types[]' || el.name === 'payment_method[]') continue;
                        if (el.required && !el.checked) {
                            el.reportValidity();
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

            function openWizard(e) {
                if (e) e.preventDefault();
                showFormPanel();
                overlay.classList.add('is-open');
                bodyEl.classList.add('auto-auction-wizard-open');
                overlay.setAttribute('aria-hidden', 'false');
                setStep(1);
            }

            document.addEventListener('click', function (e) {
                var trigger = e.target && e.target.closest && e.target.closest('.js-open-auto-auction-wizard');
                if (!trigger) return;
                openWizard(e);
            }, true);

            var closeBtn = document.getElementById('autoAuctionWizardClose');
            if (closeBtn) closeBtn.addEventListener('click', closeWizard);
            if (btnClose) btnClose.addEventListener('click', closeWizard);

            overlay.addEventListener('click', function (e) {
                if (e.target === overlay) {
                    closeWizard();
                }
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
                    if (!validateStep(6)) {
                        e.preventDefault();
                    }
                });
            }

            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape' && overlay.classList.contains('is-open')) {
                    closeWizard();
                }
            });
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initAutoAuctionWizard);
        } else {
            initAutoAuctionWizard();
        }
    })();
    </script>
@endsection

@extends('frontend.layouts.master')

@section('title') {{ __('admin.auto_dealers_page') }} - @endsection

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

        .form-section {
            margin-bottom: 40px;
            padding: 25px;
            background: #f8f9fa;
            border-radius: 8px;
            border-left: 4px solid #3498db;
        }

        .form-section h4 {
            color: #2c3e50;
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid #e9ecef;
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
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e9ecef;
            border-radius: 6px;
            font-size: 14px;
            transition: border-color 0.3s ease;
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
    </style>
@endsection

@section('header_background')
    @include('components.frontend.header-banner', ['data' => $page])
@endsection

@section('content')
    <section class="pbmit-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="pbmit-heading-subheading">
                        <p class="pbmit-title"> {!!$page->content!!}</p>
                        <div class="pbmit-separator"></div>
                    </div>

                    <div class="pbmit-content">
                        <div class="b2b-form">
                            @if(session('success'))
                                <div class="alert alert-success">
                                    <button type="button" class="btn-close" onclick="this.parentElement.style.display='none'">&times;</button>
                                    {{ session('success') }}
                                </div>
                            @endif

                            @if(session('error'))
                                <div class="alert alert-danger">
                                    <button type="button" class="btn-close" onclick="this.parentElement.style.display='none'">&times;</button>
                                    {{ session('error') }}
                                </div>
                            @endif

                            @if($errors->any())
                                <div class="alert alert-danger">
                                    <button type="button" class="btn-close" onclick="this.parentElement.style.display='none'">&times;</button>
                                    <ul style="margin: 0; padding-left: 20px;">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="accordion style-3" id="accordionExample2">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading1">
                                        <button
                                            class="accordion-button collapsed"
                                            type="button"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#collapse1"
                                            aria-expanded="false"
                                            aria-controls="collapse1"
                                        >
                                        <span class="pbmit-accordion-title">
                                          <div class="form-header">
                                            <h3>{{$page->slogan}}</h3>
                                            <p class="form-subtitle">{{ __('accounts') }}</p>
                                          </div>
                                        </span>
                                            <span class="pbmit-accordion-icon pbmit-btn">
                                          {{ __('calculate') }} <span class="pbmit-accordion-icon-opened" style="padding-left: 10px">
                                             <i
                                                 class="pbmit-shipex-icon pbmit-shipex-icon-levels"
                                             ></i>
                                          </span>
                                           <span class="pbmit-accordion-icon-closed" style="padding-left: 10px">
                                             <i class="pbmit-shipex-icon pbmit-shipex-icon-levels"></i>
                                          </span>
                                        </span>
                                        </button>
                                    </h2>
                                    <div
                                        id="collapse1"
                                        class="accordion-collapse collapse"
                                        aria-labelledby="heading1"
                                        data-bs-parent="#accordionExample2"
                                    >
                                        <div class="accordion-body">
                                            <form class="dealer-form" method="POST" action="{{ route('frontend.auto_dealer.store') }}" enctype="multipart/form-data">
                                                @csrf

                                                <!-- Company Information Section -->
                                                <div class="form-section form-row-group">
                                                    <h4>Company Information</h4>
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="legal_business_name">Legal Business Name *</label>
                                                                <input type="text" class="form-control" id="legal_business_name" name="legal_business_name" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="dba">DBA (If Any)</label>
                                                                <input type="text" class="form-control" id="dba" name="dba">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="business_type">Business Type (LLC, Corp, etc.) *</label>
                                                                <input type="text" class="form-control" id="business_type" name="business_type" placeholder="e.g., LLC, Corporation, Sole Proprietorship" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="years_operation">Years in Operation *</label>
                                                                <input type="number" class="form-control" id="years_operation" name="years_operation" min="0" max="100" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Primary Contact Section -->
                                                <div class="form-section form-row-group">
                                                    <h4>Primary Contact</h4>
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="contact_name">Full Name *</label>
                                                                <input type="text" class="form-control" id="contact_name" name="contact_name" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="contact_title">Title/Position *</label>
                                                                <input type="text" class="form-control" id="contact_title" name="contact_title" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="contact_phone">Phone Number *</label>
                                                                <input type="tel" class="form-control" id="contact_phone" name="contact_phone" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="contact_email">Email Address *</label>
                                                                <input type="email" class="form-control" id="contact_email" name="contact_email" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Location & Operations Section -->
                                                <div class="form-section form-row-group">
                                                    <h4>Location & Operations</h4>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="main_address">Main Business Address *</label>
                                                                <input type="text" class="form-control" id="main_address" name="main_address" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Do You Have Multiple Locations? *</label>
                                                                <div class="radio-group">
                                                                    <label class="radio-item">
                                                                        <input type="radio" name="multiple_locations" value="yes" required> Yes
                                                                    </label>
                                                                    <label class="radio-item">
                                                                        <input type="radio" name="multiple_locations" value="no" required> No
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="additional_addresses">If Yes, List Additional Addresses</label>
                                                                <textarea class="form-control" id="additional_addresses" name="additional_addresses" rows="3"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Can Vehicles be Picked up Unattended (Key Box)? </label>
                                                                <div class="radio-group">
                                                                    <label class="radio-item">
                                                                        <input type="radio" name="inventory_system" value="yes" required> Yes
                                                                    </label>
                                                                    <label class="radio-item">
                                                                        <input type="radio" name="inventory_system" value="no" required> No
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Upload a file with the list of Vehicles (Optional)</label>
                                                                <input type="file" class="form-control" id="insurance_certificate" name="insurance_certificate" accept=".pdf,.doc,.docx" required>
                                                                <small class="form-text text-muted">Accepted formats: PDF, DOC, DOCX</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Licenses & IDs Section -->
                                                <div class="form-section form-row-group">
                                                    <h4>Licenses & IDs</h4>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="dealer_license">Dealer License Number *</label>
                                                                <input type="text" class="form-control" id="dealer_license" name="dealer_license" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="federal_tax_id">Federal Tax ID (EIN) *</label>
                                                                <input type="text" class="form-control" id="federal_tax_id" name="federal_tax_id" placeholder="XX-XXXXXXX" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="duns_number">D-U-N-S Number (Optional)</label>
                                                                <input type="text" class="form-control" id="duns_number" name="duns_number" placeholder="XX-XXX-XXXX">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-section form-row-group">
                                                    <h4>Vehicle Transport Details</h4>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="cars_per_month">Avg. # of Cars to Transport/Month *</label>
                                                                <input type="number" class="form-control" id="cars_per_month" name="cars_per_month" min="1" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Types of Vehicles *</label>
                                                                <div class="checkbox-group">
                                                                    <label class="checkbox-item">
                                                                        <input type="checkbox" name="vehicle_types[]" value="new"> New
                                                                    </label>
                                                                    <label class="checkbox-item">
                                                                        <input type="checkbox" name="vehicle_types[]" value="used"> Used
                                                                    </label>
                                                                    <label class="checkbox-item">
                                                                        <input type="checkbox" name="vehicle_types[]" value="luxury"> Luxury
                                                                    </label>
                                                                    <label class="checkbox-item">
                                                                        <input type="checkbox" name="vehicle_types[]" value="oversized"> Oversized
                                                                    </label>
                                                                    <label class="checkbox-item">
                                                                        <input type="checkbox" name="vehicle_types[]" value="inoperable"> Inoperable
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Transport Preference *</label>
                                                                <div class="radio-group">
                                                                    <label class="radio-item">
                                                                        <input type="radio" name="transport_preference" value="open" required> Open
                                                                    </label>
                                                                    <label class="radio-item">
                                                                        <input type="radio" name="transport_preference" value="enclosed" required> Enclosed
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Preferred Delivery Type *</label>
                                                                <div class="radio-group">
                                                                    <label class="radio-item">
                                                                        <input type="radio" name="delivery_type" value="door_to_door" required> Door-to-Door
                                                                    </label>
                                                                    <label class="radio-item">
                                                                        <input type="radio" name="delivery_type" value="terminal_to_terminal" required> Terminal-to-Terminal
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Logistics Preferences Section -->
                                                <div class="form-section form-row-group">
                                                    <h4>Logistics Preferences</h4>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="inventory_contact">Main Inventory Contact (if different)</label>
                                                                <input type="text" class="form-control" id="inventory_contact" name="inventory_contact" placeholder="Name and contact info">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="pickup_times">Preferred Pickup Times *</label>
                                                                <input type="text" class="form-control" id="pickup_times" name="pickup_times" placeholder="e.g., 9 AM - 5 PM" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="delivery_days">Preferred Delivery Days *</label>
                                                                <input type="text" class="form-control" id="delivery_days" name="delivery_days" placeholder="e.g., Monday - Friday" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-section form-row-group">
                                                    <h4>Billing & Payment</h4>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="billing_contact">Billing Contact Person *</label>
                                                                <input type="text" class="form-control" id="billing_contact" name="billing_contact" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="billing_email">Billing Email *</label>
                                                                <input type="email" class="form-control" id="billing_email" name="billing_email" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label>Preferred Payment Method *</label>
                                                                <div class="radio-group">
                                                                    <label class="radio-item">
                                                                        <input type="radio" name="payment_method" value="ach" required> ACH
                                                                    </label>
                                                                    <label class="radio-item">
                                                                        <input type="radio" name="payment_method" value="credit_card" required> Credit Card
                                                                    </label>
                                                                    <label class="radio-item">
                                                                        <input type="radio" name="payment_method" value="check" required> Check
                                                                    </label>
                                                                    <label class="radio-item">
                                                                        <input type="radio" name="payment_method" value="other" required> Other
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Verification & Optional Docs Section -->
                                                <div class="form-section form-row-group">
                                                    <h4>Verification & Optional Docs</h4>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Do You Require an NDA or Service Agreement? *</label>
                                                                <div class="radio-group">
                                                                    <label class="radio-item">
                                                                        <input type="radio" name="nda_required" value="yes" required> Yes
                                                                    </label>
                                                                    <label class="radio-item">
                                                                        <input type="radio" name="nda_required" value="no" required> No
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Would You Like to Provide a Trade Reference? *</label>
                                                                <div class="radio-group">
                                                                    <label class="radio-item">
                                                                        <input type="radio" name="trade_reference" value="yes" required> Yes
                                                                    </label>
                                                                    <label class="radio-item">
                                                                        <input type="radio" name="trade_reference" value="no" required> No
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="w9_upload">Upload W-9 Form *</label>
                                                                <input type="file" class="form-control" id="w9_upload" name="w9_upload" accept=".pdf,.doc,.docx" required>
                                                                <small class="form-text text-muted">Accepted formats: PDF, DOC, DOCX</small>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="insurance_certificate">Upload Insurance Certificate (Optional)</label>
                                                                <input type="file" class="form-control" id="insurance_certificate" name="insurance_certificate" accept=".pdf,.doc,.docx">
                                                                <small class="form-text text-muted">Accepted formats: PDF, DOC, DOCX</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Submit Button -->
                                                <div class="form-section text-center mb-4">
                                                    <button type="submit" class="btn btn-primary btn-lg">Submit Application</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if(count($page->tiers))
                                @include('frontend.pages.tier', ['data' => $page->tiers, 'title' => $page->title])
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@extends('frontend.layouts.master')

@section('title') {{ __('admin.corporate_government_fleet_page') }} - @endsection

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
                        <div class="corporate-government-fleet-form">
                            @if(session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            @if(session('error'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    {{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            @if($errors->any())
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <ul class="mb-0">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            <div class="form-header">
                                <h3>{{$page->slogan}}</h3>
                                <p class="form-subtitle">{{ __('accounts') }}</p>
                            </div>

                            <form class="fleet-form" method="POST" action="{{ route('frontend.corporate_government_fleet.store') }}" enctype="multipart/form-data">
                                @csrf

                                <!-- Organization Information Section -->
                                <div class="form-section  form-row-group">
                                    <h4>Organization Information</h4>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="legal_organization_name">Legal Organization Name *</label>
                                                <input type="text" class="form-control" id="legal_organization_name" name="legal_organization_name" required>
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
                                                <label for="years_operation">Years in Operation *</label>
                                                <input type="number" class="form-control" id="years_operation" name="years_operation" min="0" max="100" required>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="website_url">Website URL</label>
                                                <input type="url" class="form-control" id="website_url" name="website_url" placeholder="https://example.com">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Business Type *</label>
                                                <div class="radio-group">
                                                    <label class="radio-item">
                                                        <input type="radio" name="business_type" value="corporate" required> Corporate
                                                    </label>
                                                    <label class="radio-item">
                                                        <input type="radio" name="business_type" value="government" required> Government
                                                    </label>
                                                    <label class="radio-item">
                                                        <input type="radio" name="business_type" value="non_profit" required> Non-Profit
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="department">Department (if applicable)</label>
                                                <input type="text" class="form-control" id="department" name="department" placeholder="e.g., Fleet Management, Transportation">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Primary Contact Section -->
                                <div class="form-section  form-row-group">
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

                                <!-- Fleet Logistics & Operations Section -->
                                <div class="form-section  form-row-group">
                                    <h4>Fleet Logistics & Operations</h4>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="primary_garage_address">Primary Garage or Lot Address *</label>
                                                <input type="text" class="form-control" id="primary_garage_address" name="primary_garage_address" required>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="fleet_management_software">Fleet Management Software (if any)</label>
                                                <input type="text" class="form-control" id="fleet_management_software" name="fleet_management_software" placeholder="e.g., Fleetio, Samsara, Geotab">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="fleet_locations">Number of Fleet Locations *</label>
                                                <input type="number" class="form-control" id="fleet_locations" name="fleet_locations" min="1" required>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="vehicle_release_contact">Point-of-Contact for Vehicle Releases *</label>
                                                <input type="text" class="form-control" id="vehicle_release_contact" name="vehicle_release_contact" placeholder="Name and contact info" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Typical Usage Type *</label>
                                                <div class="checkbox-group">
                                                    <label class="checkbox-item">
                                                        <input type="checkbox" name="usage_type[]" value="law_enforcement"> Law Enforcement
                                                    </label>
                                                    <label class="checkbox-item">
                                                        <input type="checkbox" name="usage_type[]" value="utility"> Utility
                                                    </label>
                                                    <label class="checkbox-item">
                                                        <input type="checkbox" name="usage_type[]" value="passenger"> Passenger
                                                    </label>
                                                    <label class="checkbox-item">
                                                        <input type="checkbox" name="usage_type[]" value="construction"> Construction
                                                    </label>
                                                    <label class="checkbox-item">
                                                        <input type="checkbox" name="usage_type[]" value="mixed"> Mixed
                                                    </label>
                                                    <label class="checkbox-item">
                                                        <input type="checkbox" name="usage_type[]" value="mixed"> Other
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="vehicle_condition">Are Vehicles Mostly New or Used? *</label>
                                                <select class="form-control" id="vehicle_condition" name="vehicle_condition" required>
                                                    <option value="">Select Option</option>
                                                    <option value="mostly_new">Mostly New</option>
                                                    <option value="mostly_used">Mostly Used</option>
                                                    <option value="mixed">Mixed</option>
                                                    <option value="varies">Varies by Department</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Upload a file with the list of Vehicles</label>
                                                <input type="file" class="form-control" id="insurance_certificate" name="insurance_certificate" accept=".pdf,.doc,.docx" required style="margin-bottom: 0">
                                                <small class="form-text text-muted">Accepted formats: PDF, DOC, DOCX, Excel</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Transport Needs & Preferences Section -->
                                <div class="form-section  form-row-group">
                                    <h4>Transport Needs & Preferences</h4>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="vehicles_per_month">Estimated Vehicles Transported/Month *</label>
                                                <input type="number" class="form-control" id="vehicles_per_month" name="vehicles_per_month" min="1" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="security_requirements">Security/Clearance Requirements (if any)</label>
                                                <input type="text" class="form-control" id="security_requirements" name="security_requirements" placeholder="e.g., Background check, Security clearance level">
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Transport Scope *</label>
                                                <div class="radio-group">
                                                    <label class="radio-item">
                                                        <input type="radio" name="transport_scope" value="local" required> Local
                                                    </label>
                                                    <label class="radio-item">
                                                        <input type="radio" name="transport_scope" value="regional" required> Regional
                                                    </label>
                                                    <label class="radio-item">
                                                        <input type="radio" name="transport_scope" value="nationwide" required> Nationwide
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
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
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="pickup_protocols">Pickup/Drop-Off Protocols *</label>
                                                <textarea class="form-control" id="pickup_protocols" name="pickup_protocols" rows="3" placeholder="Describe pickup and delivery procedures" required></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="special_handling">Special Handling Instructions</label>
                                                <textarea class="form-control" id="special_handling" name="special_handling" rows="3" placeholder="Any special requirements or instructions"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Billing & Payment Section -->
                                <div class="form-section  form-row-group">
                                    <h4> Billing & Payment</h4>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="billing_contact">Billing Contact Name *</label>
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
                                                <label for="payment_platform">Payment Platform (if any)</label>
                                                <input type="text" class="form-control" id="payment_platform" name="payment_platform" placeholder="e.g., Ariba, Coupa, Jaggaer, Other">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Preferred Payment Method *</label>
                                                <div class="radio-group">
                                                    <label class="radio-item">
                                                        <input type="checkbox" name="payment_method" value="ach" required> ACH
                                                    </label>
                                                    <label class="radio-item">
                                                        <input type="checkbox" name="payment_method" value="credit_card" required> Credit Card
                                                    </label>
                                                    <label class="radio-item">
                                                        <input type="checkbox" name="payment_method" value="government_po" required> Government PO
                                                    </label>
                                                    <label class="radio-item">
                                                        <input type="checkbox" name="payment_method" value="net_terms" required> Other
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Do You Require Invoicing via Vendor Portal? *</label>
                                                <div class="radio-group">
                                                    <label class="radio-item">
                                                        <input type="radio" name="vendor_portal_invoicing" value="yes" required> Yes
                                                    </label>
                                                    <label class="radio-item">
                                                        <input type="radio" name="vendor_portal_invoicing" value="no" required> No
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Verification Documents Section -->
                                <div class="form-section  form-row-group">
                                    <h4>Verification Documents</h4>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="government_corporate_id">Government/Corporate ID or Certification # *</label>
                                                <input type="text" class="form-control" id="government_corporate_id" name="government_corporate_id" placeholder="e.g., DUNS, CAGE Code, Tax ID" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="purchase_order_format">Purchase Order Format or Template (if used)</label>
                                                <input type="text" class="form-control" id="purchase_order_format" name="purchase_order_format" placeholder="e.g., Standard PO, Custom template">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="w9_upload">W9 Upload *</label>
                                                <input type="file" class="form-control" id="w9_upload" name="w9_upload" accept=".pdf,.doc,.docx" required>
                                                <small class="form-text text-muted">Accepted formats: PDF, DOC, DOCX</small>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="insurance_certificate">Insurance Certificate Upload *</label>
                                                <input type="file" class="form-control" id="insurance_certificate" name="insurance_certificate" accept=".pdf,.doc,.docx" required>
                                                <small class="form-text text-muted">Accepted formats: PDF, DOC, DOCX</small>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="references_contractors">References or Past Contractors</label>
                                                <textarea class="form-control" id="references_contractors" name="references_contractors" rows="3" placeholder="List any transportation or logistics companies you've worked with"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="form-section text-center mb-4">
                                    <button type="submit" class="btn btn-primary btn-lg">Submit Application</button>
                                </div>
                            </form>

                            @if(count($page->tiers))
                                @include('frontend.pages.tier', ['data' => $page->tiers])
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

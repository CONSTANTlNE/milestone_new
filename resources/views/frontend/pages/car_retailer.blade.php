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
                        <div class="car-retailer-form">
                            <div class="form-header">
                                <h3>{{$page->slogan}}</h3>
                                <p class="form-subtitle">{{ __('accounts') }}</p>
                            </div>

                            @if(session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" onclick="this.parentElement.style.display='none'">&times;</button>
                                </div>
                            @endif

                            @if(session('error'))
                                <div class="alert alert-danger">
                                    {{ session('error') }}
                                    <button type="button" class="btn-close" onclick="this.parentElement.style.display='none'">&times;</button>
                                </div>
                            @endif

                            @if($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                    <button type="button" class="btn-close" onclick="this.parentElement.style.display='none'">&times;</button>
                                </div>
                            @endif

                            <form class="retailer-form" method="POST" action="{{ route('frontend.car_retailer.store') }}" enctype="multipart/form-data">
                                @csrf

                                <!-- Company Information Section -->
                                <div class="form-section form-row-group">
                                    <h4>Company Information</h4>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="legal_business_name">Legal Business Name *</label>
                                                <input type="text" class="form-control" id="legal_business_name" name="legal_business_name" value="{{ old('legal_business_name') }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="dba">DBA (If Any)</label>
                                                <input type="text" class="form-control" id="dba" name="dba" value="{{ old('dba') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="years_operation">Years in Operation *</label>
                                                <input type="number" class="form-control" id="years_operation" name="years_operation" min="0" max="100" value="{{ old('years_operation') }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="website_url">Website URL</label>
                                                <input type="url" class="form-control" id="website_url" name="website_url" placeholder="https://example.com" value="{{ old('website_url') }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="business_type">Business Type (LLC, Corp, etc.) *</label>
                                                <input type="text" class="form-control" id="business_type" name="business_type" placeholder="e.g., LLC, Corporation, Sole Proprietorship" value="{{ old('business_type') }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
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

                                <!-- Primary Contact Section -->
                                <div class="form-section form-row-group">
                                    <h4>Primary Contact</h4>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="contact_name">Full Name *</label>
                                                <input type="text" class="form-control" id="contact_name" name="contact_name" value="{{ old('contact_name') }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="contact_title">Title/Position *</label>
                                                <input type="text" class="form-control" id="contact_title" name="contact_title" value="{{ old('contact_title') }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="contact_phone">Phone Number *</label>
                                                <input type="tel" class="form-control" id="contact_phone" name="contact_phone" value="{{ old('contact_phone') }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="contact_email">Email Address *</label>
                                                <input type="email" class="form-control" id="contact_email" name="contact_email" value="{{ old('contact_email') }}" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Logistics & Operations Section -->
                                <div class="form-section form-row-group">
                                    <h4>Logistics & Operations</h4>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="fulfillment_address">Main Auction Address *</label>
                                                <input type="text" class="form-control" id="fulfillment_address" name="fulfillment_address" required>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
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
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="api_url_docs">API URL or Documentation (if applicable)</label>
                                                <input type="text" class="form-control" id="api_url_docs" name="api_url_docs" placeholder="https://api.example.com or attach documentation" value="{{ old('api_url_docs') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="vehicle_list">Upload a file with the list of Vehicles</label>
                                                <input type="file" class="form-control" id="vehicle_list" name="vehicle_list" accept=".pdf,.doc,.docx,.xls,.xlsx" style="margin-bottom: 0">
                                                <small class="form-text text-muted">Accepted formats: PDF, DOC, DOCX, EXCEL</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
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
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="shipping_nodes">If Yes, List All Shipping Nodes</label>
                                                <textarea class="form-control" id="shipping_nodes" name="shipping_nodes" rows="3">{{ old('shipping_nodes') }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Transport Preferences Section -->
                                <div class="form-section form-row-group">
                                    <h4>Transport Preferences</h4>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="cars_shipped">Avg. # of Cars Shipped/Month *</label>
                                                <input type="number" class="form-control" id="cars_shipped" name="cars_shipped" min="1" value="{{ old('cars_shipped') }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
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
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
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
                                        <div class="col-md-4">
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
                                        <div class="col-md-4">
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

                                <!-- Billing & Payment Section -->
                                <div class="form-section form-row-group">
                                    <h4>Billing & Payment</h4>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="billing_contact">Billing Contact Name *</label>
                                                <input type="text" class="form-control" id="billing_contact" name="billing_contact" value="{{ old('billing_contact') }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="billing_email">Billing Email *</label>
                                                <input type="email" class="form-control" id="billing_email" name="billing_email" value="{{ old('billing_email') }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="vendor_platforms">Do You Use Vendor Platforms?</label>
                                                <input type="text" class="form-control" id="vendor_platforms" name="vendor_platforms" placeholder="e.g., QuickBooks, BILL, PayPal" value="{{ old('vendor_platforms') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
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

                                <!-- Verification Documents Section -->
                                <div class="form-section form-row-group">
                                    <h4>🔹 Verification Documents</h4>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="ein_tax_id">EIN or Federal Tax ID *</label>
                                                <input type="text" class="form-control" id="ein_tax_id" name="ein_tax_id" placeholder="XX-XXXXXXX" value="{{ old('ein_tax_id') }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="trade_references">Trade References</label>
                                                <input type="text" class="form-control" id="trade_references" name="trade_references" placeholder="List any trade references" value="{{ old('trade_references') }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="w9_upload">W9 Upload *</label>
                                                <input type="file" class="form-control" id="w9_upload" name="w9_upload" accept=".pdf,.doc,.docx" required>
                                                <small class="form-text text-muted">Accepted formats: PDF, DOC, DOCX</small>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="insurance_certificate">Insurance Certificate Upload</label>
                                                <input type="file" class="form-control" id="insurance_certificate" name="insurance_certificate" accept=".pdf,.doc,.docx">
                                                <small class="form-text text-muted">Accepted formats: PDF, DOC, DOCX</small>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
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

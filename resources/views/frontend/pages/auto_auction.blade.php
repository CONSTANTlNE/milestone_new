@extends('frontend.layouts.master')

@section('title') {{ __('admin.auto_auctions_page') }} - @endsection

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
                        <div class="auto-auction-form">
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

                            <form class="auction-form" method="POST" action="{{ route('frontend.auto_auction.store') }}" enctype="multipart/form-data">
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
                                                <label for="business_type">Business Type (LLC, Corp, etc.) *</label>
                                                <select class="form-control" id="business_type" name="business_type" required>
                                                    <option value="">Select Business Type</option>
                                                    <option value="LLC">LLC</option>
                                                    <option value="Corporation">Corporation</option>
                                                    <option value="Sole Proprietorship">Sole Proprietorship</option>
                                                    <option value="Partnership">Partnership</option>
                                                    <option value="Other">Other</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Auction Platform Type *</label>
                                                <div class="checkbox-group">
                                                    <label class="checkbox-item">
                                                        <input type="checkbox" name="platform_type[]" value="physical"> Physical
                                                    </label>
                                                    <label class="checkbox-item">
                                                        <input type="checkbox" name="platform_type[]" value="online"> Online
                                                    </label>
                                                    <label class="checkbox-item">
                                                        <input type="checkbox" name="platform_type[]" value="hybrid"> Hybrid
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

                                <!-- Auction Logistics & Operations Section -->
                                <div class="form-section form-row-group">
                                    <h4>Auction Logistics & Operations</h4>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="main_address">Main Auction Address *</label>
                                                <input type="text" class="form-control" id="main_address" name="main_address" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="primary_auction_days">Primary Auction Days *</label>
                                                <input type="text" class="form-control" id="primary_auction_days" name="primary_auction_days" placeholder="e.g., Monday, Wednesday, Friday" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="lot_numbers">Typical Lot Numbers per Auction *</label>
                                                <input type="number" class="form-control" id="lot_numbers" name="lot_numbers" min="1" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Do You Operate Multiple Locations? *</label>
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
                                                <label for="additional_locations">If Yes, List Additional Locations</label>
                                                <textarea class="form-control" id="additional_locations" name="additional_locations" rows="3"></textarea>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Inventory Management System or API Access? *</label>
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
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Can Vehicles be Picked up Unattended (Key Box)? </label>
                                                <div class="radio-group">
                                                    <label class="radio-item">
                                                        <input type="radio" name="unattended_pickup" value="yes"> Yes
                                                    </label>
                                                    <label class="radio-item">
                                                        <input type="radio" name="unattended_pickup" value="no"> No
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Upload a file with the list of Vehicles (Optional)</label>
                                                    <input type="file" class="form-control" id="vehicle_list" name="vehicle_list" accept=".pdf,.doc,.docx,.xls,.xlsx">
                                                    <small class="form-text text-muted">Accepted formats: PDF, DOC, DOCX, XLS, XLSX</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Vehicle & Transport Preferences Section -->
                                <div class="form-section form-row-group">
                                    <h4>Vehicle & Transport Preferences</h4>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="vehicles_shipped">Average Vehicles Shipped/Month (Optional) </label>
                                                <input type="number" class="form-control" id="vehicles_shipped" name="vehicles_shipped" min="1" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Vehicle Types *</label>
                                                <div class="checkbox-group">
                                                    <label class="checkbox-item">
                                                        <input type="checkbox" name="vehicle_types[]" value="new"> New
                                                    </label>
                                                    <label class="checkbox-item">
                                                        <input type="checkbox" name="vehicle_types[]" value="used"> Used
                                                    </label>
                                                    <label class="checkbox-item">
                                                        <input type="checkbox" name="vehicle_types[]" value="salvage"> Salvage
                                                    </label>
                                                    <label class="checkbox-item">
                                                        <input type="checkbox" name="vehicle_types[]" value="luxury"> Luxury
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
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="pickup_protocols">Pickup Protocols (e.g., Gate Passes, Lot IDs) *</label>
                                                <textarea class="form-control" id="pickup_protocols" name="pickup_protocols" rows="3" required></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Do Vehicles Require Condition Reports? *</label>
                                                <div class="radio-group">
                                                    <label class="radio-item">
                                                        <input type="radio" name="condition_reports" value="yes" required> Yes
                                                    </label>
                                                    <label class="radio-item">
                                                        <input type="radio" name="condition_reports" value="no" required> No
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Do You Allow Carrier Preloading? *</label>
                                                <div class="radio-group">
                                                    <label class="radio-item">
                                                        <input type="radio" name="carrier_preloading" value="yes" required> Yes
                                                    </label>
                                                    <label class="radio-item">
                                                        <input type="radio" name="carrier_preloading" value="no" required> No
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
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="billing_contact">Billing Contact Name *</label>
                                                <input type="text" class="form-control" id="billing_contact" name="billing_contact" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="billing_email">Billing Email *</label>
                                                <input type="email" class="form-control" id="billing_email" name="billing_email" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
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
                                                        <input type="checkbox" name="payment_method[]" value="check"> Check
                                                    </label>
                                                    <label class="checkbox-item">
                                                        <input type="checkbox" name="payment_method[]" value="other"> Other
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="vendor_platforms">Do You Use Vendor Platforms (e.g. BILL, QuickBooks, PayPal)?</label>
                                                <input type="text" class="form-control" id="vendor_platforms" name="vendor_platforms" placeholder="e.g., QuickBooks, BILL">
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
                                                <label for="ein_tax_id">EIN or Federal Tax ID *</label>
                                                <input type="text" class="form-control" id="ein_tax_id" name="ein_tax_id" placeholder="XX-XXXXXXX" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="dealer_license">Dealer/Auction License # *</label>
                                                <input type="text" class="form-control" id="dealer_license" name="dealer_license" required>
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
                                                <label for="trade_references">Trade References</label>
                                                <textarea class="form-control" id="trade_references" name="trade_references" rows="3" placeholder="List any trade references or business relationships"></textarea>
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

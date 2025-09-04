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
                        <div class="carrier-dispatcher-form-container">
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

                            <form method="POST" action="{{ route('frontend.carrier_dispatcher.store') }}" class="carrier-dispatcher-form" enctype="multipart/form-data">
                                @csrf

                                <div class="form-section form-row-group">
                                    <h4>Basic Information</h4>
                                    <div class="row">
                                        <div class="col-md-4">
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
                                        <div class="col-md-4">
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
                                        <div class="col-md-4">
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
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
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
                                        <div class="col-md-4">
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
                                        <div class="col-md-4">
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

                                <!-- Company Information Section -->
                                <div class="form-section form-row-group">
                                    <h4>Company Information</h4>
                                    <div class="row">
                                        <div class="col-md-3">
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
                                        <div class="col-md-3">
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
                                        <div class="col-md-3">
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
                                        <div class="col-md-3">
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

                                <!-- Primary Contact Section -->
                                <div class="form-section form-row-group">
                                    <h4> Primary Contact</h4>
                                    <div class="row">
                                        <div class="col-md-3">
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
                                        <div class="col-md-3">
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
                                        <div class="col-md-3">
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
                                        <div class="col-md-3">
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
                                        <div class="col-md-6">
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

                                <!-- Billing & Payment Section -->
                                <div class="form-section form-row-group">
                                    <h4>Billing & Payment</h4>
                                    <div class="row">
                                        <div class="col-md-4">
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
                                        <div class="col-md-4">
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
                                        <div class="col-md-4">
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

                                <!-- Verification & Documents Section -->
                                <div class="form-section form-row-group">
                                    <h4>Verification & Documents</h4>
                                    <div class="row">
                                        <div class="col-md-4">
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
                                        <div class="col-md-4">
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
                                        <div class="col-md-4">
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

                                <!-- Submit Button -->
                                <div class="form-section text-center mb-4">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="fas fa-paper-plane"></i> Submit Application
                                    </button>
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


    <script>
        // Form validation and enhancement
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('.carrier-dispatcher-form');
            const paymentCheckboxes = document.querySelectorAll('input[name="payment_method[]"]');

            // Ensure at least one payment method is selected
            form.addEventListener('submit', function(e) {
                const checkedPaymentMethods = document.querySelectorAll('input[name="payment_method[]"]:checked');
                if (checkedPaymentMethods.length === 0) {
                    e.preventDefault();
                    alert('Please select at least one payment method.');
                    return false;
                }
            });

            // Phone number formatting
            const phoneInput = document.getElementById('contact_phone');
            phoneInput.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                if (value.length >= 6) {
                    value = value.replace(/(\d{3})(\d{3})(\d{4})/, '($1) $2-$3');
                } else if (value.length >= 3) {
                    value = value.replace(/(\d{3})(\d{0,3})/, '($1) $2');
                }
                e.target.value = value;
            });

            // File size validation
            const fileInputs = document.querySelectorAll('input[type="file"]');
            fileInputs.forEach(input => {
                input.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (file && file.size > 10 * 1024 * 1024) { // 10MB
                        alert('File size must be less than 10MB.');
                        e.target.value = '';
                    }
                });
            });
        });
    </script>
@endsection

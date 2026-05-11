@extends('frontend.layouts.master', ['class' => 'header-style-2'])
@section('title') {{ $page->title }} - @endsection
@section('seo')
    @include('components.frontend.socials.seo', ['data' => $page])
@endsection
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/b2b_quotation.css') }}">
@endpush
@section('content')
    <section  id="b2b_quotation" class="section-md b2b_quotation">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-xl-12">
                    <div class="pbmit-heading-subheading b2b_quotation-header animation-style2">
                        <h2 class="pbmit-title">{{$page->title}}</h2>
                        <div class="pbmit-heading-desc">
                            {{$page->slogan}}
                        </div>
                        <p>{{ clear_content($page->content)}}</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="pbmit-element-posts-wrapper row">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>

            <div class="iq-container row">
                <form action="{{ route('frontend.b2b.quotation.store') }}" method="post" id="b2b_form">
                    @csrf

                    <input type="hidden" name="phone_business" id="phone_hidden_business">
                    <input type="hidden" name="phone" id="phone_hidden_b2b_otp">

                    @if($errors->any())
                        <div class="iqb-error-box" style="display:block">
                            @foreach($errors->all() as $error)
                                <p style="margin:0 0 4px">{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif

                    <div class="iq-layout">

                        {{-- ===== LEFT: Form Card ===== --}}
                        <div class="iq-form-card" id="iq_main_form_card">

                            {{-- Contact wrap (steps 1 & 2) --}}
                            <div id="iqb_contact_wrap">
                                <div class="iq-step-head">
                                    <h2 id="b2b_step_head_title">Contact Information</h2>
                                    <p id="b2b_step_head_desc">Enter your business contact details</p>
                                </div>

                                <div class="iq-fields-group" id="iqb_email_group">
                                    <div class="iq-field">
                                        <label for="email_b2b">Email Address</label>
                                        <input type="email" id="email_b2b" name="email" class="iq-input"
                                               placeholder="Enter email address" required autocomplete="off">
                                    </div>
                                </div>

                                {{-- HTMX target: Phone → OTP form → Verified state --}}
                                <div id="business_otp_target">
                                    <div class="iq-fields-group">
                                        <div class="iq-field">
                                            <label for="phone_input_business">Phone</label>
                                            <input type="text" id="phone_input_business" class="iq-input"
                                                   placeholder="Enter phone number" autocomplete="off">
                                            <p class="iq-error" id="phone_error_business">Phone number must be 10 digits</p>
                                        </div>
                                    </div>

                                    <p class="iq-htmx-error" id="captcha-error-business" style="margin-bottom: 12px"></p>

                                    <div style="position:relative">
                                        <button type="button" class="iq-btn-primary" disabled id="send_code_button_business"
                                                hx-post="{{ route('frontend.send.otp.business') }}"
                                                hx-vals='{"_token": "{{ csrf_token() }}"}'
                                                hx-include="[name='phone']"
                                                hx-target="#business_otp_target"
                                                hx-indicator="#loading-business">
                                            Send Code
                                        </button>
                                        <svg id="loading-business" class="htmx-indicator"
                                             xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24">
                                            <path fill="#105dbf" d="M12,23a9.63,9.63,0,0,1-8-9.5,9.51,9.51,0,0,1,6.79-9.1A1.66,1.66,0,0,0,12,2.81h0a1.67,1.67,0,0,0-1.94-1.64A11,11,0,0,0,12,23Z">
                                                <animateTransform attributeName="transform" dur="0.75s" repeatCount="indefinite" type="rotate" values="0 12 12;360 12 12"/>
                                            </path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            {{-- END contact wrap --}}

                            {{-- ===== Step 3: Vehicle section (hidden until OTP confirmed) ===== --}}
                            <div id="vehicle_section_b2b" style="display:none">

                                {{-- Two-column grid: Transport Route + Vehicle Details --}}
                                <div class="iqb-form-grid">

                                    {{-- Transport Route --}}
                                    <div class="iqb-form-card">
                                        <div class="iq-step-head">
                                            <h2>Transport Route</h2>
                                            <p>Please enter ZIP or City</p>
                                        </div>

                                        <div class="iq-fields-group">
                                            <div class="iq-field">
                                                <label for="start">Pickup Location</label>
                                                <div class="iq-input-wrap" style="position:relative">
                                                    <input type="hidden" id="start_id_business">
                                                    <input type="text" id="start" class="iq-input"
                                                           placeholder="City or ZIP" autocomplete="off">
                                                    <ul id="suggestions3" class="iq-suggestions"></ul>
                                                    <p class="iq-error" id="suggestions_error3">Please choose from selection</p>
                                                </div>
                                            </div>

                                            <div class="iq-swap-divider">
                                                <div class="iq-swap-line"></div>
                                                <button type="button" class="iq-swap-btn" aria-hidden="true" tabindex="-1" style="cursor:default">
                                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M12 5v14M12 19l-4-4M12 19l4-4" stroke="#4f6282" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                    </svg>
                                                </button>
                                                <div class="iq-swap-line"></div>
                                            </div>

                                            <div class="iq-field">
                                                <label for="destination_business">Delivery Location</label>
                                                <div class="iq-input-wrap" style="position:relative">
                                                    <input type="hidden" id="destination_id_business">
                                                    <input type="text" id="destination_business" class="iq-input"
                                                           placeholder="City or ZIP" autocomplete="off">
                                                    <ul id="suggestions4" class="iq-suggestions"></ul>
                                                    <p class="iq-error" id="suggestions_error4">Please choose from selection</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Vehicle Details --}}
                                    <div class="iqb-form-card">
                                        <div class="iq-step-head">
                                            <h2>Vehicle Details</h2>
                                            <p>Please fill vehicle details</p>
                                        </div>

                                        <div class="iq-fields-group">
                                            <div class="iq-field">
                                                <label for="year2">Year</label>
                                                <select id="year2" class="iq-select" autocomplete="off">
                                                    <option value="">Select Year</option>
                                                </select>
                                            </div>

                                            <div class="iq-field">
                                                <label for="make2">Manufacturer</label>
                                                <select id="make2" name="make_id" class="iq-select"
                                                        hx-get="{{ route('frontend.htmx.car_models') }}"
                                                        hx-trigger="change"
                                                        hx-target="#modeltarget2"
                                                        autocomplete="off">
                                                    <option value="">Select Manufacturer</option>
                                                    @foreach($cars as $make)
                                                        <option value="{{ $make->id }}">{{ $make->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="iq-field">
                                                <label for="model3">Model</label>
                                                <div id="modeltarget2">
                                                    <select id="model3" class="iq-select" autocomplete="off" name="model">
                                                        <option value="">Select Model</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                {{-- END form grid --}}

                                {{-- Inline controls: Transport Type + Operable + Add Vehicle --}}
                                <p class="iq-htmx-error" id="required_fields" style="margin-bottom:8px"></p>
                                <div class="iqb-inline-controls">
                                    <div class="iqb-inline-left">
                                        <div class="iqb-inline-group">
                                            <span class="iqb-inline-label">Transport type</span>
                                            <div class="iq-toggle">
                                                <label class="iq-toggle-btn" id="b2b_toggle_open">
                                                    <input type="radio" name="transport_type" value="open"> Open
                                                </label>
                                                <label class="iq-toggle-btn" id="b2b_toggle_closed">
                                                    <input type="radio" name="transport_type" value="closed"> Enclosed
                                                </label>
                                            </div>
                                        </div>
                                        <div class="iqb-inline-divider"></div>
                                        <div class="iqb-inline-group">
                                            <span class="iqb-inline-label">Is it operable?</span>
                                            <div class="iq-radio-group">
                                                <label class="iq-radio-label">
                                                    <input type="radio" name="operable" value="yes"> Yes
                                                </label>
                                                <label class="iq-radio-label">
                                                    <input type="radio" name="operable" value="no"> No
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="iqb-inline-right">
                                        <button type="button" id="add_car" class="iqb-btn-ghost">Add Vehicle</button>
                                    </div>
                                </div>

                                {{-- Vehicles table (shown when rows exist) --}}
                                <div id="cars_table" style="display:none">
                                    <div class="iqb-table-wrap">
                                        <table class="iqb-table">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Pickup</th>
                                                <th>Delivery</th>
                                                <th>Vehicle</th>
                                                <th>Transport Type</th>
                                                <th>Operable</th>
                                                <th>Vehicle Amount</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody id="cars_table_body"></tbody>
                                        </table>
                                    </div>
                                    <div class="iqb-table-footer">
                                        <button type="submit" class="iq-btn-primary iqb-submit-btn">Send Quotation Request</button>
                                    </div>
                                </div>

                            </div>
                            {{-- END vehicle_section_b2b --}}

                        </div>
                        {{-- END LEFT --}}

                        {{-- ===== RIGHT: Progress Panel ===== --}}
                        <div class="iq-progress-panel" id="b2b_progress_panel">
                            <h3>Progress</h3>
                            <p>Available after verification</p>

                            <div class="iq-progress-steps">
                                <div class="iq-progress-item">
                                    <div class="iq-progress-indicator is-current" id="b2b_step1_ind">
                                        <div class="iq-progress-circle">1</div>
                                    </div>
                                    <div class="iq-progress-item-text">
                                        <p class="iq-progress-item-title">Contact Information</p>
                                        <p class="iq-progress-item-desc">Provide your email and phone number</p>
                                    </div>
                                </div>
                                <div class="iq-progress-connector"></div>

                                <div class="iq-progress-item">
                                    <div class="iq-progress-indicator" id="b2b_step2_ind">
                                        <div class="iq-progress-circle">2</div>
                                    </div>
                                    <div class="iq-progress-item-text">
                                        <p class="iq-progress-item-title">Verification</p>
                                        <p class="iq-progress-item-desc">Confirm your identity with a code</p>
                                    </div>
                                </div>
                                <div class="iq-progress-connector"></div>

                                <div class="iq-progress-item">
                                    <div class="iq-progress-indicator" id="b2b_step3_ind">
                                        <div class="iq-progress-circle">3</div>
                                    </div>
                                    <div class="iq-progress-item-text">
                                        <p class="iq-progress-item-title">Quote Request</p>
                                        <p class="iq-progress-item-desc">Add vehicles and submit your request</p>
                                    </div>
                                </div>
                            </div>

                            {{-- Contact + vehicle summary (shown in step 3) --}}
                            <div id="b2b_progress_extras" style="display:none">
                                <div class="iqb-progress-divider"></div>
                                <div class="iqb-progress-contact">
                                    <p class="iqb-progress-contact-title">Contact</p>
                                    <p id="b2b_progress_phone" class="iqb-progress-contact-value"></p>
                                    <p id="b2b_progress_email" class="iqb-progress-contact-value"></p>
                                </div>
                                <div class="iqb-progress-divider"></div>
                                <div class="iqb-progress-vehicle-row">
                                    <span class="iqb-progress-vehicle-label">Vehicle Amount</span>
                                    <span id="b2b_vehicle_count" class="iqb-count-badge">0</span>
                                </div>
                            </div>

                        </div>

                    </div>{{-- END .iq-layout --}}
                </form>
            </div>
        </div>
    </section>

    {{-- Success modal --}}
    @if(session('success'))
        <div id="iq-success-modal" class="iq-modal-overlay">
            <div class="iq-modal">
                <div class="iq-modal-icon">
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M5 13l4 4L19 7" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <div class="iq-modal-body">
                    <h3>Request Sent Successfully</h3>
                    <p>Your business quotation request has been submitted. Our team will review it and get back to you shortly.</p>
                </div>
                <button class="iq-btn-secondary iq-modal-done" onclick="window.location.reload()">Done</button>
            </div>
        </div>
    @endif
@endsection
@section('scripts')

    <script>
        (function () {

            /* ---- Progress update ---- */
            window.updateB2bProgress = function (step, completed) {
                var indicators = [
                    document.getElementById('b2b_step1_ind'),
                    document.getElementById('b2b_step2_ind'),
                    document.getElementById('b2b_step3_ind'),
                ];
                var checkSvg = '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M5 13l4 4L19 7" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>';
                indicators.forEach(function (ind, i) {
                    if (!ind) return;
                    var circle = ind.querySelector('.iq-progress-circle');
                    ind.classList.remove('is-active', 'is-current');
                    if (circle) { circle.style.background = ''; circle.style.color = ''; circle.innerHTML = String(i + 1); }
                    var stepNum = i + 1;
                    if (stepNum < step) {
                        ind.classList.add('is-active');
                        if (circle) { circle.style.background = '#003285'; circle.style.color = '#fff'; circle.innerHTML = checkSvg; }
                    } else if (stepNum === step) {
                        ind.classList.add(completed ? 'is-active' : 'is-current');
                        if (completed && circle) { circle.style.background = '#003285'; circle.style.color = '#fff'; }
                    }
                });
            };

            /* ---- Year select population ---- */
            var yearSelect = document.getElementById('year2');
            if (yearSelect) {
                var currentYear = new Date().getFullYear();
                for (var y = currentYear; y >= 1950; y--) {
                    var opt = document.createElement('option');
                    opt.value = y; opt.text = y;
                    yearSelect.appendChild(opt);
                }
            }

            /* ---- TomSelect init ---- */
            document.addEventListener('DOMContentLoaded', function () {
                if (document.getElementById('year2')) {
                    new TomSelect('#year2', { create: false, sortField: { field: 'text', direction: 'desc' } });
                }
                if (document.getElementById('make2')) {
                    new TomSelect('#make2', { create: true, sortField: { field: 'text', direction: 'asc' } });
                }
                if (document.getElementById('model3')) {
                    new TomSelect('#model3', { create: true, sortField: { field: 'text', direction: 'asc' } });
                }
            });

            /* ---- Re-init TomSelect after HTMX settles (model select) ---- */
            document.addEventListener('htmx:afterSettle', function (event) {
                var initiator = event.detail.elt;
                if (initiator && initiator.id === 'modeltarget2') {
                    new TomSelect('#model3', { create: true, sortField: { field: 'text', direction: 'asc' } });
                }
            });

            /* ---- Transport type / operable toggle ---- */
            document.addEventListener('change', function (e) {
                if (e.target.name === 'transport_type') {
                    document.querySelectorAll('.iq-toggle-btn').forEach(function (btn) { btn.classList.remove('is-active'); });
                    if (e.target.checked) e.target.closest('.iq-toggle-btn').classList.add('is-active');
                }
                if (e.target.name === 'operable') {
                    var group = e.target.closest('.iq-radio-group');
                    if (!group) return;
                    group.querySelectorAll('.iq-radio-label').forEach(function (lbl) { lbl.classList.remove('is-active'); });
                    if (e.target.checked) e.target.closest('.iq-radio-label').classList.add('is-active');
                }
            });

            /* ---- Phone input handler ---- */
            window.initPhoneInputHandlersBiz = function () {
                var phoneInput  = document.getElementById('phone_input_business');
                var phoneHidden = document.getElementById('phone_hidden_business');
                var phoneOtp    = document.getElementById('phone_hidden_b2b_otp');
                var sendBtn     = document.getElementById('send_code_button_business');
                var phoneError  = document.getElementById('phone_error_business');
                if (!phoneInput) return;

                phoneInput.addEventListener('input', function (e) {
                    var digits = e.target.value.replace(/\D/g, '').substring(0, 10);
                    var formatted = '';
                    if (digits.length < 4)      formatted = '(' + digits;
                    else if (digits.length < 7) formatted = '(' + digits.substring(0, 3) + ') ' + digits.substring(3);
                    else                        formatted = '(' + digits.substring(0, 3) + ') ' + digits.substring(3, 6) + '-' + digits.substring(6);
                    e.target.value = formatted;
                    if (digits.length === 10) {
                        var e164 = '+1' + digits;
                        if (phoneHidden) phoneHidden.value = e164;
                        if (phoneOtp)    phoneOtp.value    = e164;
                        if (sendBtn)     sendBtn.disabled  = false;
                        if (phoneError)  phoneError.style.display = 'none';
                    } else {
                        if (phoneHidden) phoneHidden.value = '';
                        if (phoneOtp)    phoneOtp.value    = '';
                        if (sendBtn)     sendBtn.disabled  = true;
                        if (phoneError)  phoneError.style.display = 'block';
                    }
                });
            };

            window.initPhoneInputHandlersBiz();

            /* ---- Show vehicle section (called after OTP confirmation) ---- */
            window.showB2bVehicleSection = function () {
                var contactWrap = document.getElementById('iqb_contact_wrap');
                if (contactWrap) contactWrap.style.display = 'none';

                var formCard = document.getElementById('iq_main_form_card');
                if (formCard) formCard.classList.add('iqb-step3-card');

                var section = document.getElementById('vehicle_section_b2b');
                if (section) section.style.display = 'block';

                var titleEl = document.getElementById('b2b_step_head_title');
                var descEl  = document.getElementById('b2b_step_head_desc');
                if (titleEl) titleEl.textContent = 'Quote Request';
                if (descEl)  descEl.textContent  = 'Add vehicles and submit your request';

                var phoneHidden   = document.getElementById('phone_hidden_business');
                var emailInput    = document.getElementById('email_b2b');
                var progressPhone = document.getElementById('b2b_progress_phone');
                var progressEmail = document.getElementById('b2b_progress_email');
                if (progressPhone && phoneHidden) progressPhone.textContent = phoneHidden.value;
                if (progressEmail && emailInput)  progressEmail.textContent = emailInput.value;

                var extras = document.getElementById('b2b_progress_extras');
                if (extras) extras.style.display = 'block';

                if (typeof htmx !== 'undefined') {
                    htmx.process(document.getElementById('vehicle_section_b2b'));
                }
            };

            /* ---- Google Places autocomplete ---- */
            function attachAutocomplete(inputId, suggestionListId, errorId, hiddenId) {
                var input       = document.getElementById(inputId);
                var list        = document.getElementById(suggestionListId);
                var errorEl     = document.getElementById(errorId);
                var hiddenInput = document.getElementById(hiddenId);
                if (!input || !list) return;

                var debounce;
                input.addEventListener('input', function () {
                    clearTimeout(debounce);
                    var query = this.value.trim();
                    if (query.length < 3) { list.innerHTML = ''; list.style.border = 'none'; return; }
                    debounce = setTimeout(function () {
                        fetch('/placesautocomplete', {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                            body: JSON.stringify({ address: query }),
                        })
                            .then(function (r) { return r.json(); })
                            .then(function (data) {
                                var suggestions = (data && !Array.isArray(data) && Array.isArray(data.suggestions))
                                    ? data.suggestions : (Array.isArray(data) ? data : []);
                                list.innerHTML = '';
                                if (suggestions.length > 0) {
                                    suggestions.forEach(function (item) {
                                        var pred = item.placePrediction;
                                        var description = pred.text && pred.text.text || '';
                                        var placeId = pred.placeId;
                                        var li = document.createElement('li');
                                        li.textContent = description;
                                        li.addEventListener('click', function () {
                                            input.value = description;
                                            if (hiddenInput) hiddenInput.value = placeId;
                                            list.innerHTML = '';
                                            list.style.border = 'none';
                                            if (errorEl) errorEl.style.display = 'none';
                                        });
                                        list.appendChild(li);
                                    });
                                    list.style.border = '1px solid #ccc';
                                } else {
                                    if (errorEl) errorEl.style.display = 'block';
                                    list.style.border = 'none';
                                }
                            });
                    }, 150);
                });
            }

            attachAutocomplete('start', 'suggestions3', 'suggestions_error3', 'start_id_business');
            attachAutocomplete('destination_business', 'suggestions4', 'suggestions_error4', 'destination_id_business');

            /* ---- Helpers ---- */
            function getSelectedText(sel) {
                if (!sel) return '';
                var ts = sel.tomselect;
                if (ts) {
                    var val = ts.getValue();
                    if (Array.isArray(val)) val = val[0] || '';
                    if (!val) return '';
                    if (ts.options && ts.options[val] && ts.options[val].text) return (ts.options[val].text || '').trim();
                    var item = ts.getItem(val);
                    if (item) return item.textContent.trim();
                }
                var opt = sel.selectedOptions && sel.selectedOptions[0];
                if (opt && opt.text) return opt.text.trim();
                return (sel.value || '').trim();
            }

            function getRadioValue(name) {
                var el = document.querySelector('input[name="' + name + '"]:checked');
                return el ? el.value : '';
            }

            function transportBadge(val) {
                if (val === 'open')   return '<span class="iqb-badge iqb-badge-blue">Open</span>';
                if (val === 'closed') return '<span class="iqb-badge iqb-badge-default">Enclosed</span>';
                return val || '-';
            }

            function operableBadge(val) {
                if (val === 'yes') return '<span class="iqb-badge iqb-badge-blue">Yes</span>';
                if (val === 'no')  return '<span class="iqb-badge iqb-badge-orange">No</span>';
                return val || '-';
            }

            /* ---- Add Vehicle ---- */
            document.addEventListener('DOMContentLoaded', function () {
                var addBtn        = document.getElementById('add_car');
                var tbody         = document.getElementById('cars_table_body');
                var validationBox = document.getElementById('required_fields');

                function showValidation(text) {
                    if (validationBox) { validationBox.textContent = text; validationBox.style.display = 'block'; }
                }
                function clearValidation() {
                    if (validationBox) { validationBox.textContent = ''; validationBox.style.display = 'none'; }
                }

                function syncTableVisibility() {
                    var tableSection  = document.getElementById('cars_table');
                    var vehicleCount  = document.getElementById('b2b_vehicle_count');
                    var rowCount = tbody ? tbody.querySelectorAll('tr').length : 0;
                    if (tableSection) tableSection.style.display = rowCount > 0 ? 'block' : 'none';
                    if (vehicleCount) vehicleCount.textContent = String(rowCount);
                }

                function reindexRows() {
                    if (!tbody) return;
                    Array.from(tbody.querySelectorAll('tr')).forEach(function (tr, i) {
                        var first = tr.querySelector('td');
                        if (first) first.textContent = String(i + 1);
                    });
                }

                function attachRemoveHandler(tr) {
                    var btn = tr.querySelector('.js-remove-row');
                    if (!btn) return;
                    btn.addEventListener('click', function (e) {
                        e.preventDefault();
                        e.stopPropagation();
                        if (typeof e.stopImmediatePropagation === 'function') e.stopImmediatePropagation();
                        setTimeout(function () { tr.remove(); reindexRows(); syncTableVisibility(); }, 0);
                    });
                }

                function clearVehicleInputs() {
                    var container = document.getElementById('vehicle_section_b2b');
                    if (!container) return;
                    container.querySelectorAll('input[type="text"]').forEach(function (el) { el.value = ''; });
                    container.querySelectorAll('input[type="radio"]').forEach(function (el) { el.checked = false; });
                    container.querySelectorAll('.iq-toggle-btn, .iq-radio-label').forEach(function (lbl) { lbl.classList.remove('is-active'); });
                    container.querySelectorAll('select').forEach(function (sel) {
                        var ts = sel.tomselect;
                        if (ts) { try { ts.clear(true); } catch (e) {} }
                        else    { sel.selectedIndex = 0; sel.value = ''; }
                    });
                    ['suggestions3','suggestions4'].forEach(function (id) {
                        var el = document.getElementById(id);
                        if (el) { el.innerHTML = ''; el.style.border = 'none'; }
                    });
                    ['suggestions_error3','suggestions_error4'].forEach(function (id) {
                        var el = document.getElementById(id);
                        if (el) el.style.display = 'none';
                    });
                }

                if (addBtn && tbody) {
                    addBtn.addEventListener('click', function () {
                        var start        = (document.getElementById('start')?.value || '').trim();
                        var destination  = (document.getElementById('destination_business')?.value || '').trim();
                        var year         = (document.getElementById('year2')?.value || '').trim();
                        var makeEl       = document.getElementById('make2');
                        var makeText     = getSelectedText(makeEl);
                        var modelEl      = document.getElementById('model3') || document.getElementById('model');
                        var modelText    = getSelectedText(modelEl);
                        var transportType = getRadioValue('transport_type');
                        var operable     = getRadioValue('operable');

                        if (!start || !destination || !year || !makeText || !modelText || !transportType || !operable) {
                            showValidation('Please fill all fields including Transport Type and Operable status.');
                            return;
                        }
                        clearValidation();

                        var startId   = (document.getElementById('start_id_business')?.value || '').trim();
                        var destId    = (document.getElementById('destination_id_business')?.value || '').trim();
                        var makeId    = (makeEl?.value || '').trim();
                        var modelId   = (modelEl?.value || '').trim();
                        var rowNumber = tbody.querySelectorAll('tr').length + 1;
                        var vehicle   = (year + ' ' + makeText + ' ' + modelText).trim();

                        var tr = document.createElement('tr');
                        tr.innerHTML =
                            '<td>' + rowNumber + '</td>' +
                            '<td>' + start +
                            '<input type="hidden" name="start[]" value="' + start + '">' +
                            '<input type="hidden" name="start_id_business[]" value="' + startId + '">' +
                            '</td>' +
                            '<td>' + destination +
                            '<input type="hidden" name="destination[]" value="' + destination + '">' +
                            '<input type="hidden" name="destination_id_business[]" value="' + destId + '">' +
                            '</td>' +
                            '<td>' + vehicle +
                            '<input type="hidden" name="year[]" value="' + year + '">' +
                            '<input type="hidden" name="make_id[]" value="' + makeId + '">' +
                            '<input type="hidden" name="make_text[]" value="' + makeText + '">' +
                            '<input type="hidden" name="model_id[]" value="' + modelId + '">' +
                            '<input type="hidden" name="model_text[]" value="' + modelText + '">' +
                            '</td>' +
                            '<td>' + transportBadge(transportType) +
                            '<input type="hidden" name="transport_type[]" value="' + transportType + '">' +
                            '</td>' +
                            '<td>' + operableBadge(operable) +
                            '<input type="hidden" name="operable[]" value="' + operable + '">' +
                            '</td>' +
                            '<td><input type="number" min="1" value="1" name="qty[]" class="iqb-qty-input"></td>' +
                            '<td><button type="button" class="iqb-remove-btn js-remove-row">Remove</button></td>';

                        tbody.appendChild(tr);
                        attachRemoveHandler(tr);
                        syncTableVisibility();
                        clearVehicleInputs();
                    });

                    Array.from(tbody.querySelectorAll('tr')).forEach(attachRemoveHandler);
                }

                if (typeof htmx !== 'undefined') {
                    htmx.process(document.getElementById('business_otp_target'));
                }
            });

        }());
    </script>
@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/quotation.css') }}">
@endpush

<section id="index_quotation">
    <div class="container">

        {{-- Page Header --}}
        <div class="iq-page-header">
            <span class="iq-badge">Individual Clients</span>
            <h1 class="iq-page-title">For Individuals</h1>
            <p class="iq-page-subtitle">Built for teams and companies that need a smarter way to manage communication, workflows, and digital tools in one place.</p>
        </div>

        {{-- Form + Progress Container --}}
        <div class="iq-container">
            <div class="iq-layout">

                {{-- Form Card --}}
                <div class="iq-form-card">
                    <form>
                        <input type="hidden" name="to" value="" id="destination_id">
                        <input type="hidden" name="from" value="" id="start_id">
                        <input type="hidden" name="phone" id="phone_hidden"/>
                        <input type="hidden" name="email" id="email_hidden"/>
                        <input type="hidden" name="first_name" id="first_name_hidden"/>
                        <input type="hidden" name="last_name" id="last_name_hidden"/>
                        <input type="hidden" name="cloudflare_captcha" id="cloudflare_captcha">

                        <p id="htmx_error_request_type" class="iq-htmx-error"></p>
                        <p id="htmx_error_make_id" class="iq-htmx-error"></p>
                        <p id="htmx_error_email" class="iq-htmx-error"></p>
                        <p id="htmx_error_phone" class="iq-htmx-error"></p>

                        {{-- Step 1: Transport Route --}}
                        <div id="destination_widget" class="iq-step is-active">
                            <div class="iq-step-head">
                                <h2>Transport Route</h2>
                                <p>Please enter ZIP or City</p>
                            </div>

                            <div class="iq-fields-group">
                                <div class="iq-field">
                                    <label for="from">Pickup Location</label>
                                    <div class="iq-input-wrap">
                                        <input type="text" id="from" class="iq-input"
                                               placeholder="Transport cart from"
                                               name="from"
                                               required
                                               autocomplete="off">
                                        <ul id="suggestions" class="list-group"></ul>
                                    </div>
                                    <p class="iq-error" id="pickup_error">Please fill pickup point</p>
                                    <p class="iq-error" id="suggestions_error">Please choose from selection</p>
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
                                    <label for="destination">Delivery Location</label>
                                    <div class="iq-input-wrap">
                                        <input type="text" id="destination" class="iq-input"
                                               placeholder="Transport Car To"
                                               name="destination"
                                               required
                                               autocomplete="off">
                                        <ul id="suggestions2" class="list-group"></ul>
                                    </div>
                                    <p class="iq-error" id="destination_error">Please fill destination</p>
                                    <p class="iq-error" id="suggestions_error2">Please choose from selection</p>
                                </div>
                            </div>

                            <div class="iq-transport-type">
                                <span class="iq-transport-label">Transport Type:</span>
                                <div class="iq-toggle">
                                    <label class="iq-toggle-btn" id="toggle-open">
                                        <input type="radio" name="transport_type" value="open">
                                        Open
                                    </label>
                                    <label class="iq-toggle-btn" id="toggle-closed">
                                        <input type="radio" name="transport_type" value="closed">
                                        Enclosed
                                    </label>
                                </div>
                            </div>
                            <p class="iq-error" id="transport_type_error" style="margin-bottom: 16px;">Please select transport type</p>

                            <button id="dest_next" type="button" class="iq-btn-primary">Next</button>
                        </div>

                        {{-- Step 2: Vehicle Details --}}
                        <div id="car_details_widget" class="iq-step">
                            <div class="iq-step-head">
                                <h2>Vehicle Details</h2>
                                <p>Please fill vehicle details</p>
                            </div>

                            <div class="iq-fields-group">
                                <div class="iq-field">
                                    <label for="year">Year</label>
                                    <select id="year" class="iq-select" autocomplete="off">
                                        <option value="">Select Year</option>
                                    </select>
                                    <p class="iq-error" id="year_error">Please select Car Year</p>
                                </div>

                                <div class="iq-field">
                                    <label for="make">Manufacturer</label>
                                    <select id="make"
                                            name="make_id"
                                            class="iq-select"
                                            hx-get="{{ route('frontend.htmx.car_models') }}"
                                            hx-trigger="change"
                                            hx-target="#modeltarget"
                                            autocomplete="off">
                                        <option value="">Select Manufacturer</option>
                                        @foreach($cars as $make)
                                            <option value="{{ $make->id }}">{{ $make->name }}</option>
                                        @endforeach
                                    </select>
                                    <p class="iq-error" id="make_error">Please select Manufacturer</p>
                                </div>

                                <div class="iq-field">
                                    <label for="model2">Model</label>
                                    <div id="modeltarget">
                                        <select class="iq-select" autocomplete="off" id="model2" name="model">
                                            <option value="">Select Model</option>
                                        </select>
                                    </div>
                                    <p class="iq-error" id="model_error">Please select Car Model</p>
                                </div>

                                <div class="iq-field iq-field-inline">
                                    <label>Is it operable?</label>
                                    <div class="iq-radio-group">
                                        <label class="iq-radio-label">
                                            <input type="radio" name="operable" value="yes"> Yes
                                        </label>
                                        <label class="iq-radio-label">
                                            <input type="radio" name="operable" value="no"> No
                                        </label>
                                    </div>
                                    <p class="iq-error" id="operable_error">Please select vehicle condition</p>
                                </div>

                                <div class="iq-field">
                                    <label for="availability">Availability</label>
                                    <select name="availability"
                                            class="iq-select"
                                            autocomplete="off"
                                            id="availability">
                                        <option value="">Select Availability</option>
                                        @foreach($availabilities as $availability)
                                            <option value="{{ $availability->id }}">{{ $availability->title }}</option>
                                        @endforeach
                                    </select>
                                    <p class="iq-error" id="availability_error">Please select Time</p>
                                </div>
                            </div>

                            <div class="iq-btn-row">
                                <button id="car_details_prev" type="button" class="iq-btn-secondary">Previous</button>
                                <button id="car_details_next" type="button" class="iq-btn-primary">Next</button>
                            </div>
                        </div>

                        {{-- Step 3: Contact & Verify --}}
                        <div id="contact_details_widget" class="iq-step" style="position: relative">
                            <div class="iq-step-head">
                                <h2>Contact Information</h2>
                                <p>Enter your business contact details</p>
                            </div>

                            <div class="iq-fields-group">
                                <div class="iq-field">
                                    <label for="first_name">Name</label>
                                    <input type="text" id="first_name" class="iq-input"
                                           oninput="document.getElementById('first_name_hidden').value = this.value"
                                           placeholder="Enter your name"
                                           required
                                           autocomplete="off">
                                </div>

                                <div class="iq-field">
                                    <label for="last_name">Surname</label>
                                    <input type="text" id="last_name" class="iq-input"
                                           oninput="document.getElementById('last_name_hidden').value = this.value"
                                           placeholder="Enter your surname"
                                           required
                                           autocomplete="off">
                                </div>

                                <div class="iq-field">
                                    <label for="email">Email Address</label>
                                    <input type="email" id="email" class="iq-input"
                                           oninput="document.getElementById('email_hidden').value = this.value"
                                           placeholder="Enter email address"
                                           required
                                           autocomplete="off">
                                </div>

                                <div class="iq-field">
                                    <label for="phone_input">Phone</label>
                                    <input type="text" id="phone_input" class="iq-input"
                                           placeholder="Enter phone number"
                                           required
                                           autocomplete="off">
                                    <p class="iq-error" id="phone_error">Phone number must be 10 digits</p>
                                </div>
                            </div>

                            <p id="captcha-error" class="iq-error" style="margin-bottom: 12px;"></p>

                            <div class="iq-btn-row">
                                <button id="contact_details_prev" type="button" class="iq-btn-secondary">Back</button>
                                <button type="button" class="iq-btn-primary"
                                        hx-post="{{ route('frontend.send.otp') }}"
                                        hx-vals='{"_token": "{{ csrf_token() }}"}'
                                        hx-include="[name='phone'],[name='cloudflare_captcha'],[name='email']"
                                        hx-target="#contact_details_widget"
                                        hx-indicator="#loading"
                                        disabled
                                        id="send_code_button">
                                    Send Code
                                </button>
                            </div>

                            <svg id="loading"
                                 class="htmx-indicator"
                                 xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24">
                                <path fill="#105dbf"
                                      d="M12,23a9.63,9.63,0,0,1-8-9.5,9.51,9.51,0,0,1,6.79-9.1A1.66,1.66,0,0,0,12,2.81h0a1.67,1.67,0,0,0-1.94-1.64A11,11,0,0,0,12,23Z">
                                    <animateTransform attributeName="transform" dur="0.75s" repeatCount="indefinite"
                                                      type="rotate" values="0 12 12;360 12 12"/>
                                </path>
                            </svg>
                        </div>

                        <div class="col-md-12 col-lg-12 message-status"></div>
                    </form>
                </div>

                {{-- Progress Panel --}}
                <div class="iq-progress-panel">
                    <h3>Progress</h3>
                    <p>Available after verification</p>

                    <div class="iq-progress-steps">
                        <div class="iq-progress-item">
                            <div class="iq-progress-indicator is-current" id="progress-indicator-1">
                                <div class="iq-progress-circle" id="progress-circle-1">1</div>
                            </div>
                            <div class="iq-progress-item-text">
                                <p class="iq-progress-item-title">Transport Route</p>
                                <p class="iq-progress-item-desc">Enter pickup and delivery locations</p>
                            </div>
                        </div>

                        <div class="iq-progress-connector"></div>

                        <div class="iq-progress-item">
                            <div class="iq-progress-indicator" id="progress-indicator-2">
                                <div class="iq-progress-circle" id="progress-circle-2">2</div>
                            </div>
                            <div class="iq-progress-item-text">
                                <p class="iq-progress-item-title">Vehicle Details</p>
                                <p class="iq-progress-item-desc">Provide your vehicle information</p>
                            </div>
                        </div>

                        <div class="iq-progress-connector"></div>

                        <div class="iq-progress-item">
                            <div class="iq-progress-indicator" id="progress-indicator-3">
                                <div class="iq-progress-circle" id="progress-circle-3">3</div>
                            </div>
                            <div class="iq-progress-item-text">
                                <p class="iq-progress-item-title">Contact &amp; Verify</p>
                                <p class="iq-progress-item-desc">Enter contact info and verify</p>
                            </div>
                        </div>
                    </div>

                    <div id="iq-booking-summary" style="display: none;">
                        <div class="iq-summary-divider"></div>
                        <div class="iq-summary-item">
                            <p class="iq-summary-label">Route</p>
                            <p class="iq-summary-value" id="summary-route"></p>
                        </div>
                        <div class="iq-summary-divider"></div>
                        <div class="iq-summary-item">
                            <p class="iq-summary-label">Vehicle</p>
                            <p class="iq-summary-value" id="summary-vehicle"></p>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</section>

<div id="turnstile-container"></div>
<div id="turnstile-container2"></div>
<div id="turnstile-container3"></div>

<script>
(function () {
    var CHECKMARK = '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M5 13l4 4L19 7" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>';

    /**
     * @param {number} activeStep  1-3
     * @param {boolean} [currentInProgress]  when true, the active step shows as
     *   "in-progress" (light-blue ring/circle + dark-blue number) instead of completed
     */
    function updateProgress(activeStep, currentInProgress) {
        for (var i = 1; i <= 3; i++) {
            var indicator = document.getElementById('progress-indicator-' + i);
            var circle    = document.getElementById('progress-circle-' + i);
            if (!indicator || !circle) { continue; }

            indicator.classList.remove('is-active', 'is-current');

            if (i < activeStep) {
                indicator.classList.add('is-active');
                circle.innerHTML = CHECKMARK;
            } else if (i === activeStep) {
                if (currentInProgress) {
                    indicator.classList.add('is-current');
                    circle.textContent = String(i);
                } else {
                    indicator.classList.add('is-active');
                    circle.innerHTML = CHECKMARK;
                }
            } else {
                circle.textContent = String(i);
            }
        }
    }

    window.updateProgress = updateProgress;

    updateProgress(1, true);

    // ---- Element refs ----
    var dest_next          = document.getElementById('dest_next');
    var car_details        = document.getElementById('car_details_widget');
    var destination_widget = document.getElementById('destination_widget');
    var car_details_next   = document.getElementById('car_details_next');
    var car_details_prev   = document.getElementById('car_details_prev');
    var contact_details    = document.getElementById('contact_details_widget');

    var transport_type_error = document.getElementById('transport_type_error');
    var start_id             = document.getElementById('start_id');
    var destination_id       = document.getElementById('destination_id');
    var pickup_error         = document.getElementById('pickup_error');
    var destination_error    = document.getElementById('destination_error');

    // ---- Transport type toggle ----
    var toggleBtns = document.querySelectorAll('.iq-toggle-btn');
    toggleBtns.forEach(function (btn) {
        var radio = btn.querySelector('input[type="radio"]');
        if (!radio) { return; }
        radio.addEventListener('change', function () {
            toggleBtns.forEach(function (b) { b.classList.remove('is-active'); });
            if (this.checked) { btn.classList.add('is-active'); }
        });
    });

    // ---- Radio group toggle (operable) ----
    function initRadioGroups() {
        document.querySelectorAll('.iq-radio-group').forEach(function (group) {
            group.querySelectorAll('.iq-radio-label').forEach(function (label) {
                var radio = label.querySelector('input[type="radio"]');
                if (!radio) { return; }
                radio.addEventListener('change', function () {
                    group.querySelectorAll('.iq-radio-label').forEach(function (l) {
                        l.classList.remove('is-active');
                    });
                    if (this.checked) { label.classList.add('is-active'); }
                });
            });
        });
    }
    initRadioGroups();

    // ---- Step 1 → Step 2 ----
    dest_next.addEventListener('click', function () {
        var car_type = document.querySelector('[name="transport_type"]:checked');
        if (start_id.value.length < 4) {
            pickup_error.style.display = 'block';
        } else if (destination_id.value.length < 4) {
            destination_error.style.display = 'block';
            pickup_error.style.display = 'none';
        } else if (!car_type) {
            pickup_error.style.display = 'none';
            destination_error.style.display = 'none';
            transport_type_error.style.display = 'block';
        } else {
            pickup_error.style.display = 'none';
            destination_error.style.display = 'none';
            transport_type_error.style.display = 'none';
            destination_widget.classList.remove('is-active');
            car_details.classList.add('is-active');
            updateProgress(2);
        }
    });

    // ---- Step 2 → Step 1 ----
    car_details_prev.addEventListener('click', function () {
        car_details.classList.remove('is-active');
        destination_widget.classList.add('is-active');
        updateProgress(1, true);
    });

    // ---- Step 2 → Step 3 ----
    var year              = document.getElementById('year');
    var make              = document.getElementById('make');
    var operable_error    = document.getElementById('operable_error');
    var year_error        = document.getElementById('year_error');
    var make_error        = document.getElementById('make_error');
    var model_error       = document.getElementById('model_error');
    var availability      = document.getElementById('availability');
    var availability_error = document.getElementById('availability_error');
    var availabilityIds   = @json($availabilities->pluck('id'));

    var availability_value = availability.value;
    availability.addEventListener('change', function () {
        availability_value = this.value;
    });

    car_details_next.addEventListener('click', function () {
        var operable = document.querySelector('[name="operable"]:checked');
        var model    = document.getElementById('model') || document.getElementById('model2');

        if (year.value.length < 4) {
            year_error.style.display = 'block';
        } else if (make.value.length < 1) {
            year_error.style.display = 'none';
            make_error.style.display = 'block';
        } else if (!model || model.value === '') {
            year_error.style.display = 'none';
            make_error.style.display = 'none';
            model_error.style.display = 'block';
        } else if (!operable) {
            year_error.style.display = 'none';
            make_error.style.display = 'none';
            model_error.style.display = 'none';
            operable_error.style.display = 'block';
        } else if (!availabilityIds.includes(Number(availability_value))) {
            year_error.style.display = 'none';
            make_error.style.display = 'none';
            model_error.style.display = 'none';
            operable_error.style.display = 'none';
            availability_error.style.display = 'block';
        } else {
            year_error.style.display = 'none';
            make_error.style.display = 'none';
            model_error.style.display = 'none';
            operable_error.style.display = 'none';
            availability_error.style.display = 'none';
            car_details.classList.remove('is-active');
            contact_details.classList.add('is-active');
            updateProgress(3, true);
            populateBookingSummary();
        }
    });

    // ---- Booking summary ----
    function populateBookingSummary() {
        var summarySection = document.getElementById('iq-booking-summary');
        var summaryRoute   = document.getElementById('summary-route');
        var summaryVehicle = document.getElementById('summary-vehicle');
        if (!summarySection) { return; }

        var fromVal  = document.getElementById('from').value;
        var destVal  = document.getElementById('destination').value;
        var yearVal  = document.getElementById('year').value;
        var makeEl   = document.getElementById('make');
        var makeText = makeEl.options[makeEl.selectedIndex] ? makeEl.options[makeEl.selectedIndex].text : '';
        var modelEl  = document.getElementById('model') || document.getElementById('model2');
        var modelText = modelEl && modelEl.options[modelEl.selectedIndex] ? modelEl.options[modelEl.selectedIndex].text : '';

        if (summaryRoute)   { summaryRoute.textContent   = fromVal + ' → ' + destVal; }
        if (summaryVehicle) { summaryVehicle.textContent = [yearVal, makeText, modelText].filter(Boolean).join(' '); }
        summarySection.style.display = 'block';
    }

    // ---- Step 3 → Step 2 (init + after HTMX swap) ----
    function initContactPrev() {
        var contact_details_prev = document.getElementById('contact_details_prev');
        if (contact_details_prev) {
            contact_details_prev.addEventListener('click', function () {
                contact_details.classList.remove('is-active');
                car_details.classList.add('is-active');
                updateProgress(2);
                var summary = document.getElementById('iq-booking-summary');
                if (summary) { summary.style.display = 'none'; }
            });
        }
    }
    initContactPrev();

    // ---- Phone validation ----
    function initPhoneInputHandlers() {
        var phone_input = document.getElementById('phone_input');
        var phoneHidden = document.getElementById('phone_hidden');
        var sendBtn     = document.getElementById('send_code_button');
        var emailInput  = document.getElementById('email');

        if (phone_input) {
            phone_input.addEventListener('input', function (e) {
                var digits    = e.target.value.replace(/\D/g, '').substring(0, 10);
                var formatted = '';
                sendBtn.disabled = true;
                if (digits.length < 4) {
                    formatted = '(' + digits;
                } else if (digits.length < 7) {
                    formatted = '(' + digits.substring(0, 3) + ') ' + digits.substring(3);
                } else {
                    formatted = '(' + digits.substring(0, 3) + ') ' + digits.substring(3, 6) + '-' + digits.substring(6);
                }
                e.target.value = formatted;
                var phone_error = document.getElementById('phone_error');
                if (digits.length === 10) {
                    sendBtn.disabled = false;
                    phoneHidden.value = '+1' + digits;
                    phone_error.style.display = 'none';
                } else {
                    phoneHidden.value = '';
                    phone_error.style.display = 'block';
                }
            });
        }

        if (emailInput) {
            var emailHidden = document.getElementById('email_hidden');
            emailInput.addEventListener('input', function () {
                emailHidden.value = this.value;
            });
        }
    }
    initPhoneInputHandlers();

    document.body.addEventListener('htmx:afterSwap', function () {
        initPhoneInputHandlers();
        initContactPrev();
    });

    // ---- Year select population ----
    var startYear   = 1950;
    var currentYear = new Date().getFullYear();
    var yearSelect  = document.getElementById('year');
    for (var y = currentYear; y >= startYear; y--) {
        var opt = document.createElement('option');
        opt.value = y;
        opt.text  = y;
        yearSelect.appendChild(opt);
    }

    // ---- TomSelect init ----
    document.addEventListener('DOMContentLoaded', function () {
        new TomSelect('#year', {
            create: false,
            sortField: { field: 'text', direction: 'desc' }
        });
        new TomSelect('#make', {
            create: true,
            sortField: { field: 'text', direction: 'asc' }
        });
        new TomSelect('#model2', {
            create: true,
            sortField: { field: 'text', direction: 'asc' }
        });
    });

    document.addEventListener('htmx:afterSettle', function (event) {
        var initiator = event.detail.elt;
        var xhr       = event.detail.xhr;
        if (xhr.status === 200 && initiator.id === 'modeltarget') {
            new TomSelect('#model', {
                create: true,
                sortField: { field: 'text', direction: 'asc' }
            });
        }
    });

    // ---- Google Places: from ----
    var debounceTimer;
    document.getElementById('from').addEventListener('input', function () {
        clearTimeout(debounceTimer);
        var query          = this.value.trim();
        var suggestionList = document.getElementById('suggestions');
        if (query.length < 3) {
            suggestionList.innerHTML = '';
            suggestionList.style.border = 'none';
            return;
        }
        debounceTimer = setTimeout(function () {
            fetch('/placesautocomplete', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify({ address: query })
            })
            .then(function (r) {
                if (!r.ok) { throw new Error('HTTP ' + r.status); }
                return r.json();
            })
            .then(function (data) {
                var suggestions      = Array.isArray(data) ? data : (data.suggestions || []);
                var suggestions_error = document.getElementById('suggestions_error');
                suggestionList.innerHTML = '';
                if (suggestions.length > 0) {
                    suggestions.forEach(function (item) {
                        var prediction  = item.placePrediction;
                        var description = prediction.text && prediction.text.text || '';
                        var placeId     = prediction.placeId;
                        var li          = document.createElement('li');
                        li.textContent  = description;
                        li.classList.add('list-group-item');
                        li.onclick = function () {
                            document.getElementById('from').value = description;
                            start_id.value = placeId;
                            suggestionList.innerHTML = '';
                            suggestions_error.style.display = 'none';
                        };
                        suggestionList.appendChild(li);
                    });
                } else {
                    suggestions_error.style.display = 'block';
                }
            })
            .catch(function () {
                document.getElementById('suggestions_error').style.display = 'block';
                suggestionList.innerHTML = '';
            });
        }, 300);
    });

    // ---- Google Places: destination ----
    var debounceTimer2;
    document.getElementById('destination').addEventListener('input', function () {
        clearTimeout(debounceTimer2);
        var query          = this.value.trim();
        var suggestionList = document.getElementById('suggestions2');
        if (query.length < 3) {
            suggestionList.innerHTML = '';
            return;
        }
        debounceTimer2 = setTimeout(function () {
            fetch('/placesautocomplete', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify({ address: query })
            })
            .then(function (r) {
                if (!r.ok) { throw new Error('HTTP ' + r.status); }
                return r.json();
            })
            .then(function (data) {
                var suggestions       = Array.isArray(data) ? data : (data.suggestions || []);
                var suggestions_error2 = document.getElementById('suggestions_error2');
                suggestionList.innerHTML = '';
                if (suggestions.length > 0) {
                    suggestions.forEach(function (item) {
                        var prediction  = item.placePrediction;
                        var description = prediction.text && prediction.text.text || '';
                        var placeId     = prediction.placeId;
                        var li          = document.createElement('li');
                        li.textContent  = description;
                        li.classList.add('list-group-item');
                        li.onclick = function () {
                            document.getElementById('destination').value = description;
                            destination_id.value = placeId;
                            suggestionList.innerHTML = '';
                            suggestions_error2.style.display = 'none';
                        };
                        suggestionList.appendChild(li);
                    });
                } else {
                    suggestions_error2.style.display = 'block';
                }
            })
            .catch(function () {
                document.getElementById('suggestions_error2').style.display = 'block';
                suggestionList.innerHTML = '';
            });
        }, 100);
    });

}());
</script>

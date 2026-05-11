<div class="iq-step-head">
    <h2>Verification Code</h2>
    <p>Confirm your identity</p>
</div>

<div class="iq-fields-group">
    <div class="iq-otp-info">
        <div>
            <p class="iq-otp-info-label">A verification code has been sent to:</p>
            <p class="iq-otp-info-phone">{{ $phone ?? '' }}</p>
        </div>
        @if(!empty($email))
            <p class="iq-otp-info-email">{{ $email }}</p>
        @else
            <p class="iq-otp-info-email" id="otp-email-display"></p>
        @endif
    </div>

    <div class="iq-field">
        <label for="code">Confirmation Code</label>
        <input type="text" id="code" class="iq-input"
               placeholder="Enter code"
               name="code"
               required
               autocomplete="off">
        <p class="iq-error" id="code-error"></p>
        <p class="iq-error" id="code-invalid"></p>
    </div>
</div>

<div class="iq-btn-row">
    <button type="button" class="iq-btn-secondary"
            hx-post="{{ route('frontend.change.phone') }}"
            hx-vals='{"_token": "{{ csrf_token() }}"}'
            hx-target="#contact_details_widget">
        Change Phone
    </button>
    <button type="button" class="iq-btn-primary" id="confirm_otp">
        Confirm
    </button>
</div>

<script>
(function () {
    // Populate email display if not injected server-side
    var otpEmailDisplay = document.getElementById('otp-email-display');
    if (otpEmailDisplay) {
        var emailHidden = document.getElementById('email_hidden');
        otpEmailDisplay.textContent = emailHidden ? emailHidden.value : '';
    }

    // Update progress: steps 1 & 2 completed, step 3 in-progress
    if (typeof window.updateProgress === 'function') {
        window.updateProgress(3, true);
    }

    // Code input validation
    var codeInput  = document.getElementById('code');
    var errorDiv   = document.getElementById('code-error');
    var confirmBtn = document.getElementById('confirm_otp');

    codeInput.addEventListener('input', function () {
        this.value = this.value.replace(/\D/g, '').substring(0, 6);
        errorDiv.textContent = '';
        errorDiv.style.display = 'none';
    });

    codeInput.addEventListener('blur', function () {
        if (this.value.trim().length !== 6) {
            errorDiv.textContent = 'Code must be exactly 6 digits.';
            errorDiv.style.display = 'block';
        } else {
            errorDiv.style.display = 'none';
        }
    });

    confirmBtn.addEventListener('click', function () {
        var code = codeInput.value.trim();
        if (!/^\d{6}$/.test(code)) {
            errorDiv.textContent = 'Please enter a valid 6-digit code.';
            errorDiv.style.display = 'block';
            codeInput.focus();
            return;
        }

        var codeInvalid = document.getElementById('code-invalid');

        var phone_hidden2    = document.getElementById('phone_hidden').value;
        var destination_id2  = document.getElementById('destination_id').value;
        var start_id2        = document.getElementById('start_id').value;
        var email_hidden2    = document.getElementById('email_hidden').value;
        var first_name2      = document.getElementById('first_name_hidden') ? document.getElementById('first_name_hidden').value : '';
        var last_name2       = document.getElementById('last_name_hidden')  ? document.getElementById('last_name_hidden').value  : '';
        var from2            = document.getElementById('from').value;
        var destination2     = document.getElementById('destination').value;
        var transport_type2  = document.querySelector('[name="transport_type"]:checked').value;
        var operable2        = document.querySelector('[name="operable"]:checked').value;
        var year2            = document.getElementById('year').value;
        var make2            = document.getElementById('make').value;
        var carmodel         = document.getElementById('model') || document.getElementById('model2');
        var model2           = carmodel ? carmodel.value : '';
        var availability2    = document.getElementById('availability').value;
        var request_type_el  = document.querySelector('input[name="request_type"]:checked');
        var request_type     = request_type_el ? request_type_el.value : '';

        confirmBtn.disabled = true;

        var body = new URLSearchParams({
            _token:         '{{ csrf_token() }}',
            availability:   availability2,
            code:           code,
            phone_hidden:   phone_hidden2,
            destination_id: destination_id2,
            start_id:       start_id2,
            email:          email_hidden2,
            first_name:     first_name2,
            last_name:      last_name2,
            from:           from2,
            destination:    destination2,
            transport_type: transport_type2,
            operable:       operable2,
            year:           year2,
            make:           make2,
            model:          model2,
            request_type:   request_type,
        });

        fetch('{{ route('frontend.confirm.otp') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
            body: body.toString(),
        })
        .then(function (response) {
            var type = response.headers.get('X-HTMX-Request-Type');
            return response.text().then(function (html) {
                return { ok: response.ok, type: type, html: html };
            });
        })
        .then(function (result) {
            if (result.type === 'ind-quotation-success') {
                var tmp = document.createElement('div');
                tmp.innerHTML = result.html;
                document.body.appendChild(tmp.firstElementChild);
            } else if (result.ok) {
                if (codeInvalid) {
                    codeInvalid.textContent = result.html.trim() || 'Invalid code.';
                    codeInvalid.style.display = 'block';
                }
                confirmBtn.disabled = false;
            } else {
                if (codeInvalid) {
                    codeInvalid.textContent = 'An error occurred. Please try again.';
                    codeInvalid.style.display = 'block';
                }
                confirmBtn.disabled = false;
            }
        })
        .catch(function () {
            if (codeInvalid) {
                codeInvalid.textContent = 'An error occurred. Please try again.';
                codeInvalid.style.display = 'block';
            }
            confirmBtn.disabled = false;
        });
    });
}());
</script>

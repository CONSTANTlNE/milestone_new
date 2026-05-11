<div class="iq-otp-info">
    <div>
        <p class="iq-otp-info-label">A verification code has been sent to:</p>
        <p class="iq-otp-info-phone" id="b2b-otp-phone-display"></p>
    </div>
</div>

<div class="iq-fields-group">
    <div class="iq-field">
        <label for="code2">Confirmation Code</label>
        <input type="text" id="code2" class="iq-input"
               placeholder="Enter code"
               name="code"
               required
               autocomplete="off">
        <p class="iq-error" id="code-error2"></p>
        <p class="iq-error" id="code-invalid-business"></p>
    </div>
</div>

<div class="iq-btn-row">
    <button type="button" class="iq-btn-secondary"
            hx-post="{{ route('frontend.change.phone.business') }}"
            hx-vals='{"_token": "{{ csrf_token() }}"}'
            hx-target="#business_otp_target">
        Change Phone
    </button>
    <button type="button" class="iq-btn-primary" id="confirm_otp_business">
        Confirm
    </button>
</div>

<script>
(function () {
    var phoneHidden  = document.getElementById('phone_hidden_business');
    var phoneDisplay = document.getElementById('b2b-otp-phone-display');
    if (phoneDisplay && phoneHidden) {
        phoneDisplay.textContent = phoneHidden.value;
    }

    var emailGroup = document.getElementById('iqb_email_group');
    if (emailGroup) emailGroup.style.display = 'none';

    var titleEl = document.getElementById('b2b_step_head_title');
    var descEl  = document.getElementById('b2b_step_head_desc');
    if (titleEl) titleEl.textContent = 'Verification Code';
    if (descEl)  descEl.textContent  = 'Confirm your identity';

    if (typeof window.updateB2bProgress === 'function') {
        window.updateB2bProgress(2, false);
    }

    if (typeof htmx !== 'undefined') {
        htmx.process(document.getElementById('business_otp_target'));
    }

    var codeInput  = document.getElementById('code2');
    var errorDiv   = document.getElementById('code-error2');
    var confirmBtn = document.getElementById('confirm_otp_business');

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

        var codeInvalid = document.getElementById('code-invalid-business');

        confirmBtn.disabled = true;

        fetch('{{ route('frontend.confirm.otp.business') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
            body: new URLSearchParams({
                _token:       '{{ csrf_token() }}',
                code:         code,
                phone_hidden: phoneHidden ? phoneHidden.value : '',
            }).toString(),
        })
        .then(function (response) {
            var type = response.headers.get('X-HTMX-Request-Type');
            return response.text().then(function (html) {
                return { ok: response.ok, type: type, html: html };
            });
        })
        .then(function (result) {
            if (result.type === 'bsiness-otp-success') {
                var target = document.getElementById('business_otp_target');
                if (target) {
                    target.outerHTML = result.html;
                }

                var verifiedDisplay = document.getElementById('b2b-verified-phone-display');
                if (verifiedDisplay && phoneHidden) {
                    verifiedDisplay.textContent = phoneHidden.value;
                }

                if (typeof window.updateB2bProgress === 'function') {
                    window.updateB2bProgress(2, true);
                    window.updateB2bProgress(3, false);
                }

                if (typeof window.showB2bVehicleSection === 'function') {
                    window.showB2bVehicleSection();
                }
            } else {
                if (codeInvalid) {
                    codeInvalid.textContent = result.html.trim() || 'Invalid code. Please try again.';
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

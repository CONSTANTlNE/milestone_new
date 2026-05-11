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
            disabled
            id="send_code_button">
        Send Code
    </button>
</div>

<script>
(function () {
    // Pre-fill from hidden fields
    var fnHidden    = document.getElementById('first_name_hidden');
    var lnHidden    = document.getElementById('last_name_hidden');
    var emailHidden = document.getElementById('email_hidden');
    var phoneHidden = document.getElementById('phone_hidden');

    var fnInput    = document.getElementById('first_name');
    var lnInput    = document.getElementById('last_name');
    var emailInput = document.getElementById('email');
    var phoneInput = document.getElementById('phone_input');

    if (fnHidden && fnInput)       { fnInput.value    = fnHidden.value; }
    if (lnHidden && lnInput)       { lnInput.value    = lnHidden.value; }
    if (emailHidden && emailInput) { emailInput.value = emailHidden.value; }

    // Pre-fill formatted phone from hidden value
    if (phoneHidden && phoneInput && phoneHidden.value) {
        var digits = phoneHidden.value.replace(/\D/g, '').slice(-10);
        if (digits.length === 10) {
            phoneInput.value = '(' + digits.substring(0, 3) + ') ' + digits.substring(3, 6) + '-' + digits.substring(6);
        }
    }

    // Update progress: step 3 in-progress
    if (typeof window.updateProgress === 'function') {
        window.updateProgress(3, true);
    }

    // Process HTMX on the new send button
    if (typeof htmx !== 'undefined') {
        htmx.process(document.getElementById('contact_details_widget'));
    }
}());
</script>

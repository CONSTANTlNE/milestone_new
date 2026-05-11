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

<script>
(function () {
    var titleEl = document.getElementById('b2b_step_head_title');
    var descEl  = document.getElementById('b2b_step_head_desc');
    if (titleEl) titleEl.textContent = 'Contact Information';
    if (descEl)  descEl.textContent  = 'Enter your business contact details';

    if (typeof window.initPhoneInputHandlersBiz === 'function') {
        window.initPhoneInputHandlersBiz();
    }

    var emailGroup = document.getElementById('iqb_email_group');
    if (emailGroup) emailGroup.style.display = '';

    if (typeof window.updateB2bProgress === 'function') {
        window.updateB2bProgress(1, false);
    }

    if (typeof htmx !== 'undefined') {
        htmx.process(document.getElementById('business_otp_target'));
    }
}());
</script>

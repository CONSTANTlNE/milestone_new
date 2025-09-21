<p class="text-center">Please enter confirmation code</p>
<div class="row mb-2" style="position: relative">
    <div class="d-flex justify-content-center">
        <input type="text" id="code2" class="form-control text-center mb-0"
               placeholder="Code" name="code" required="" autocomplete="off">
    </div>
    <p id="code-error2" style="color: red;margin-bottom: 0" class="text-center"></p>
    <p id="code-invalid-business" style="color: red;" class="text-center"></p>
</div>

<div class="d-flex justify-content-center gap-4">
    <button type="button" class="pbmit-btn  text-center"
            hx-post="{{route('frontend.change.phone.business')}}"
            hx-vals='{"_token": "{{ csrf_token() }}"}'
            hx-target="#business_otp_target"
            style="z-index: 0;padding-right: 30px;min-width:150px">
        <span>Change Phone</span>
    </button>
    <button type="button" class="pbmit-btn  text-center"
            id="confirm_otp2"
            style="z-index: 0;padding-right: 30px;min-width:150px">
        <span>Confirm</span>
    </button>
</div>
<div id="dummy"></div>
<script>
    codeInput2 = document.getElementById('code2');
    errorDiv2 = document.getElementById('code-error2');
    confirm_otp2 = document.getElementById('confirm_otp2')

    codeInput2.addEventListener('input', function () {
        // Remove non-digit characters immediately
        let digits = this.value.replace(/\D/g, '');
        // Limit to 6 digits max
        this.value = digits.substring(0, 6);
        // Clear error message as user types
        errorDiv2.textContent = '';
    });

    codeInput2.addEventListener('blur', function () {
        const code = this.value.trim();

        if (code.length !== 6) {
            errorDiv2.textContent = 'Code must be exactly 6 digits.';
        } else {
            errorDiv2.textContent = '';
        }
    });


    confirm_otp2.addEventListener('click', function (e) {
        const code = codeInput2.value.trim();
        if (!/^\d{6}$/.test(code)) {
            errorDiv2.textContent = 'Please enter a valid 6-digit code.';
            codeInput2.focus();
        } else {
            htmx.ajax('POST', '{{route('frontend.confirm.otp.business')}}', {
                swap: 'none',
                headers: {
                    'X-HTMX-Request-Type': 'manual-otp'
                },
                // target: '#contact_details_widget',
                values: {
                    _token: "{{ csrf_token() }}",
                    code: code,
                }
            });
        }
    });


</script>

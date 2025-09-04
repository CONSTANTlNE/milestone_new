<p class="text-center">Please enter confirmation code</p>
<div class="row mb-2" style="position: relative">
    <div class="d-flex justify-content-center">
        <input type="text" id="code" class="form-control text-center"
               placeholder="Code" name="code" required="" autocomplete="off">
    </div>
    <p id="code-error" style="color: red;margin-bottom: 0" class="text-center"></p>
    <p id="code-invalid" style="color: red;" class="text-center"></p>
</div>

<div class="d-flex justify-content-center gap-4">
    <button type="button" class="pbmit-btn  text-center"
            hx-post="{{route('frontend.change.phone')}}"
            hx-vals='{"_token": "{{ csrf_token() }}"}'
            hx-target="#contact_details_widget"
            style="z-index: 0;padding-right: 30px;min-width:150px">
        <span>Change Phone</span>
    </button>
    <button type="button" class="pbmit-btn  text-center"
            id="confirm_otp"
            style="z-index: 0;padding-right: 30px;min-width:150px">
        <span>Confirm</span>
    </button>
</div>
<div id="dummy"></div>
<script>
    codeInput = document.getElementById('code');
    errorDiv = document.getElementById('code-error');
    confirm_otp = document.getElementById('confirm_otp')

    codeInput.addEventListener('input', function () {
        // Remove non-digit characters immediately
        let digits = this.value.replace(/\D/g, '');
        // Limit to 6 digits max
        this.value = digits.substring(0, 6);
        // Clear error message as user types
        errorDiv.textContent = '';
    });

    codeInput.addEventListener('blur', function () {
        const code = this.value.trim();

        if (code.length !== 6) {
            errorDiv.textContent = 'Code must be exactly 6 digits.';
        } else {
            errorDiv.textContent = '';
        }
    });


    confirm_otp.addEventListener('click', function (e) {
        const code = codeInput.value.trim();
        if (!/^\d{6}$/.test(code)) {
            errorDiv.textContent = 'Please enter a valid 6-digit code.';
            codeInput.focus();
        } else {
            phone_hidden2 = document.getElementById('phone_hidden').value
            destination_id2 = document.getElementById('destination_id').value
            start_id2 = document.getElementById('start_id').value
            email_hidden2 = document.getElementById('email_hidden').value

            from2 = document.getElementById('from').value
            destination2 = document.getElementById('destination').value
            transport_type2 = document.querySelector('[name="transport_type"]:checked').value;
            operable2 = document.querySelector('[name="operable"]:checked').value;
            year2 = document.getElementById('year').value
            make2 = document.getElementById('make').value
            carmodel=document.getElementById('model')
            if(carmodel){
                model2 = carmodel.value
            } else {
                model2=document.getElementById('model2').value
            }

            availability2 = document.getElementById('availability').value
            request_type = document.querySelector('input[name="request_type"]:checked')?.value;


            htmx.ajax('POST', '{{route('frontend.confirm.otp')}}', {
                swap: 'none',
                headers: {
                    'X-HTMX-Request-Type': 'manual-otp'
                },
                // target: '#contact_details_widget',
                values: {
                    _token: "{{ csrf_token() }}",
                    availability: availability2,
                    code: code,
                    phone_hidden: phone_hidden2,
                    destination_id: destination_id2,
                    start_id: start_id2,
                    email: email_hidden2,
                    from: from2,
                    destination: destination2,
                    transport_type: transport_type2,
                    operable: operable2,
                    year: year2,
                    make: make2,
                    model: model2,
                    request_type:request_type
                }
            });
        }
    });


</script>

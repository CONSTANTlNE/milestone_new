<div class="d-flex justify-content-center p-0">
    <input style="max-width: 300px;margin-bottom: 10px" type="text"
           class="form-control text-center"
           placeholder="Phone" required="" id="phone_input_business" autocomplete="off">

</div>
<p class="text-center" style="color:red;display: none" id="phone_error_business">
    Phone number must be 10 digits
</p>
<button type="button" class="pbmit-btn  text-center"
        hx-post="{{route('frontend.send.otp.business')}}"
        hx-vals='{"_token": "{{ csrf_token() }}"}'
        hx-include="[name='phone_business']"
        hx-target="#business_otp_target"
        hx-indicator="#loading"
        disabled
        id="send_code_button_business"
        style="z-index: 0;padding-right: 30px;max-width:150px">
    <span>Send Code</span>
</button>

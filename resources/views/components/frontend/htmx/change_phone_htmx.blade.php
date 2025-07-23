<p class="text-center">Please fill in contact information *</p>
<div class="row mb-2" style="position: relative">
    <div class="d-flex justify-content-center">
        <input type="email" id="email" class="form-control text-center"
               placeholder="Email" name="email" required="" autocomplete="off">
    </div>
</div>

<div class="row mb-2" style="position: relative">
    <div class="d-flex justify-content-center">

        <input type="text" class="form-control text-center"
               placeholder="Phone"  required="" id="phone_input" autocomplete="off">
    </div>
    <p class="text-center" style="color:red;display: none" id="phone_error">Phone number must be 10 digits</p>
</div>

<div class="d-flex justify-content-center gap-4">
    <button id="contact_details_prev" type="button" class="pbmit-btn  text-center"
            style="z-index: 0;padding-right: 30px;min-width:150px">
        <span>Previous</span>
    </button>
    <button type="button" class="pbmit-btn  text-center"
            hx-post="{{route('frontend.send.otp')}}"
            hx-vals='{"_token": "{{ csrf_token() }}"}'
            hx-include="[name='phone']"
            hx-target="#contact_details_widget"
            disabled
            id="send_code_button"
            style="z-index: 0;padding-right: 30px;min-width:150px">
        <span>Send Code</span>
    </button>
</div>

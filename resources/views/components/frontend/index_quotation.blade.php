{{--@push('csss')--}}
<style>

    input {
        color: black !important;
        font-size: 16px;
        opacity: 1 !important;
    }


    #suggestions {
        list-style: none;
        padding: 0;
        position: absolute;
        top: 60px;
        background: white;
        z-index: 100;
        width: 100%; /* ✅ Match parent width */
        box-sizing: border-box; /* ✅ Include border/padding in width */
    }

    #suggestions li {
        padding: 8px;
        cursor: pointer;
    }

    #suggestions li:hover {
        background: #f0f0f0;
    }

    #suggestions2 {
        list-style: none;
        padding: 0;
        top: 60px;
        position: absolute;
        background: white;
        z-index: 100;
        width: 100%; /* ✅ Match parent width */
        box-sizing: border-box; /* ✅ Include border/padding in width */
    }

    #suggestions2 li {
        padding: 8px;
        cursor: pointer;
    }

    #suggestions2 li:hover {
        background: #f0f0f0;
    }

    /*@media only screen and (min-width:1200px ){*/
    /*    #suggestions {*/
    /*        width: 500px;*/
    /*    }*/
    /*}*/

    .htmx-indicator {
        display: none;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 1000;
        opacity: 0;
        transition: opacity 500ms ease-in;
    }

    .htmx-request .htmx-indicator {
        display: block;
        opacity: 1;
    }

    .htmx-request.htmx-indicator {
        display: block;
        opacity: 1;
    }

    .remove-after::after {
        content: none !important;
    }

    .customul {
        width: 100px;
        min-width: 100px;
    }

    select, option {
        color: black !important;
    }

    option {
        color: black !important;
    }

    .htmx_errors {
        display: none;
        text-align: center;
        margin-bottom: 3px;
    }

    .availability_select {
        padding-bottom: 5px;
        padding-top: 5px;
        height: 50px;
    }

</style>
{{--@endpush--}}

<section id="index_quotation">

    <div class="container mt-3">
        <div class="row g-0 justify-content-center">
            <div>
                <form>
                    <input type="hidden" name="to" value="" id="destination_id">
                    <input type="hidden" name="from" value="" id="start_id">
                    <input type="hidden" name="phone" id="phone_hidden"/>
                    <input type="hidden" name="email" id="email_hidden"/>
                    <input type="hidden" name="cloudflare_captcha" id="cloudflare_captcha">
                    <div style="padding-left:30px;padding-right: 30px"
                         class="contact-form-rightbox pbmit-bg-color-white" id="adresses">

                        <p id="htmx_error_request_type" class="htmx_errors"></p>
                        <p id="htmx_error_make_id" class="htmx_errors"></p>
                        <p id="htmx_error_email" class="htmx_errors"></p>
                        <p id="htmx_error_phone" class="htmx_errors"></p>
                        <div class="contact-form">
                            {{--   start and destination --}}
                            <div style="display: block" id="destination_widget">

                                <p class="text-center">Please enter ZIP or City*</p>
                                <div class="row" style="position: relative">
                                    <div class="col-md-12">
                                        <input type="text" id="from" class="form-control text-center"
                                               placeholder="Transport Car From"
                                               name="from"
                                               required=""
                                               autocomplete="off">
                                        <p style="display: none;color:red" id="pickup_error"
                                           class="text-center">
                                            please fill pickup point
                                        </p>
                                    </div>
                                    <ul id="suggestions" class="list-group col-md-12"></ul>
                                    <p id="suggestions_error" style="color:red;display: none"
                                       class="text-center">Please
                                        choose from selection</p>
                                </div>
                                <div class="row" style="position: relative">
                                    <div class="col-md-12">
                                        <input type="text" id="destination"
                                               class="form-control text-center"
                                               placeholder="Transport Car to"
                                               name="destination" required=""
                                               autocomplete="off">
                                        <p style="display: none;color:red" id="destination_error"
                                           class="text-center">
                                            please fill destination</p>
                                    </div>
                                    <ul id="suggestions2" class="list-group col-md-12"></ul>
                                    <p id="suggestions_error2" style="color:red;display: none"
                                       class="text-center">
                                        Please choose from selection
                                    </p>
                                </div>
                                <div class="row" style="position: relative">
                                    <div style="gap: 20px" class="d-flex justify-content-center">
                                        <p class="text-center">Transport type</p>
                                        <label class="text-center">
                                            <input type="radio" class="form-check-input"
                                                   name="transport_type"
                                                   value="open">
                                            Open
                                        </label>
                                        <label class="text-center">
                                            <input type="radio" class="form-check-input"
                                                   name="transport_type"
                                                   value="closed">
                                            Enclosed
                                        </label>
                                    </div>
                                    <p style="display: none;color:red" id="transport_type_error"
                                       class="text-center">
                                        please select transport type
                                    </p>
                                </div>
                                <div class="d-flex justify-content-center">
                                    <button id="dest_next" type="button"
                                            class="pbmit-btn  text-center"
                                            style="z-index: 0;padding-right: 30px;min-width:150px">
                                        <span>next</span>
                                    </button>
                                </div>
                            </div>
                            {{--  Car Detaisl --}}
                            <div style="display: none" id="car_details_widget">
                                <p class="text-center">Please fill vehicle details *</p>
                                <div class="row mb-2" style="position: relative">
                                    <div class="d-flex justify-content-center">
                                        <select style="width: 200px" id="year" autocomplete="off">
                                            <option value="">Select Year</option>
                                        </select>
                                    </div>
                                    <p class="text-center mb-0" style="color:red;display:none" id="year_error">
                                        Please select Car Year
                                    </p>
                                </div>
                                <div class="row mb-2" style="position: relative">
                                    <div class="d-flex justify-content-center">
                                        <select style="width: 200px"
                                                id="make"
                                                name="make_id"
                                                hx-get="{{route('frontend.htmx.car_models')}}"
                                                hx-trigger="change"
                                                hx-target="#modeltarget"
                                                autocomplete="off">
                                            <option value="">Select Manufacturer</option>
                                            @foreach($cars as $make)
                                                <option value="{{$make->id}}">{{$make->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <p class="text-center mb-0" style="color:red;display:none" id="make_error">Please
                                        select Manufacturer</p>
                                </div>
                                <div class="row mb-2" style="position: relative">
                                    <div class="d-flex justify-content-center" id="modeltarget">
                                        <select style="width: 200px" autocomplete="off" id="model2" name="model">
                                            <option value="">Select Model</option>
                                        </select>
                                    </div>
                                    <p class="text-center" style="color:red;display: none" id="model_error">
                                        Please select Car Model
                                    </p>
                                </div>
                                <div class="row" style="position: relative">
                                    <div style="gap: 20px" class="d-flex justify-content-center mt-3">
                                        <p class="mb-0">Is it operable?</p>
                                        <label>
                                            <input type="radio" class="form-check-input" name="operable" value="yes">
                                            Yes
                                        </label>
                                        <label>
                                            <input type="radio" class="form-check-input" name="operable" value="no">
                                            No
                                        </label>
                                    </div>
                                    <p class="text-center" style="color:red;display:none" id="operable_error">
                                        Please select vehicle condition
                                    </p>
                                </div>
                                <div class="row mb-2" style="position: relative">
                                    <div class="d-flex justify-content-center">
                                        <div style="max-width: 300px">
                                            <select name="availability"
                                                    class="availability_select form-control"
                                                    autocomplete="off"
                                                    id="availability">
                                                <option value="">Select Availability</option>
                                                @foreach($availabilities as $availability)
                                                    <option value="{{$availability->id}}">{{$availability->title}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <p id="availability_error" class="text-center" style="color:red;display:none">
                                        Please select Time
                                    </p>
                                </div>
                                <div style="margin-left:22px " class="d-flex justify-content-center gap-4">
                                    <button id="car_details_prev" type="button" class="pbmit-btn  text-center"
                                            style="z-index: 0;padding-right: 30px;min-width:150px">
                                        <span>previous</span>
                                    </button>
                                    <button id="car_details_next" type="button" class="pbmit-btn  text-center"
                                            style="z-index: 0;padding-right: 30px;min-width:150px">
                                        <span>next</span>
                                    </button>
                                </div>
                            </div>
                            {{--   Contact details--}}
                            <div style="display: none;position: relative" id="contact_details_widget">
                                <p class="text-center">Please fill in contact information *</p>
{{--                                <div class="row mb-2" style="position: relative">--}}
{{--                                    <div class="d-flex justify-content-center">--}}
{{--                                        <div style="gap: 20px" class="d-flex justify-content-center mb-3">--}}
{{--                                            <p class="mb-0">Request Type</p>--}}
{{--                                            <label>--}}
{{--                                                <input type="radio" class="form-check-input" name="request_type"--}}
{{--                                                       value="1">--}}
{{--                                                Individual--}}
{{--                                            </label>--}}
{{--                                            <label>--}}
{{--                                                <input type="radio" class="form-check-input" name="request_type" value="2">--}}
{{--                                                Business--}}
{{--                                            </label>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
                                <div class="row mb-2" style="position: relative">

                                    <div class="d-flex justify-content-center">
                                        <input type="email" id="email" class="form-control text-center"
                                               oninput="document.getElementById('email_hidden').value = this.value"
                                               placeholder="Email" required="" autocomplete="off">
                                    </div>
                                </div>

                                <div class="row mb-2" style="position: relative">
                                    <div class="d-flex justify-content-center">

                                        <input type="text" class="form-control text-center"
                                               placeholder="Phone" required="" id="phone_input" autocomplete="off">
                                    </div>
                                    <p class="text-center" style="color:red;display: none" id="phone_error">
                                        Phone number must be 10 digits
                                    </p>
                                </div>

                                <div class="d-flex justify-content-center gap-4">
                                    <button id="contact_details_prev" type="button" class="pbmit-btn  text-center"
                                            style="z-index: 0;padding-right: 30px;min-width:150px">
                                        <span>Previous</span>
                                    </button>
                                    <button type="button" class="pbmit-btn  text-center"
                                            hx-post="{{route('frontend.send.otp')}}"
                                            hx-vals='{"_token": "{{ csrf_token() }}"}'
                                            hx-include="[name='phone'],[name='cloudflare_captcha']"
                                            hx-target="#contact_details_widget"
                                            hx-indicator="#loading"
                                            disabled
                                            id="send_code_button"
                                            style="z-index: 0;padding-right: 30px;min-width:150px">
                                        <span>Send Code</span>
                                    </button>
                                    <p id="captcha-error" style="color: red;" class="text-center"></p>
                                </div>
                                <svg
                                        id="loading"
                                        class="htmx-indicator overlay d-done"
                                        xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24">
                                    <path fill="#105dbf"
                                          d="M12,23a9.63,9.63,0,0,1-8-9.5,9.51,9.51,0,0,1,6.79-9.1A1.66,1.66,0,0,0,12,2.81h0a1.67,1.67,0,0,0-1.94-1.64A11,11,0,0,0,12,23Z">
                                        <animateTransform attributeName="transform" dur="0.75s" repeatCount="indefinite"
                                                          type="rotate"
                                                          values="0 12 12;360 12 12"/>
                                    </path>
                                </svg>
                            </div>

                            <div class="col-md-12 col-lg-12 message-status"></div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<div id="turnstile-container"></div>
<div id="turnstile-container2"></div>
<div id="turnstile-container3"></div>
<script>
    // Cloudflare captcha
    @php
        if(env('LOCAL_TEST')){
              $siteKey = "1x00000000000000000000BB";
        } else {
             $siteKey = "{{config('milestone.CLOUDFLARE_SITE_KEY')}}";
        }
    @endphp

    // captcha for requesting sms code
    {{--window.onloadTurnstileCallback = function () {--}}
    {{--    turnstile.render("#turnstile-container", {--}}
    {{--        sitekey: "{{$siteKey}}",--}}
    {{--        callback: function (token) {--}}
    {{--            console.log(token)--}}
    {{--            document.getElementById('cloudflare_captcha').value = token;--}}
    {{--        },--}}
    {{--    });--}}

    {{--    widgetId2 = turnstile.render("#turnstile-container2", {--}}
    {{--        sitekey: "{{$siteKey}}",--}}
    {{--        callback: function (token) {--}}
    {{--            console.log("Widget 2 Token:", token);--}}
    {{--            window.lastTokenFrom2 = token; // Save if needed--}}
    {{--        },--}}
    {{--    });--}}

    {{--    widgetId3 = turnstile.render("#turnstile-container3", {--}}
    {{--        sitekey: "{{$siteKey}}",--}}
    {{--        callback: function (token) {--}}
    {{--            console.log("Widget 3 Token:", token);--}}
    {{--            window.lastTokenFrom3 = token;--}}
    {{--        },--}}
    {{--    });--}}
    {{--};--}}


    const dest_next = document.getElementById('dest_next')
    const car_details = document.getElementById('car_details_widget')
    const destination_widget = document.getElementById('destination_widget')
    const car_details_next = document.getElementById('car_details_next')
    const car_details_prev = document.getElementById('car_details_prev')
    const contact_details = document.getElementById('contact_details_widget')

    const transport_type_error = document.getElementById('transport_type_error')

    const start_id = document.getElementById('start_id')
    const destination_id = document.getElementById('destination_id')
    const pickup_error = document.getElementById('pickup_error')
    const destination_error = document.getElementById('destination_error')


    // start and destination adress validation
    dest_next.addEventListener('click', () => {
        const car_type = document.querySelector('[name="transport_type"]:checked');
        if (start_id.value.length < 4) {
            pickup_error.style.display = 'block'
        } else if (destination_id.value.length < 4) {
            destination_error.style.display = 'block'
            pickup_error.style.display = 'none'
        } else if (!car_type) {
            pickup_error.style.display = 'none'
            destination_error.style.display = 'none'
            transport_type_error.style.display = 'block'
        } else {
            pickup_error.style.display = 'none'
            destination_error.style.display = 'none'
            destination_widget.style.display = 'none'
            transport_type_error.style.display = 'none'

            car_details.style.display = 'block'
        }

    });


    car_details_prev.addEventListener('click', () => {
        destination_widget.style.display = 'block'
        car_details.style.display = 'none'
    });

    // Car details validation
    const year = document.getElementById('year')
    const make = document.getElementById('make')
    const operable_error = document.getElementById('operable_error')
    const year_error = document.getElementById('year_error')
    const make_error = document.getElementById('make_error')
    const model_error = document.getElementById('model_error')
    const availability = document.getElementById('availability')
    const availability_error = document.getElementById('availability_error')
    const availabilityIds = @json($availabilities->pluck('id'));

    let availability_value = availability.value
    availability.addEventListener('change', () => {
        availability_value = document.getElementById('availability').value
    })

    car_details_next.addEventListener('click', () => {
        const operable = document.querySelector('[name="operable"]:checked');
        let model = document.getElementById('model')
        if (!model) {
            model= document.getElementById('model2')
        }


        if (year.value.length < 4) {
            year_error.style.display = 'block'
        } else if (make.value.length < 1) {
            make_error.style.display = 'block'
            year_error.style.display = 'none'
        } else if (model.value == '') {

            model_error.style.display = 'block'
            make_error.style.display = 'none'
            year_error.style.display = 'none'
        } else if (!operable) {
            make_error.style.display = 'none'
            year_error.style.display = 'none'
            model_error.style.display = 'none'
            operable_error.style.display = 'block'
        } else if (!availabilityIds.includes(Number(availability_value))) {
            make_error.style.display = 'none'
            year_error.style.display = 'none'
            model_error.style.display = 'none'
            operable_error.style.display = 'none'
            availability_error.style.display = 'block'
        } else {
            make_error.style.display = 'none'
            year_error.style.display = 'none'
            operable_error.style.display = 'none'
            model_error.style.display = 'none'
            availability_error.style.display = 'none'

            car_details.style.display = 'none'
            contact_details.style.display = 'block'
        }


    });

    function initListener() {
        contact_details_prev = document.getElementById('contact_details_prev')
        if (contact_details_prev) {
            contact_details_prev.addEventListener('click', () => {
                car_details.style.display = 'block'
                contact_details.style.display = 'none'
            });
        }
    }

    initListener()

    // Phone number validation
    function initPhoneInputHandlers() {
        const phone_input = document.getElementById('phone_input');
        const phoneHidden = document.getElementById('phone_hidden');
        const sendBtn = document.getElementById('send_code_button');
        const email = document.getElementById('email')

        if (phone_input) {
            phone_input.addEventListener('input', function (e) {
                let digits = e.target.value.replace(/\D/g, '').substring(0, 10);
                sendBtn.disabled = true;
                let formatted = '';
                if (digits.length < 4) {
                    formatted = '(' + digits;
                } else if (digits.length < 7) {
                    formatted = '(' + digits.substring(0, 3) + ') ' + digits.substring(3);
                } else {
                    formatted = '(' + digits.substring(0, 3) + ') ' + digits.substring(3, 6) + '-' + digits.substring(6);
                }

                e.target.value = formatted;

                const phone_error = document.getElementById('phone_error')
                // Always update hidden input as E.164 (+1XXXXXXXXXX)
                if (digits.length === 10) {
                    sendBtn.disabled = false;
                    phoneHidden.value = '+1' + digits;
                    phone_error.style.display = 'none'

                } else {
                    phoneHidden.value = '';
                    phone_error.style.display = 'block'
                }
            });
        }


        const emailHidden = document.getElementById('email_hidden');
        if (email) {
            email.addEventListener('input', () => {
                emailHidden.value = email.value;
            });
        }
    }

    // Run on initial load
    initPhoneInputHandlers();

    // Re-run after HTMX replaces any elements
    document.body.addEventListener('htmx:afterSwap', function (e) {
        initPhoneInputHandlers();
        initListener()
    });

</script>


<script>
    const startYear = 1950;
    const currentYear = new Date().getFullYear();
    const select = document.getElementById('year');


    for (let year = currentYear; year >= startYear; year--) {
        const option = document.createElement('option');
        option.value = year;
        option.text = year;
        select.appendChild(option);
    }
</script>

{{--From Address--}}
<script>

    document.addEventListener('DOMContentLoaded', () => {
        new TomSelect("#year", {
            create: false,
            sortField: {
                field: "text",
                direction: "desc"
            }
        });

        new TomSelect("#make", {
            create: true,
            sortField: {
                field: "text",
                direction: "asc"
            }
        });


        new TomSelect("#model2", {
            create: true,
            sortField: {
                field: "text",
                direction: "asc"
            }
        });
    });

    // reinitilize tom select after successful request for car models
    document.addEventListener('htmx:afterSettle', function (event) {

        let initiator = event.detail.elt;
        const xhr = event.detail.xhr;
        // console.log(xhr.status)

        if (xhr.status === 200) {
            if (initiator.id === 'modeltarget') {
                new TomSelect("#model", {
                    create: true,
                    sortField: {
                        field: "text",
                        direction: "asc"
                    }
                });
            }
        }

    });


</script>

{{--  Google Places Api--}}
<script>
    // google place suggestions for START address
    let debounceTimer;
    document.getElementById('from').addEventListener('input', function () {
        clearTimeout(debounceTimer); // Clear previous timer

        let query = this.value.trim(); // Use trimmed input

        let suggestionList = document.getElementById('suggestions');

        if (query.length < 2) {
            suggestionList.innerHTML = '';
            suggestionList.style.border = 'none';
            return
        }


        // If input is too short, clear suggestions and return early
        if (query.length < 3) {
            suggestionList.innerHTML = '';
            suggestionList.style.border = 'none';
            return;
        }

        debounceTimer = setTimeout(() => {
            fetch('/placesautocomplete', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': "{{csrf_token()}}",
                },
                body: JSON.stringify({address: query})
            })
                .then(response => response.json())
                .then(data => {
                    let suggestions = [];
                    const suggestions_error = document.getElementById('suggestions_error');

                    // Handle both formats of returned data
                    if (data && typeof data === 'object' && !Array.isArray(data) && Array.isArray(data.suggestions)) {
                        suggestions = data.suggestions;
                    } else if (Array.isArray(data)) {
                        suggestions = data;
                    }

                    // Clear previous suggestions
                    suggestionList.innerHTML = '';

                    if (suggestions.length > 0) {
                        suggestions.forEach(item => {
                            const prediction = item.placePrediction;
                            const description = prediction.text?.text || '';
                            const placeId = prediction.placeId;

                            let li = document.createElement('li');
                            li.textContent = description;
                            li.classList.add('list-group-item');
                            li.onclick = () => {
                                document.getElementById('from').value = description;
                                document.getElementById('start_id').value = placeId;
                                suggestionList.innerHTML = '';
                                suggestionList.style.border = 'none';
                                suggestions_error.style.display = 'none';
                            };

                            suggestionList.appendChild(li);
                        });

                        suggestionList.style.border = '1px solid #ccc';
                    } else {
                        suggestions_error.style.display = 'block';
                        suggestionList.style.border = 'none';
                    }
                });
        }, 100);
    });
    {{--google place suggestions for DESTINATION address --}}
    let debounceTimer2;
    document.getElementById('destination').addEventListener('input', function () {
        clearTimeout(debounceTimer2);

        let query = this.value.trim(); // Clean whitespace
        let suggestionList = document.getElementById('suggestions2');

        if (query.length < 3) {
            suggestionList.innerHTML = '';
            suggestionList.style.border = 'none';
            return;
        }

        debounceTimer2 = setTimeout(() => {
            fetch('/placesautocomplete', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': "{{csrf_token()}}",
                },
                body: JSON.stringify({address: query})
            })
                .then(response => response.json())
                .then(data => {
                    let suggestions = [];

                    if (data && typeof data === 'object' && !Array.isArray(data) && Array.isArray(data.suggestions)) {
                        suggestions = data.suggestions;
                    } else if (Array.isArray(data)) {
                        suggestions = data;
                    }

                    const suggestions_error2 = document.getElementById('suggestions_error2');

                    // Clear previous suggestions
                    suggestionList.innerHTML = '';

                    if (suggestions.length > 0) {
                        suggestions.forEach(item => {
                            const prediction = item.placePrediction;
                            const description = prediction.text?.text || '';
                            const placeId = prediction.placeId;

                            let li = document.createElement('li');
                            li.textContent = description;
                            li.classList.add('list-group-item');
                            li.onclick = () => {
                                document.getElementById('destination').value = description;
                                document.getElementById('destination_id').value = placeId;
                                suggestionList.innerHTML = '';
                                suggestionList.style.border = 'none';
                                suggestions_error2.style.display = 'none';
                            };

                            suggestionList.appendChild(li);
                        });

                        suggestionList.style.border = '1px solid #ccc';
                    } else {
                        suggestions_error2.style.display = 'block';
                        suggestionList.style.border = 'none';
                    }
                });
        }, 100);

    });
</script>

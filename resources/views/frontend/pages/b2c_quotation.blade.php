@extends('frontend.layouts.master')
@section('title') {{ $page->title }} - @endsection
@section('seo')
    @include('components.frontend.socials.seo', ['data' => $page])
@endsection
@push('css')
    <style>
        .custom-input {
            font-size: 0.85rem; /* Smaller text */
            padding: 0.25rem 0.5rem; /* Compact padding */
            border: 1px solid #ccc; /* Light gray border */
            border-radius: 4px; /* Slight rounding */
            outline: none; /* Remove focus outline */
            width: auto; /* Shrink to content if needed */
        }

        .custom-input:focus {
            border-color: #0056b3;
            box-shadow: 0 0 5px rgba(0, 91, 187, 0.5);
        }

        .custom-input::placeholder {
            color: #999;
            font-style: italic;
        }
    </style>
@endpush
@section('header_background')
    <div class="pbmit-title-bar-wrapper" style="background-image: url({{asset($page->src ?: config('filemanager.default_backend_image'))}});">
        <div class="container">
            <div class="pbmit-title-bar-content">
                <div class="pbmit-title-bar-content-inner">
                    <div class="pbmit-tbar">
                        <div class="pbmit-tbar-inner container">
                            <h1 class="pbmit-tbar-title">{{$page->title}}</h1>
                        </div>
                    </div>
                    <div class="pbmit-breadcrumb">
                        <div class="pbmit-breadcrumb-inner">
								<span>
									<a title="" href="#" class="home"><span>{{__('page')}}</span></a>
								</span>
                            <span class="sep">
									<i class="pbmit-base-icon-angle-right"></i>
								</span>
                            <span><span class="post-root post post-post current-item"> {{$page->title}}</span></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')

    <section class="section-lg individual_quotation">
        <div class="container">
            <div class="pbmit-element-posts-wrapper row">
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

            </div>
        </div>

        @include('components.frontend.index_quotation')
    </section>







    <div id="turnstile-business"></div>
    {{--        <div--}}
    {{--            class="cf-turnstile"--}}
    {{--            data-sitekey="0x4AAAAAABmcVARJuH5NYIlN"--}}
    {{--            data-callback="javascriptCallback"--}}
    {{--        ></div>--}}
    <!-- Services end -->


    <div class="b2b_scripts">
        {{--From Address--}}
        <script>
            const startYear2 = 1950;
            const currentYear2 = new Date().getFullYear();
            const select2 = document.getElementById('year2');


            for (let year2 = currentYear2; year2 >= startYear2; year2--) {
                const option2 = document.createElement('option');
                option2.value = year2;
                option2.text = year2;
                select2.appendChild(option2);
            }

            document.addEventListener('DOMContentLoaded', () => {
                new TomSelect("#year2", {
                    create: false,
                    sortField: {
                        field: "text",
                        direction: "desc"
                    }
                });

                new TomSelect("#make2", {
                    create: true,
                    sortField: {
                        field: "text",
                        direction: "asc"
                    }
                });


                new TomSelect("#model3", {
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
                    if (initiator.id === 'modeltarget2') {
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
            let debounceTimer3;
            document.getElementById('start').addEventListener('input', function () {
                clearTimeout(debounceTimer3); // Clear previous timer

                let query2 = this.value.trim(); // Use trimmed input

                let suggestionList2 = document.getElementById('suggestions3');

                if (query2.length < 2) {
                    suggestionList2.innerHTML = '';
                    suggestionList2.style.border = 'none';
                    return
                }


                // If input is too short, clear suggestions and return early
                if (query2.length < 3) {
                    suggestionList2.innerHTML = '';
                    suggestionList2.style.border = 'none';
                    return;
                }

                debounceTimer3 = setTimeout(() => {
                    fetch('/placesautocomplete', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': "{{csrf_token()}}",
                        },
                        body: JSON.stringify({address: query2})
                    })
                        .then(response => response.json())
                        .then(data => {
                            console.log(data)
                            let suggestions3 = [];
                            const suggestions_error3 = document.getElementById('suggestions_error3');

                            // Handle both formats of returned data
                            if (data && typeof data === 'object' && !Array.isArray(data) && Array.isArray(data.suggestions)) {
                                suggestions3 = data.suggestions;
                            } else if (Array.isArray(data)) {
                                suggestions3 = data;
                            }

                            // Clear previous suggestions
                            suggestionList2.innerHTML = '';

                            if (suggestions3.length > 0) {
                                suggestions3.forEach(item => {
                                    const prediction3 = item.placePrediction;
                                    const description3 = prediction3.text?.text || '';
                                    const placeId3 = prediction3.placeId;

                                    let li = document.createElement('li');
                                    li.textContent = description3;
                                    li.classList.add('list-group-item');
                                    li.onclick = () => {
                                        document.getElementById('start').value = description3;
                                        document.getElementById('start_id_business').value = placeId3;
                                        suggestionList2.innerHTML = '';
                                        suggestionList2.style.border = 'none';
                                        suggestions_error3.style.display = 'none';
                                    };

                                    suggestionList2.appendChild(li);
                                });

                                suggestionList2.style.border = '1px solid #ccc';
                            } else {
                                suggestions_error3.style.display = 'block';
                                suggestionList2.style.border = 'none';
                            }
                        });
                }, 100);
            });


            {{--google place suggestions for DESTINATION address --}}
            let debounceTimer4;
            document.getElementById('destination_business').addEventListener('input', function () {
                clearTimeout(debounceTimer4);

                let query = this.value.trim(); // Clean whitespace
                let suggestionList4 = document.getElementById('suggestions4');

                if (query.length < 3) {
                    suggestionList4.innerHTML = '';
                    suggestionList4.style.border = 'none';
                    return;
                }

                debounceTimer4 = setTimeout(() => {
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
                            let suggestions4 = [];

                            if (data && typeof data === 'object' && !Array.isArray(data) && Array.isArray(data.suggestions)) {
                                suggestions4 = data.suggestions;
                            } else if (Array.isArray(data)) {
                                suggestions4 = data;
                            }

                            const suggestions_error4 = document.getElementById('suggestions_error4');

                            // Clear previous suggestions
                            suggestionList4.innerHTML = '';

                            if (suggestions4.length > 0) {
                                suggestions4.forEach(item => {
                                    const prediction = item.placePrediction;
                                    const description = prediction.text?.text || '';
                                    const placeId = prediction.placeId;

                                    let li = document.createElement('li');
                                    li.textContent = description;
                                    li.classList.add('list-group-item');
                                    li.onclick = () => {
                                        document.getElementById('destination_business').value = description;
                                        document.getElementById('destination_id_business').value = placeId;
                                        suggestionList4.innerHTML = '';
                                        suggestionList4.style.border = 'none';
                                        suggestions_error4.style.display = 'none';
                                    };

                                    suggestionList4.appendChild(li);
                                });

                                suggestionList4.style.border = '1px solid #ccc';
                            } else {
                                suggestions_error4.style.display = 'block';
                                suggestionList4.style.border = 'none';
                            }
                        });
                }, 100);

            });
        </script>

        <script>
            // Phone number validation
            function initPhoneInputHandlersBiz() {
                const phone_input_business = document.getElementById('phone_input_business');
                const phoneHidden_business = document.getElementById('phone_hidden_business');
                const sendBtn_business = document.getElementById('send_code_button_business');

                if (phone_input_business) {
                    phone_input_business.addEventListener('input', function (e) {
                        let digits = e.target.value.replace(/\D/g, '').substring(0, 10);
                        sendBtn_business.disabled = true;
                        let formatted = '';
                        if (digits.length < 4) {
                            formatted = '(' + digits;
                        } else if (digits.length < 7) {
                            formatted = '(' + digits.substring(0, 3) + ') ' + digits.substring(3);
                        } else {
                            formatted = '(' + digits.substring(0, 3) + ') ' + digits.substring(3, 6) + '-' + digits.substring(6);
                        }

                        e.target.value = formatted;

                        const phone_error = document.getElementById('phone_error_business')
                        // Always update hidden input as E.164 (+1XXXXXXXXXX)
                        if (digits.length === 10) {
                            sendBtn_business.disabled = false;
                            phoneHidden_business.value = '+1' + digits;
                            phone_error.style.display = 'none'

                        } else {
                            phoneHidden_business.value = '';
                            phone_error.style.display = 'block'
                        }
                    });
                }

            }

            // Run on initial load
            initPhoneInputHandlersBiz();

            // Add Vehicle -> append a row into cars_table_body from current inputs
            document.addEventListener('DOMContentLoaded', function () {
                const addBtn = document.getElementById('add_car');
                const tbody = document.getElementById('cars_table_body');
                const validationBox = document.getElementById('required_fields');
                const otpTarget = document.getElementById('business_otp_target');

                function toggleOtpVisibility() {
                    if (!otpTarget) return;
                    const hasRows = tbody && tbody.querySelectorAll('tr').length > 0;
                    otpTarget.style.display = hasRows ? 'flex' : 'none';
                }

                function showValidationError(text) {
                    if (validationBox) {
                        validationBox.textContent = text;
                        validationBox.style.display = 'block';
                        try {
                            validationBox.scrollIntoView({behavior: 'smooth', block: 'nearest'});
                        } catch (e) {
                        }
                    }
                }

                function clearValidation() {
                    if (validationBox) {
                        validationBox.textContent = '';
                        validationBox.style.display = 'none';
                    }
                }

                // Hide validation as soon as user starts filling any relevant field
                const hideOnInputIds = ['start', 'destination_business', 'year2', 'make2', 'model3'];
                hideOnInputIds.forEach(id => {
                    const el = document.getElementById(id);
                    if (el) {
                        const evt = el.tagName === 'SELECT' ? 'change' : 'input';
                        el.addEventListener(evt, clearValidation);
                    }
                });
                // For radios (transport type and operable)
                document.querySelectorAll('input[name="transport_type"], input[name="operable"]').forEach(r => {
                    r.addEventListener('change', clearValidation);
                });


                function getSelectedTextFromElement(sel) {
                    if (!sel) return '';
                    // If TomSelect is attached, prefer its value/text
                    const ts = sel.tomselect;
                    if (ts) {
                        let val = ts.getValue();
                        if (Array.isArray(val)) val = val[0] || '';
                        if (!val) return '';
                        if (ts.options && ts.options[val] && ts.options[val].text) {
                            return (ts.options[val].text || '').trim();
                        }
                        const item = ts.getItem(val);
                        if (item) return item.textContent.trim();
                    }
                    // Fallback to native select methods
                    const opt = sel.selectedOptions && sel.selectedOptions[0];
                    if (opt && opt.text) return opt.text.trim();
                    return (sel.value || '').trim();
                }

                function getRadioValue(name) {
                    const el = document.querySelector(`input[name="${name}"]:checked`);
                    return el ? el.value : '';
                }

                function reindexRows() {
                    if (!tbody) return;
                    Array.from(tbody.querySelectorAll('tr')).forEach((tr, idx) => {
                        const firstCell = tr.querySelector('td');
                        if (firstCell) firstCell.textContent = String(idx + 1);
                    });
                }

                function attachRemoveHandlers(tr) {
                    const removeBtn = tr.querySelector('.js-remove-row');
                    if (removeBtn) {
                        removeBtn.addEventListener('click', function (e) {
                            // Prevent form/htmx handlers from processing this click on a soon-to-be-removed node
                            e.preventDefault();
                            e.stopPropagation();
                            if (typeof e.stopImmediatePropagation === 'function') {
                                e.stopImmediatePropagation();
                            }
                            // Defer removal so other listeners attached to the element don't run into a detached target
                            setTimeout(() => {
                                tr.remove();
                                reindexRows();
                                toggleOtpVisibility();
                            }, 0);
                        });
                    }
                }

                if (addBtn && tbody) {
                    addBtn.addEventListener('click', function () {

                        // document.getElementById('cars_table').style.display='block'
                        const start = (document.getElementById('start')?.value || '').trim();
                        const destination = (document.getElementById('destination_business')?.value || '').trim();
                        const year = (document.getElementById('year2')?.value || '').trim();
                        const makeText = getSelectedTextFromElement(document.getElementById('make2'));
                        const modelEl = document.getElementById('model3') || document.getElementById('model');
                        const modelText = getSelectedTextFromElement(modelEl);
                        const transportType = getRadioValue('transport_type');
                        const operable = getRadioValue('operable');

                        // Basic validation: ensure key fields are provided
                        if (!start || !destination || !year || !makeText || !modelText) {
                            showValidationError('Please fill Start, Destination, Year, Make and Model to add the vehicle.');
                            return;
                        }

                        const vehicle = `${year} ${makeText} ${modelText}`.trim();

                        const rowNumber = tbody.querySelectorAll('tr').length + 1;

                        const tr = document.createElement('tr');

                        // capture ids as well
                        const startId = (document.getElementById('start_id_business')?.value || '').trim();
                        const destinationId = (document.getElementById('destination_id_business')?.value || '').trim();
                        const makeId = (document.getElementById('make2')?.value || '').trim();
                        const modelId = (modelEl?.value || '').trim();

                        tr.innerHTML = `
                        <td class="text-center">${rowNumber}</td>
                        <td class="text-center">
                            ${start}
                            <input type="hidden" name="start[]" value="${start}">
                            <input type="hidden" name="start_id_business[]" value="${startId}">
                        </td>
                        <td class="text-center">
                            ${destination}
                            <input type="hidden" name="destination[]" value="${destination}">
                            <input type="hidden" name="destination_id_business[]" value="${destinationId}">
                        </td>
                        <td class="text-center">
                            ${vehicle}
                            <input type="hidden" name="year[]" value="${year}">
                            <input type="hidden" name="make_id[]" value="${makeId}">
                            <input type="hidden" name="make_text[]" value="${makeText}">
                            <input type="hidden" name="model_id[]" value="${modelId}">
                            <input type="hidden" name="model_text[]" value="${modelText}">
                        </td>
                        <td class="text-center text-capitalize">
                            ${transportType || '-'}
                            <input type="hidden" name="transport_type[]" value="${transportType}">
                        </td>
                        <td class="text-center text-capitalize">
                            ${operable || '-'}
                            <input type="hidden" name="operable[]" value="${operable}">
                        </td>
                        <td class="text-center">
                            <input type="number" min="1" value="1" name="qty[]" class="custom-input text-center" placeholder="Vehicle QTY">
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-sm btn-link text-danger js-remove-row">Remove</button>
                        </td>
                    `;

                        tbody.appendChild(tr);
                        attachRemoveHandlers(tr);
                        toggleOtpVisibility();
                    });

                    // Attach remove to any pre-existing rows if present
                    Array.from(tbody.querySelectorAll('tr')).forEach(attachRemoveHandlers);
                    // Initialize visibility state on load
                    toggleOtpVisibility();
                }
            });
        </script>
    </div>

    <div  class="individual_scripts">


    </div>


    <script>
        // Show form if turnstile is successfull
        {{--window.onloadTurnstileCallback = function () {--}}
        {{--    turnstile.render("#turnstile-business", {--}}
        {{--        sitekey: "0x4AAAAAABmcVARJuH5NYIlN",--}}
        {{--        callback: function (token) {--}}
        {{--            htmx.ajax('post', '{{route('turnstile.verify')}}', {--}}
        {{--                values: {--}}
        {{--                    cf_token: token,--}}
        {{--                    _token: '{{ csrf_token() }}'--}}
        {{--                },--}}
        {{--                target: '#turnstile-business',--}}
        {{--            });--}}
        {{--        },--}}
        {{--    });--}}
        {{--}--}}

    </script>

@endsection

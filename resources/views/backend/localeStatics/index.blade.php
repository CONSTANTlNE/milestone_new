@extends('backend.layouts.master')
@section('title') {{ __('admin.static_words') }} @endsection
@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin-table.css') }}">
@endsection
@section('content')
    <div class="content">
        <div class="main-content static-words">
            <div class="block justify-between page-header md:flex">
                <div>
                    <h3 class="!text-defaulttextcolor dark:!text-defaulttextcolor/70 dark:text-white dark:hover:text-white text-[1.375rem] font-semibold font-first-geo">
                        {{ __('admin.static_words') }}
                    </h3>
                    <p class="font-second-geo text-defaulttextcolor/70">{{ __('admin.welcome') }}</p>
                </div>
                @can('backend.locales.index')
                        <div class="flex items-center whitespace-nowrap min-w-0 gap-3 addNewLanguage">
                            <form class="flex gap-3 form-valide form-inline" method="POST" action="{{ route('backend.translation.create') }}">
                                @csrf
                                <div class="form-group has-float-label col-4 w-100">
                                    <label class="font-w600 font-second-geo" for="localeKey">
                                        {{ __('admin.main_keywords') }} (Key)
                                        <span class="text-danger"> *</span>
                                    </label>
                                    <div class="w-100 position-relative pb-3">
                                        <input type="text" name="localeKey" id="localeKey"
                                               class="form-control font-second-geo"
                                               data-required="{{ __('admin.error_invalid_key') }}"
                                               data-minlength="{{ __('admin.error_key') }}">
                                    </div>
                                </div>
                                <div class="form-group has-float-label col-5 pl-0">
                                    <label class="font-w600 font-second-geo" for="localeValue">
                                        {{ __('admin.word') }} ({{ __('admin.first_added_main_language') }} - {{ $default->title }})
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="w-100 position-relative pb-3">
                                        <input type="text" name="localeValue" id="localeValue"
                                               class="form-control font-second-geo"
                                               data-required="{{ __('admin.error_value') }}"
                                               data-minlength="{{ __('admin.error_invalid_value') }}">
                                    </div>
                                </div>
                                <button class="add-static-btn ti-btn ti-btn-info-full text-white !font-medium font-second-geo" type="submit"><i class="ri-add-line"></i></button>

                                <a href="{{ route('backend.localeStatics.index') }}" class="add-static-btn-reset ti-btn bg-warning text-white !font-medium font-second-geo"><i class="ri-refresh-line"></i></a>
                            </form>
                        </div>
                    @endcan
            </div>
            <x-backend.alert-messages />

            <div class="grid grid-cols-12 gap-6 index-table-page white-bg">
                <div class="xl:col-span-12 col-span-12">
                    <div class="box custom-box">
                        <div class="box-body">
                            <div class="table-responsive">
                                @can('backend.locales.index')
                                <table class="table whitespace-nowrap table-bordered min-w-full" id="datatablesTable">
                                    <thead class="bg-primary/10">
                                    <tr class="border-b border-primary/10">
                                        <th class="static-key">Key</th>
                                        @if($languages->count() > 0)
                                            @foreach($languages as $language)
                                                <th scope="col" class="static-{{$language->code}} text-start">{{ $language->title }} ({{ $language->code }})</th>
                                            @endforeach
                                        @endif
                                        <th scope="col" class="static-actions"><i class="ri ri-tools-fill header-link-icon text-[1.125rem]"></i></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if($columnsCount > 0)
                                        @foreach($columns[array_key_first($columns)] as $columnKey => $columnValue)
                                            <tr>
                                                <td>
                                                    <label class="translate-key"
                                                           data-title="Enter Key"
                                                           data-type="text"
                                                           data-pk="{{ $columnKey }}"
                                                           data-url="{{ route('backend.translation.update.json.key') }}">
                                                        {{ $columnKey }}
                                                    </label>
                                                </td>
                                                @for($i=1; $i<=$columnsCount; ++$i)
                                                    <td>
                                                        <label class="translate"
                                                               data-title="Enter Translate"
                                                               data-code="{{ $columns[$i]['lang'] }}"
                                                               data-name="{{ isset($columns[$i]['data'][$columnKey]) ? $columns[$i]['data'][$columnKey] : '' }}"
                                                               data-type="textarea" data-pk="{{ $columnKey }}"
                                                               data-url="{{ route('backend.translation.update.json') }}">
                                                            {!! isset($columns[$i]['data'][$columnKey]) ? $columns[$i]['data'][$columnKey] : '<span class="emptyText"><i class="ri-add-line"></i></span>' !!}
                                                        </label>
                                                    </td>
                                                @endfor
                                                <td>
                                                    <button class="add-static-btn-remove ti-btn ti-btn-danger-full text-white !font-medium cursor-pointer font-second-geo remove-key"
                                                            data-pk="{{$columnKey}}"
                                                            data-action="{{ route('backend.translation.destroy') }}">
                                                        <i class="ri-delete-bin-2-fill"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                                @endcan
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('scripts')
<script>

    if(document.getElementsByClassName("static-words")){
        let currentTranslate = {
            rowType: null,
            row: null,
            el: null,
            type: null,
            pk: null,
            url: null,
            code: null,
            name: null
        };

        // Use event delegation for better performance and to handle dynamic content
        document.addEventListener('click', function(event) {
            // Handle translate-key clicks
            if (event.target.classList.contains('translate-key') || event.target.closest('.translate-key')) {
                const translateKeyElement = event.target.classList.contains('translate-key') ? event.target : event.target.closest('.translate-key');
                onTranslateKeyClick(translateKeyElement, 'key', event);
            }

            // Handle translate clicks
            if (event.target.classList.contains('translate') || event.target.closest('.translate')) {
                const translateElement = event.target.classList.contains('translate') ? event.target : event.target.closest('.translate');
                onTranslateKeyClick(translateElement, 'value', event);
            }

            // Handle remove button clicks
            if (event.target.classList.contains('remove-key') || event.target.closest('.remove-key')) {
                event.preventDefault();
                const removeButton = event.target.classList.contains('remove-key') ? event.target : event.target.closest('.remove-key');

                const url = removeButton.getAttribute("data-action");
                const pk = removeButton.getAttribute("data-pk");
                const parentRow = removeButton.parentElement.parentElement;

                fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                    body: JSON.stringify({ key: pk }),
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! Status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    parentRow.remove();
                })
                .catch(error => {
                    console.error('Error:', error.message);
                    // Handle error, display a message, or perform other actions
                });
            }
        });

        function onPopupAnswer(state) {
            if (state) {
                const http = new XMLHttpRequest();
                let data;

                data = {
                    pk: currentTranslate.pk,
                    value: currentTranslate.el.children[0].value,
                    code: currentTranslate.code,

                };

                http.open("POST", currentTranslate.url, false);
                http.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
                http.setRequestHeader('Content-Type', 'application/json');
                http.onload = () => {
                    currentTranslate.row.innerHTML = data.value;

                    document.getElementById("temp-popup").remove();
                    currentTranslate = {
                        rowType: null,
                        row: null,
                        el: null,
                        type: null,
                        pk: null,
                        url: null,
                        code: null,
                        name: null,
                    };
                };
                http.send(JSON.stringify(data));
            } else {
                document.getElementById("temp-popup").remove();
                currentTranslate = {
                    rowType: null,
                    row: null,
                    el: null,
                    type: null,
                    pk: null,
                    url: null,
                    code: null,
                    name: null,
                };
            }
        }

        function renderPopup(el, type, value, name) {
            const prev = document.getElementById("temp-popup");
            if (prev) {
                prev.remove();
            }
            const parent = el.parentElement;
            const popupParent = parent.classList.add("popupParent");


            const input = type === "textarea" ? `<textarea  class="form-control" rows="3" cols="50">${name}</textarea>` : `<input type="${type}" class="form-control" value="${value}">`;

            const element = document.createElement("div");
            element.classList.add("popup");
            element.id = "temp-popup";
            element.innerHTML += input;
            element.innerHTML += '<button onclick="onPopupAnswer(false)" class="add-static-btn-remove ti-btn ti-btn-danger-full text-white !font-medium cursor-pointer font-second-geo"><i class="ri-close-line"></i></button><button onclick="onPopupAnswer(true)" class="add-static-btn-remove ti-btn ti-btn-info-full text-white !font-medium cursor-pointer font-second-geo"><i class="ri-add-line"></i></button>';

            parent.appendChild(element);
            return element;
        }

        function onTranslateKeyClick(el, rowType, event) {
            const type = el.getAttribute("data-type");
            const pk = el.getAttribute("data-pk");
            const url = el.getAttribute("data-url");
            const code = el.getAttribute("data-code");
            const name = el.getAttribute("data-name");

            const popup = renderPopup(el, type, pk, name);

            currentTranslate = {
                rowType: rowType,
                row: el,
                el: popup,
                type: type,
                pk: pk,
                url: url,
                code: code,
                name: name
            };
        }
    }
</script>
@endpush

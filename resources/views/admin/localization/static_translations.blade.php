@extends('admin.admin_layout')

@section('staticTranslation')

    @push('css')
        <link rel="stylesheet" href="https://cdn.datatables.net/2.0.0/css/dataTables.dataTables.css">
    @endpush
    @if(session('error'))
        <div class="alert alert-danger mt-5" role="alert">
            {{ session('error') }}
        </div>
    @endif
    <div class="box mt-5">
        <form class="" action="{{route('storeStaticTranslations')}}" method="POST">
            @csrf
            <div class="box-header justify-between">
                <div class="box-title">
                    Add Static Translations
                </div>
            </div>
            <div class="mt-4  sm:mb-0 input-group flex justify-center">
                <div class="input-group-text">key</div>
                <input style="max-width: 250px" type="text" class="form-control"
                       name="key">
            </div>
            <div class="box-body grid grid-cols-2 gap-4 items-center">
                <br>
                @foreach($locales as $index => $locale)
                    <div class="mb-4 sm:mb-0 input-group  col-span-2">
                        <div class="input-group-text">{{$locale['abbr']}}</div>
                        <textarea @required($main===$locale['abbr']) class="form-control" name="{{$locale['abbr']}}" id="translation{{$index}}" cols="30" rows="5"></textarea>
                    </div>
                @endforeach


            </div>
            <div class="flex justify-center  p-5">
                <button type="submit" class="ti-btn ti-btn-primary-full !mb-0">Add Translation</button>
            </div>
        </form>
    </div>

    <div class="flex justify-center gap-3 mt-2 mb-2">
        <form action="{{route('autotranslate')}}" method="post" class="flex justify-center">
            @csrf
            <label for="from_file">From File</label>
            <select id="from_file" class="form-control" name="from_file">
                <option value="">Select</option>
                @foreach($locales as $key => $locale)
                    <option value="{{$locale['abbr']}}">{{$locale['abbr']}}</option>
                @endforeach
            </select>

            <label for="to_file">Translation</label>
            <select id="to_file" class="form-control" name="to_file">
                <option value="">Select</option>
                @foreach($locales as $key => $locale)
                    <option value="{{$locale['abbr']}}">{{$locale['abbr']}}</option>
                @endforeach
            </select>

            <button class="ti-btn ti-btn-primary-full !mb-0">Translate</button>
        </form>
    </div>

    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-12">
            <div class="box">
                <div class="box-header">
                    <h5 class="box-title">Static Translations</h5>
                </div>
                <div class="box-body">
                    <div class="overflow-auto">
                        <div id="basic-table" class="ti-custom-table ti-striped-table ti-custom-table-hover">
                            <form id="updateForm" action="{{route('updateStaticTranslation')}}" method="post">
                                @csrf
                                <table class="text-center" id="static-lang" style="width:100%">
                                    <thead>
                                    <tr>
                                        <th style="text-align: center;width: 300px">Key</th>
                                        @foreach($locales as $index => $locale)
                                            <th style="text-align: center">{{$locale['abbr']}}</th>
                                        @endforeach
                                        <th style="text-align: center">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php
                                        $counter = -1; // Initialize counter variable
                                    @endphp
                                    @foreach($keys as $index=> $key)
                                        @php
                                            $counter++;
                                        @endphp

                                        <tr>
                                            <td style="max-width: 300px!important" >
                                                <p style="max-width: 300px!important">  {{$key}}</p>

                                            </td>
                                            @foreach($jsonData as $abbr => $language)
                                                <td>
                                                    <input data-form-abbr="{{$index}}" name="abbr[]" type="hidden" value="{{$abbr}}" disabled>
                                                    <input data-form-key="{{$index}}"  name="key[]" type="hidden" value="{{$key}}" disabled>
                                                    <textarea  disabled  class="form-control translation"  data-translation="{{$index}}" name="translation[]">@if(isset ($language[$key])) {{$language[$key]}} @endif</textarea>
                                                    {{--                                                    <input--}}
                                                    {{--                                                            @if($main===$abbr && !isset ($language[$key])) style="border-color:red" @endif--}}
                                                    {{--                                                            data-translation="{{$index}}" name="translation[]"--}}
                                                    {{--                                                           value="@if(isset ($language[$key])) {{$language[$key]}} @endif" type="text"--}}
                                                    {{--                                                            class="form-control translation"--}}
                                                    {{--                                                           placeholder="No Translation" disabled="">--}}
                                                </td>
                                            @endforeach
                                            {{--                                                @php dd($index) @endphp--}}
                                            <td class="flex justify-center align-middle gap-2">
                                                <span data-edit="{{$index}}"
                                                      style="cursor: pointer;color:blue"
                                                      class="material-symbols-outlined edit-translation">edit</span>
                                                <span data-submit="{{$index}}"
                                                      style="display: none;cursor: pointer;color:green"
                                                      class="material-symbols-outlined">done</span>
                                                <span data-cancel-submit="{{$index}}"
                                                      style="display: none;cursor: pointer;color:red"
                                                      class="material-symbols-outlined">close</span>
                                                <span data-delete="{{$index}}"
                                                      style="display: none;cursor: pointer;color:red"
                                                      class="material-symbols-outlined">delete</span>
                                                <input style="display:none" data-deleteinput="{{$index}}"
                                                       name="delete"
                                                       value="delete" type="text"
                                                       class="form-control translation"
                                                       placeholder="Disabled input" disabled="">
                                            </td>

                                        </tr>

                                    @endforeach

                                    </tbody>
                                </table>
                            </form>

                            {{--                            </form>--}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{--    @foreach($jsonData as $fileName =>$language)--}}
    {{--        @php--}}
    {{--            $extension = str_replace('.json', '', $fileName);--}}
    {{--            $langCode = substr($extension, 0, 2);--}}
    {{--        @endphp--}}
    {{--        @if(key($language)!='')--}}
    {{--            <tr>--}}
    {{--                <td>{{$langCode}}</td>--}}
    {{--                <td>{{ key($language) }}</td>--}}
    {{--                <td>{{ $language[key($language)] }}</td>--}}
    {{--                <td></td>--}}
    {{--            </tr>--}}
    {{--        @endif--}}
    {{--    @endforeach--}}

    <!-- edit static traslation -->

        <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
        <script src="https://cdn.datatables.net/2.0.0/js/dataTables.js"></script>

    <script>
        new DataTable('#static-lang', {
            autoWidth: false
        });

        const updateForm2 = document.getElementById('updateForm')

        if (updateForm2) {

            updateForm2.addEventListener('mouseover', (e) => {
                editTranslationButtons = document.querySelectorAll(`[data-edit]`)
                // console.log(editTranslationButtons)
                editTranslationButtons.forEach((el, index) => {

                    el.addEventListener('click', e => {

                        document.querySelectorAll('[data-form-abbr="' + el.getAttribute('data-edit') + '"]').forEach(element => {
                            element.removeAttribute('disabled');
                        });
                        document.querySelectorAll('[data-form-key="' + el.getAttribute('data-edit') + '"]').forEach(element => {
                            element.removeAttribute('disabled');
                        });

                        document.querySelectorAll('[data-key="' + el.getAttribute('data-edit') + '"]').forEach(element => {
                            element.removeAttribute('disabled');
                        });

                        document.querySelectorAll('[data-translation="' + el.getAttribute('data-edit') + '"]').forEach(element => {
                            element.removeAttribute('disabled');
                            element.setAttribute('rows', 10);
                        });

                        document.querySelectorAll('[data-abbr="' + el.getAttribute('data-edit') + '"]').forEach(element => {
                            element.removeAttribute('disabled');
                        });

                        document.querySelectorAll('[data-submit="' + el.getAttribute('data-edit') + '"]').forEach(element => {
                            element.style.display = 'block';
                        });
                        document.querySelectorAll('[data-cancel-submit="' + el.getAttribute('data-edit') + '"]').forEach(element => {
                            element.style.display = 'block';
                        });

                        document.querySelectorAll('[data-delete="' + el.getAttribute('data-edit') + '"]').forEach(element => {
                            element.style.display = 'block';
                        });

                    });

                    // Cancel Edit

                    const cancelEdit = document.querySelectorAll('[data-cancel-submit="' + el.getAttribute('data-edit') + '"]');
                    cancelEdit.forEach((eli) => {
                        eli.addEventListener('click', e => {
                            console.log('clicked')

                            document.querySelectorAll('[data-form-abbr="' + el.getAttribute('data-edit') + '"]').forEach(element => {
                                element.setAttribute('disabled', '');
                            });
                            document.querySelectorAll('[data-form-key="' + el.getAttribute('data-edit') + '"]').forEach(element => {
                                element.setAttribute('disabled', '');
                            });

                            document.querySelectorAll('[data-submit="' + eli.getAttribute('data-cancel-submit') + '"]').forEach(element => {
                                element.style.display = 'none';
                            });
                            console.log(document.querySelectorAll('[data-submit="' + eli.getAttribute('data-cancel-submit') + '"]'))

                            document.querySelectorAll('[data-cancel-submit="' + eli.getAttribute('data-cancel-submit') + '"]').forEach(element => {
                                element.style.display = 'none';
                            });
                            document.querySelectorAll('[data-delete="' + eli.getAttribute('data-cancel-submit') + '"]').forEach(element => {
                                element.style.display = 'none';
                            });
                            document.querySelectorAll('[data-key="' + eli.getAttribute('data-cancel-submit') + '"]').forEach(element => {
                                element.setAttribute('disabled', '');
                            });

                            document.querySelectorAll('[data-abbr="' + eli.getAttribute('data-cancel-submit') + '"]').forEach(element => {
                                element.setAttribute('disabled', '');
                            });

                            document.querySelectorAll('[data-translation="' + eli.getAttribute('data-cancel-submit') + '"]').forEach(element => {
                                element.setAttribute('disabled', '');
                                element.setAttribute('rows', 2);

                            });
                        })
                    })
                    // Submit and update Translations

                    const submitTranslationUpdate = document.querySelectorAll('[data-submit="' + el.getAttribute('data-edit') + '"]');

                    submitTranslationUpdate.forEach((updt) => {
                        updt.addEventListener('click', e => {
                            updateForm.submit()
                        })
                    })


                    // Delete Particular Translations
                    const deleteTranslation = document.querySelectorAll('[data-delete="' + el.getAttribute('data-edit') + '"]');

                    deleteTranslation.forEach((dlt1) => {
                        dlt1.addEventListener('click', e => {
                            console.log('delete clicked')
                            console.log(document.querySelectorAll('[data-deleteinput="' + el.getAttribute('data-edit') + '"]'))
                            document.querySelectorAll('[data-deleteinput="' + el.getAttribute('data-edit') + '"]').forEach(dlt => {
                                dlt.removeAttribute('disabled');
                                console.log(dlt)

                            });

                            updateForm.submit()
                        })
                    })
                });
            })
        }

    </script>
@endsection
@extends('admin.admin_layout')

@section('languages')

    <div class="grid grid-cols-12 gap-x-6">
        <div class="xxl:col-span-8 xl:col-span-6 lg:col-span-6 md:col-span-6 col-span-12">
            <div class="box">
                <div class="box-header justify-between">
                    <div class="box-title">
                        Add Language
                    </div>
                </div>
                <div class="box-body">
                    <form class="grid grid-cols-6 gap-4 items-center" action="{{route('createLanguage')}}"
                          method="post">
                        @csrf
                        <div class="col-span-12">
                            <div class="mb-4 sm:mb-0 input-group">
                                <div class="input-group-text">Icon</div>
                                <input type="text" class="form-control"
                                       id="icon" name="icon" placeholder='Icon..'>
                            </div>
                            <div class="flex gap-4 mt-3 flex-wrap sm:flex-nowrap">
                                <div class="mb-4 sm:mb-0 input-group">
                                    <div class="input-group-text">Abbr</div>
                                    <input type="text" class="form-control"
                                           id="inlineFormInputGroupUsername" name="abbr" placeholder='en,ka,ru...'>
                                </div>
                                <div class="mb-4 sm:mb-0 input-group">
                                    <div class="input-group-text">Language</div>
                                    <input type="text" class="form-control"
                                           id="inlineFormInputGroupUsername" name="language" placeholder='English..'>
                                </div>
                                <button type="submit" class="ti-btn ti-btn-primary-full !mb-0 ">Add</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="xxl:col-span-4 xl:col-span-4 lg:col-span-6 md:col-span-6 col-span-12">
            <div class="box">
                <div class="box-header justify-between">
                    <div class="box-title">
                        Languages
                    </div>
                </div>
                <div class="box-body">
                    <form id="positionForm" action="{{route('changePosition')}}">
                        <ul class="list-none mb-0 lang-container">
                            @foreach($languages as $index => $language)
                                <li draggable="true" class="mb-4 draggable-lang">
                                    <div class="flex tems-center">
                                        <input type="hidden" name="id[]" value="{{$language['id']}}">
                                        <input class="position" type="hidden" name="position[]"
                                               value="{{$language['position']}}">
                                        <div class="leading-none">
                            <span style="width: 32px; height: 32px" class="inline-flex justify-center items-center">
                               {!! $language['icon'] !!}
                            </span>
                                        </div>
                                        <div class="flex-grow ms-2 justify-center align-middle">
                                            <p class="font-semibold mt-1 text-center">{{$language['language']}}</p>
                                        </div>
                                        <div>
                                            <span class="text-success font-semibold">{{$language['abbr']}}</span>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-12">
            <div class="box">
                <div class="box-header">
                    <h5 class="box-title">Basic DataTable</h5>
                </div>
                <div class="box-body">
                    <div class="overflow-auto">
                        <div id="basic-table" class="ti-custom-table ti-striped-table ti-custom-table-hover">
                            <table class="text-center" id="lang" class="display" style="width:100%">
                                <thead>
                                <tr>
                                    <th style="text-align: center">key</th>
                                    <th style="text-align: center">Language</th>
                                    <th style="text-align: center">Status</th>
                                    <th style="text-align: center">Main</th>

                                    <th style="text-align: center">action</th>

                                </tr>
                                </thead>
                                <tbody>
                                @foreach($languages as $index =>$language)
                                    <tr>
                                        <td>{{$language->abbr}}</td>
                                        <td>{{$language->language}}</td>
                                        <td class="flex justify-center align-middle">
                                            <form data-descr="langStatusForm" id="langStatusForm{{$index}}"
                                                  action="{{route('updateLangStatus')}}" method="post">
                                                @csrf
                                                <input type="hidden" name="id" value="{{$language->id}}">
                                                <div class="custom-toggle-switch  mb-4">
                                                    <input type="checkbox"
                                                           {{--                                                           id="hs-basic-with-description-checked"--}}
                                                           id="langStatusSwitch{{$index}}"
                                                           class="ti-switch"
                                                           onclick="this.form.submit()"
                                                            @checked($language->active==1)>
                                                    <label for="langStatusSwitch{{$index}}"
                                                           class="label-success"></label>
                                                    <span class="ms-3"></span>
                                                </div>
                                            </form>
                                        </td>
                                        <td>
                                            <form style="cursor:pointer" action="{{route('setMainLang')}}"
                                                  method="post">
                                                @csrf
                                                <input type="hidden" name="id" value="{{$language->id}}">
                                                <button style="all:unset">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                         viewBox="0 0 24 24">
                                                        <path fill="{{$language->main==1 ? '#2ea627' : '#dfdfdf' }}"
                                                              d="M9 16.17L4.83 12l-1.42 1.41L9 19L21 7l-1.41-1.41z"/>
                                                    </svg>
                                                    </span>
                                                </button>
                                            </form>
                                        </td>
                                        <td>
                                            @if($language->main!==1)
                                                <form action="{{route('deleteLanguage')}}" method="post">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{$language->id}}">
                                                    <input type="hidden" name="abbr" value="{{$language->abbr}}">
                                                    <button style="all:unset;color:red;cursor:pointer">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                             viewBox="0 0 24 24">
                                                            <path fill="#b32907"
                                                                  d="M7 21q-.825 0-1.412-.587T5 19V6q-.425 0-.712-.288T4 5t.288-.712T5 4h4q0-.425.288-.712T10 3h4q.425 0 .713.288T15 4h4q.425 0 .713.288T20 5t-.288.713T19 6v13q0 .825-.587 1.413T17 21zM17 6H7v13h10zm-7 11q.425 0 .713-.288T11 16V9q0-.425-.288-.712T10 8t-.712.288T9 9v7q0 .425.288.713T10 17m4 0q.425 0 .713-.288T15 16V9q0-.425-.288-.712T14 8t-.712.288T13 9v7q0 .425.288.713T14 17M7 6v13z"/>
                                                        </svg>
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>

                                @endforeach
                                </tbody>
                                {{--                                <tfoot>--}}
                                {{--                                <tr>--}}
                                {{--                                    <th>Abbr</th>--}}
                                {{--                                    <th>Language</th>--}}
                                {{--                                    <th>Status</th>--}}
                                {{--                                    <th>Main</th>--}}
                                {{--                                </tr>--}}
                                {{--                                </tfoot>--}}
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Drag and Drop Functionality--}}
    <script>
        const draggables = document.querySelectorAll(".draggable-lang");
        const containers = document.querySelectorAll(".lang-container");

        // Ajax request
        function updatePosition() {
            const positionForm = document.getElementById('positionForm')
            const formData = new FormData(positionForm);
            fetch('{{ route('changePosition') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-Token': document.querySelector('meta[name="CSRF"]').content,
                    },
                    body: formData
                }
            )
                .then(response => response.json())
                .catch(error => console.error('Error:', error));
        }


        draggables.forEach((draggable) => {
            draggable.addEventListener("dragstart", () => {
                draggable.classList.add("dragging");
            });

            // UPDATE VALUES OF INPUTS and SEND AJAX
            draggable.addEventListener("dragend", () => {
                draggable.classList.remove("dragging");

                updateDataAttributes();
                updatePosition()
            });
        });

        containers.forEach((container) => {
            container.addEventListener("dragover", (e) => {
                e.preventDefault();
                const afterElement = getDragAfterElement(container, e.clientY);
                const draggable = document.querySelector(".dragging");
                if (afterElement == null) {
                    container.appendChild(draggable);

                } else {
                    container.insertBefore(draggable, afterElement);
                }
            });
        });

        function getDragAfterElement(container, y) {
            const draggableElements = [
                ...container.querySelectorAll(".draggable-lang:not(.dragging)"),
            ];

            return draggableElements.reduce(
                (closest, child) => {
                    const box = child.getBoundingClientRect();
                    const offset = y - box.top - box.height / 2;
                    if (offset < 0 && offset > closest.offset) {
                        return {offset: offset, element: child};
                    } else {
                        return closest;
                    }
                },
                {offset: Number.NEGATIVE_INFINITY}
            ).element;
        }

        function updateDataAttributes() {
            // Get all draggable elements
            const draggables = document.querySelectorAll(".position");
            // Loop through each draggable element
            draggables.forEach((draggable, index) => {
                // Update data-data attribute value
                draggable.value = index + 1;
            });
        }

    </script>

@endsection
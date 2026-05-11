@extends('backend.layouts.master')
@section('title')
    {{ __('strings.Quotation') }}
@endsection
@section('content')

    <div class="overlay" id="overlay" style="display:none;">
        <svg xmlns="http://www.w3.org/2000/svg" width="250" height="250" viewBox="0 0 24 24">
            <g>
                <rect width="2" height="5" x="11" y="1" fill="currentColor" opacity="0.14"/>
                <rect width="2" height="5" x="11" y="1" fill="currentColor" opacity="0.29"
                      transform="rotate(30 12 12)"/>
                <rect width="2" height="5" x="11" y="1" fill="currentColor" opacity="0.43"
                      transform="rotate(60 12 12)"/>
                <rect width="2" height="5" x="11" y="1" fill="currentColor" opacity="0.57"
                      transform="rotate(90 12 12)"/>
                <rect width="2" height="5" x="11" y="1" fill="currentColor" opacity="0.71"
                      transform="rotate(120 12 12)"/>
                <rect width="2" height="5" x="11" y="1" fill="currentColor" opacity="0.86"
                      transform="rotate(150 12 12)"/>
                <rect width="2" height="5" x="11" y="1" fill="currentColor" transform="rotate(180 12 12)"/>
                <animateTransform attributeName="transform" calcMode="discrete" dur="0.75s" repeatCount="indefinite"
                                  type="rotate"
                                  values="0 12 12;30 12 12;60 12 12;90 12 12;120 12 12;150 12 12;180 12 12;210 12 12;240 12 12;270 12 12;300 12 12;330 12 12;360 12 12"/>
            </g>
        </svg>
    </div>
    <!-- Start::content  -->
    <div class="content">

        <!-- Start::main-content -->
        <div class="main-content">
            <!-- Page Header -->
            <div class="block justify-between page-header md:flex">
                <div class="flex flex-col md:flex-row md:items-center md:justify-center gap-4 w-full align-middle items-center">
                    <h3 class="!text-defaulttextcolor dark:!text-defaulttextcolor/70 dark:text-white dark:hover:text-white text-[1.125rem] font-semibold">
                        B2B Quotations
                    </h3>

                        <form action="{{ route('backend.b2b_quotations.index') }}" method="GET" class="flex items-center gap-2">
                            <div class="relative">
                                <input type="text" name="q" value="{{ request('q') }}" placeholder="Search quotations..."
                                       class="ti-form-input w-64" />
                            </div>
                            <div>
                                <input type="date" name="date_from" value="{{ request('date_from') }}" class="ti-form-input" placeholder="From date" />
                            </div>
                            <div>
                                <input type="date" name="date_to" value="{{ request('date_to') }}" class="ti-form-input" placeholder="To date" />
                            </div>
                            <button type="submit" class="ti-btn ti-btn-primary">Filter</button>
                            @if(request('q')|| request('date_from') || request('date_to'))
                                <a href="{{ route('backend.b2b_quotations.index') }}" class="ti-btn ti-btn-outline-secondary">Clear</a>
                            @endif
                        </form>
                        <a href="javascript:void(0);"
                           class="hs-dropdown-toggle ti-btn ti-btn-primary-full  mb-0"
                           data-hs-overlay="#users">
                            Users
                        </a>
                        <div id="users"
                             class="hs-overlay hidden ti-modal  [--overlay-backdrop:static]">
                            <div class="hs-overlay-open:mt-7 ti-modal-box mt-0 ease-out">
                                <div class="ti-modal-content" style="background: lightgrey">
                                    <form
                                        action="{{route('backend.b2b_quotations.notify-users')}}"
                                        method="post">
                                        @csrf
                                        <div class="ti-modal-header">
                                            <h6 class="modal-title text-[1rem] font-semibold">
                                                Send new B2B quotation notification to user
                                            </h6>
                                            <button type="button"
                                                    class="hs-dropdown-toggle !text-[1rem] !font-semibold !text-defaulttextcolor"
                                                    data-hs-overlay="#users">
                                                <span class="sr-only">Close</span>
                                                <i class="ri-close-line"></i>
                                            </button>
                                        </div>
                                        <div class="ti-modal-body px-0 ">
                                            @foreach($users as $user)
                                                <div class="flex justify-between mt-2">
                                                    <label for="user{{$user->id}}" class="gap-2 flex items-center cursor-pointer">
                                                        <input id="user{{$user->id}}"
                                                               type="checkbox"
                                                               name="users[]"
                                                               @checked($user->send_b2b_quotation)
                                                               value="{{$user->id}}" class="form-check-input">
                                                        {{$user->name}}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="flex justify-center gap-4 mt-4">
                                            <button type="button"
                                                    class="hs-dropdown-toggle ti-btn  ti-btn-secondary-full align-middle"
                                                    data-hs-overlay="#users">
                                                Close
                                            </button>
                                            <button type="submit"
                                                    class="hs-dropdown-toggle ti-btn  ti-btn-secondary-full align-middle">
                                                Update
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <div class="justify-between">
                            <div class="box-title box-show-number gap-5">
                                <a href="{{ route('backend.b2b_quotations.export') }}"
                                   class="ti-btn bg-success text-white !font-medium font-second-geo">
                                    <i class="fas fa-file-excel me-1"></i>
                                    {{ __('admin.export_excel') }}
                                </a>
                            </div>
                        </div>
                </div>
            </div>
            <!-- Page Header Close -->
            @if ($errors->any())
                <div class="bg-danger/20 border border-danger/20 text-sm text-danger/80 rounded-lg p-4" role="alert">
                    <div class="flex justify-center">
                        <div class="flex-shrink-0">
                            <svg class="flex-shrink-0 size-4 mt-0.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><path d="m15 9-6 6"></path><path d="m9 9 6 6"></path></svg>
                        </div>
                        <div class="ms-4">
                            <h3 class="text-sm font-semibold">
                                A problem has been occurred while submitting your data.
                            </h3>
                            <div class="mt-2 text-sm text-red-700 dark:text-red-400">
                                <ul class="list-disc space-y-1 ps-5">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            @if (session('error'))
                <div class="bg-danger/20 border-s-4 border-danger p-4 dark:bg-danger/20" role="alert">
                    <div class="flex justify-center">
                        <div class="flex-shrink-0">
                            <!-- Icon -->
                            <span class="inline-flex justify-center items-center size-8 rounded-full border-1 border-danger bg-danger/40 text-red-800 dark:border-danger dark:bg-danger/20 dark:text-red-400">
                                              <svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"></path><path d="m6 6 12 12"></path></svg>
                                            </span>
                            <!-- End Icon -->
                        </div>
                        <div class="ms-3">
                            <h6 class="text-gray-800 font-semibold dark:text-white">
                                Error!
                            </h6>
                            <p class="text-sm text-gray-700 dark:text-gray-400">
                                {{session('error')}}
                            </p>
                        </div>
                    </div>
                </div>
            @endif
            <!-- Start:: row-11 -->
            <div class="grid grid-cols-12 gap-6 index-table-page">
                <div class="xl:col-span-12 col-span-12">
                    <div class="box custom-box">
                        <div class="box-body">
                            <div class="table-responsive">
                                <table class="table whitespace-nowrap table-bordered min-w-full" id="datatablesTable">
                                    <thead class="bg-primary/10">
                                    <tr class="border-b border-primary/10">
                                        <th id="move-th" scope="col" class="move bg-warning text-center hidden">
                                            <i class="ri-drag-move-2-line text-white"></i>
                                        </th>
                                        @can('backend.sliders.massDestroy')
                                            <th scope="col" class="select-number !text-start">
                                                <input class="form-check-input cursor-pointer" type="checkbox"
                                                       id="select-all">
                                            </th>
                                        @endcan
                                        <th scope="col" class="title text-center">#</th>
                                        <th scope="col" class="id text-center sortable"
                                            data-sort="id">{{ __('admin.id') }}</th>
                                        <th scope="col" class="title text-center">Date</th>
                                        <th scope="col" class="title text-center">Unique ID</th>
                                        <th scope="col" class="title text-center">Request Type</th>
                                        <th scope="col" class="title text-center">Start Address</th>
                                        <th scope="col" class="title text-center">End Address</th>
                                        <th scope="col" class="title text-center">Distance</th>
                                        <th scope="col" class="title text-center">Transportation Type</th>
                                        <th scope="col" class="title text-center">Operable</th>
                                        <th scope="col" class="title text-center">Vehicle</th>
                                        <th scope="col" class="title text-center">Vehicle Specs <p>(inch / lbs)</p></th>
                                        <th scope="col" class="title text-center">Vehicle Type</th>
                                        <th scope="col" class="title text-center">Vehicle Links</th>
                                        <th scope="col" class="title text-center">Availability</th>
                                        <th scope="col" class="title text-center">Email</th>
                                        <th scope="col" class="title text-center">Phone</th>
                                        <th scope="col" class="title text-center">Calculate</th>
                                        <th scope="col" class="title text-center">Total Charge</th>
                                        <th scope="col" class="title text-center">Action</th>
                                        <th scope="col" class="title text-center">Quotation Sent By</th>
                                        <th scope="col" class="title text-center">Approved by Customer</th>
                                    </tr>
                                    </thead>
                                    <tbody id="socials-tbody">
                                    @forelse($quotations as $quotation_index => $quotation)
                                        <tr class="product-list border-b border-primary/10"
                                            data-id="{{$quotation->id}}">
                                            <td>{{$quotation_index+1}}</td>
                                            <td class="drag-handle-cell text-center hidden">
                                                <span class="drag-handle" style="display:none;">&#9776;</span>
                                            </td>
                                            @can('backend.sliders.massDestroy')
                                                <td class="text-center">
                                                    <input class="form-check-input list-checkbox-item cursor-pointer"
                                                           type="checkbox" value="{{$quotation->id}}">
                                                </td>
                                            @endcan
                                            <td>
                                                {{$quotation->id}}
                                            </td>
                                            <td>{{$quotation->created_at->format('d/m/Y')}}</td>
                                            <td>{{$quotation->quotation_identifier}}</td>
                                            <td>{{$quotation->request_type}}</td>
                                            <td>{{$quotation->start_address}}</td>
                                            <td>{{$quotation->destination_address}}</td>
                                            <td>
                                                <p>{{$quotation->distance_mile}}</p>
                                                @if(!$quotation->distance_mile)
                                                    <form action="{{route('backend.b2b_quotations.calculatedistance')}}"
                                                          method="post">
                                                        @csrf
                                                        <input type="hidden" name="quotation_id"
                                                               value="{{$quotation->id}}">
                                                        <button
                                                            onclick="showOverlay()"
                                                            class="ti-btn ti-btn-secondary-full ti-btn-wave">
                                                            Distance
                                                        </button>
                                                    </form>
                                                @endif
                                            </td>
                                            <td>{{$quotation->transport_type}}</td>
                                            <td>{{$quotation->operable}}</td>
                                            <td>{{$quotation->vehicle}}</td>
                                            <td>
                                                @if($quotation->body_weight)
                                                    <p>Width : {{$quotation->width}}</p>
                                                    <p>Height : {{$quotation->height}}</p>
                                                    <p>Length : {{$quotation->length}}</p>
                                                    <p>Weight : {{$quotation->body_weight}}</p>
                                                @else
                                                    <form action="{{route('backend.b2b_quotations.airequest')}}"
                                                          method="post">
                                                        @csrf
                                                        <input type="hidden" name="quotation_id"
                                                               value="{{$quotation->id}}">
                                                        <button type="submit"
                                                                onclick="showOverlay()"
                                                                class="ti-btn ti-btn-secondary-full ti-btn-wave">
                                                            Get Specs
                                                        </button>
                                                    </form>
                                                @endif
                                            </td>
                                            <td>{{$quotation->car_type}}</td>
                                            <td>
                                                {{-- {{$quotation->specs_links}} --}}
                                                @forelse (collect($quotation->specs_links)->take(3) as $specIndex => $link)
                                                    <a href="{{ $link }}" target="_blank">Link {{ $specIndex + 1 }}</a>
                                                    <br>
                                                @empty
                                                    <p>No specs links available.</p>
                                                @endforelse
                                            </td>
                                            <td>{{$quotation->availability}}</td>
                                            <td>{{$quotation->email}}</td>
                                            <td>{{$quotation->phone}}</td>
                                            <td class="text-center">
                                                <form action="{{route('backend.b2b_quotations.calculatecost')}}"
                                                      class="flex flex-col gap-2"
                                                      style="min-width: 200px"
                                                      method="post">
                                                    @csrf
                                                    <input type="hidden" name="quotation_id" value="{{$quotation->id}}">
                                                    <div class="flex gap-4 justify-center mt-1">
                                                        <input class="form-check-input"
                                                               type="checkbox"
                                                               @checked($quotation->suv==1)
                                                               value="1"
                                                               name="suv"
                                                               id="suv{{$quotation->id}}">
                                                        <label class="form-check-label" for="suv{{$quotation->id}}">
                                                            SUV
                                                        </label>
                                                        <input class="form-check-input"
                                                               type="checkbox"
                                                               value="1"
                                                               @checked($quotation->luxury==1)
                                                               name="luxury"
                                                               id="luxury{{$quotation->id}}"
                                                        >
                                                        <label class="form-check-label" for="luxury{{$quotation->id}}">
                                                            LUXURY
                                                        </label>
                                                    </div>
                                                    <input type="text"
                                                           class="form-control"
                                                           name="custom_charge_name"
                                                           placeholder="Custom Charge Name">
                                                    <input type="number"
                                                           class="form-control"
                                                           name="custom_charge_value"
                                                           min="1" step="0.5"
                                                           placeholder="Custom Charge amount">
                                                    <button type="submit" class="ti-btn ti-btn-primary-full">Calculate
                                                    </button>
                                                </form>
                                            </td>
                                            <td class="text-center">
                                                @if($quotation->calculated_cost)
                                                    <a href="javascript:void(0);"
                                                       class="hs-dropdown-toggle ti-btn ti-btn-primary-full "
                                                       data-hs-overlay="#surcharge_details{{$quotation->id}}">
                                                        Details
                                                    </a>
                                                    <div id="surcharge_details{{$quotation->id}}"
                                                         class="hs-overlay hidden ti-modal  [--overlay-backdrop:static]">
                                                        <div class="hs-overlay-open:mt-7 ti-modal-box mt-0 ease-out">
                                                            <div class="ti-modal-content">
                                                                <div class="ti-modal-header">
                                                                    <h6 class="modal-title text-[1rem] font-semibold">
                                                                        Detailed Charge for
                                                                        Quotation# {{$quotation->id}}
                                                                    </h6>
                                                                    <button type="button"
                                                                            class="hs-dropdown-toggle !text-[1rem] !font-semibold !text-defaulttextcolor"
                                                                            data-hs-overlay="#surcharge_details{{$quotation->id}}">
                                                                        <span class="sr-only">Close</span>
                                                                        <i class="ri-close-line"></i>
                                                                    </button>
                                                                </div>
                                                                <div class="ti-modal-body px-4">


                                                                    @foreach($quotation->surcharges as $surcharge_index => $surcharge)
                                                                        <div class="flex gap-2">
                                                                            <p class="w-full">{{$surcharge['name']}}</p>
                                                                            <form
                                                                                id="surcharge_update{{$quotation->id}}{{$surcharge_index}}"
                                                                                action="{{route('backend.b2b_quotations.update-charge')}}"
                                                                                method="post">
                                                                                @csrf
                                                                                <input type="hidden" name="quotation_id"
                                                                                       value="{{$quotation->id}}">
                                                                                <input type="number" min="1" step="0.5"
                                                                                       class="form-control w-full"
                                                                                       name="surcharge_value"
                                                                                       value="{{round($surcharge['value'])}}">
                                                                                <input type="hidden"
                                                                                       name="surcharge_id"
                                                                                       value="{{$surcharge['id']}}">
                                                                            </form>

                                                                            <form
                                                                                id="surcharge_delete{{$quotation->id}}{{$surcharge_index}}"
                                                                                action="{{route('backend.b2b_quotations.delete-charge')}}"
                                                                                method="post">
                                                                                @csrf
                                                                                <input type="hidden"
                                                                                       name="surcharge_id"
                                                                                       value="{{$surcharge['id']}}">
                                                                                <input type="hidden" name="quotation_id"
                                                                                       value="{{$quotation->id}}">
                                                                            </form>

                                                                            <button
                                                                                form="surcharge_update{{$quotation->id}}{{$surcharge_index}}"
                                                                                type="submit"
                                                                                class="ti-btn ti-btn-success-full ti-btn-wave">
                                                                                Update
                                                                            </button>
                                                                            <button
                                                                                form="surcharge_delete{{$quotation->id}}{{$surcharge_index}}"
                                                                                type="submit"
                                                                                class="ti-btn ti-btn-danger-full ti-btn-wave">
                                                                                Delete
                                                                            </button>
                                                                        </div>
                                                                    @endforeach

                                                                </div>
                                                                <div class="flex justify-center">
                                                                    <button type="button"
                                                                            class="hs-dropdown-toggle ti-btn  ti-btn-secondary-full align-middle"
                                                                            data-hs-overlay="#surcharge_details{{$quotation->id}}">
                                                                        Close
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                                <p>{{ round($quotation->calculated_cost)}} $</p>
                                            </td>
                                            <td class="text-center">

                                                {{--                                                <form action="{{route('backend.quotations.approve')}}" method="post">--}}
                                                {{--                                                    @csrf--}}
                                                {{--                                                    <input type="hidden" name="quotation_id" value="{{$quotation->id}}">--}}
                                                {{--                                                    @if($quotation->approved==0)--}}
                                                {{--                                                        <button type="submit"--}}
                                                {{--                                                                class="hs-dropdown-toggle ti-btn  ti-btn-secondary-full align-middle">--}}
                                                {{--                                                            Approve--}}
                                                {{--                                                        </button>--}}
                                                {{--                                                    @else--}}
                                                {{--                                                        <button type="submit"--}}
                                                {{--                                                                class="ti-btn ti-btn-secondary-full ti-btn-wave">--}}
                                                {{--                                                            Approved--}}
                                                {{--                                                        </button>--}}
                                                {{--                                                    @endif--}}
                                                {{--                                                </form>--}}
                                                @if(round($quotation->calculated_cost) != 0 && $identifiersFullyCalculated->has($quotation->quotation_identifier))
                                                    <form action="{{route('backend.b2b_quotations.sendoffer')}}"
                                                          method="post">
                                                        @csrf
                                                        <input type="hidden" name="identifier"
                                                               value="{{$quotation->quotation_identifier}}">
                                                        <button type="submit"
                                                                onclick="showOverlay()"
                                                                class="hs-dropdown-toggle ti-btn  ti-btn-secondary-full align-middle">
                                                            Send Quotation
                                                        </button>
                                                        @if($quotation->quotation_sent_date)
                                                            <p>{{$quotation->quotation_sent_date}}</p>
                                                        @endif
                                                    </form>



                                                    <a href="javascript:void(0);"
                                                       class="ti-btn ti-btn-danger-full ti-btn-wave"
                                                       data-hs-overlay="#delete{{$quotation->id}}">
                                                        Delete
                                                    </a>
                                                    <div id="delete{{$quotation->id}}"
                                                         class="hs-overlay hidden ti-modal  [--overlay-backdrop:static]">
                                                        <div class="hs-overlay-open:mt-7 ti-modal-box mt-0 ease-out">
                                                            <div class="ti-modal-content">
                                                                <div class="ti-modal-header">
                                                                    <h6 class="modal-title text-[1rem] font-semibold">
                                                                        Delete
                                                                        Quotation# {{$quotation->id}}
                                                                    </h6>
                                                                    <button type="button"
                                                                            class="hs-dropdown-toggle !text-[1rem] !font-semibold !text-defaulttextcolor"
                                                                            data-hs-overlay="#delete{{$quotation->id}}">
                                                                        <span class="sr-only">Close</span>
                                                                        <i class="ri-close-line"></i>
                                                                    </button>
                                                                </div>
                                                                <div class="ti-modal-body px-4">
                                                                    <p>Are you sure you want to delete Quotation ?</p>
                                                                </div>
                                                                <div class="flex justify-center gap-4">
                                                                    <button type="button"
                                                                            class="hs-dropdown-toggle ti-btn  ti-btn-secondary-full align-middle"
                                                                            data-hs-overlay="#delete{{$quotation->id}}">
                                                                        Close
                                                                    </button>
                                                                    <form action="{{route('backend.b2b_quotations.delete')}}" method="post">
                                                                        @csrf
                                                                        <input type="hidden" name="id" value="{{$quotation->id}}">
                                                                        <button type="submit"
                                                                                class="ti-btn ti-btn-danger-full ti-btn-wave">
                                                                            Yes
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                @if($quotation->quotation_sent_date)
                                                    <p>{{$quotation->user->name}}</p>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if($quotation->approved)
                                                    approved
                                                @else
                                                    pending
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr class="empty-state">
                                            <td colspan="7" class="text-center py-8">
                                                {{--                                                <x-backend.table.empty-state--}}
                                                {{--                                                    :actionText="__('admin.create_first_slider')"--}}
                                                {{--                                                    permission="backend.quotations.create"--}}
                                                {{--                                                />--}}
                                            </td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <x-backend.pagination :paginator="$quotations"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End::content  -->
@endsection
@push('scripts')
    <script>
        function showOverlay() {
            document.getElementById('overlay').style.display = 'flex';
        }

    </script>
@endpush

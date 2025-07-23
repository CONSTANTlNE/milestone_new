@extends('backend.layouts.master')
@section('title') {{ __('strings.Quotation') }} @endsection
@section('content')
    <!-- Start::content  -->
    <div class="content">
        <!-- Start::main-content -->
        <div class="main-content">
            <!-- Page Header -->
            <div class="block justify-between page-header md:flex">
                <div>
                    <h3 class="!text-defaulttextcolor dark:!text-defaulttextcolor/70 dark:text-white dark:hover:text-white text-[1.125rem] font-semibold"> Quotations</h3>
                </div>
            </div>
            <!-- Page Header Close -->
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
                                                <input class="form-check-input cursor-pointer" type="checkbox" id="select-all">
                                            </th>
                                        @endcan
                                        <th scope="col" class="id text-start sortable" data-sort="id">{{ __('admin.id') }}</th>
                                        <th scope="col" class="title text-start">Date</th>
                                        <th scope="col" class="title text-start">Start Address</th>
                                        <th scope="col" class="title text-start">End Address</th>
                                        <th scope="col" class="title text-start">Distance</th>
                                        <th scope="col" class="title text-start">Transportation Type</th>
                                        <th scope="col" class="title text-start">Operable</th>
                                        <th scope="col" class="title text-start">Vehicle</th>
                                        <th scope="col" class="title text-start">Vehicle Specs <p>(inch / lbs)</p></th>
                                        <th scope="col" class="title text-start">Vehicle Type</th>
                                        <th scope="col" class="title text-start">Vehicle Links</th>
                                        <th scope="col" class="title text-start">Availability</th>
                                        <th scope="col" class="title text-start">Email</th>
                                        <th scope="col" class="title text-start">Phone</th>
                                        <th scope="col" class="title text-start">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody id="socials-tbody">
                                    @forelse($quotations as $quotation)
                                        <tr class="product-list border-b border-primary/10" data-id="{{$quotation->id}}">
                                            <td class="drag-handle-cell text-center hidden">
                                                <span class="drag-handle" style="display:none;">&#9776;</span>
                                            </td>
                                            @can('backend.sliders.massDestroy')
                                                <td class="text-center">
                                                    <input class="form-check-input list-checkbox-item cursor-pointer" type="checkbox" value="{{$quotation->id}}">
                                                </td>
                                            @endcan
                                            <td>
                                                {{$quotation->id}}
                                            </td>
                                            <td>{{$quotation->created_at->format('d/m/Y')}}</td>
                                            <td>{{$quotation->start_address}}</td>
                                            <td>{{$quotation->destination_address}}</td>
                                            <td>
                                                <p>{{$quotation->distance_mile}}</p>
                                                <form action="{{route('backend.quotations.calculatedistance')}}" method="post">
                                                    @csrf
                                                    <input type="hidden" name="quotation_id" value="{{$quotation->id}}">
                                                    <button>
                                                        <i style="color: green; font-size: 1.5rem;"
                                                           class="ri-calculator-line"></i>
                                                    </button>
                                                </form>
                                            </td>
                                            <td>{{$quotation->transport_type}}</td>
                                            <td>{{$quotation->operable}}</td>
                                            <td>{{$quotation->vehicle}}</td>
                                            <td>
                                                <p>Width : {{$quotation->width}}</p>
                                                <p>Height : {{$quotation->height}}</p>
                                                <p>Length : {{$quotation->length}}</p>
                                                <p>Weight : {{$quotation->body_weight}}</p>
                                            </td>
                                            <td>{{$quotation->car_type}}</td>
                                            <td>
                                                {{--                                        {{$quotation->specs_links}}--}}
                                                @forelse (collect($quotation->specs_links)->take(3) as $specIndex => $link)
                                                    <a href="{{ $link }}" target="_blank">Link {{ $specIndex + 1 }}</a><br>
                                                @empty
                                                    <p>No specs links available.</p>
                                                @endforelse
                                            </td>
                                            <td>{{$quotation->availability}}</td>
                                            <td>{{$quotation->email}}</td>
                                            <td>{{$quotation->phone}}</td>
                                            <td>
                                                <form action="{{route('backend.quotations.airequest')}}" method="post">
                                                    @csrf
                                                    <input type="hidden" name="quotation_id" value="{{$quotation->id}}">
                                                    <button>
                                                        <i style="color: green; font-size: 1.5rem;"
                                                           class="ri-delete-bin-line"></i>
                                                    </button>
                                                </form>
                                                <form action="{{route('backend.quotations.delete')}}" method="post">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{$quotation->id}}">
                                                    <button>
                                                        <i style="color: red; font-size: 1.5rem;"
                                                           class="ri-delete-bin-line"></i>
                                                    </button>
                                                </form>
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
                        <x-backend.pagination :paginator="$quotations" />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End::content  -->
@endsection
@push('scripts')
@endpush

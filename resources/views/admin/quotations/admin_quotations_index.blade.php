@extends('admin.admin_layout')

@section('admin_quotations_page')

    @push('css')
        <style>
            th {
                text-align: center !important;
                background-color: #2B2E31
            }

            td {
                text-align: center !important;
            }

            .page {
                min-height: 100%;
            }
        </style>
    @endpush

    <div class="grid grid-cols-12 gap-6 mt-3">
        <div class="col-span-12">
            <div class="box">
                <div class="box-header">
                    <h5 class="box-title">Quotations</h5>
                </div>
                <div class="box-body">
                    <div class="table-responsive" style="max-height: calc(100vh - 245px)">
                        <table class="table whitespace-nowrap ti-striped-table min-w-full">
                            <thead>
                            <tr class="text-center">
                                <th scope="col" class="sticky top-0  z-10">Date</th>
                                <th scope="col" class="sticky top-0  z-10">Start Address</th>
                                <th scope="col" class="sticky top-0  z-10">End Address</th>
                                <th scope="col" class="sticky top-0  z-10">Distance</th>
                                <th scope="col" class="sticky top-0  z-10">Transportation Type</th>
                                <th scope="col" class="sticky top-0  z-10">Operable</th>
                                <th scope="col" class="sticky top-0 z-10">Vehicle</th>
                                <th scope="col" class="sticky top-0 z-10">Availability</th>
                                <th scope="col" class="sticky top-0 z-10">Email</th>
                                <th scope="col" class="sticky top-0  z-10">Phone</th>
                                <th scope="col" class="sticky top-0  z-10">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($quotations as $index =>$quotation)
                                <tr>
                                    <td>{{$quotation->created_at->format('d/m/Y')}}</td>
                                    <td>{{$quotation->start_address}}</td>
                                    <td>{{$quotation->destination_address}}</td>
                                    <td>
                                        <form action="{{route('distance.calculate')}}" method="post">
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
                                    <td>{{$quotation->availability}}</td>
                                    <td>{{$quotation->email}}</td>
                                    <td>{{$quotation->phone}}</td>
                                    <td>
                                        <form action="{{route('quotation.delete')}}" method="post">
                                            @csrf
                                            <input type="hidden" name="id" value="{{$quotation->id}}">
                                            <button>
                                                <i style="color: red; font-size: 1.5rem;"
                                                   class="ri-delete-bin-line"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                            {{--  <tfoot>--}}
                            {{--   <tr>--}}
                            {{--                                    <th>Abbr</th>--}}
                            {{--                                    <th>Language</th>--}}
                            {{--                                    <th>Status</th>--}}
                            {{--   <th>Main</th>--}}
                            {{--  </tr>--}}
                            {{--   </tfoot>--}}
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
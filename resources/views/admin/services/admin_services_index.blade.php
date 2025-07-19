@extends('backend.layouts.master')
@section('title') {{ __('admin.sidebar_blogs') }} @endsection
@section('styles')

        <link rel="stylesheet" href="{{ asset('css/admin-table.css') }}">
@endsection
@section('content')
    <div class="content">
        <div class="main-content">

    <a href="{{route('backend.service.multiply')}}">create 5 copies</a>
    <div class="grid grid-cols-12 gap-6 mt-3">
        <div class="col-span-12">
            <div class="box">

                <div class="box-header">
                    <h5 class="box-title">Services</h5>
                </div>
                <div class="box-body">
                    <div class="table-responsive" style="max-height: calc(100vh - 245px)">
                        <table class="table whitespace-nowrap ti-striped-table min-w-full">
                            <thead  class="bg-light">
                            <tr class="text-center">
                                <th scope="col" class="sticky top-0  z-10">Date</th>
                                <th scope="col" class="sticky top-0  z-10">Name</th>
                                <th scope="col" class="sticky top-0  z-10">Short Description</th>
                                <th scope="col" class="sticky top-0  z-10">Description</th>
                                <th scope="col" class="sticky top-0  z-10">Features</th>
                                <th scope="col" class="sticky top-0  z-10">F.A.Q</th>
                                <th scope="col" class="sticky top-0  z-10">Images</th>
                                <th scope="col" class="sticky top-0  z-10">Check</th>
                                <th scope="col" class="sticky top-0 z-10">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($services as $index =>$service)
                                <tr>
                                    <td>{{$service->created_at->format('d/m/Y')}}</td>
                                    <td>
                                        <a href="javascript:void(0);"
                                           class="hs-dropdown-toggle ti-btn ti-btn-primary-full"
                                           data-hs-overlay="#eidit_name{{$index}}">
                                            {{$service->name}}
                                        </a>
                                        @include('admin.services.modals.service_name_edit_modal')
                                    </td>
                                    <td>

                                        <button type="button"
                                                class="hs-dropdown-toggle ti-btn ti-btn-primary-full"
                                                hx-get="{{route('backend.service.get.htmx')}}"
                                                hx-target="#editshortdescr{{$index}}"
                                                hx-vals='{"service_id": "{{$service->id}}","data_request": "short_description"}'
                                                data-hs-overlay="#edit_shortdescription{{$index}}">
                                            Edit Short Description
                                        </button>
                                        @include('admin.services.modals.service_shortdescription_edit_modal')
                                    </td>
                                    <td>

                                        <button type="button"
                                                class="hs-dropdown-toggle ti-btn ti-btn-primary-full"
                                                hx-get="{{route('backend.service.get.htmx')}}"
                                                hx-target="#editlongdescr{{$index}}"
                                                hx-vals='{"service_id": "{{$service->id}}","data_request": "long_description"}'
                                                data-hs-overlay="#edit_longdescription{{$index}}">
                                            Edit Short Description
                                        </button>
                                        @include('admin.services.modals.service_longdescription_edit_modal')
                                    </td>
                                    <td>
                                        <button type="button"
                                                class="hs-dropdown-toggle ti-btn ti-btn-primary-full"
                                                hx-get="{{route('backend.service.get.htmx')}}"
                                                hx-target="#editfeatures{{$index}}"
                                                hx-vals='{"service_id": "{{$service->id}}","data_request": "service_features"}'
                                                data-hs-overlay="#edit_features{{$index}}">
                                            Edit Features
                                        </button>
                                        @include('admin.services.modals.service_features_edit_modal')
                                    </td>
                                    <td></td>
                                    <td>
                                        <button type="button"
                                                class="hs-dropdown-toggle ti-btn ti-btn-primary-full"
                                                hx-get="{{route('backend.service.get.htmx')}}"
                                                hx-target="#editimages{{$index}}"
                                                hx-vals='{"service_id": "{{$service->id}}","data_request": "service_images","index":"{{$index}}"}'
                                                data-hs-overlay="#edit_images{{$index}}">
                                            Edit Images
                                        </button>
                                        @include('admin.services.modals.service_images_edit_modal')
                                    </td>
                                    <td>
                                        <a target="_blank"
                                           href="{{route('backend.service.single',['slug'=>$service->slug])}}#service_single"
                                           type="button" class="ti-btn ti-btn-link ti-btn-wave">Check </a>
                                    </td>
                                    <td>
                                        <div class="flex justify-center gap-2">
                                            <a target="_blank" href="{{route('backend.service.edit',$service->id)}}"
                                               style="color:blue;font-size: 1.5rem"><i class="ri-edit-line"></i>
                                            </a>
                                            <form action="{{route('backend.service.delete')}}" method="post">
                                                @csrf
                                                <input type="hidden" name="service_id" value="{{$service->id}}">
                                                <button style="color:red;font-size: 1.5rem">
                                                    <i class="ri-delete-bin-line"></i>
                                                </button>
                                            </form>
                                        </div>
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
        </div>
    </div>
@endsection

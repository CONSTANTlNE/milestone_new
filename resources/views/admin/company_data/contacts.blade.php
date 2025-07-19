@extends('admin.admin_layout')


@section('contact_info_page')

    @push('css')
        <style>
            th {
                text-align: center !important;
            }

            .page {
                min-height: 100%;
            }

            .wdt500 {
                width: 500px !important;
            }

            .wdt300 {
                max-width: 500px !important;
            }
        </style>
    @endpush


    {{--    contact info--}}
    <div class="grid grid-cols-12 gap-6 mt-3">
        <div class="col-span-12">
            <div class="box">
                <div class="box-header">
                    <h5 class="box-title">Contacts</h5>
                </div>
                <div class="box-body">
                    <div class="table-responsive" style="max-height: calc(100vh - 245px)">
                        <form action="{{route('contactinfo.update')}}" method="post">
                            @csrf
                            <table class="table whitespace-nowrap table-bordered  min-w-full">
                                <thead class="bg-light">
                                <tr class="text-center border-b border-defaultborder">
                                    <th scope="col" class="sticky top-0  z-10">Email</th>
                                    <th scope="col" class="sticky top-0  z-10">Phone</th>
                                    <th scope="col" class="sticky top-0  z-10">Address</th>
                                    <th scope="col" class="sticky top-0  z-10">Working Days</th>
                                    <th scope="col" class="sticky top-0  z-10">Update</th>
                                </tr>
                                </thead>
                                <tbody>

                                <tr class="border-b border-defaultborder">
                                    <td>
                                        <input class="form-control" type="text" name="email"
                                               value="{{$contact?->email}}">
                                    </td>
                                    <td>
                                        <input class="form-control" type="text" name="phone"
                                               value="{{$contact?->phone}}">
                                    </td>
                                    <td>
                                        <input class="form-control" type="text" name="address"
                                               value="{{$contact?->address}}">
                                    </td>
                                    <td>
                                        <input class="form-control" type="text" name="working_days"
                                               value="{{$contact?->working_days}}">
                                    </td>
                                    <td class="flex justify-center">
                                        <button type="submit" class="ti-btn ti-btn-light ti-btn-wave">Update</button>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{--socials--}}
    <div class="grid grid-cols-12 gap-6 mt-3">
        <div class="col-span-12">
            <div class="box">
                <div class="box-header">
                    <h5 class="box-title">Socials</h5>
                </div>
                <form class="box-body" method="post" action="{{route('socials.store')}}">
                    @csrf
                    <div class="flex gap-4  flex-wrap sm:flex-nowrap">
                        <div class="w-full">
                            <label for="input-label" class="form-label">Socials Name</label>
                            <input type="text" name="name" class="form-control" value="{{old('name')}}">
                        </div>
                        <div class="w-full">
                            <label for="input-label" class="form-label">Socials URL</label>
                            <input type="text" name="url" class="form-control" value="{{old('url')}}">
                        </div>
                        <div class="w-full">
                            <label for="input-label" class="form-label">Socials icon SVG</label>
                            <input type="text" name="icon" class="form-control" value="{{old('icon')}}">
                        </div>
                        <div  style="min-width: 25px">
                            <label for="input-label" class="form-label">Icon Width</label>
                            <input type="number" min="1" name="width" class="form-control" value="25">
                        </div>
                        <div style="min-width: 25px">
                            <label for="input-label" class="form-label">Height</label>
                            <input type="number" min="1" name="height" class="form-control" value="25">
                        </div>
                        <div>
                            <div style="height: 26px"></div>
                            <button type="submit" class="ti-btn ti-btn-light ti-btn-wave">Create</button>
                        </div>
                    </div>
                </form>
                <div class="box-body">
                    <div class="table-responsive" style="max-height: calc(100vh - 245px)">
                        <table class="table whitespace-nowrap table-bordered  min-w-full">
                            <thead class="bg-light">
                            <tr class="text-center border-b border-defaultborder">
                                <th scope="col" class="sticky top-0  z-10">Socials Name</th>
                                <th scope="col" class="sticky top-0  z-10">Socials URL</th>
                                <th scope="col" class="sticky top-0  z-10">Socials icon</th>
                                <th scope="col" class="sticky top-0  z-10">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($socials as $socialindex => $social)

                                <tr class="border-b border-defaultborder">

                                    <td>
                                        <p class="text-center">{{$social->name }}</p>
                                    </td>
                                    <td>
                                        <div class="flex justify-center">
                                            <a href="{{$social->url}}">{{$social->url}}</a>
                                        </div>
                                    </td>
                                    <td >
                                        <div class="flex justify-center">
                                            {!! $social->icon !!}
                                        </div>
                                    </td>
                                    <td  class="flex justify-center gap-3">
                                        <a href="javascript:void(0);"
                                           class="hs-dropdown-toggle ti-btn ti-btn-light ti-btn-wave"
                                           data-hs-overlay="#edit_social{{$socialindex}}">
                                            Edit Social
                                        </a>
                                        <div id="edit_social{{$socialindex}}"
                                             class="hs-overlay hidden ti-modal  [--overlay-backdrop:static]">
                                            <div class="hs-overlay-open:mt-7 ti-modal-box mt-0 ease-out">
                                                <form class="ti-modal-content" method="post"
                                                      action="{{route('socials.update')}}">
                                                    @csrf
                                                    <input type="hidden" value="{{$social->id}}" name="social_id">
                                                    <div class="ti-modal-header">
                                                        <h6 class="modal-title text-[1rem] font-semibold">Edit
                                                            Social</h6>
                                                        <button type="button"
                                                                class="hs-dropdown-toggle !text-[1rem] !font-semibold !text-defaulttextcolor"
                                                                data-hs-overlay="#edit_social{{$socialindex}}">
                                                            <span class="sr-only">Close</span>
                                                            <i class="ri-close-line"></i>
                                                        </button>
                                                    </div>
                                                    <div class="ti-modal-body px-4 overflow-hidden">
                                                        <div class="flex gap-4  flex-wrap">
                                                            <div class="w-full flex flex-col">
                                                                <label for="input-label" class="form-label">Socials
                                                                    Name</label>
                                                                <input type="text" name="name" class="form-control"
                                                                       value="{{$social->name}}">
                                                            </div>
                                                            <div class="w-full flex flex-col">
                                                                <label for="input-label" class="form-label">Socials
                                                                    URL</label>
                                                                <input type="text" name="url" class="form-control"
                                                                       value="{{$social->url}}">
                                                            </div>
                                                            <div class="w-full flex flex-col">
                                                                <label for="input-label" class="form-label">Socials icon
                                                                    SVG</label>
                                                                <input type="text" name="icon" class="form-control"
                                                                       value="{{$social->icon}}">
                                                            </div>
                                                            <div  style="min-width: 25px"  class="flex flex-col">
                                                                <label for="input-label" class="form-label">Icon Width</label>
                                                                <input type="number" min="1" name="width" class="form-control" value="{{old('icon')}}">
                                                            </div>
                                                            <div style="min-width: 25px" class="flex flex-col">
                                                                <label for="input-label" class="form-label">Height</label>
                                                                <input type="number" min="1" name="height" class="form-control" value="{{old('icon')}}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="ti-modal-footer">
                                                        <button type="button"
                                                                class="hs-dropdown-toggle ti-btn  ti-btn-secondary-full align-middle"
                                                                data-hs-overlay="#edit_social{{$socialindex}}">
                                                            Close
                                                        </button>
                                                        <button type="submit"
                                                                class="ti-btn bg-primary text-white !font-medium">Update
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <form action="{{route('socials.delete')}}" method="post">
                                            @csrf
                                            <input type="hidden" name="social_id" value="{{$social->id}}">
                                            <button type="submit" class="ti-btn ti-btn-danger-full ti-btn-wave">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
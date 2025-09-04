@extends('backend.layouts.master')
@section('title')
    {{ __('strings.Quotation') }}
@endsection
@section('content')
    <!-- Start::content  -->
    <div class="content">
        <!-- Start::main-content -->
        <div class="main-content">
            <!-- Page Header -->
            <div class="block justify-between page-header md:flex">
                <div>
                    <h3 class="!text-defaulttextcolor dark:!text-defaulttextcolor/70 dark:text-white dark:hover:text-white text-[1.125rem] font-semibold">
                        Quuotation Surcharges</h3>
                </div>
            </div>
            <div class="flex justify-center">
                <div class="xl:col-span-6 col-span-6">
                    <form action="{{route('backend.quotation_charge.store')}}" method="post">
                        @csrf
                        <div class="flex justify-center flex-wrap gap-4 mb-2">
                            <div class="sm:col-span-3 col-span-3">
                                <input type="text" class="form-control" placeholder="Charge Name"
                                       name="name"
                                       aria-label="Charge Name">
                            </div>
                            <div class="sm:col-span-1 col-span-1">
                                <input type="number" min="0.1" step="0.01" class="form-control" placeholder="Amount"
                                       name="surcharge"
                                       aria-label="Amount">
                            </div>
                        </div>
                        <div class="flex justify-center">
                            <button type="submit" class="ti-btn ti-btn-primary-full">Create</button>
                        </div>
                    </form>
                </div>
            </div>


            <!-- Page Header Close -->
            <!-- Start:: row-11 -->
            <div class="flex justify-center">
                <div class="grid grid-cols-12 gap-6 index-table-page">
                    <div class="xl:col-span-12 col-span-12">
                        <div class="box custom-box">
                            <div class="box-body">
                                <div class="table-responsive">
                                    <table class="table whitespace-nowrap table-bordered min-w-full"
                                           id="datatablesTable">
                                        <thead class="bg-primary/10">
                                        <tr class="border-b border-primary/10">
                                            <th id="move-th" scope="col" class="move bg-warning text-center hidden">
                                                <i class="ri-drag-move-2-line teffsdfsdfxt-white"></i>
                                            </th>
                                            @can('backend.sliders.massDestroy')
                                                <th scope="col" class="select-number !text-start">
                                                    <input class="form-check-input cursor-pointer" type="checkbox"
                                                           id="select-all">
                                                </th>
                                            @endcan
                                            <th scope="col" class="title text-center">#</th>
                                            <th scope="col" class="title text-center">Date</th>
                                            <th scope="col" class="title text-center">Name</th>
                                            <th scope="col" class="title text-center">Surcharge</th>
                                            <th scope="col" class="title text-center">Active</th>
                                        </thead>
                                        <tbody id="socials-tbody">
                                        @forelse($charges as $charge_index => $charge)
                                            <tr class="product-list border-b border-primary/10"
                                                data-id="{{$charge->id}}">
                                                <td class="text-center">{{$charge_index+1}}</td>
                                                <td class="text-center">{{$charge->created_at->format('d/m/Y')}}</td>
                                                <td class="text-center">{{$charge->name}}</td>
                                                <td class="text-center">
                                                    <form action="{{route('backend.quotation_charge.update')}}"
                                                          class="flex flex-col justify-center gap-2"
                                                          method="post">
                                                        @csrf
                                                        <input type="hidden" value="{{$charge->id}}" name="charge_id">
                                                        <input type="number" min="0.1" step="0.01" class="form-control"
                                                               placeholder="Amount"
                                                               name="amount"
                                                               aria-label="Amount"
                                                               value="{{$charge->surcharge}}">
                                                        <button type="submit" class="ti-btn ti-btn-primary-full">
                                                            Update
                                                        </button>
                                                    </form>

                                                </td>
                                                <td class="text-center">
                                                    <form action="{{route('backend.quotation_charge.activate')}}"
                                                          method="post">
                                                        <input type="hidden" value="{{$charge->id}}" name="charge_id">
                                                        @csrf
                                                        <input onchange="this.form.submit()"
                                                               type="checkbox"
                                                               class="ti-switch"
                                                            @checked($charge->is_active==1)>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End::content  -->
@endsection
@push('scripts')
@endpush

@extends('backend.layouts.master')
@section('title') {{ __('strings.Home') }} @endsection
@section('content')
    <!-- Start::content  -->
    <div class="content">
        <!-- Start::main-content -->
        <div class="main-content">
            <!-- Page Header -->
            <div class="block justify-between page-header md:flex">
                <div>
                    <h3 class="!text-defaulttextcolor dark:!text-defaulttextcolor/70 dark:text-white dark:hover:text-white text-[1.125rem] font-semibold"> Empty</h3>
                </div>
                <ol class="flex items-center whitespace-nowrap min-w-0">
                    <li class="text-[0.813rem] ps-[0.5rem]">
                        <a class="flex items-center text-primary hover:text-primary dark:text-primary truncate" href="javascript:void(0);">
                            Pages
                            <i class="ti ti-chevrons-right flex-shrink-0 text-[#8c9097] dark:text-white/50 px-[0.5rem] overflow-visible rtl:rotate-180"></i>
                        </a>
                    </li>
                    <li class="text-[0.813rem] text-defaulttextcolor font-semibold hover:text-primary dark:text-[#8c9097] dark:text-white/50 " aria-current="page">
                        Empty
                    </li>
                </ol>
            </div>
            <!-- Page Header Close -->
            <!-- Start:: row-11 -->
            <div class="grid grid-cols-12 gap-6 index-table-page">
                <div class="xl:col-span-12 col-span-12">
                    <div class="box custom-box">
                        <div class="box-header justify-between">
                            <div class="box-title">
                                Always responsive
                            </div>
                            <div class="prism-toggle">
                                <button type="button" class="ti-btn !py-1 !px-2 ti-btn-primary !font-medium !text-[0.75rem]">Show Code<i class="ri-code-line ms-2 inline-block align-middle"></i></button>
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="table-responsive">
                                <table class="table whitespace-nowrap table-bordered min-w-full">
                                    <thead class="bg-primary/10">
                                    <tr class="border-b border-primary/10">
                                        <th scope="col"><input class="form-check-input" type="checkbox" id="checkboxNoLabel" value="" aria-label="..."></th>
                                        <th scope="col" class="text-start">Team Head</th>
                                        <th scope="col" class="text-start">Category</th>
                                        <th scope="col" class="text-start">Role</th>
                                        <th scope="col" class="text-start">Gmail</th>
                                        <th scope="col" class="text-start">Team</th>
                                        <th scope="col" class="text-start">Work Progress</th>
                                        <th scope="col" class="text-start">Revenue</th>
                                        <th scope="col" class="text-start">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr class="border-b border-primary/10">
                                        <th scope="row"><input class="form-check-input" type="checkbox" id="checkboxNoLabel1" value="" aria-label="..."></th>
                                        <td>
                                            <div class="flex items-center">
                                                        <span class="avatar avatar-xs me-2 online avatar-rounded">
                                                            <img src="../assets/images/faces/3.jpg" alt="img">
                                                        </span>Mayor Kelly
                                            </div>
                                        </td>
                                        <td>Manufacturer</td>
                                        <td><span class="badge bg-primary/10 text-primary">Team Lead</span></td>
                                        <td>mayorkrlly@gmail.com</td>
                                        <td>
                                            <div class="avatar-list-stacked">
                                                        <span class="avatar avatar-sm avatar-rounded">
                                                            <img src="../assets/images/faces/2.jpg" alt="img">
                                                        </span>
                                                <span class="avatar avatar-sm avatar-rounded">
                                                            <img src="../assets/images/faces/8.jpg" alt="img">
                                                        </span>
                                                <span class="avatar avatar-sm avatar-rounded">
                                                            <img src="../assets/images/faces/2.jpg" alt="img">
                                                        </span>
                                                <a class="avatar avatar-sm bg-primary text-white avatar-rounded" href="javascript:void(0);">
                                                    +4
                                                </a>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="progress progress-xs">
                                                <div class="progress-bar bg-primary w-[52%]" aria-valuenow="52" aria-valuemin="0" aria-valuemax="100">
                                                </div>
                                            </div>
                                        </td>
                                        <td>$10,984.29</td>
                                        <td>
                                            <div class="hstack flex gap-3 text-[.9375rem]">
                                                <a aria-label="anchor" href="javascript:void(0);" class="ti-btn ti-btn-icon ti-btn-sm ti-btn-success-full"><i class="ri-download-2-line"></i></a>
                                                <a aria-label="anchor" href="javascript:void(0);" class="ti-btn ti-btn-icon ti-btn-sm ti-btn-info-full"><i class="ri-edit-line"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="box-footer border-t-0 flex justify-between">
                            <div class="box-title">
                                <span class="opacity-[0.7] font-normal text-[#536485] block text-[0.6875rem]">Showing 1 to 10 of 20 results</span>
                            </div>
                            <div class="prism-toggle flex">
                                <div class="xl:col-span-6 col-span-12">
                                    <label for="table-number" class="hidden">Gender</label>
                                    <select class="form-control w-full !rounded-md js-choices" name="table-number" id="table-number">
                                        <option value="10">10</option>
                                        <option value="25">25</option>
                                        <option value="50">50</option>
                                    </select>
                                </div>

                                <nav aria-label="...">
                                    <ul class="ti-pagination pr-0">
                                        <li class="page-item disabled">
                                            <a class="page-link p-2 block">Previous</a>
                                        </li>
                                        <li class="page-item">
                                            <a class="page-link p-2 block" href="javascript:void(0);">1</a>
                                        </li>
                                        <li class="page-item " aria-current="page">
                                            <a class="page-link active p-2 block" href="javascript:void(0);">2</a>
                                        </li>
                                        <li class="page-item">
                                            <a aria-label="anchor" class="page-link p-2 block" href="javascript:void(0);">
                                                <i class="bi bi-three-dots"></i>
                                            </a>
                                        </li>
                                        <li class="page-item">
                                            <a class="page-link p-2 block" href="javascript:void(0);">21</a>
                                        </li>
                                        <li class="page-item">
                                            <a class="page-link p-2 block" href="javascript:void(0);">Next</a>
                                        </li>
                                    </ul>
                                </nav>
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

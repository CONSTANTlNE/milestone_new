@extends('backend.layouts.master')
@section('title') {{ __('admin.corporate_government_fleets') }} @endsection
@section('styles')
<link rel="stylesheet" href="{{ asset('css/admin-table.css') }}">
@endsection
@section('content')
    <div class="content">
        <div class="main-content">

            <div class="block justify-between page-header md:flex">
                <div>
                    <h3 class="!text-defaulttextcolor dark:!text-defaulttextcolor/70 dark:text-white dark:hover:text-white text-[1.375rem] font-semibold font-first-geo">{{ __('admin.all_corporate_government_fleets') }}</h3>
                    <p class="font-second-geo text-defaulttextcolor/70">{{ __('admin.welcome') }}</p>
                </div>
            </div>

            <x-backend.alert-messages />

            <div class="grid grid-cols-12 gap-6 index-table-page white-bg">
                <div class="xl:col-span-12 col-span-12">
                    <div class="box custom-box">
                        <div class="box-header justify-between">
                            <div class="box-title box-show-number gap-5">
                                <x-backend.table.number />
                                <x-backend.table.massDestroy
                                    :url="route('backend.corporateGovernmentFleets.massDestroy')"
                                />
                            </div>

                            <x-backend.table.filter :status="false"/>
                        </div>

                        <div class="box-body">
                            <div class="table-responsive">
                                <table class="table whitespace-nowrap table-bordered min-w-full" id="datatablesTable">
                                    <thead class="bg-primary/10">
                                    <tr class="border-b border-primary/10">
                                        <th scope="col" class="select-number !text-start">
                                            <input class="form-check-input cursor-pointer" type="checkbox" id="select-all">
                                        </th>
                                        <th scope="col" class="id text-start sortable" data-sort="id">{{ __('admin.id') }}</th>
                                        <th scope="col" class="legal_organization_name text-start">{{ __('admin.legal_organization_name') }}</th>
                                        <th scope="col" class="contact_name text-start">{{ __('admin.contact_name') }}</th>
                                        <th scope="col" class="contact_email text-start">{{ __('admin.contact_email') }}</th>
                                        <th scope="col" class="contact_phone text-start">{{ __('admin.contact_phone') }}</th>
                                        <th scope="col" class="business_type text-start">{{ __('admin.business_type') }}</th>
                                        <th scope="col" class="fleet_locations text-start">{{ __('admin.fleet_locations') }}</th>
                                        <th scope="col" class="vehicles_per_month text-start">{{ __('admin.vehicles_per_month') }}</th>
                                        <th scope="col" class="documents text-start">{{ __('admin.documents') }}</th>
                                        <th scope="col" class="created-time text-start sortable" data-sort="created_at">{{ __('admin.created_at') }}</th>
                                        <th scope="col" class="actions text-start">{{ __('admin.actions') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($corporateGovernmentFleets as $corporateGovernmentFleet)
                                        <tr class="product-list border-b border-primary/10" data-id="{{$corporateGovernmentFleet->id}}">
                                            <td class="text-center">
                                                <input class="form-check-input list-checkbox-item cursor-pointer" type="checkbox" value="{{$corporateGovernmentFleet->id}}">
                                            </td>
                                            <td>
                                                {{$corporateGovernmentFleet->id}}
                                            </td>
                                            <td>
                                                <span class="font-medium">{{$corporateGovernmentFleet->legal_organization_name}}</span>
                                                @if($corporateGovernmentFleet->dba)
                                                    <br><small class="text-muted">DBA: {{$corporateGovernmentFleet->dba}}</small>
                                                @endif
                                                @if($corporateGovernmentFleet->department)
                                                    <br><small class="text-muted">Dept: {{$corporateGovernmentFleet->department}}</small>
                                                @endif
                                            </td>
                                            <td>
                                                {{$corporateGovernmentFleet->contact_name}}
                                                <br><small class="text-muted">{{$corporateGovernmentFleet->contact_title}}</small>
                                            </td>
                                            <td>
                                                <a href="mailto:{{$corporateGovernmentFleet->contact_email}}" class="text-primary">{{$corporateGovernmentFleet->contact_email}}</a>
                                            </td>
                                            <td>
                                                <a href="tel:{{$corporateGovernmentFleet->contact_phone}}" class="text-primary">{{$corporateGovernmentFleet->contact_phone}}</a>
                                            </td>
                                            <td>
                                                <x-backend.badge type="light" :text="ucfirst($corporateGovernmentFleet->business_type)" />
                                            </td>
                                            <td>
                                                <x-backend.badge type="info" :text="$corporateGovernmentFleet->fleet_locations . ' locations'" />
                                            </td>
                                            <td>
                                                <x-backend.badge type="success" :text="$corporateGovernmentFleet->vehicles_per_month . '/month'" />
                                            </td>
                                            <td>
                                                <div class="flex flex-wrap gap-1">
                                                    <a href="{{ Storage::url($corporateGovernmentFleet->w9_upload) }}" target="_blank" class="ti-btn ti-btn-sm ti-btn-primary">
                                                        W9
                                                    </a>
                                                    <a href="{{ Storage::url($corporateGovernmentFleet->insurance_certificate) }}" target="_blank" class="ti-btn ti-btn-sm ti-btn-success">
                                                        IN
                                                    </a>
                                                    <a href="{{ Storage::url($corporateGovernmentFleet->government_corporate_id) }}" target="_blank" class="ti-btn ti-btn-sm ti-btn-warning">
                                                       ID
                                                    </a>
                                                </div>
                                            </td>
                                            <td>
                                                <x-backend.badge type="light" :text="$corporateGovernmentFleet->created_at->format('d/m/Y H:i')" />
                                            </td>
                                            <td>
                                                <x-backend.table.actions
                                                    :model="$corporateGovernmentFleet"
                                                    show-view="backend.corporateGovernmentFleets.show"
                                                    show-delete="backend.corporateGovernmentFleets.delete"
                                                />
                                            </td>
                                        </tr>
                                    @empty
                                        <tr class="empty-state">
                                            <td colspan="13" class="text-center py-8">
                                                <x-backend.table.empty-state
                                                    :actionText="__('admin.no_corporate_government_fleets_found')"
                                                />
                                            </td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <x-backend.pagination :paginator="$corporateGovernmentFleets" />
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="{{ asset('js/admin-table.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#corporateGovernmentFleetsTable').DataTable({
                "pageLength": 25,
                "order": [[ 0, "desc" ]],
                "responsive": true,
                "language": {
                    "search": "Search:",
                    "lengthMenu": "Show _MENU_ entries per page",
                    "info": "Showing _START_ to _END_ of _TOTAL_ entries",
                    "infoEmpty": "Showing 0 to 0 of 0 entries",
                    "infoFiltered": "(filtered from _MAX_ total entries)",
                    "emptyTable": "No data available in table",
                    "zeroRecords": "No matching records found",
                    "paginate": {
                        "first": "First",
                        "last": "Last",
                        "next": "Next",
                        "previous": "Previous"
                    }
                },
                "columnDefs": [
                    {
                        "targets": [9], // Documents column
                        "orderable": false,
                        "searchable": false
                    },
                    {
                        "targets": [12], // Actions column
                        "orderable": false,
                        "searchable": false
                    }
                ]
            });
        });
    </script>
@endpush

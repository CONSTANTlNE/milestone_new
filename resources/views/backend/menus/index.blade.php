@extends('backend.layouts.master')
@section('title') {{ __('admin.sidebar_menu') }} @endsection
@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin-table.css') }}">
@endsection
@section('content')
    <div class="content">
        <div class="main-content static-words">
            <div class="block justify-between page-header md:flex">
                <div>
                    <h3 class="!text-defaulttextcolor dark:!text-defaulttextcolor/70 dark:text-white dark:hover:text-white text-[1.375rem] font-semibold font-first-geo">
                        {{ __('admin.sidebar_menu') }}
                    </h3>
                    <p class="font-second-geo text-defaulttextcolor/70">{{ __('admin.welcome') }}</p>
                </div>
                @can('backend.locales.index')
                    <div class="flex items-center whitespace-nowrap min-w-0 gap-3 addNewLanguage">
                        <form class="flex gap-3 form-valide form-inline" method="POST" action="{{ route('backend.menus.store') }}">
                            @csrf
                            <div class="form-group has-float-label col-4 w-100">
                                <label class="font-w600 font-second-geo" for="menuValue">
                                    {{ __('admin.menu_title') }}
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="w-100 position-relative pb-3">
                                    <input type="text" name="menuValue" id="menuValue"
                                           class="form-control font-second-geo"
                                           placeholder="{{ __('admin.menu_unique_title') }}"
                                           data-required="{{ __('strings.error_value') }}"
                                           data-minlength="{{ __('strings.error_invalid_value') }}">
                                </div>
                            </div>
                            <div class="form-group has-float-label col-5 pl-0">
                                <label class="font-w600 font-second-geo" for="block">
                                    {{ __('admin.menu_position') }}
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="menu-block w-100 position-relative">
                                    <select class="form-control w-full !rounded-md js-choices"
                                            name="block"
                                            id="block">
                                        <option value="HEADER">HEADER</option>
                                        <option value="MOBILE">MOBILE</option>
                                        <option value="FOOTER">FOOTER</option>
                                    </select>

                                </div>
                            </div>
                            <button class="add-static-btn ti-btn ti-btn-info-full text-white !font-medium font-second-geo" type="submit"><i class="ri-add-line"></i></button>

                            <a href="{{ route('backend.menus.index') }}" class="add-static-btn-reset ti-btn bg-warning text-white !font-medium font-second-geo"><i class="ri-refresh-line"></i></a>
                        </form>
                    </div>
                @endcan
            </div>
            <x-backend.alert-messages />


            <div class="grid grid-cols-12 gap-6 white-bg">
                @foreach($menus as $menu)
                <div class="xl:col-span-3 col-span-12">
                    <div class="box">
                        <div class="box-body">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="table-responsive">
                                    <table class="table w-full">
                                        <thead>
                                        <tr>
                                            <th class="font-second-geo"><strong>{{ __('admin.menu_title') }}</strong></th>
                                            <th class="menu-text-right font-second-geo"><strong>{{ __('admin.action') }}</strong></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>{{$menu->name}}</td>
                                            <td>
                                                <div class="flex justify-end">
                                                    @can('backend.locales.edit')
                                                        <a href="{{ route('backend.menus.edit', $menu->id) }}"
                                                           class="add-static-btn-remove ti-btn ti-btn-info-full text-white !font-medium cursor-pointer font-second-geo">
                                                            <i class="ri-edit-fill"></i>
                                                        </a>
                                                    @endcan
                                                    @can('backend.locales.destroy')
                                                        <form action="{{ route('backend.menus.destroy', $menu->id) }}"
                                                              method="POST" class="menu-delete-form"
                                                              onsubmit="return confirm('{{ __('strings.You really want to delete it') }}');">
                                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                            <button class="add-static-btn-remove ti-btn ti-btn-danger-full text-white !font-medium cursor-pointer font-second-geo">
                                                                <i class="ri-delete-bin-2-fill"></i>
                                                            </button>
                                                        </form>
                                                    @endcan
                                                </div>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

            </div>

        </div>
    </div>
@endsection
@push('scripts')
    <script src="{{ asset('js/admin-table.js') }}"></script>
@endpush


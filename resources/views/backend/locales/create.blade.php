@extends('backend.layouts.master')
@section('title') {{ __('admin.create_locales') }} @endsection
@section('styles')
    @vite('public/css/quill-editor.css')
@endsection
@section('content')
    <div class="content">
        <div class="main-content">

            <div class="block justify-between page-header md:flex">
                <div>
                    <h3 class="!text-defaulttextcolor dark:!text-defaulttextcolor/70 dark:text-white dark:hover:text-white text-[1.375rem] font-semibold font-first-geo">{{ __('admin.create_locales') }}</h3>
                    <p class="font-second-geo text-defaulttextcolor/70">{{ __('admin.welcome') }}</p>
                </div>
                <ol class="flex items-center whitespace-nowrap min-w-0 gap-3 header-nav-links">
                    @can('backend.locales.index')
                        <li class="text-[0.813rem] ps-[0.5rem]">
                            <a href="{{ route('backend.locales.index') }}" class="ti-btn bg-secondary text-white !font-medium font-second-geo">
                                <i class="ri-arrow-go-back-line text-[1.375rem]"></i>
                                {{ __('admin.return_back') }} - {{ __('admin.all_locales') }}
                            </a>
                        </li>
                    @endcan
                    @can('backend.locales.trash')
                        <li class="text-[0.813rem] text-defaulttextcolor font-semibold hover:text-danger dark:text-[#8c9097] dark:text-white/50">
                            <a href="{{ route('backend.locales.trash') }}" class="ti-btn bg-danger text-white !font-medium font-second-geo">
                                <i class="ri-delete-bin-2-line text-[1.375rem]"></i>
                                {{__('admin.deleted_locales')}}
                            </a>
                        </li>
                    @endcan
                </ol>
            </div>

            @include('backend.layouts.components.errors',[
              'errors' => $errors,
            ])

            <form method="post" action="{{ route('backend.locales.store') }}" novalidate enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-12 gap-6 white-bg">
                    <div class="xl:col-span-9 col-span-12">
                        <div class="box">
                            <div class="box-body">
                                <div class="mt-4">
                                    <x-backend.input
                                        type="text"
                                        :lang="null"
                                        :data="null"
                                        label="locale_title"
                                        column="title"
                                        place-holder="locale_title_example"
                                        success-text="success_field"
                                        help-text="error_field"
                                        :required="true"
                                        :disabled="false"
                                    />
                                </div>

                                <div class="mt-4">
                                    <x-backend.input
                                        type="text"
                                        :lang="null"
                                        :data="null"
                                        label="locale_native"
                                        column="native"
                                        place-holder="locale_native_example"
                                        success-text="success_field"
                                        help-text="error_field"
                                        :required="true"
                                        :disabled="false"
                                    />
                                </div>

                                <div class="mt-4">
                                    <x-backend.input
                                        type="text"
                                        :lang="null"
                                        :data="null"
                                        label="locale_code"
                                        column="code"
                                        place-holder="locale_code_example"
                                        success-text="success_field"
                                        help-text="error_field"
                                        :required="true"
                                        :disabled="false"
                                    />
                                </div>

                                <div class="mt-4">
                                    <x-backend.publishDate
                                        :data="null"
                                        column="published_at"
                                        label="published_at"
                                        place-holder=""
                                        success-text="success_field"
                                        help-text="error_field"
                                        :required="false"
                                        :disabled="false"
                                        :staticData="false"
                                        width="12"
                                    />
                                </div>

                                <div class="mt-4">
                                    <x-backend.selectStatic
                                        :data="config('crm.status')"
                                        column="status"
                                        label="status_type"
                                        place-holder=""
                                        success-text="success_field"
                                        help-text="error_field"
                                        :required="true"
                                        :disabled="false"
                                        :staticData="false"
                                        hidden="show-search-hidden"
                                        width="12"
                                    />
                                </div>
                            </div>
                            <div class="box-footer text-end">
                                <button type="submit" class="ti-btn bg-primary text-white font-second-geo">
                                    <i class="ri-add-line"></i>
                                    {{__('admin.create')}}
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="xl:col-span-3 col-span-12">
                        <div class="box">
                            <div class="box-body">
                                @include('backend.fileManager.layers.both')
                            </div>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>
    @include('backend.fileManager.templates.file-manager-modal')
@endsection
@push('scripts')
    @vite('public/js/quill-editor.js')
    @include('backend.fileManager.templates.filemanager', ['indexRoute' => route('backend.files.index')])
@endpush

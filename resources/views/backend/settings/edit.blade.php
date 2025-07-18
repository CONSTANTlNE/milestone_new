@extends('backend.layouts.master')
@section('title') {{ __('admin.settings') }} @endsection
@section('styles')
    @vite('public/css/quill-editor.css')
@endsection
@section('content')
    <div class="content">
        <div class="main-content">

            <div class="block justify-between page-header md:flex">
                <div>
                    <h3 class="!text-defaulttextcolor dark:!text-defaulttextcolor/70 dark:text-white dark:hover:text-white text-[1.375rem] font-semibold font-first-geo">
                        {{ __('admin.contact_info') }} / {{ __('admin.settings_info') }}
                    </h3>
                    <p class="font-second-geo text-defaulttextcolor/70">{{ __('admin.welcome') }}</p>
                </div>
            </div>

            <x-backend.alert-messages />

            <form method="post" action="{{ route('backend.settings.update', $setting->id) }}" novalidate enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-12 gap-6 white-bg mt-5">
                    <div class="xl:col-span-9 col-span-12">
                        <div class="box">
                            <div class="box-body">
                                @include('backend.layouts.includes.langTabComponent')
                                <div class="tab-content">
                                    @foreach(getLocales() as $key => $lang)
                                        <div
                                            class="{{($key == 0) ? '' : 'hidden'}}"
                                            id="locale-{{$lang->code}}"
                                            role="tabpanel"
                                            aria-labelledby="locale-item-{{$lang->code}}"
                                        >
                                            <div class=""
                                                 id="content-locale-{{$lang->code}}"
                                                 role="tabpanel"
                                                 aria-labelledby="content-locale-item-{{$lang->code}}">
                                                <div class="p-5 border rounded-ss-none rounded-sm dark:border-white/10 border-gray-200 content-section">

                                                    <x-backend.input
                                                        type="text"
                                                        :lang="$lang"
                                                        :data="$setting"
                                                        label="title"
                                                        column="title"
                                                        place-holder="holder_title"
                                                        success-text="success_field"
                                                        help-text="error_field"
                                                        :required="true"
                                                        :disabled="false"
                                                    />

                                                    <x-backend.input
                                                        type="text"
                                                        :lang="$lang"
                                                        :data="$setting"
                                                        label="address"
                                                        column="address"
                                                        place-holder="address"
                                                        success-text="success_field"
                                                        help-text="error_field"
                                                        :required="false"
                                                        :disabled="false"
                                                    />

                                                    <x-backend.input
                                                        type="text"
                                                        :lang="$lang"
                                                        :data="$setting"
                                                        label="working_hours"
                                                        column="working_hours"
                                                        place-holder="working_hours"
                                                        success-text="success_field"
                                                        help-text="error_field"
                                                        :required="false"
                                                        :disabled="false"
                                                    />
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="mt-4">
                                    <x-backend.input
                                        type="text"
                                        :lang="null"
                                        :data="$setting"
                                        label="email"
                                        column="email"
                                        place-holder="email"
                                        success-text="success_field"
                                        help-text="error_field"
                                        :required="false"
                                        :disabled="false"
                                    />
                                </div>
                                <div class="mt-4">
                                    <x-backend.input
                                        type="text"
                                        :lang="null"
                                        :data="$setting"
                                        label="send_email"
                                        column="send_email"
                                        place-holder="send_email"
                                        success-text="success_field"
                                        help-text="error_field"
                                        :required="false"
                                        :disabled="false"
                                    />
                                </div>
                                <div class="mt-4">
                                    <x-backend.input
                                        type="text"
                                        :lang="null"
                                        :data="$setting"
                                        label="phone"
                                        column="phone"
                                        place-holder="phone"
                                        success-text="success_field"
                                        help-text="error_field"
                                        :required="false"
                                        :disabled="false"
                                    />
                                </div>
                                <div class="mt-4">
                                    <x-backend.input
                                        type="text"
                                        :lang="null"
                                        :data="$setting"
                                        label="lat"
                                        column="lat"
                                        place-holder="lat"
                                        success-text="success_field"
                                        help-text="error_field"
                                        :required="false"
                                        :disabled="false"
                                    />
                                </div>
                                <div class="mt-4">
                                    <x-backend.input
                                        type="text"
                                        :lang="null"
                                        :data="$setting"
                                        label="lng"
                                        column="lng"
                                        place-holder="lng"
                                        success-text="success_field"
                                        help-text="error_field"
                                        :required="false"
                                        :disabled="false"
                                    />
                                </div>
                                <div class="mt-4">
                                    <x-backend.input
                                        type="text"
                                        :lang="null"
                                        :data="$setting"
                                        label="g_map"
                                        column="g_map"
                                        place-holder="g_map"
                                        success-text="success_field"
                                        help-text="error_field"
                                        :required="false"
                                        :disabled="false"
                                    />
                                </div>

                                <div class="mt-4">
                                    <x-backend.input
                                        type="text"
                                        :lang="null"
                                        :data="$setting"
                                        label="g_analytics"
                                        column="g_analytics"
                                        place-holder="g_analytics"
                                        success-text="success_field"
                                        help-text="error_field"
                                        :required="false"
                                        :disabled="false"
                                    />
                                </div>

                                <div class="mt-4">
                                    <x-backend.input
                                        type="text"
                                        :lang="null"
                                        :data="$setting"
                                        label="fb_id"
                                        column="fb_id"
                                        place-holder="fb_id"
                                        success-text="success_field"
                                        help-text="error_field"
                                        :required="false"
                                        :disabled="false"
                                    />
                                </div>

                            </div>
                            <div class="box-footer text-end">
                                <button type="submit" class="ti-btn bg-primary text-white font-second-geo">
                                    <i class="ri-add-line"></i>
                                    {{__('admin.update')}}
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="xl:col-span-3 col-span-12">
                        <div class="box">
                            <div class="box-body">
                                <x-backend.publishDate
                                    :data="$setting->created_at"
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

                                <x-backend.selectStatic
                                    :data="config('crm.status')"
                                    :choose="$setting->status"
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
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

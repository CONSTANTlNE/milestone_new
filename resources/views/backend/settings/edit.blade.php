@extends('backend.layouts.master')
@section('title') {{ __('strings.Contact') }} / {{ __('strings.Settings') }} @endsection
@section('content')
    <div class="container-fluid" xmlns="http://www.w3.org/1999/html">
        <div class="form-head d-md-flex mb-sm-4 mb-3 align-items-start">
            <div class="mr-auto  d-lg-block">
                <h2 class="text-black font-w600">{{ __('strings.Contact') }} / {{ __('strings.Settings') }}</h2>
                <p class="mb-0 font-w600">{{ __('strings.Welcome') }}</p>
            </div>
        </div>
        @include('backend.layouts.components.errors',[
          'errors' => $errors,
        ])
        <form method="POST" class="needs-validation" action="{{ route('backend.settings.update', [app()->getLocale(), $setting->id]) }}"  novalidate enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-12 p-0">
                    <div class="col-md-12 col-xl-12 float-left">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        @include('backend.layouts.includes.langTabComponent')
                                        <div class="tab-content">
                                            @foreach(getLocales() as $key => $lang)
                                                <div class="tab-pane {{($key == 0) ? 'active' : ''}}" id="locale-{{$lang->code}}" role="tabpanel">
                                                    <div class="tab-content pt-4 pb-0 text-muted no-padding" style="width: 100%">
                                                        <div class="tab-pane active" id="content-locale-{{$lang->code}}" role="tabpanel">
                                                            <x-input
                                                                type="text"
                                                                :lang="$lang"
                                                                :data="$setting"
                                                                label="Title"
                                                                column="title"
                                                                place-holder="Holder Title"
                                                                success-text="Success Field"
                                                                help-text="Error Field"
                                                                :required="true"
                                                                :disabled="false"
                                                            />

                                                            <x-input
                                                                type="text"
                                                                :lang="$lang"
                                                                :data="$setting"
                                                                label="Content"
                                                                column="content"
                                                                place-holder="Holder Description"
                                                                success-text="Success Field"
                                                                help-text="Error Field"
                                                                :required="true"
                                                                :disabled="false"
                                                            />
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group position-relative">
                                                    <label class="font-w600" for="validationTip">
                                                        {{ __('strings.Email') }}
                                                    </label>
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        name="email"
                                                        value="{{ $setting->email }}"
                                                        placeholder=""
                                                        id="validationTip"
                                                    />
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group position-relative">
                                                    <label class="font-w600" for="validationTip">
                                                        {{ __('strings.Mobile') }}
                                                    </label>
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        name="mobile"
                                                        value="{{ $setting->mobile }}"
                                                        placeholder=""
                                                        id="validationTip"
                                                    />
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group position-relative">
                                                    <label class="font-w600" for="validationTip">
                                                        {{ __('strings.send_email') }}
                                                    </label>
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        name="send_email"
                                                        value="{{ $setting->send_email }}"
                                                        placeholder=""
                                                        id="validationTip"
                                                    />
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group position-relative">
                                                    <label class="font-w600" for="validationTip">
                                                        {{ __('strings.lat') }}
                                                    </label>
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        name="lat"
                                                        value="{{ $setting->lat }}"
                                                        placeholder=""
                                                        id="validationTip"
                                                    />
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group position-relative">
                                                    <label class="font-w600" for="validationTip">
                                                        {{ __('strings.lng') }}
                                                    </label>
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        name="lng"
                                                        value="{{ $setting->lng }}"
                                                        placeholder=""
                                                        id="validationTip"
                                                    />
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group position-relative">
                                                    <label class="font-w600" for="validationTip">
                                                        {{ __('strings.g_map') }}
                                                    </label>
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        name="g_map"
                                                        value="{{ $setting->g_map }}"
                                                        placeholder=""
                                                        id="validationTip"
                                                    />
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group position-relative">
                                                    <label class="font-w600" for="validationTip">
                                                        {{ __('strings.g_analytics') }}
                                                    </label>
                                                    <textarea class="form-control" name="g_analytics">{{ $setting->g_analytics }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <x-checkbox
                                                column="block"
                                                label="Review"
                                                place-holder="Review"
                                                success-text="Checkbox Success"
                                                help-text="Checkbox Error"
                                                :required="true"
                                            />
                                            <div class="col-lg-12">
                                                <button class="btn btn-primary" type="submit">{{ __('strings.Update') }}</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

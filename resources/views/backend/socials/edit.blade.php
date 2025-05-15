@extends('backend.layouts.master')
@section('title') {{ __('strings.Edit Social Network') }} @endsection
@section('content')
    <div class="container-fluid">
        <div class="form-head d-md-flex mb-sm-4 mb-3 align-items-start">
            <div class="mr-auto  d-lg-block">
                <h2 class="text-black font-w600">{{ __('strings.Edit Social Network') }}</h2>
                <p class="mb-0 font-w600">{{ __('strings.Welcome') }}</p>
            </div>
            @can('backend.socials.index')
                <a href="{{ route('backend.socials.index', app()->getLocale())}}" class="btn btn-info rounded"><i class="flaticon-381-repeat-1"></i> {{ __('strings.Return Back') }} - {{ __('strings.Social Network') }}</a>
            @endcan
            @can('backend.socials.trash')
                <a href="{{ route('backend.socials.trash', app()->getLocale())}}" class="btn btn-primary rounded light deleted-archive ml-3"><i class="flaticon-381-trash-2"></i>  {{ __('strings.Deleted Social Network') }}</a>
            @endcan
        </div>
        @include('backend.layouts.components.errors',[
          'errors' => $errors,
        ])
        <form method="post" class="needs-validation" action="{{ route('backend.socials.update', [app()->getLocale(), $social->id]) }}"  novalidate enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-12 col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <x-input
                                    type="text"
                                    :lang="null"
                                    :data="$social"
                                    label="Social Network Title"
                                    column="title"
                                    place-holder="Example : Facebook"
                                    success-text="Success Field"
                                    help-text="Error Field"
                                    :required="true"
                                    :disabled="false"
                                    width="6"
                                />

                                <x-input
                                    type="text"
                                    :lang="null"
                                    :data="$social"
                                    label="Social Network Link"
                                    column="link"
                                    place-holder="Example : F"
                                    success-text="Success Field"
                                    help-text="Error Field"
                                    :required="true"
                                    :disabled="false"
                                    width="6"
                                />

                                @php
                                    $x = '';
                                    if (!empty($social->icon)){
                                    $x = '<option value="'.$social->icon.'">'.__('strings.Code') .' : '. $social->icon .'</option>';
                                    }
                                @endphp
                                <x-select
                                    :lang="null"
                                    :data="null"
                                    :dataSingle="$x"
                                    column="icon"
                                    label="Choose Social Network"
                                    place-holder=""
                                    success-text="Success Field"
                                    help-text="Error Field"
                                    :required="true"
                                    :disabled="false"
                                    :staticData="false"
                                    width="6"
                                />

                                <x-select
                                    :lang="null"
                                    :data="null"
                                    column="status"
                                    label="Choose Status"
                                    place-holder=""
                                    success-text="Success Field"
                                    help-text="Error Field"
                                    :required="true"
                                    :disabled="false"
                                    :staticData="false"
                                    width="6"
                                />
                            </div>
                            <div class="row">
                                <x-checkbox
                                    column="block"
                                    label="Review"
                                    place-holder="Review"
                                    success-text="Checkbox Success"
                                    help-text="Checkbox Error"
                                    :required="true"
                                />
                                <div class="col-lg-12 mt-2">
                                    <button class="btn btn-primary btn-md btn-block waves-effect waves-light" type="submit">{{ __('strings.Update') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
@push('scripts')
    <script src="{{URL::asset('/js/additional/form-advanced.min.js')}}"></script>
@endpush

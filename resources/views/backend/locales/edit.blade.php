@extends('backend.layouts.master')
@section('title') {{ __('strings.Edit Language') }} @endsection
@section('content')
    <div class="container-fluid">
        <div class="form-head d-md-flex mb-sm-4 mb-3 align-items-start">
            <div class="mr-auto  d-lg-block">
                <h2 class="text-black font-w600">{{ __('strings.Edit Language') }}</h2>
                <p class="mb-0 font-w600">{{ __('strings.Welcome') }}</p>
            </div>
            @can('backend.locales.index')
                <a href="{{ route('backend.locales.index', app()->getLocale())}}" class="btn btn-info rounded"><i class="flaticon-381-repeat-1"></i> {{ __('strings.Return Back') }} - {{ __('strings.All Languages') }}</a>
            @endcan
            @can('backend.locales.trash')
                <a href="{{ route('backend.locales.trash', app()->getLocale())}}" class="btn btn-primary rounded light deleted-archive ml-3"><i class="flaticon-381-trash-2"></i>  {{ __('strings.Deleted Languages') }}</a>
            @endcan
        </div>
        @include('backend.layouts.components.errors',[
          'errors' => $errors,
        ])
  <form method="POST" class="needs-validation" action="{{ route('backend.locales.update', [app()->getLocale(), $locale->id]) }}"  novalidate enctype="multipart/form-data">
      @csrf
      @method('PUT')
      <div class="row">

          <div class="col-md-12 col-xl-9">
              <div class="card">
                  <div class="card-body">

                      <div class="row">
                          <x-input
                              type="text"
                              :lang="null"
                              :data="$locale"
                              label="Language Title"
                              column="name"
                              place-holder="Example : English"
                              success-text="Success Field"
                              help-text="Error Field"
                              :required="true"
                              :disabled="false"
                              width="12"
                          />
                          <x-input
                              type="text"
                              :lang="null"
                              :data="$locale"
                              label="Language Code"
                              column="code"
                              place-holder="Example : Code"
                              success-text="Success Field"
                              help-text="Error Field"
                              :required="true"
                              :disabled="false"
                              width="12"
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
                              width="12"
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

          <div class="col-md-12 col-xl-3">
          <div class="card" style="height: auto;">
              <div class="card-body">
                  <div class="row">
                      @include('backend.fileManager.layers.main', ['item' => $locale])
                  </div>
              </div>
          </div>
      </div>
    </div>
  </form>
    </div>
    @include('backend.fileManager.templates.file-manager-modal')
@endsection

@push('scripts')
    <script src="{{URL::asset('/js/additional/form-advanced.min.js')}}"></script>
    @include('backend.fileManager.templates.filemanager', ['indexRoute' => route('backend.files.index', app()->getLocale())])
@endpush

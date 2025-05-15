@extends('backend.layouts.master')
@section('title') {{ __('strings.Edit Banner') }} @endsection
@section('content')
    <div class="container-fluid">
        <div class="form-head d-md-flex mb-sm-4 mb-3 align-items-start">
            <div class="mr-auto  d-lg-block">
                <h2 class="text-black font-w600">{{ __('strings.Edit Banner') }}</h2>
                <p class="mb-0 font-w600">{{ __('strings.Welcome') }}</p>
            </div>
            @can('backend.banners.index')
                <a href="{{ route('backend.banners.index', app()->getLocale())}}" class="btn btn-info rounded"><i class="flaticon-381-repeat-1"></i> {{ __('strings.Return Back') }} - {{ __('strings.All Banner') }}</a>
            @endcan
            @can('backend.banners.trash')
                <a href="{{ route('backend.banners.trash', app()->getLocale())}}" class="btn btn-primary rounded light deleted-archive ml-3"><i class="flaticon-381-trash-2"></i>  {{ __('strings.Deleted Banners') }}</a>
            @endcan
        </div>
        @include('backend.layouts.components.errors',[
          'errors' => $errors,
        ])
        <form method="post" class="needs-validation" action="{{ route('backend.banners.update', [app()->getLocale(), $banner->id]) }}"  novalidate enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-12 p-0">
                    <div class="col-md-12 col-xl-9 float-left">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        @include('backend.layouts.includes.langTabComponent')
                                        <div class="tab-content">
                                            @foreach(getLocales() as $key => $lang)
                                                <div class="tab-pane {{($key == 0) ? 'active' : ''}}" id="locale-{{$lang->code}}" role="tabpanel">
                                                    <div class="tab-content pb-0 text-muted no-padding" style="width: 100%">
                                                        <div class="tab-pane active" id="content-locale-{{$lang->code}}" role="tabpanel">
                                                            <x-input
                                                                type="text"
                                                                :lang="$lang"
                                                                :data="$banner"
                                                                label="Title"
                                                                column="title"
                                                                place-holder="Holder Title"
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
                                            <x-input
                                                type="text"
                                                :lang="null"
                                                :data="$banner"
                                                label="Banner Url"
                                                column="url"
                                                place-holder="Holder Banner Url"
                                                success-text="Success Field"
                                                help-text="Error Field"
                                                :required="true"
                                                :disabled="false"
                                                width="12"
                                            />
                                            @php
                                                $x = '';
                                                if (!empty($banner->zone)){
                                                $x = '<option value="'.$banner->zone.'">'.__('strings.Zone') .' : '. $banner->zone = $banner->zone == 1 ? 'Top Banner' : 'Bottom Banner' .'</option>';
                                                }
                                            @endphp
                                            <x-select
                                                :lang="null"
                                                :data="null"
                                                :dataSingle="$x"
                                                column="zone"
                                                label="Choose Banner Zone"
                                                place-holder="Holder Banner Zone"
                                                success-text="Success Field"
                                                help-text="Error Field"
                                                :required="true"
                                                :disabled="false"
                                                :staticData="false"
                                                width="12"
                                            />
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
                    <div class="col-md-12 col-xl-3 float-right">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    @include('backend.fileManager.layers.main', ['item' => $banner])
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
    @include('backend.fileManager.templates.filemanager', ['indexRoute' => route('backend.files.index', app()->getLocale())])
@endpush

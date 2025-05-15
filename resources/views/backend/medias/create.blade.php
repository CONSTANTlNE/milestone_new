@extends('backend.layouts.master')
@section('title') {{ __('strings.Fact in Media Create') }} @endsection
@push('styles')
    <link href="{{URL::asset('css/summernote-lite.min.css')}}" rel="stylesheet" type="text/css" >
@endpush
@section('content')
    <div class="container-fluid">
        <div class="form-head d-md-flex mb-sm-4 mb-3 align-items-start">
            <div class="mr-auto  d-lg-block">
                <h2 class="text-black font-w600">{{ __('strings.Fact in Media Create') }}</h2>
                <p class="mb-0 font-w600">{{ __('strings.Welcome') }}</p>
            </div>
            @can('backend.medias.index')
                <a href="{{ route('backend.medias.index', app()->getLocale())}}" class="btn btn-info rounded"><i class="flaticon-381-repeat-1"></i> {{ __('strings.Return Back') }} - {{ __('strings.All Fact in Media') }}</a>
            @endcan
            @can('backend.medias.trash')
                <a href="{{ route('backend.medias.trash', app()->getLocale())}}" class="btn btn-primary rounded light deleted-archive ml-3"><i class="flaticon-381-trash-2"></i>  {{ __('strings.Deleted Fact in Medias') }}</a>
            @endcan
        </div>
        @include('backend.layouts.components.errors',[
          'errors' => $errors,
        ])
        <form method="post" class="needs-validation" action="{{ route('backend.medias.store', app()->getLocale()) }}" novalidate enctype="multipart/form-data">
            {{csrf_field()}}
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
                                                    <div class="tab-content pt-4 pb-0 text-muted no-padding" style="width: 100%">
                                                        <div class="tab-pane active" id="content-locale-{{$lang->code}}" role="tabpanel">
                                                            <x-input
                                                                type="text"
                                                                :lang="$lang"
                                                                :data="null"
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
                                                                :data="null"
                                                                label="Source"
                                                                column="source"
                                                                place-holder="Holder Source"
                                                                success-text="Success Field"
                                                                help-text="Error Field"
                                                                :required="true"
                                                                :disabled="false"
                                                            />

                                                            <x-input
                                                                type="text"
                                                                :lang="$lang"
                                                                :data="null"
                                                                label="Link"
                                                                column="links"
                                                                place-holder="Holder Link"
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
                                            <x-checkbox
                                                column="block"
                                                label="Review"
                                                place-holder="Review"
                                                success-text="Checkbox Success"
                                                help-text="Checkbox Error"
                                                :required="true"
                                            />
                                            <div class="col-lg-12">
                                                <button class="btn btn-primary" type="submit">{{ __('strings.Create') }}</button>
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
                                    @include('backend.fileManager.layers.both')

                                    <div class="col-md-12">
                                        <p class="mb-1">შექმნის თარიღი</p>
                                        <input type="datetime-local" name="published_at" class="form-control" id="datetimepicker">
                                    </div>

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
    <script src="{{URL::asset('/js/my/summernote-lite.min.js')}}"></script>
    <script src="{{URL::asset('/js/my/summernote-cleaner.js')}}"></script>
    <script src="{{URL::asset('/js/additional/jquery-ui.min.js')}}"></script>
    @include('backend.fileManager.templates.filemanager', ['indexRoute' => route('backend.files.index', app()->getLocale())])
@endpush

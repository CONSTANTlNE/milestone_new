@extends('backend.layouts.master')
@section('title') {{ __('strings.Article Create') }} @endsection
@push('styles')
    <link href="{{URL::asset('css/summernote-lite.min.css')}}" rel="stylesheet" type="text/css" >
@endpush
@section('content')
    <div class="container-fluid">
        <div class="form-head d-md-flex mb-sm-4 mb-3 align-items-start">
            <div class="mr-auto  d-lg-block">
                <h2 class="text-black font-w600">{{ __('strings.Article Create') }}</h2>
                <p class="mb-0 font-w600">{{ __('strings.Welcome') }}</p>
            </div>
            @can('backend.articles.index')
                <a href="{{ route('backend.articles.index', app()->getLocale())}}" class="btn btn-info rounded"><i class="flaticon-381-repeat-1"></i> {{ __('strings.Return Back') }} - {{ __('strings.All Article') }}</a>
            @endcan
            @can('backend.articles.trash')
                <a href="{{ route('backend.articles.trash', app()->getLocale())}}" class="btn btn-primary rounded light deleted-archive ml-3"><i class="flaticon-381-trash-2"></i>  {{ __('strings.Deleted Articles') }}</a>
            @endcan
        </div>
        @include('backend.layouts.components.errors',[
          'errors' => $errors,
        ])
        <form method="post" class="needs-validation" action="{{ route('backend.articles.store', app()->getLocale()) }}" novalidate enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="row">

                <div class="col-md-3"></div>
                <div class="col-md-3"></div>

                <div class="col-md-3">
                    <div class="form-group position-relative select-access">
                        <label class="control-label font-w600" for="validationTipSelectReporter">
                            {{ __('strings.Choose Reporter') }}:
                        </label>

                        <select id="validationTipSelectReporter" class="select2 form-control select2 dropdown-groups"  name="reporter" required>
                            <option value="0">{{ __('strings.Reporter') }}</option>
                            @foreach($reporters as $key => $reporter)
                                <option value="{{$key}}">{{$reporter}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>



                <div class="col-md-3">
                    <div class="form-group position-relative select-access">
                        <label class="control-label font-w600" for="validationTipSelectVerdict">
                            {{ __('strings.Choose Verdict') }}:
                        </label>
                        <select id="validationTipSelectVerdict" class="select2 form-control select2 dropdown-groups" name="verdict" required>
                            <option value="0">{{ __('strings.Verdict') }}</option>
                            @foreach($verdicts as $key => $verdict)
                                <option value="{{$key}}">{{$verdict}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

            </div>

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
                                                    @include('backend.layouts.includes.seoLangTabComponent')
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
                                                                label="Description"
                                                                column="slogan"
                                                                place-holder="Holder Description"
                                                                success-text="Success Field"
                                                                help-text="Error Field"
                                                                :required="true"
                                                                :disabled="false"
                                                            />

                                                            <div class="testtest">
{{--                                                                <div class="col-md-12 pb-2">--}}
{{--                                                                    <button type="button" class="btn  btn-primary btn-sm add-social" id="addPicturetextarea{{$lang->code}}" name="addPicture" data-code="textarea{{$lang->code}}" data-shortcode="social_icons">{{ __('strings.Add Social Network Share links') }}</button>--}}
{{--                                                                </div>--}}
                                                                <div class="col-md-12 pb-2">
                                                                    <div id="clearFormattingBtn{{$lang->code}}" class="btn  btn-primary btn-sm">Clear Formatting - {{$lang->code}}</div>
                                                                </div>
                                                                @include('backend.layouts.components.editorTextarea',
                                                                [
                                                                    'lang' => $lang,
                                                                    'data' => '',
                                                                    'column' => 'content',
                                                                    'label' => 'ჩაწერეთ თქვენი ტექსტი!',
                                                                    'required' => false,
                                                                    'placeHolder' => 'Holder Title',
                                                                    'successText' => 'Success Fild',
                                                                    'helpText' => 'Error Filed',
                                                               ])
                                                            </div>

                                                            <div id="content-select" class="col-md-12" data-lang-code="{{$lang->code}}">
                                                                <div class="form-group position-relative">
                                                                    <label class="font-w600" for="multi-value-select-{{$lang->code}}">
                                                                        {{ __('strings.Tags') }}
                                                                    </label>
                                                                    <select id="multi-value-select-{{$lang->code}}" class="multi-value-select" data-lang-code="{{$lang->code}}" name="tags[{{$lang->code}}][]" multiple="multiple">
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @include('backend.layouts.includes.seoComponent', [
                                                            'lang' => $lang,
                                                            'code' => $lang->code,
                                                            'data' => null
                                                        ])
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

                                    <div class="col-md-12">
                                        <div class="form-group position-relative select-access">
                                            <label class="control-label font-w600" for="validationTipSelectType">
                                                {{ __('strings.Choose Article Place') }}:
                                            </label>

                                            <select id="validationTipSelectType" class="select2 form-control select2 multi-select" name="options[]" multiple="multiple" required>
                                                <option value="1">Fake</option>
                                                <option value="2">Promise</option>
                                                <option value="3">Main Slider</option>
                                                <option value="4">Factcheck Newspaper</option>
                                                <option value="5">Show on Main Page</option>
                                                <option value="6">User provided facts</option>
                                                <option value="8">FB Instant Article</option>
                                            </select>
                                        </div>
                                    </div>

                                    @include('backend.fileManager.layers.both')

                                    <div class="col-md-12">
                                        <p class="mb-1">შექმნის თარიღი</p>
                                        <input type="datetime-local" name="published_at" class="form-control" id="datetimepicker">
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group position-relative select-access">
                                            <label class="control-label font-w600" for="validationTipSelectPerson">
                                                {{ __('strings.Choose Persons And Organizations') }}
                                            </label>
                                            <select id="validationTipSelectPerson" class="select2 form-control select2 multi-select" name="persons[]" multiple="multiple" required>
                                                <option value="0">{{ __('strings.Persons/Organizations') }}</option>
                                                @foreach($persons as $key => $person)
                                                    <option value="{{$key}}">{{$person}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group position-relative select-access">
                                            <label class="control-label font-w600" for="validationTipSelectCategory">
                                                {{ __('strings.Choose Article Category') }}:
                                            </label>

                                            <select id="validationTipSelectCategory" class="select2 form-control select2 multi-select" name="category[]" multiple="multiple" required>
                                                <option value="0">{{ __('strings.Categories') }}</option>
                                                @foreach($articleCategires as $key => $articleCategory)
                                                    <option value="{{$key}}">{{$articleCategory}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group position-relative select-access">
                                            <label class="control-label font-w600" for="validationTipSelectRegion">
                                                {{ __('strings.Choose Region') }}:
                                            </label>
                                            <select id="validationTipSelectRegion" class="select2 form-control select2 dropdown-groups" name="region" required>
                                                <option value="0">{{ __('strings.Region') }}</option>
                                                @foreach($regions as $key => $region)
                                                    <option value="{{$key}}">{{$region}}</option>
                                                @endforeach
                                            </select>
                                        </div>
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
    <script src="{{asset('/js/additional/select2.min.js')}}"></script>
    <script src="{{asset('/js/plugins-init/select2-init.js')}}"></script>
    @include('backend.fileManager.templates.filemanager', ['indexRoute' => route('backend.files.index', app()->getLocale())])
@endpush

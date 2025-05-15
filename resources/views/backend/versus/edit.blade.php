@extends('backend.layouts.master')
@section('title') {{ __('strings.Edit Article') }} - Versus @endsection
@push('styles')
    <link href="{{URL::asset('css/summernote-lite.min.css')}}" rel="stylesheet" type="text/css" >
@endpush
@section('content')
    <div class="container-fluid">
        <div class="form-head d-md-flex mb-sm-4 mb-3 align-items-start">
            <div class="mr-auto  d-lg-block">
                <h2 class="text-black font-w600">{{ __('strings.Edit Article') }} - Versus</h2>
                <p class="mb-0 font-w600">{{ __('strings.Welcome') }}</p>
            </div>
            @can('backend.versus.index')
                <a href="{{ route('backend.versus.index', app()->getLocale())}}" class="btn btn-info rounded"><i class="flaticon-381-repeat-1"></i> {{ __('strings.Return Back') }} - Versus</a>
            @endcan
            @can('backend.versus.trash')
                <a href="{{ route('backend.versus.trash', app()->getLocale())}}" class="btn btn-primary rounded light deleted-archive ml-3"><i class="flaticon-381-trash-2"></i>  {{ __('strings.Deleted Versus') }}</a>
            @endcan
        </div>
        @include('backend.layouts.components.errors',[
          'errors' => $errors,
        ])
        <form method="post" class="needs-validation" action="{{ route('backend.versus.update', [app()->getLocale(), $article->id]) }}"  novalidate enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">

                <div class="col-md-3"></div>

                <div class="col-md-3">
                    <div class="form-group position-relative select-access">
                        <label class="control-label font-w600" for="validationTipSelectReporter">
                            {{ __('strings.Choose Reporter') }}
                        </label>

                        <select id="validationTipSelectReporter" class="select2 form-control select2 dropdown-groups"  name="reporter" required>
                            @if(isset($article->reporter))
                                <option value="{{$article->reporter->id}}">{{ __('strings.Selected') }} - {{$article->reporter->getTranslation('title', app()->getLocale())}}</option>
                            @else
                                <option value="0">{{ __('strings.Reporter') }}</option>
                            @endif
                            @foreach($reporters as $key => $reporter)
                                <option value="{{$key}}">{{$reporter}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>



                <div class="col-md-3">
                    <div class="form-group position-relative select-access">
                        <label class="control-label font-w600" for="validationTipSelectVerdict">
                            {{ __('strings.Choose Verdict') }}
                        </label>
                        <select id="validationTipSelectVerdict" class="select2 form-control select2 dropdown-groups" name="verdict" required>
                            @if(isset($article->verdict))
                                <option value="{{$article->verdict->id}}">{{ __('strings.Selected') }} - {{$article->verdict->getTranslation('title', app()->getLocale())}}</option>
                            @else
                                <option value="0">{{ __('strings.Verdict1') }}</option>
                            @endif
                            @foreach($verdicts as $key => $verdict)
                                <option value="{{$key}}">{{$verdict}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group position-relative select-access">
                        <label class="control-label font-w600" for="validationTipSelectVerdict2">
                            {{ __('strings.Choose Verdict') }}
                        </label>
                        <select id="validationTipSelectVerdict2" class="select2 form-control select2 dropdown-groups" name="verdict2" required>
                            @if(isset($article->verdictVersus))
                                <option value="{{$article->verdictVersus->id}}">{{ __('strings.Selected') }} - {{$article->verdictVersus->getTranslation('title', app()->getLocale())}}</option>
                            @else
                                <option value="0">{{ __('strings.Verdict2') }}</option>
                            @endif
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
                                                                :data="$article"
                                                                label="General Title"
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
                                                                :data="$article->versus->first()"
                                                                label="Title"
                                                                column="title1"
                                                                place-holder="Holder Title"
                                                                success-text="Success Field"
                                                                help-text="Error Field"
                                                                :required="true"
                                                                :disabled="false"
                                                            />
                                                            <x-input
                                                                type="text"
                                                                :lang="$lang"
                                                                :data="$article->versus->first()"
                                                                label="Title"
                                                                column="title2"
                                                                place-holder="Holder Title"
                                                                success-text="Success Field"
                                                                help-text="Error Field"
                                                                :required="true"
                                                                :disabled="false"
                                                            />
                                                            <x-input
                                                                type="text"
                                                                :lang="$lang"
                                                                :data="$article->versus->first()"
                                                                label="Slogan1"
                                                                column="slogan1"
                                                                place-holder="Holder Description"
                                                                success-text="Success Field"
                                                                help-text="Error Field"
                                                                :required="true"
                                                                :disabled="false"
                                                            />

                                                            <x-input
                                                                type="text"
                                                                :lang="$lang"
                                                                :data="$article->versus->first()"
                                                                label="Slogan2"
                                                                column="slogan2"
                                                                place-holder="Holder Description"
                                                                success-text="Success Field"
                                                                help-text="Error Field"
                                                                :required="true"
                                                                :disabled="false"
                                                            />

                                                            <div class="testtest">
                                                                <div class="col-md-12 pb-2">
                                                                    <button type="button" class="btn  btn-primary btn-sm add-social" id="addPicturetextarea{{$lang->code}}" name="addPicture" data-code="textarea{{$lang->code}}" data-shortcode="social_icons">{{ __('strings.Add Social Network Share links') }}</button>
                                                                </div>
                                                                @include('backend.layouts.components.editorTextarea',
                                                                [
                                                                    'lang' => $lang,
                                                                    'data' => $article,
                                                                    'column' => 'content',
                                                                    'label' => 'ჩაწერეთ თქვენი ტექსტი!',
                                                                    'required' => false,
                                                                    'placeHolder' => 'Holder Title',
                                                                    'successText' => 'Success Fild',
                                                                    'helpText' => 'Error Fild',
                                                               ])
                                                            </div>
                                                            <div id="content-select" class="col-md-12" data-lang-code="{{$lang->code}}">
                                                                <div class="form-group position-relative">
                                                                    <label class="font-w600" for="multi-value-select-{{$lang->code}}">
                                                                        {{ __('strings.Tags') }} ({{$lang->name}})
                                                                    </label>
                                                                    <select id="multi-value-select-{{$lang->code}}" class="multi-value-select" data-lang-code="{{$lang->code}}" name="tags[{{$lang->code}}][]" multiple="multiple">
                                                                        @forelse($article->tags as $tag)
                                                                            @if($lang->code == $tag->lang)<option value="{{$tag->title}}" selected>{{$tag->title}}</option> @endif
                                                                        @empty
                                                                        @endforelse
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="tab-pane" id="seo-locale-{{$lang->code}}" role="tabpanel">
                                                            <x-input
                                                                type="text"
                                                                :lang="$lang"
                                                                :data="$seo"
                                                                label="Seo Title"
                                                                column="seoTitles"
                                                                place-holder="Holder Seo Title"
                                                                success-text="Success Field"
                                                                help-text="Error Field"
                                                                :required="false"
                                                                :disabled="false"
                                                            />
                                                            <x-input
                                                                type="text"
                                                                :lang="$lang"
                                                                :data="$seo"
                                                                label="Seo Keywords"
                                                                column="seoKeywords"
                                                                place-holder="Holder Seo Keywords"
                                                                success-text="Success Field"
                                                                help-text="Error Field"
                                                                :required="false"
                                                                :disabled="false"
                                                            />

                                                            @include('backend.layouts.components.textarea',
                                                                 [
                                                                     'lang' => $lang,
                                                                     'data' => $seo,
                                                                     'column' => 'seoDescriptions',
                                                                     'label' => 'Seo Text',
                                                                     'required' => false,
                                                                     'placeHolder' => 'Holder Seo Text',
                                                                     'successText' => 'Success Fild',
                                                                     'helpText' => 'Error Fild',
                                                                ])
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
                                    <div class="col-md-12">
                                        <div class="form-group position-relative select-access">
                                            <label class="control-label font-w600" for="validationTipSelectType">
                                                {{ __('strings.Choose Article Place') }}
                                            </label>

                                            @php
                                            $options = [
                                                '2' => 'Promise',
                                                '3' => 'Main Slider',
                                                '4' => 'Factcheck Newspaper',
                                                '5' => 'Show on Main Page',
                                            ]
                                            @endphp

                                            <select id="validationTipSelectType" class="select2 form-control select2 multi-select" name="options[]" multiple="multiple" required>
                                                @if(isset($article->option_id))
                                                    @foreach(json_decode($article->option_id, true) as $option)
                                                        <option value="{{$option}}" selected>{{$options[$option]}}</option>
                                                    @endforeach
                                                @endif
                                                <option value="2">Promise</option>
                                                <option value="3">Main Slider</option>
                                                <option value="4">Factcheck Newspaper</option>
                                                <option value="5">Show on Main Page</option>
                                            </select>
                                        </div>
                                    </div>

                                    @include('backend.fileManager.layers.both', ['item' => $article])

                                    <div class="col-md-12">
                                        <div class="form-group position-relative select-access">
                                            <label class="control-label font-w600" for="validationTipSelectPerson">
                                                {{ __('strings.Choose Persons And Organizations') }}
                                            </label>
                                            <select id="validationTipSelectPerson" class="select2 form-control select2 multi-select" name="persons[]" multiple="multiple" required>
                                                @if(isset($article->persons))
                                                    @foreach($article->persons as $person)
                                                        <option value="{{$person->id}}" selected>{{$person->getTranslation('title', app()->getLocale())}}</option>
                                                    @endforeach
                                                @else
                                                    <option value="0">{{ __('strings.Persons/Organizations') }}</option>
                                                @endif
                                                @foreach($persons as $key => $person)
                                                    <option value="{{$key}}">{{$person}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group position-relative select-access">
                                            <label class="control-label font-w600" for="validationTipSelectCategory">
                                                {{ __('strings.Choose Article Category') }}
                                            </label>

                                            <select id="validationTipSelectCategory" class="select2 form-control select2 multi-select" name="category[]" multiple="multiple" required>
                                                @if(isset($article->categories))
                                                    @foreach($article->categories as $category)
                                                        <option value="{{$category->id}}" selected>{{$category->getTranslation('title', app()->getLocale())}}</option>
                                                    @endforeach
                                                @else
                                                    <option value="0">{{ __('strings.Categories') }}</option>
                                                @endif
                                                @foreach($articleCategories as $key => $articleCategory)
                                                    <option value="{{$key}}">{{$articleCategory}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group position-relative select-access">
                                            <label class="control-label font-w600" for="validationTipSelectRegion">
                                                {{ __('strings.Choose Region') }}
                                            </label>
                                            <select id="validationTipSelectRegion" class="select2 form-control select2 dropdown-groups" name="region" required>
                                                @if(count($article->regions))
                                                    <option value="{{$article->regions()->first()->id}}">{{ __('strings.Selected') }} - {{$article->regions()->first()->getTranslation('title', app()->getLocale())}}</option>
                                                @else
                                                    <option value="0">{{ __('strings.Region') }}</option>
                                                @endif
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

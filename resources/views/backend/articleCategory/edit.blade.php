@extends('backend.layouts.master')
@section('title') {{ __('strings.Edit Article Category') }} @endsection
@push('styles')
    <link href="{{URL::asset('css/summernote-lite.min.css')}}" rel="stylesheet" type="text/css" >
@endpush
@section('content')
    <div class="container-fluid">
        <div class="form-head d-md-flex mb-sm-4 mb-3 align-items-start">
            <div class="mr-auto  d-lg-block">
                <h2 class="text-black font-w600">{{ __('strings.Edit Article Category') }}</h2>
                <p class="mb-0 font-w600">{{ __('strings.Welcome') }}</p>
            </div>
            @can('backend.articleCategory.index')
                <a href="{{ route('backend.articleCategory.index', app()->getLocale())}}" class="btn btn-info rounded"><i class="flaticon-381-repeat-1"></i> {{ __('strings.Return Back') }} - {{ __('strings.Category Articles') }}</a>
            @endcan
            @can('backend.articleCategory.trash')
                <a href="{{ route('backend.articleCategory.trash', app()->getLocale())}}" class="btn btn-primary rounded light deleted-archive ml-3"><i class="flaticon-381-trash-2"></i>   {{ __('strings.Deleted Category Articles') }}</a>
            @endcan
        </div>
        @include('backend.layouts.components.errors',[
          'errors' => $errors,
        ])
        <form method="POST" class="needs-validation" action="{{ route('backend.articleCategory.update', [app()->getLocale(), $articleCategory->id]) }}"  novalidate enctype="multipart/form-data">
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
                                                    @include('backend.layouts.includes.seoLangTabComponent')
                                                    <div class="tab-content pt-4 pb-0 text-muted no-padding" style="width: 100%">
                                                        <div class="tab-pane active" id="content-locale-{{$lang->code}}" role="tabpanel">
                                                            <x-input
                                                                type="text"
                                                                :lang="$lang"
                                                                :data="$articleCategory"
                                                                label="Title"
                                                                column="title"
                                                                place-holder="Holder Title"
                                                                success-text="Success Field"
                                                                help-text="Error Field"
                                                                :required="true"
                                                                :disabled="false"
                                                            />
                                                            <div class="testtest">
                                                                <div class="col-md-12 pb-2">
                                                                    <div id="clearFormattingBtn{{$lang->code}}" class="btn  btn-primary btn-sm">Clear Formatting - {{$lang->code}}</div>
                                                                </div>
                                                                @include('backend.layouts.components.editorTextarea',
                                                                [
                                                                    'lang' => $lang,
                                                                    'data' => $articleCategory,
                                                                    'column' => 'content',
                                                                    'label' => 'ჩაწერეთ თქვენი ტექსტი!',
                                                                    'required' => false,
                                                                    'placeHolder' => 'Holder Title',
                                                                    'successText' => 'Success Fild',
                                                                    'helpText' => 'Error Filed',
                                                               ])
                                                            </div>
                                                        </div>
                                                        @include('backend.layouts.includes.seoComponent', [
                                                            'lang' => $lang,
                                                            'code' => $lang->code,
                                                            'data' => $seo
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
                                    @include('backend.fileManager.layers.both', ['item' => $articleCategory])
                                    <div class="col-md-12">
                                    <hr>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group position-relative select-access">
                                            <label class="control-label font-w600" for="validationTipSelectParentId">
                                                {{ __('strings.Choose Category General') }}
                                            </label>
                                            <select id="single-select" class="select2 form-control select2" id="validationTipSelectParentId"  name="parent_id" required>
                                                @if(!empty($articleCategory->rowParent))
                                                    <option value="{{$articleCategory->rowParent->id}}">{{ __('strings.Selected') }} : {{$articleCategory->rowParent->getTranslation('title', app()->getLocale())}}</option>
                                                    <option value="0">{{ __('strings.Delete the assigned Category General') }}</option>
                                                @else
                                                    <option value="0">{{ __('strings.Choose Category') }}</option>
                                                @endif
                                                @foreach($articleCategories as $v)
                                                    <option value="{{$v->id}}">{{$v->getTranslation('title', app()->getLocale())}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <hr>
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
    <script src="{{URL::asset('/js/additional/select2.min.js')}}"></script>
    <script src="{{URL::asset('/js/plugins-init/select2-init.js')}}"></script>
    @include('backend.fileManager.templates.filemanager', ['indexRoute' => route('backend.files.index', app()->getLocale())])
@endpush

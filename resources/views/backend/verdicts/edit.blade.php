@extends('backend.layouts.master')
@section('title') {{ __('strings.Edit Verdict') }} @endsection
@push('styles')
    <style>

        .ui-widget-content {
            border: 1px solid #ccc;
            background-image: -webkit-linear-gradient(0deg, #e74646 4%, #e6aa37 24%, #eeca2f 35%, #f6ea26 51%, #97f02f 66%, #38f638 76%, #2f921f);
            border-radius: 10px;
        }

        .ui-widget-header {
            border: 1px solid #aaaaaa;
            color: #222222;
            font-weight: bold;
        }

        .ui-slider { position: relative; text-align: left; }
        .ui-slider .ui-slider-handle { position: absolute; z-index: 2; width: 1.2em; height: 1.2em; cursor: default; }
        .ui-slider .ui-slider-range { position: absolute; z-index: 1; font-size: .7em; display: block; border: 0; background-position: 0 0; }

        .ui-slider-horizontal { height: .8em; }
        .ui-slider-horizontal .ui-slider-handle {
            top: -.3em;
            margin-left: -.6em;
            background: #fff;
            border: 2px solid #409eff;
            border-radius: 100%;
            cursor: pointer;
        }
        .ui-slider-horizontal .ui-slider-range { top: 0; height: 100%;  }
        .ui-slider-horizontal .ui-slider-range-min { left: 0;  }
        .ui-slider-horizontal .ui-slider-range-max { right: 0;}

        #color {
            width: 35px;
            text-align: center;
            font-size: 14px;
        }

        #sliderRange {
            width: 85%;
            float: left;
            margin-right: 3%;
            margin-top: 6px;
            cursor: pointer;
        }

    </style>
@endpush
@section('content')
    <div class="container-fluid">
        <div class="form-head d-md-flex mb-sm-4 mb-3 align-items-start">
            <div class="mr-auto  d-lg-block">
                <h2 class="text-black font-w600">{{ __('strings.Edit Verdict') }}</h2>
                <p class="mb-0 font-w600">{{ __('strings.Welcome') }}</p>
            </div>
            @can('backend.verdicts.index')
                <a href="{{ route('backend.verdicts.index', app()->getLocale())}}" class="btn btn-info rounded"><i class="flaticon-381-repeat-1"></i> {{ __('strings.Return Back') }} - {{ __('strings.All Verdict') }}</a>
            @endcan
            @can('backend.verdicts.trash')
                <a href="{{ route('backend.verdicts.trash', app()->getLocale())}}" class="btn btn-primary rounded light deleted-archive ml-3"><i class="flaticon-381-trash-2"></i>  {{ __('strings.Deleted Verdicts') }}</a>
            @endcan
        </div>
        @include('backend.layouts.components.errors',[
          'errors' => $errors,
        ])
        <form method="POST" class="needs-validation" action="{{ route('backend.verdicts.update', [app()->getLocale(), $verdict->id]) }}"  novalidate enctype="multipart/form-data">
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
                                                                :data="$verdict"
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
                                                                :data="$verdict"
                                                                label="Description"
                                                                column="slogan"
                                                                place-holder="Holder Description"
                                                                success-text="Success Field"
                                                                help-text="Error Field"
                                                                :required="true"
                                                                :disabled="false"
                                                            />
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
                                    <div class="col-md-12">
                                        <hr>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group position-relative select-access">
                                            <label class="control-label font-w600" for="validationTipSelectstatus">
                                                {{ __('strings.Verdict Percentage') }} : {{$verdict->color}}
                                            </label>
                                            <div>
                                                <div id="sliderRange"></div>
                                                <input id="color" name="color" readonly value="{{$verdict->color}}" style="float: left">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div>
                                            <label class="control-label font-w600" for="color1">
                                                {{ __('strings.Verdict Color') }}
                                            </label>
                                            <div>
                                                <input type="color" id="color1" name="colorCode" value="{{$verdict->colorCode}}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <hr>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group position-relative select-access">
                                            <label class="control-label font-w600" for="validationTipSelectParentId">
                                                {{ __('strings.Choose Verdicts General') }}
                                            </label>
                                            <select class="select2 form-control select2" id="validationTipSelectParentId"  name="parent_id" required>
                                                @if(!empty($verdict->rowParent))
                                                    <option value="{{$verdict->rowParent->id}}">{{$verdict->rowParent->getTranslation('title', app()->getLocale())}}</option>
                                                @else
                                                    <option value="0">{{ __('strings.Choose Verdicts Type') }}</option>
                                                @endif
                                                @foreach($verdicts as $v)
                                                    <option value="{{$v->id}}">{{$v->getTranslation('title', app()->getLocale())}}</option>
                                                @endforeach
                                            </select>
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
    @include('backend.fileManager.templates.file-manager-modal')
@endsection
@push('scripts')
    <script src="{{URL::asset('/js/additional/jquery-ui.min.js')}}"></script>
    <script>
        $(document).ready(function(){
            $( "#sliderRange" ).slider({
                value: {{$verdict->color}},
                min: 0,
                max: 100,
                slide: function( event, ui ) {
                    $( "#color" ).val(ui.value);
                }
            });
        });
    </script>
@endpush

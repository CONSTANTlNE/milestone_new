@extends('backend.layouts.master')
@section('title') {{ __('strings.View Verdict') }} @endsection
@section('content')
    <div class="container-fluid">
        <div class="form-head d-md-flex mb-sm-4 mb-3 align-items-start">
            <div class="mr-auto  d-lg-block">
                <h2 class="text-black font-w600">{{ __('strings.View Verdict') }}</h2>
                <p class="mb-0 font-w600">{{ __('strings.Welcome') }}</p>
            </div>
            @can('backend.verdicts.index')
                <a href="{{ route('backend.verdicts.index', app()->getLocale())}}" class="btn btn-info rounded"><i class="flaticon-381-repeat-1"></i> {{ __('strings.Return Back') }} - {{ __('strings.All Verdict') }}</a>
            @endcan
            @can('backend.verdicts.create')
                <a href="{{ route('backend.verdicts.create', app()->getLocale())}}" class="btn btn-primary rounded ml-3"><i class="flaticon-381-add-2"></i> {{ __('strings.Add a new Verdict') }}</a>
            @endcan
            @can('backend.verdicts.trash')
                <a href="{{ route('backend.verdicts.trash', app()->getLocale())}}" class="btn btn-primary rounded light deleted-archive ml-3"><i class="flaticon-381-trash-2"></i> {{ __('strings.Deleted Verdicts') }}</a>
            @endcan
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="bg-primary text-white-50">
                            <div class="card-body" style="color:#fff;">
                                <p class="card-text">{{ __('strings.Create Date') }} -
                                    {{ $verdict->created_at->format('d-m-Y h:i:s') }}
                                </p>
                                @if(!empty($verdict->rowParent))
                                    <hr>
                                    <p class="card-text">{{ __('strings.General Verdict') }} -
                                        @if (Arr::get($verdict->rowParent->getTranslations('title'), app()->getLocale()) === null)
                                            {{ __('strings.Translated') }} {{ implode(', ', array_keys($verdict->rowParent->getTranslations('title'))) }}
                                        @else
                                            {{ $verdict->rowParent->getTranslation('title', app()->getLocale()) }}
                                        @endif
                                    </p>
                                @endif
                                <hr>
                                <h5 class="mt-0 mb-4 text-white"><i class="mdi mdi-bullseye-arrow"></i>
                                    {{ __('strings.Title') }} -
                                    @if (Arr::get($verdict->getTranslations('title'), app()->getLocale()) === null)
                                        {{ __('strings.TranslationTitle') }} ({{ __('strings.Translated') }} {{ implode(', ', array_keys($verdict->getTranslations('title'))) }})
                                    @else
                                        {{Str::limit($verdict->getTranslation('title', app()->getLocale()), 30)}}
                                    @endif
                                </h5>
                                <hr>
                                <p class="card-text">{{ __('strings.Slug') }} -
                                    @if (Arr::get($verdict->getTranslations('slug'), app()->getLocale()) === null)
                                        {{ __('strings.Translated') }} {{ implode(', ', array_keys($verdict->getTranslations('slug'))) }}
                                    @else
                                        {{$verdict->getTranslation('slug', app()->getLocale())}}
                                    @endif
                                </p>
                                @if(!empty($verdict->getTranslations('slogan')))
                                    <hr>
                                    <p class="card-text">{{ __('strings.Slogan') }} -
                                        @if (Arr::get($verdict->getTranslations('slogan'), app()->getLocale()) === null)
                                            {{ __('strings.Translated') }} {{ implode(', ', array_keys($verdict->getTranslations('slogan'))) }}
                                        @else
                                            {{ $verdict->getTranslation('slogan', app()->getLocale()) }}
                                        @endif
                                    </p>
                                @endif

                                <hr>

                                <p class="card-text">{{ __('strings.Status') }} -
                                    @if($verdict->status == "1")
                                        {{ __('strings.Activated') }}
                                    @else
                                        {{ __('strings.Disabled') }}
                                    @endif
                                </p>
                                <hr>
                                <p class="card-text">{{ __('strings.Number of news items') }} - {{ count($verdict->articles) }}
                                </p>
                                <hr>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

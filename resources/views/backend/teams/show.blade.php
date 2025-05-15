@extends('backend.layouts.master')
@section('title') {{ __('strings.View Team') }} @endsection
@section('content')
    <div class="container-fluid">
        <div class="form-head d-md-flex mb-sm-4 mb-3 align-items-start">
            <div class="mr-auto  d-lg-block">
                <h2 class="text-black font-w600">{{ __('strings.View Team') }}</h2>
                <p class="mb-0 font-w600">{{ __('strings.Welcome') }}</p>
            </div>
            @can('backend.teams.index')
                <a href="{{ route('backend.teams.index', app()->getLocale())}}" class="btn btn-info rounded"><i class="flaticon-381-repeat-1"></i> {{ __('strings.Return Back') }} - {{ __('strings.All Team') }}</a>
            @endcan
            @can('backend.teams.create')
                <a href="{{ route('backend.teams.create', app()->getLocale())}}" class="btn btn-primary rounded ml-3"><i class="flaticon-381-add-2"></i> {{ __('strings.Add a new Team') }}</a>
            @endcan
            @can('backend.teams.trash')
                <a href="{{ route('backend.teams.trash', app()->getLocale())}}" class="btn btn-primary rounded light deleted-archive ml-3"><i class="flaticon-381-trash-2"></i> {{ __('strings.Deleted Teams') }}</a>
            @endcan
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="bg-primary text-white-50">
                            <div class="card-body" style="color:#fff;">
                                <p class="card-text">{{ __('strings.Create Date') }} -
                                    {{ $team->created_at->format('d-m-Y h:i:s') }}
                                </p>
                                <hr>
                                <h5 class="mt-0 mb-4 text-white"><i class="mdi mdi-bullseye-arrow"></i>
                                    {{ __('strings.Title') }} -
                                    @if (Arr::get($team->getTranslations('title'), app()->getLocale()) === null)
                                        {{ __('strings.TranslationTitle') }} ({{ __('strings.Translated') }} {{ implode(', ', array_keys($team->getTranslations('title'))) }})
                                    @else
                                        {{Str::limit($team->getTranslation('title', app()->getLocale()), 30)}}
                                    @endif
                                </h5>
                                <hr>

                                <p class="card-text">{{ __('strings.Slug') }} -
                                    @if (Arr::get($team->getTranslations('slug'), app()->getLocale()) === null)
                                        {{ __('strings.Translated') }} {{ implode(', ', array_keys($team->getTranslations('slug'))) }}
                                    @else
                                        {{$team->getTranslation('slug', app()->getLocale())}}
                                    @endif
                                </p>

                                <hr>
                                <h5 class="mt-0 mb-4 text-white"><i class="mdi mdi-bullseye-arrow"></i>
                                    {{ __('strings.Work Position') }} -
                                    @if (Arr::get($team->getTranslations('work'), app()->getLocale()) === null)
                                        {{ __('strings.TranslationTitle') }} ({{ __('strings.Translated') }} {{ implode(', ', array_keys($team->getTranslations('work'))) }})
                                    @else
                                        {{Str::limit($team->getTranslation('work', app()->getLocale()), 30)}}
                                    @endif
                                </h5>
                                <hr>
                                <p class="card-text">{{ __('strings.Status') }} -
                                    @if($team->status == "1")
                                        {{ __('strings.Activated') }}
                                    @else
                                        {{ __('strings.Disabled') }}
                                    @endif
                                </p>
                                <hr>

                                @if(isset($team->generalImage[0]))
                                    @if($team->generalImage[0]->type == "image")
                                        <hr>
                                        <p class="card-text">{{ __('strings.Main Image') }}:
                                            <a href="{{ asset($team->generalImage[0]->src ?? config('filemanager.default_backend_image')) }}" target="black">
                                                <img class="avatar-lg" src="{{ asset($team->generalImage[0]->src ?? config('filemanager.default_backend_image')) }}" style="border: 1px solid #fff;background: #fff;width: 100px">
                                            </a>
                                        </p>
                                        <hr>
                                    @else
                                        <hr>
                                        <p class="card-text">{{ __('strings.Main File') }}:
                                            <a href="{{ asset($team->generalImage[0]->src ?? config('filemanager.default_backend_image')) }}" target="_blank" class="avatar-lg" style="cursor: pointer;font-size: 52px;color: #3b5de7;display: block;background: #f5f9ff;text-align: center;width: 100px"><i class="fa fa-file sss"></i></a>
                                        </p>
                                        <hr>
                                    @endif
                                @else
                                    <hr>
                                    <p class="card-text">{{ __('strings.Main Image') }}:
                                        <a href="{{ asset(config('filemanager.default_backend_image')) }}" target="black">
                                            <img class="avatar-lg" src="{{ asset(config('filemanager.default_backend_image')) }}" style="border: 1px solid #fff;background: #fff;width: 100px">
                                        </a>
                                    </p>
                                    <hr>
                                @endif
                                @if(count($team->allImages))
                                    <hr>
                                    <p class="card-text">{{ __('strings.Additional Images') }}:
                                    <ul style="display: flex;justify-content: left;list-style-type: none;">
                                        @foreach($page->allImages as $img)
                                            @if($img->type == "image")
                                                <li style="margin-right: 10px;"><a href="{{ asset($img->src) }}" target="_blank"><img class=" avatar-lg" src="{{ asset($img->src)}}" style="border: 1px solid #fff;background: #fff;width: 200px"></a></li>
                                            @else
                                                <li style="margin-right: 10px;"><a href="{{ asset($img->src) }}" target="_blank" class="rounded avatar-lg" style="cursor: pointer;font-size: 52px;color: #3b5de7;display: block;background: #f5f9ff;text-align: center;"><i class="fa fa-file sss"></i></a></li>
                                            @endif
                                        @endforeach
                                    </ul>
                                    </p>
                                @endif
                                <hr>
                                <div class="card-text">{{ __('strings.Content') }} -
                                    @if (Arr::get($team->getTranslations('content'), app()->getLocale()) === null)
                                        {{ __('strings.Translated') }} {{ implode(', ', array_keys($team->getTranslations('content'))) ?: __('strings.no_translated') }}
                                    @else
                                        {!! $team->getTranslation('content', app()->getLocale()) !!}
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

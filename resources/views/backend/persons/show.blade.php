@extends('backend.layouts.master')
@section('title') {{ __('strings.View Person') }} @endsection
@section('content')
    <div class="container-fluid">
        <div class="form-head d-md-flex mb-sm-4 mb-3 align-items-start">
            <div class="mr-auto  d-lg-block">
                <h2 class="text-black font-w600">{{ __('strings.View Person') }}</h2>
                <p class="mb-0 font-w600">{{ __('strings.Welcome') }}</p>
            </div>
            @can('backend.persons.index')
                <a href="{{ route('backend.persons.index', app()->getLocale())}}" class="btn btn-info rounded"><i class="flaticon-381-repeat-1"></i> {{ __('strings.Return Back') }} - {{ __('strings.All Person') }}</a>
            @endcan
            @can('backend.persons.create')
                <a href="{{ route('backend.persons.create', app()->getLocale())}}" class="btn btn-primary rounded ml-3"><i class="flaticon-381-add-2"></i> {{ __('strings.Add a new Person') }}</a>
            @endcan
            @can('backend.persons.trash')
                <a href="{{ route('backend.persons.trash', app()->getLocale())}}" class="btn btn-primary rounded light deleted-archive ml-3"><i class="flaticon-381-trash-2"></i> {{ __('strings.Deleted Persons') }}</a>
            @endcan
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="bg-primary text-white-50">
                            <div class="card-body" style="color:#fff;">
                                <p class="card-text">{{ __('strings.Create Date') }} -
                                    {{ $person->created_at->format('d-m-Y h:i:s') }}
                                </p>
                                <hr>
                                <h5 class="mt-0 mb-4 text-white"><i class="mdi mdi-bullseye-arrow"></i>
                                    {{ __('strings.Title') }} -
                                    @if (Arr::get($person->getTranslations('title'), app()->getLocale()) === null)
                                        {{ __('strings.TranslationTitle') }} ({{ __('strings.Translated') }} {{ implode(', ', array_keys($person->getTranslations('title'))) }})
                                    @else
                                        {{Str::limit($person->getTranslation('title', app()->getLocale()), 30)}}
                                    @endif
                                </h5>
                                <hr>

                                <p class="card-text">{{ __('strings.Slug') }} -
                                    @if (Arr::get($person->getTranslations('slug'), app()->getLocale()) === null)
                                        {{ __('strings.Translated') }} {{ implode(', ', array_keys($person->getTranslations('slug'))) }}
                                    @else
                                        {{$person->getTranslation('slug', app()->getLocale())}}
                                    @endif
                                </p>
                                <hr>
                                <p class="card-text">{{ __('strings.Type') }} - {{ ($person->type == 1) ? __('strings.Person') :  __('strings.Organization') }}
                                </p>
                                <hr>
                                <p class="card-text">{{ __('strings.Status') }} -
                                    @if($person->status == "1")
                                        {{ __('strings.Activated') }}
                                    @else
                                        {{ __('strings.Disabled') }}
                                    @endif
                                </p>
                                <hr>
                                <p class="card-text">{{ __('strings.Number of news items') }} - {{ count($person->articles) }}
                                </p>


                                @if(isset($person->generalImage[0]))
                                    @if($person->generalImage[0]->type == "image")
                                        <hr>
                                        <p class="card-text">{{ __('strings.Main Image') }}:
                                            <a href="{{ asset($person->generalImage[0]->src ?? config('filemanager.default_backend_image')) }}" target="black">
                                                <img class="avatar-lg" src="{{ asset($person->generalImage[0]->src ?? config('filemanager.default_backend_image')) }}" style="border: 1px solid #fff;background: #fff;width: 100px">
                                            </a>
                                        </p>
                                    @else
                                        <hr>
                                        <p class="card-text">{{ __('strings.Main File') }}:
                                            <a href="{{ asset($person->generalImage[0]->src ?? config('filemanager.default_backend_image')) }}" target="_blank" class="avatar-lg" style="cursor: pointer;font-size: 52px;color: #3b5de7;display: block;background: #f5f9ff;text-align: center;width: 100px"><i class="fa fa-file sss"></i></a>
                                        </p>
                                    @endif
                                @else
                                    <hr>
                                    <p class="card-text">{{ __('strings.Main Image') }}:
                                        <a href="{{ asset(config('filemanager.default_backend_image')) }}" target="black">
                                            <img class="avatar-lg" src="{{ asset(config('filemanager.default_backend_image')) }}" style="border: 1px solid #fff;background: #fff;width: 100px">
                                        </a>
                                    </p>
                                @endif
                                @if(count($person->allImages))
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
                                    @if (Arr::get($person->getTranslations('content'), app()->getLocale()) === null)
                                        {{ __('strings.Translated') }} {{ implode(', ', array_keys($person->getTranslations('content'))) ?: __('strings.no_translated') }}
                                    @else
                                        {!! $person->getTranslation('content', app()->getLocale()) !!}
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

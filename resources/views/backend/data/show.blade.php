@extends('backend.layouts.master')
@section('title') {{ __('strings.View Data') }} @endsection
@section('content')
    <div class="container-fluid">
        <div class="form-head d-md-flex mb-sm-4 mb-3 align-items-start">
            <div class="mr-auto  d-lg-block">
                <h2 class="text-black font-w600">{{ __('strings.View Data') }}</h2>
                <p class="mb-0 font-w600">{{ __('strings.Welcome') }}</p>
            </div>
            @can('backend.data.index')
                <a href="{{ route('backend.data.index', app()->getLocale())}}" class="btn btn-info rounded"><i class="flaticon-381-repeat-1"></i> {{ __('strings.Return Back') }} - {{ __('strings.All Data') }}</a>
            @endcan
            @can('backend.data.create')
                <a href="{{ route('backend.data.create', app()->getLocale())}}" class="btn btn-primary rounded ml-3"><i class="flaticon-381-add-2"></i> {{ __('strings.Add a new Data') }}</a>
            @endcan
            @can('backend.data.trash')
                <a href="{{ route('backend.data.trash', app()->getLocale())}}" class="btn btn-primary rounded light deleted-archive ml-3"><i class="flaticon-381-trash-2"></i> {{ __('strings.Deleted Data') }}</a>
            @endcan
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="bg-primary text-white-50">
                            <div class="card-body" style="color:#fff;">
                                <p class="card-text">{{ __('strings.Create Date') }} -
                                    {{ $data->created_at->format('d-m-Y h:i:s') }}
                                </p>
                                <hr>
                                <h5 class="mt-0 mb-4 text-white"><i class="mdi mdi-bullseye-arrow"></i>
                                    {{ __('strings.Title') }} -
                                    @if (Arr::get($data->getTranslations('title'), app()->getLocale()) === null)
                                        {{ __('strings.TranslationTitle') }} ({{ __('strings.Translated') }} {{ implode(', ', array_keys($data->getTranslations('title'))) }})
                                    @else
                                        {{Str::limit($data->getTranslation('title', app()->getLocale()), 30)}}
                                    @endif
                                </h5>
                                <hr>

                                <p class="card-text">{{ __('strings.Slug') }} -
                                    @if (Arr::get($data->getTranslations('slug'), app()->getLocale()) === null)
                                        {{ __('strings.Translated') }} {{ implode(', ', array_keys($data->getTranslations('slug'))) }}
                                    @else
                                        {{$data->getTranslation('slug', app()->getLocale())}}
                                    @endif
                                </p>

                                <hr>
                                <h5 class="mt-0 mb-4 text-white"><i class="mdi mdi-bullseye-arrow"></i>
                                    {{ __('strings.Links') }} -
                                    @if (Arr::get($data->getTranslations('links'), app()->getLocale()) === null)
                                        {{ __('strings.TranslationTitle') }} ({{ __('strings.Translated') }} {{ implode(', ', array_keys($data->getTranslations('links'))) }})
                                    @else
                                        {{$data->getTranslation('links', app()->getLocale())}}
                                    @endif
                                </h5>
                                <hr>
                                <p class="card-text">{{ __('strings.Status') }} -
                                    @if($data->status == "1")
                                        {{ __('strings.Activated') }}
                                    @else
                                        {{ __('strings.Disabled') }}
                                    @endif
                                </p>
                                <hr>

                                @if(isset($locale->generalImage[0]))
                                    @if($locale->generalImage[0]->type == "image")
                                        <p class="card-text">{{ __('strings.Main Image') }}:
                                            <a href="{{ asset($locale->generalImage[0]->src ?? config('filemanager.default_backend_image')) }}" target="black">
                                                <img class="avatar-lg" src="{{ asset($locale->generalImage[0]->src ?? config('filemanager.default_backend_image')) }}" style="border: 1px solid #fff;background: #fff;width: 100px">
                                            </a>
                                        </p>
                                        <hr>
                                    @else
                                        <p class="card-text">{{ __('strings.Main File') }}:
                                            <a href="{{ asset($locale->generalImage[0]->src ?? config('filemanager.default_backend_image')) }}" target="_blank" class="avatar-lg" style="cursor: pointer;font-size: 52px;color: #3b5de7;display: block;background: #f5f9ff;text-align: center;width: 100px"><i class="fa fa-file sss"></i></a>
                                        </p>
                                        <hr>
                                    @endif
                                @else
                                    <p class="card-text">{{ __('strings.Main Image') }}:
                                        <a href="{{ asset(config('filemanager.default_backend_image')) }}" target="black">
                                            <img class="avatar-lg" src="{{ asset(config('filemanager.default_backend_image')) }}" style="border: 1px solid #fff;background: #fff;width: 100px">
                                        </a>
                                    </p>
                                    <hr>
                                @endif
                                @if(count($data->allImages))
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
                                @if(!empty($data->files))
                                    <hr>
                                    <ul style="display: flex;justify-content: left;list-style-type: none;">
                                        @php
                                        $file = explode(',', $data->files);
                                        $sent = $file[0];
                                        $received = trim($file[1]);
                                        @endphp
                                        @if(!empty($sent))
                                            <li style="margin-right: 10px;"><a href="{{ asset($sent) }}" target="_blank" class="rounded avatar-lg" style="cursor: pointer;font-size: 52px;color: #3b5de7;display: block;background: #f5f9ff;text-align: center;">Sent - <i class="fa fa-file sss"></i></a></li>
                                        @else
                                            Sent: Empty
                                        @endif
                                        @if(!empty($received))
                                            <li style="margin-right: 10px;"><a href="{{asset($received)}}" target="_blank" class="rounded avatar-lg" style="cursor: pointer;font-size: 52px;color: #3b5de7;display: block;background: #f5f9ff;text-align: center;">Received - <i class="fa fa-file sss"></i></a></li>
                                        @else
                                            Received: Empty
                                        @endif
                                    </ul>
                                @endif
                                <hr>
                                <div class="card-text">{{ __('strings.Content') }} -
                                    @if (Arr::get($data->getTranslations('content'), app()->getLocale()) === null)
                                        {{ __('strings.Translated') }} {{ implode(', ', array_keys($data->getTranslations('content'))) ?: __('strings.no_translated') }}
                                    @else
                                        {!! $data->getTranslation('content', app()->getLocale()) !!}
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

@extends('backend.layouts.master')
@section('title') {{ __('strings.View Article') }} @endsection
@section('content')
    <div class="container-fluid">
        <div class="form-head d-md-flex mb-sm-4 mb-3 align-items-start">
            <div class="mr-auto  d-lg-block">
                <h2 class="text-black font-w600">{{ __('strings.View Article') }}</h2>
                <p class="mb-0 font-w600">{{ __('strings.Welcome') }}</p>
            </div>
            @can('backend.articles.index')
                <a href="{{ route('backend.articles.index', app()->getLocale())}}" class="btn btn-info rounded"><i class="flaticon-381-repeat-1"></i> {{ __('strings.Return Back') }} - {{ __('strings.All Article') }}</a>
            @endcan
            @can('backend.articles.create')
                <a href="{{ route('backend.articles.create', app()->getLocale())}}" class="btn btn-primary rounded ml-3"><i class="flaticon-381-add-2"></i> {{ __('strings.Add a new Article') }}</a>
            @endcan
            @can('backend.articles.trash')
                <a href="{{ route('backend.articles.trash', app()->getLocale())}}" class="btn btn-primary rounded light deleted-archive ml-3"><i class="flaticon-381-trash-2"></i> {{ __('strings.Deleted Articles') }}</a>
            @endcan
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="bg-primary text-white-50">
                            <div class="card-body" style="color:#fff;">
                                <p class="card-text">{{ __('strings.Create Date') }} -
                                    {{ $article->created_at->format('d-m-Y h:i:s') }}
                                </p>
                                <hr>
                                <h5 class="mt-0 mb-4 text-white"><i class="mdi mdi-bullseye-arrow"></i>
                                    {{ __('strings.Title') }} -
                                    @if (Arr::get($article->getTranslations('title'), app()->getLocale()) === null)
                                        {{ __('strings.TranslationTitle') }} ({{ __('strings.Translated') }} {{ implode(', ', array_keys($article->getTranslations('title'))) }})
                                    @else
                                        {{Str::limit($article->getTranslation('title', app()->getLocale()), 255)}}
                                    @endif
                                </h5>
                                <hr>
                                <p class="card-text">{{ __('strings.Slug') }} -
                                    @if (Arr::get($article->getTranslations('slug'), app()->getLocale()) === null)
                                        {{ __('strings.Translated') }} {{ implode(', ', array_keys($article->getTranslations('slug'))) }}
                                    @else
                                        {{$article->getTranslation('slug', app()->getLocale())}}
                                    @endif
                                </p>
                                @if(!empty($article->getTranslations('slogan')))
                                    <hr>
                                    <p class="card-text">{{ __('strings.Slogan') }} -
                                        @if (Arr::get($article->getTranslations('slogan'), app()->getLocale()) === null)
                                            {{ __('strings.Translated') }} {{ implode(', ', array_keys($article->getTranslations('slogan'))) }}
                                        @else
                                            {{ $article->getTranslation('slogan', app()->getLocale()) }}
                                        @endif
                                    </p>
                                @endif

                                <hr>

                                <p class="card-text">{{ __('strings.Status') }} -
                                    @if($article->status == "1")
                                        {{ __('strings.Activated') }}
                                    @else
                                        {{ __('strings.Disabled') }}
                                    @endif
                                </p>
                                <hr>
                                <p class="card-text">სიახლეების კატეგორია -
                                    @if(count($article->categories))
                                        @foreach($article->categories as $category)
                                            {{$category->getTranslation('title', app()->getLocale())}},
                                        @endforeach
                                    @else
                                        კატეგორიის გარეშე
                                    @endif
                                </p>
                                <hr>
                                <p class="card-text">სიახლეების ავტორი -
                                    {{$article->reporter->getTranslation('title', app()->getLocale()) ?? "ავტორის გარეშე"}}
                                </p>
                                <hr>
                                <p class="card-text">სიახლეების პერსონა/ორგანიზაცია -
                                    @if(count($article->persons))
                                        @foreach($article->persons as $person)
                                            {{$person->getTranslation('title', app()->getLocale())}},
                                        @endforeach
                                    @else
                                        პერსონა/ორგანიზაციის გარეშე
                                    @endif
                                </p>
                                <hr>

                                <p class="card-text">ვერდიქტი -
                                    @if(isset($article->verdict_id))
                                        {{$article->verdict->first()->getTranslation('title', app()->getLocale()) ?? "ვერდიქტი გარეშე"}}
                                    @else
                                        ვერდიქტი გარეშე
                                    @endif
                                </p>
                                <hr>
                                <p class="card-text">რეგიონები -
                                    @if(count($article->regions))
                                        {{$article->regions()->first()->getTranslation('title', app()->getLocale()) ?? "რეგიონები გარეშე"}}
                                    @else
                                        რეგიონები გარეშე
                                    @endif
                                </p>
                                <hr>

                                <?php $images = $article->mainImageShow(); ?>
                                @if($images->type == "image")
                                    <p class="card-text">{{ __('strings.Main Image') }}:
                                        <a href="{{ asset($images->src) }}" target="black">
                                            <img class="avatar-lg" src="{{ asset($images->src)}}" style="border: 1px solid #fff;background: #fff;width: 100px">
                                        </a>
                                    </p>
                                @else
                                    <p class="card-text">{{ __('strings.Main File') }}:
                                        <a href="{{ asset($images->src) }}" target="_blank" class="avatar-lg" style="cursor: pointer;font-size: 52px;color: #3b5de7;display: block;background: #f5f9ff;text-align: center;width: 100px"><i class="fa fa-file sss"></i></a>
                                    </p>
                                @endif
                                @if(count($article->allImages))
                                    <hr>
                                    <p class="card-text">{{ __('strings.Additional Images') }}:
                                    <ul style="display: flex;justify-content: left;list-style-type: none;">
                                        @foreach($article->allImages as $img)
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
                                    @if (Arr::get($article->getTranslations('content'), app()->getLocale()) === null)
                                        {{ __('strings.Translated') }} {{ implode(', ', array_keys($article->getTranslations('content'))) ?: __('strings.no_translated') }}
                                    @else
                                        {!! $article->getTranslation('content', app()->getLocale()) !!}
                                    @endif
                                </div>
                                <hr>
                                <p class="card-text">ტეგები -
                                    @if(count($article->tagViews(app()->getLocale())->get()))
                                        @foreach($article->tagViews(app()->getLocale())->get() as $tags)
                                            {{$tags->title}},
                                        @endforeach
                                    @else
                                        ტეგებიის გარეშე
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

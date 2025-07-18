@extends('backend.layouts.master')
@section('title') {{ __('admin.view_service') }} @endsection
@section('content')
    <div class="content">
        <div class="main-content">
            <div class="block justify-between page-header md:flex">
                <div>
                    <h3 class="!text-defaulttextcolor dark:!text-defaulttextcolor/70 dark:text-white dark:hover:text-white text-[1.375rem] font-semibold font-first-geo">
                        {{ __('admin.view_service') }}
                    </h3>
                    <p class="font-second-geo text-defaulttextcolor/70">{{ __('admin.welcome') }}</p>
                </div>
                <ol class="flex items-center whitespace-nowrap min-w-0 gap-3 header-nav-links">
                    @can('backend.services.index')
                        <li class="text-[0.813rem] ps-[0.5rem]">
                            <a href="{{ route('backend.services.index') }}" class="ti-btn bg-secondary text-white !font-medium font-second-geo">
                                <i class="ri-arrow-go-back-line text-[1.375rem]"></i>
                                {{ __('admin.return_back') }} - {{ __('admin.all_services') }}
                            </a>
                        </li>
                    @endcan
                    @can('backend.services.update')
                        <li class="text-[0.813rem] ps-[0.5rem]">
                            <a href="{{ route('backend.services.edit', $service->id) }}" class="ti-btn bg-warning text-white !font-medium font-second-geo">
                                <i class="ri-edit-line text-[1.375rem]"></i>
                                {{__('admin.edit_services')}}
                            </a>
                        </li>
                    @endcan
                    @can('backend.services.trash')
                        <li class="text-[0.813rem] text-defaulttextcolor font-semibold hover:text-danger dark:text-[#8c9097] dark:text-white/50">
                            <a href="{{ route('backend.services.trash') }}" class="ti-btn bg-danger text-white !font-medium font-second-geo">
                                <i class="ri-delete-bin-2-line text-[1.375rem]"></i>
                                {{__('admin.deleted_services')}}
                            </a>
                        </li>
                    @endcan
                </ol>
            </div>

            <div class="grid grid-cols-12 gap-6 white-bg">
                <div class="xl:col-span-9 col-span-12">
                    <div class="box">
                        <div class="box-body">
                            <div class="flex items-center space-x-4 p-4 bg-primary/5 rounded-lg">
                                <div class="w-12 h-12 bg-primary/10 rounded-full flex items-center justify-center">
                                    <i class="ri ri-service-line text-2xl text-primary"></i>
                                </div>
                                <div class="mx-3">
                                    <h4 class="text-lg font-semibold text-gray-900 dark:text-white">
                                        {{ $service->getTranslation('title', app()->getLocale()) ?: $service->getTranslation('title', 'en') }}
                                    </h4>
                                    <p class="text-sm text-gray-500 font-second-geo">
                                        {{ __('admin.service_id') }}: #{{ $service->id }} | {{ __('admin.status') }}
                                        <span class="text-white badge {{ $service->status ? 'bg-success' : 'bg-secondary' }}">
                                            {{ $service->status ? __('admin.active') : __('admin.inactive') }}
                                        </span>
                                    </p>
                                    <hr>
                                </div>
                            </div>

                            <div class="items-center space-x-4 p-4 bg-primary/5 rounded-lg mt-4">
                                <p class="text-sm text-gray-500 font-second-geo">
                                    {{ __('admin.short_description') }}: {{ $service->slogan }}
                                </p>
                            </div>

                            <div class="items-center space-x-4 p-4 bg-primary/5 rounded-lg mt-4 text-sm text-gray-500 font-second-geo">
                                <p>
                                    {{ __('admin.content') }}: {!! $service->content !!}
                                </p>
                            </div>
                            @if(count($service->faqs))
                                <div class="items-center space-x-4 p-4 bg-primary/5 rounded-lg mt-4 text-sm text-gray-500 font-second-geo">
                                        {{ __('admin.faqs') }}:
                                    @foreach($service->faqs as $faq)
                                        <div class="w-full">
                                            {{ __('admin.answer') }} : {{$faq->title}}<br>
                                            {{ __('admin.question') }} : {{$faq->content}}
                                        </div>
                                        --------------------------
                                        @endforeach

                                </div>
                            @endif

                            @if(count($service->features))
                                <div class="items-center space-x-4 p-4 bg-primary/5 rounded-lg mt-4 text-sm text-gray-500 font-second-geo">
                                        {{ __('admin.feature') }}:
                                    @foreach($service->features as $feature)
                                        <div class="w-full">
                                            {{ __('admin.title') }} : {{$feature->title}}
                                        </div>
                                        --------------------------
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="xl:col-span-3 col-span-12">
                    <div class="box">
                        <div class="box-body">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="bg-gray-50 dark:bg-gray-800 p-4 rounded-lg">
                                    <h6 class="font-medium text-gray-900 dark:text-white mb-2">
                                        <i class="ri-image-line me-2"></i>
                                        {{ __('admin.image') }}
                                    </h6>
                                    <p class="card-text">
                                        <x-backend.imageDefault :src="$service->src" />
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

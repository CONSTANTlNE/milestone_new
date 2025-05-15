@extends('backend.layouts.master')
@section('title') {{ __('strings.Partners') }} @endsection
@push('styles')
    <link href="{{URL::asset('css/additional/toastr.min.css')}}" rel="stylesheet" type="text/css" >
@endpush
@section('content')
    <div class="container-fluid">
        <div class="form-head d-md-flex mb-sm-4 mb-3 align-items-start">
            <div class="mr-auto  d-lg-block">
                <h2 class="text-black font-w600">{{ __('strings.Partners') }} - {{ __('strings.Reorder') }}</h2>
                <p class="mb-0 font-w600">{{ __('strings.Welcome') }}</p>
            </div>
            @can('backend.partners.index')
                <a href="{{ route('backend.partners.index', app()->getLocale())}}" class="btn btn-info rounded"><i class="flaticon-381-repeat-1"></i> {{ __('strings.Return Back') }} - {{ __('strings.Partners') }}</a>
            @endcan
            @can('backend.partners.create')
                <a href="{{ route('backend.partners.create', app()->getLocale()) }}" class="btn btn-primary rounded ml-3"><i class="flaticon-381-add-2"></i> {{ __('strings.Add a new Partner') }}</a>
            @endcan
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-responsive-md">
                                <thead>
                                    <tr>
                                    <th class="width80"><strong>#id</strong></th>
                                    <th><strong>{{ __('strings.Title') }}</strong></th>
                                    <th><strong>{{ __('strings.Create Date') }}</strong></th>
                                    <th><strong>{{ __('strings.Images') }}</strong></th>
                                </tr>
                                </thead>
                                <tbody id="post_sortable" class="post_list_ul"
                                       data-reorder="{{route('backend.partners.reorder', app()->getLocale())}}"
                                >
                                    @foreach($partners as $partner)
                                    <tr class="ui-state-default" data-id="{{ $partner->id }}">
                                        <td><strong>{{$partner->id}}</strong></td>
                                        <td>
                                            @if (Arr::get($partner->getTranslations('title'), app()->getLocale()) === null)
                                                {{ __('strings.TranslationTitle') }} ({{ __('strings.Translated') }} {{ implode(', ', array_keys($partner->getTranslations('title'))) }})
                                            @else
                                                {{Str::limit($partner->getTranslation('title', app()->getLocale()), 30)}}
                                            @endif
                                        </td>
                                        <td>{{ $partner->created_at->format('d-m-Y h:i:s') }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="{{ asset($partner->generalImage[0]->src ?? config('filemanager.default_backend_image')) }}" class="rounded-lg mr-2" width="24" alt="">
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="{{URL::asset('/js/additional/sortable.min.js')}}"></script>
@endpush

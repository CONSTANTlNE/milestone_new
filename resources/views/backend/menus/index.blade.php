@extends('backend.layouts.master')
@section('title') {{ __('strings.All MenuTrait') }} @endsection
@section('content')
    <div class="container-fluid">
        <div class="form-head d-md-flex mb-sm-2 mb-1 align-items-start">
            <div class="mr-auto  d-lg-block">
                <h2 class="text-black font-w600">{{ __('strings.All MenuTrait') }}</h2>
                <p class="mb-0 font-w600">{{ __('strings.Welcome') }}</p>
            </div>
            @can('backend.locales.index')
                <div class="form-validation col-8 addNewLanguage">
                    <form class="form-valide form-inline justify-content-end" method="POST" action="{{ route('backend.menus.store', app()->getLocale()) }}">
                        @csrf
                        <div class="form-group has-float-label col-5 pl-0">
                            <label class="font-w600 fs-14" for="menuValue">
                                მენიუ დასახელება (მენიუს დასახელება უნდა იყოს უნიკალური)
                                <span class="text-danger">*</span>
                            </label>
                            <div class="w-100 position-relative pb-3">
                                <input type="text" name="menuValue" id="menuValue"
                                       class="form-control w-100"
                                       data-required="{{ __('strings.Error Value') }}"
                                       data-minlength="{{ __('strings.Error Invalid Value') }}">
                            </div>
                        </div>
                        <button class="btn btn-primary shadow mr-3" type="submit"><i class="flaticon-381-add-1"></i></button>
                        <a href="{{ route('backend.menus.index', app()->getLocale()) }}" class="btn btn-warning shadow font-w600">{{ __('strings.Reset') }}</a>
                    </form>
                </div>
            @endcan
        </div>
        @if(session('success'))
            @include('backend.layouts.components.success',[
              'success' => session('success'),
            ])
        @endif
        @if(session('error'))
            @include('backend.layouts.components.error',[
              'error' => session('error'),
            ])
        @endif
        <div class="row">
            <div class="col-lg-12">
                @foreach($menus as $menu)
                    <div class="card col-lg-3 float-left mr-4" style="height: auto;">
                        <div class="card-body pl-2 pr-2">
                            <div class="table-responsive">
                                <table class="table justify-content-end m-0">
                                    <thead>
                                    <tr>
                                        <th><strong>მენიუს დასახელება</strong></th>
                                        <th class="text-right"><strong>მოქმედება</strong></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>{{$menu->name}}</td>
                                        <td>
                                            <div class="d-flex justify-content-end">
                                                @can('backend.locales.edit')
                                                    <a href="{{ route('backend.menus.edit', [app()->getLocale(), 'id'=>$menu->id]) }}" class="btn btn-primary shadow btn-xs sharp mr-1"><i class="flaticon-381-edit-1"></i></a>
                                                @endcan
                                                @can('backend.locales.destroy')
                                                    <form action="{{ route('backend.menus.destroy', [app()->getLocale(), 'id'=>$menu->id]) }}" method="POST" class="action-list d-inline-block" onsubmit="return confirm('{{ __('strings.You really want to delete it') }}');">
                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                        <button class="btn btn-danger shadow btn-xs sharp"><i class="flaticon-381-trash-2"></i></button>
                                                    </form>
                                                @endcan
                                            </div>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

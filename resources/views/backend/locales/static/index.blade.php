@extends('backend.layouts.master')
@section('title') {{ __('strings.All Static Words') }}  @endsection
@section('content')
    <div class="container-fluid static-words">
        <div class="form-head d-md-flex mb-sm-4 mb-3 align-items-start">
            <div class="mr-auto  d-lg-block">
                <h2 class="text-black font-w600">{{ __('strings.Static Words') }}</h2>
                <p class="mb-0 font-w600">{{ __('strings.Welcome') }}</p>
            </div>
            @can('backend.locales.index')
            <div class="form-validation col-8 addNewLanguage">
                <form class="form-valide form-inline" method="POST" action="{{ route('backend.translation.create', app()->getLocale()) }}">
                    @csrf
                    <div class="form-group has-float-label col-4 w-100">
                        <label class="font-w600 fs-14" for="localeKey">
                            {{ __('strings.Main Keywords') }} (Key)
                            <span class="text-danger"> *</span>
                        </label>
                        <div class="w-100 position-relative pb-3">
                            <input type="text" name="localeKey" id="localeKey"
                                   class="form-control w-100"
                                   data-required="{{ __('strings.Error Invalid Key') }}"
                                   data-minlength="{{ __('strings.Error Key') }}">
                        </div>
                    </div>
                    <div class="form-group has-float-label col-5 pl-0">
                        <label class="font-w600 fs-14" for="localeValue">
                            {{ __('strings.Word') }} ({{ __('strings.The first is added to the main language') }} - {{ $default->name }})
                            <span class="text-danger">*</span>
                        </label>
                        <div class="w-100 position-relative pb-3">
                            <input type="text" name="localeValue" id="localeValue"
                                   class="form-control w-100"
                                   data-required="{{ __('strings.Error Value') }}"
                                   data-minlength="{{ __('strings.Error Invalid Value') }}">
                        </div>
                    </div>
                    <button class="btn btn-primary shadow mr-3" type="submit"><i class="flaticon-381-add-1"></i></button>
                    <a href="{{ route('backend.locales.static.index', app()->getLocale()) }}" class="btn btn-warning shadow font-w600">{{ __('strings.Reset') }}</a>
                </form>
            </div>
            @endcan
        </div>
        <!-- row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                        @can('backend.locales.index')
                            <table class="table table-responsive-md">
                                <thead class="thead-light">
                                <tr>
                                    <th>Key</th>
                                    @if($languages->count() > 0)
                                        @foreach($languages as $language)
                                            <th>{{ $language->name }}({{ $language->code }})</th>
                                        @endforeach
                                    @endif
                                    <th width="80px;">{{ __('strings.Actions') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if($columnsCount > 0)
                                    @foreach($columns[array_key_first($columns)] as $columnKey => $columnValue)
                                        <tr>
                                            <td><label class="translate-key" data-title="Enter Key" data-type="text" data-pk="{{ $columnKey }}" data-url="{{ route('backend.translation.update.json.key', app()->getLocale()) }}">{{ $columnKey }}</label></td>
                                            @for($i=1; $i<=$columnsCount; ++$i)
                                                <td>
                                                    <label class="translate"
                                                           data-title="Enter Translate"
                                                           data-code="{{ $columns[$i]['lang'] }}"
                                                           data-name="{{ isset($columns[$i]['data'][$columnKey]) ? $columns[$i]['data'][$columnKey] : '' }}"
                                                           data-type="textarea" data-pk="{{ $columnKey }}"
                                                           data-url="{{ route('backend.translation.update.json', app()->getLocale()) }}">
                                                        {!! isset($columns[$i]['data'][$columnKey]) ? $columns[$i]['data'][$columnKey] : '<span class="emptyText"><i class="flaticon-381-add-2"></i></span>' !!}
                                                    </label>
                                                </td>
                                            @endfor
                                            <td>
                                                <button data-action="{{ route('backend.translation.destroy', app()->getLocale()) }}" data-pk="{{ $columnKey }}" class="btn btn-danger shadow btn-sm float-right sharp remove-key">
                                                    <i class="flaticon-381-trash-2"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                           @endcan
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

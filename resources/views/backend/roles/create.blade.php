@extends('backend.layouts.master')
@section('title') {{ __('strings.Role Create') }} @endsection
@section('content')
    <div class="container-fluid">
        <div class="form-head d-md-flex mb-sm-4 mb-3 align-items-start">
            <div class="mr-auto  d-lg-block">
                <h2 class="text-black font-w600">{{ __('strings.Role Create') }}</h2>
                <p class="mb-0 font-w600">{{ __('strings.Welcome') }}</p>
            </div>
            @can('backend.roles.index')
                <a href="{{ route('backend.roles.index', app()->getLocale())}}" class="btn btn-info rounded"><i class="flaticon-381-repeat-1"></i> {{ __('strings.Return Back') }} - {{ __('strings.All Role') }}</a>
            @endcan
            @can('backend.roles.trash')
                <a href="{{ route('backend.roles.trash', app()->getLocale())}}" class="btn btn-primary rounded light deleted-archive ml-3"><i class="flaticon-381-trash-2"></i>  {{ __('strings.Deleted Roles') }}</a>
            @endcan
        </div>
        @include('backend.layouts.components.errors',[
          'errors' => $errors,
        ])
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <form method="post" class="needs-validation" action="{{ route('backend.roles.store', app()->getLocale()) }}" novalidate>
                            {{csrf_field()}}
                            <div class="col-md-12">
                                @include('backend.layouts.includes.langTabComponent')
                                <div class="tab-content p-3 text-muted">
                                    @foreach(getLocales() as $key => $lang)
                                        <div class="tab-pane {{($key == 0) ? 'active' : ''}}" id="locale-{{$lang->code}}" role="tabpanel">
                                            <div class="row">
                                                <x-input
                                                    type="text"
                                                    :lang="$lang"
                                                    :data="null"
                                                    label="Title"
                                                    column="title"
                                                    place-holder="Holder Title"
                                                    success-text="Success Field"
                                                    help-text="Error Field"
                                                    :required="false"
                                                    :disabled="false"
                                                    width="12"
                                                />
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            <hr>

                            <div class="row p-3">
                            	@include('backend.layouts.components.textField',
                                    [  'lang' => null,
                                       'data' => '',
                                       'column' => 'name',
                                       'label' => 'Role Code',
                                       'required' => true,
                                       'placeHolder' => 'Role Example',
                                       'successText' => 'Success Field',
                                       'helpText' => 'Error Field',
                                    ])

                                <div class="col-md-9">
                                    <div class="form-group position-relative select-access">
                                        <label for="validationTooltip05" class="control-label font-w600">{{ __('strings.Choose Permissions') }}</label>
                                        <select class="select2 form-control select2-multiple" title="{{ __('strings.View all Permissions') }}" id="validationTooltip05" name="permission[]" multiple="multiple" data-placeholder="{{ __('strings.Choose Permissions') }}" required>
                                            <option value="0">{{ __('strings.Choose Permissions') }}</option>
                                            @foreach($permissions as $permission)
                                                <option value="{{ $permission->id }}">{{ $permission->getTranslation('title', app()->getLocale()) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group position-relative select-access">
                                        <label for="has_backend_access" class="control-label font-w600">{{ __('strings.Access to the Admin Panel') }}</label>
                                        <select class="form-control select2" name="has_backend_access" id="has_backend_access" required>
                                            <option value="true">{{ __('strings.Activate') }}</option>
                                            <option value="false">{{ __('strings.Blocked') }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                            <x-checkbox
                                column="block"
                                label="Review"
                                place-holder="Review"
                                success-text="Checkbox Success"
                                help-text="Checkbox Error"
                                :required="true"
                            />

                        <div class="col-md-12 p-3">
                            <button class="btn btn-primary" type="submit">{{ __('strings.Create') }}</button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="{{URL::asset('/js/additional/form-advanced.min.js')}}"></script>
@endpush

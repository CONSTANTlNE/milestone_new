@extends('backend.layouts.master')
@section('title') {{ __('strings.Edit User') }} @endsection
@section('content')
    <div class="container-fluid">
        <div class="form-head d-md-flex mb-sm-4 mb-3 align-items-start">
            <div class="mr-auto  d-lg-block">
                <h2 class="text-black font-w600">{{ __('strings.Edit User') }}</h2>
                <p class="mb-0 font-w600">{{ __('strings.Welcome') }}</p>
            </div>
            @can('backend.users.index')
                <a href="{{ route('backend.users.index', app()->getLocale())}}" class="btn btn-info rounded"><i class="flaticon-381-repeat-1"></i> {{ __('strings.Return Back') }} - {{ __('strings.All User') }}</a>
            @endcan
            @can('backend.users.trash')
                <a href="{{ route('backend.users.trash', app()->getLocale())}}" class="btn btn-primary rounded light deleted-archive ml-3"><i class="flaticon-381-trash-2"></i>  {{ __('strings.Deleted Users') }}</a>
            @endcan
        </div>

        @include('backend.layouts.components.errors',[
          'errors' => $errors,
        ])

        <form method="POST" class="needs-validation" action="{{ route('backend.users.update', [app()->getLocale(), $user->id]) }}"  novalidate enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-12 p-0">
                    <div class="col-md-12 col-xl-9 float-left">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        @include('backend.layouts.includes.langTabComponent')
                                        <div class="tab-content">
                                            @foreach(getLocales() as $key => $lang)
                                                <div class="tab-pane {{($key == 0) ? 'active' : ''}}" id="locale-{{$lang->code}}" role="tabpanel">
                                                    <div class="row">
                                                        <x-input
                                                            type="text"
                                                            :lang="$lang"
                                                            :data="$user"
                                                            label="Name Surname"
                                                            column="title"
                                                            place-holder="Holder Full Name"
                                                            success-text="Success Field"
                                                            help-text="Error Field"
                                                            :required="false"
                                                            :disabled="false"
                                                            width="6"
                                                        />
                                                        <x-input
                                                            type="text"
                                                            :lang="$lang"
                                                            :data="$user"
                                                            column="about"
                                                            label="About"
                                                            place-holder="Holder About"
                                                            success-text="Success Field"
                                                            help-text="Error Field"
                                                            :required="false"
                                                            :disabled="false"
                                                            width="6"
                                                        />
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <x-input
                                                type="email"
                                                :lang="null"
                                                :data="$user"
                                                column="email"
                                                label="Email"
                                                place-holder=""
                                                success-text="Success Field"
                                                help-text="Error Field"
                                                :required="true"
                                                :disabled="false"
                                                width="6"
                                            />
                                            @php
                                            $x = '';
                                            if (!empty($user->roles()->pluck('id')->implode(' '))){
                                            $x = '<option value="'.$user->roles()->pluck('id')->implode(' ').'">'.__('strings.Name of the chosen role') .' : '. $user->roles()->pluck('name')->implode(' ') .'</option>';
                                            }
                                            @endphp
                                            <x-select
                                                :lang="null"
                                                :data="$roles"
                                                :dataSingle="$x"
                                                column="role"
                                                label="Role"
                                                place-holder="Choose Role Title"
                                                success-text="Success Field"
                                                help-text="Error Field"
                                                :required="true"
                                                :disabled="false"
                                                :staticData="true"
                                                width="6"
                                            />
                                            <x-input
                                                type="password"
                                                :lang="null"
                                                :data="null"
                                                column="password"
                                                label="Password"
                                                place-holder=""
                                                success-text="Success Field"
                                                help-text="Error Field"
                                                :required="false"
                                                :disabled="false"
                                                width="6"
                                            />
                                            <x-input
                                                type="password"
                                                :lang="null"
                                                :data="null"
                                                column="password_confirmation"
                                                label="Confirm Password"
                                                place-holder=""
                                                success-text="Success Field"
                                                help-text="Error Field"
                                                :required="false"
                                                :disabled="false"
                                                width="6"
                                            />
                                            <x-checkbox
                                                column="block"
                                                label="Review"
                                                place-holder="Review"
                                                success-text="Checkbox Success"
                                                help-text="Checkbox Error"
                                                :required="true"
                                            />
                                            <div class="col-lg-12">
                                                <button class="btn btn-primary" type="submit">{{ __('strings.Update') }}</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-xl-3 float-right">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    @include('backend.fileManager.layers.both', ['item' => $user])
                                    <x-select
                                        :lang="null"
                                        :data="null"
                                        column="status"
                                        label="Choose Status"
                                        place-holder=""
                                        success-text="Success Field"
                                        help-text="Error Field"
                                        :required="true"
                                        :disabled="false"
                                        :staticData="false"
                                        width="12"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    @include('backend.fileManager.templates.file-manager-modal')
@endsection

@push('scripts')
    <script src="{{URL::asset('/js/additional/form-advanced.min.js')}}"></script>
    <script src="{{URL::asset('/js/additional/jquery-ui.min.js')}}"></script>
    @include('backend.fileManager.templates.filemanager', ['indexRoute' => route('backend.files.index', app()->getLocale())])
@endpush

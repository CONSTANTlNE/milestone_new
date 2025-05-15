@extends('layouts.app')
@section('title') {{ __('auth.Admin Panel') }} @endsection
@section('content')
    <div class="col-md-6">
        <div class="authincation-content">
            <div class="row no-gutters">
                <div class="col-xl-12">
                    <div class="text-center login-header p-5">
                        <a href="{{ route('login')}}"><img src="{{ asset('images/logo.png') }}"
                                                                               alt="{{ __('site title') }}"></a>
                    </div>
                    <div class="auth-form">

                        <h4 class="text-center mb-4">{{ __('auth.Admin Panel') }}</h4>
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="form-group">
                                <label for="email" class="mb-1"><strong>{{ __('strings.Email') }}</strong></label>
                                <div class="col-md-12 p-0">
                                    <input id="email" type="email"
                                           class="form-control @error('email') is-invalid @enderror" name="email"
                                           value="{{ old('email') }}" required autocomplete="email" autofocus>
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password" class="mb-1"><strong>{{ __('strings.Password') }}</strong></label>
                                <div class="col-md-12 p-0">
                                    <input id="password" type="password"
                                           class="form-control @error('password') is-invalid @enderror" name="password"
                                           required autocomplete="current-password">
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row d-flex justify-content-between mt-4 mb-2">
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox ml-1 remember">
                                        <input class="custom-control-input" type="checkbox" name="remember"
                                               id="remember" {{ old('remember') ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="remember">
                                            {{ __('auth.Remember Me') }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary btn-block login">{{ __('auth.Login') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

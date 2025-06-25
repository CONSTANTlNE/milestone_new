@php
    use Laravel\Fortify\Features;
@endphp
@extends('frontend.auth.layout')
{{--'სისტემაში შესვლა'--}}
@section('title', __('config.login_title111'))
{{--გამარჯობა! სისტემაში შესასვლელათ გამოიყენეთ სწრაფი შესვლა google-ის ავტორიზაციით ან შეიყვანეთ თქვენი ელ-ფოსტა და პაროლი.--}}
@section('content', __('config.login_text'))
@section('form')
    <form method="POST" action="{{ route('frontend.auth.login') }}">
        @csrf
        <div class="grid grid-cols-12 gap-y-4">
            <div class="xl:col-span-12 col-span-12 mt-0">
                <label for="signing-email" class="form-label text-default">{{ __('config.your_email') }}</label>
                <input
                    id="signing-email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                    autocomplete="email"
                    class="form-control form-control-lg w-full rounded-md @error('email') is-invalid @enderror"
                    placeholder="{{ __('config.email') }}"
                >
                @error('email')
                <span class="invalid-feedback text-red-500 text-sm w-full" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="xl:col-span-12 col-span-12 mb-4">
                <label for="password" class="form-label text-default block mb-1">
                    {{ __('config.your_password') }}
                    @if (feature_enabled_for_customer(Features::resetPasswords()))
                    <a href="{{ route('frontend.auth.password.request') }}" class="float-right text-danger text-sm underline">
                        {{ __('config.forgot_password') }}
                    </a>
                    @endif
                </label>
                <div class="input-group">
                    <input
                        id="password"
                        type="password"
                        name="password"
                        required
                        autocomplete="current-password"
                        placeholder="{{ __('config.password') }}"
                        class="form-control form-control-lg w-full pr-10 rounded-md @error('password') is-invalid @enderror"
                    >
                    <button
                        type="button"
                        onclick="createpassword('password', this)"
                        class="ti-btn ti-btn-light !rounded-s-none !mb-0"
                        aria-label="Toggle Password Visibility"
                        id="button-addon2"
                    >
                        <i class="ri-eye-off-line align-middle"></i>
                    </button>
                    @error('password')
                    <span class="invalid-feedback text-red-500 text-sm w-full" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mt-2">
                    <div class="form-check !ps-0">
                        <input
                            class="form-check-input"
                            type="checkbox"
                            name="remember"
                            id="remember"
                            {{ old('remember') ? 'checked' : '' }}
                        >
                        <label class="form-check-label text-sm text-[#8c9097] dark:text-white/50" for="remember">
                            {{ __('config.remember_the_password') }}
                        </label>
                    </div>
                </div>
            </div>
            <div class="xl:col-span-12 col-span-12 grid mt-2">
                <button type="submit" class="ti-btn ti-btn-lg bg-primary text-white font-medium w-full dark:border-defaultborder/10">
                    {{ __('config.login') }}
                </button>
            </div>
        </div>
    </form>
@endsection

@extends('auth.layout')
@section('title', __('config.login_title'))
@section('content', __('config.login_text'))
@section('form')
    <form method="POST" action="{{ route('login') }}" class="login">
        @csrf
        <div class="grid grid-cols-12 gap-y-4">
            <div class="xl:col-span-12 col-span-12 mt-0">
                <label for="signing-email" class="text-[12px] text-default font-second-geo opacity-[0.5]">{{ __('config.your_email') }}</label>
                <input
                    id="signing-email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                    autocomplete="email"
                    class="form-control font-second-geo text-[12px] form-control-lg w-full rounded-md @error('email') is-invalid @enderror"
                >
                @error('email')
                    <span class="block invalid-feedback font-second-geo text-[12px] opacity-[0.5] w-full" role="alert">
                        <strong class="text-red-600">{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="xl:col-span-12 col-span-12 mb-4">
                <label for="password" class="text-[12px] text-default block font-second-geo opacity-[0.5]">
                    {{ __('config.your_password') }}
                    @fortifyFeature('resetPasswords')
                    <a href="{{ route('password.request') }}" class="float-right text-danger text-sm font-second-geo">
                        {{ __('config.forgot_password') }}
                    </a>
                    @endfortifyFeature
                </label>
                <div class="input-group">
                    <input
                        id="password"
                        type="password"
                        name="password"
                        required
                        autocomplete="current-password"
                        class="form-control font-second-geo text-[12px] form-control-lg w-full pr-10 rounded-md @error('password') is-invalid @enderror"
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
                    <span class="invalid-feedback text-red-500 font-second-geo text-sm w-full" role="alert">
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
                        <label class="form-check-label text-[#8c9097] dark:text-white/50 font-second-geo text-[10px]" for="remember">
                            {{ __('config.remember_the_password') }}
                        </label>
                    </div>
                </div>
            </div>
            <div class="xl:col-span-12 col-span-12 grid mt-2">
                <button type="submit" class="ti-btn ti-btn-lg bg-primary text-white font-medium w-full dark:border-defaultborder/10 font-second-geo">
                    {{ __('config.login') }}
                </button>
            </div>
        </div>
    </form>
@endsection

@extends('frontend.auth.layout')
{{--'სისტემაში შესვლა'--}}
@section('title', __('config.reset_password_title'))
{{--გამარჯობა! სისტემაში შესასვლელათ გამოიყენეთ სწრაფი შესვლა google-ის ავტორიზაციით ან შეიყვანეთ თქვენი ელ-ფოსტა და პაროლი.--}}
@section('content', __('config.reset_password_text'))
@section('form')
    <form method="POST" action="{{ route('frontend.auth.password.update') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">

        <div class="grid grid-cols-12 gap-y-4">
            <div class="xl:col-span-12 col-span-12 mt-0">
                <label for="reset-email" class="form-label text-default">{{ __('config.your_email') }}</label>
                <input
                    id="reset-email"
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
                </label>
                <div class="input-group mb-3">
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
                <label for="password-confirm" class="form-label text-default block mb-1">
                    {{ __('config.your_confirm_password') }}
                </label>
                <div class="input-group">
                    <input
                        id="password-confirm"
                        type="password"
                        name="password_confirmation"
                        required
                        autocomplete="new-password"
                        class="form-control form-control-lg w-full pr-10 rounded-md"
                    >
                    <button
                        type="button"
                        onclick="createpassword('password-confirm', this)"
                        class="ti-btn ti-btn-light !rounded-s-none !mb-0"
                        aria-label="Toggle Password Visibility"
                        id="button-addon2"
                    >
                        <i class="ri-eye-off-line align-middle"></i>
                    </button>
                </div>
            </div>
            <div class="xl:col-span-12 col-span-12 grid mt-2">
                <button type="submit" class="ti-btn ti-btn-lg bg-primary text-white font-medium w-full dark:border-defaultborder/10">
                    {{ __('config.reset_password') }}
                </button>
            </div>
        </div>
    </form>
    <div class="text-center">
        <p class="text-[0.75rem] text-[#8c9097] dark:text-white/50 mt-4">
            <a href="{{ route('frontend.auth.login') }}" class="text-primary">{{ __('config.admin_panel_login') }}</a>
        </p>
    </div>
@endsection

@extends('frontend.auth.layout')
{{--'სისტემაში შესვლა'--}}{{--{{ __('Confirm Password') }}--}}
@section('title', __('config.confirm_password_title'))
{{--გამარჯობა! სისტემაში შესასვლელათ გამოიყენეთ სწრაფი შესვლა google-ის ავტორიზაციით ან შეიყვანეთ თქვენი ელ-ფოსტა და პაროლი.--}}
@section('content', __('config.confirm_password_text'))
@section('form')
    {{ __('Please confirm your password before continuing.') }}
    <form method="POST" action="{{ route('frontend.auth.password.confirm') }}">
        @csrf
        <div class="grid grid-cols-12 gap-y-4">

            <div class="xl:col-span-12 col-span-12 mb-4">
                <label for="confirm-password" class="form-label text-default block mb-1">
                    {{ __('config.password') }}
                </label>
                <div class="input-group">
                    <input
                        id="confirm-password"
                        type="password"
                        name="password"
                        required
                        autocomplete="current-password"
                        class="form-control form-control-lg w-full pr-10 rounded-md @error('password') is-invalid @enderror"
                    >
                    <button
                        type="button"
                        onclick="createpassword('confirm-password', this)"
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
            </div>

            <div class="xl:col-span-12 col-span-12 grid mt-2">
                <button type="submit" class="ti-btn ti-btn-lg bg-primary text-white font-medium w-full dark:border-defaultborder/10">
                    {{ __('config.confirm_password') }}
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

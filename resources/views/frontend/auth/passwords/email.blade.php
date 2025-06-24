@extends('frontend.auth.layout')
{{--'სისტემაში შესვლა'--}}
@section('title', __('config.reset_email_title'))
{{--გამარჯობა! სისტემაში შესასვლელათ გამოიყენეთ სწრაფი შესვლა google-ის ავტორიზაციით ან შეიყვანეთ თქვენი ელ-ფოსტა და პაროლი.--}}
@section('content', __('config.reset_email_text'))
@section('form')
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    <form method="POST" action="{{ route('frontend.auth.password.email') }}">
        @csrf
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
            <div class="xl:col-span-12 col-span-12 grid mt-2">
                <button type="submit" class="ti-btn ti-btn-lg bg-primary text-white font-medium w-full dark:border-defaultborder/10">
                    {{ __('config.send_password_reset_link') }}
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

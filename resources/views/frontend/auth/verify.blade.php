@extends('frontend.auth.layout')
{{--'სისტემაში შესვლა'--}}
@section('title', __('config.verify_your_email_address'))
{{--გამარჯობა! სისტემაში შესასვლელათ გამოიყენეთ სწრაფი შესვლა google-ის ავტორიზაციით ან შეიყვანეთ თქვენი ელ-ფოსტა და პაროლი.--}}
@section('content', __('config.verify_your_email_address_text'))
@section('form')
    @if (session('resent'))
        <div class="alert alert-success" role="alert">
            {{ __('A fresh verification link has been sent to your email address.') }}
        </div>
    @endif
    {{ __('Before proceeding, please check your email for a verification link.') }}
    {{ __('If you did not receive the email') }},
    <form method="POST" action="{{ route('frontend.auth.verification.resend') }}">
        @csrf
        <div class="grid grid-cols-12 gap-y-4">
            <div class="xl:col-span-12 col-span-12 grid mt-2">
                <button type="submit" class="ti-btn ti-btn-lg bg-primary text-white font-medium w-full dark:border-defaultborder/10">
                    {{ __('click here to request another') }}
                </button>
            </div>
        </div>
    </form>
@endsection

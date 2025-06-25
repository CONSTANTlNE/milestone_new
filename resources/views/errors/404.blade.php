@extends('errors.layout')

@section('code', '404')
@section('error-message', __('errors.page_not_found'))
@section('message', __('errors.message_404'))
@section('link')
	<a href="{{ route('frontend.index') }}" class="ti-btn bg-primary text-white font-semibold font-second-geo"><i class="ri-arrow-left-line align-middle inline-block"></i>{{ __('errors.back_to_home')}}</a>
@endsection
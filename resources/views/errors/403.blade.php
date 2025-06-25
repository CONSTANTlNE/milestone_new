@extends('errors.layout')

@section('code', '403')
@section('error-message', __('errors.forbidden'))
@section('message', __('errors.message_403'))
@section('link')
 <a href="{{ url()->previous() }}" class="ti-btn bg-primary text-white font-semibold font-second-geo"><i class="ri-arrow-left-line align-middle inline-block"></i>{{ __('errors.go_back')}}</a>
@endsection


<?php

namespace App\Http\Responses;

use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Contracts\LogoutResponse as LogoutResponseContract;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class LogoutResponse implements LogoutResponseContract
{
    public function toResponse($request): Redirector|RedirectResponse|Response
    {
        return redirect()->route('frontend.index');
    }
}

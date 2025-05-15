<?php

namespace App\Http\Responses;

use Illuminate\Routing\Redirector;
use Laravel\Fortify\Contracts\LogoutResponse as LogoutResponseContract;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class LogoutResponse implements LogoutResponseContract
{
    public function toResponse($request): Redirector|RedirectResponse|Response
    {
        $locale = LaravelLocalization::getCurrentLocale();
        $redirect = "/$locale";
        return redirect()->intended($redirect);
    }
}

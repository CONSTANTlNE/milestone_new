<?php

namespace App\Http\Responses;

use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request): Response|RedirectResponse
    {
        if (Auth::guard('customers')->check()) {
            return redirect()->route('frontend.customers.index');
        }

        if (Auth::guard('web')->check()) {
            return redirect()->route('backend.index');
        }

        return redirect()->route('frontend.index');
    }
}

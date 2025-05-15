<?php

namespace App\Http\Responses;

use Illuminate\Routing\Redirector;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request): Response|RedirectResponse
    {
        $locale = LaravelLocalization::getCurrentLocale();
//        $user = $request->user();
//
//        if ($user->hasRole('admin')) {
//            $redirect = "/$locale/backend/dashboard";
//        } elseif ($user->hasRole('editor')) {
//            $redirect = "/$locale/editor";
//        } else {
//            $redirect = "/$locale/user/home";
//        }
        $redirect = "/$locale/backend";

        return redirect()->intended($redirect);
    }
}

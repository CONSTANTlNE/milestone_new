<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class CheckAdminUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return RedirectResponse|Redirector|Application|Response
     */
    public function handle(Request $request, Closure $next): RedirectResponse|Redirector|Application|Response
    {
        if (!Auth::check()) {
            return redirect()->route('frontend.index');
        }

        $user = Auth::guard('web')->user();
        $cacheKey = 'UserHasBackendAccess_' . $user->id;

        $hasAccess = Cache::remember($cacheKey, 60 * 60 * 24, function () use ($user) {
            return $user->roles()->where('has_backend_access', true)->exists();
        });

        if (!$hasAccess) {
            Auth::logout();

            return redirect()->route('login')->withErrors([
                'email' => __('auth.no_access'),
            ]);
        }

        return $next($request);
    }
}

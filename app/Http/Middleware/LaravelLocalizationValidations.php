<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class LaravelLocalizationValidations
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @return Response|RedirectResponse
     */
    public function handle(Request $request, Closure $next): Response|RedirectResponse
    {
        $parsedUrl = parse_url($request->getRequestUri());
        $path = isset($parsedUrl['path']) ? preg_replace('#/+#', '/', $parsedUrl['path']) : '/';
        $path = rtrim($path, '/') ?: '/';
        $cleanUri = $path . (isset($parsedUrl['query']) ? '?' . $parsedUrl['query'] : '');

        if ($request->getRequestUri() !== $cleanUri) {
            return redirect()->to($cleanUri, 301);
        }

        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next): mixed
    {
        if (Auth::check()) {

//            if (!Cache::has('UserHasBackendAccess')){
//                $hasBackendAccess = Cache::remember('UserHasBackendAccess', 60*60*24, function (){
//                    return Auth::user()->roles()->where('has_backend_access', 1)->first();
//                });
//            }else{
//            }
            $hasBackendAccess = Auth::user()->roles()->first();
            if ($hasBackendAccess->has_backend_access) {
                return $next($request);
            } else {
                return redirect('/');
            }
        } else {
            return redirect('/');
        }
        //return $next($request);
    }
}

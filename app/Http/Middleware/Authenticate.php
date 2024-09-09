<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
// use Closure;
// use Illuminate\Support\Facades\Auth;

class Authenticate extends Middleware
{
    // public function handle($request, Closure $next, ...$guards)
    // {
    //     if ($request->is('api/*')) {   
    //         var_dump(Auth::user());exit;
    //         if (!$request->user()) {
    //             return response()->json(['status' => false, 'message' => 'Unable to Authenticate. Please login again.', 'data' => null]);
    //         }
    //     }

    //     return $next($request);
    // }

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            return route('login');
        }
    }
}

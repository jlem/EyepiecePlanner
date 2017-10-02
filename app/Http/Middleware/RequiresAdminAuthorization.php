<?php

namespace EPP\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RequiresAdminAuthorization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (!Auth::check($guard)) {
            return redirect('/home');
        }

        if (!Auth::user($guard)->isAdmin()) {
            return redirect('/home');
        }

        return $next($request);
    }
}

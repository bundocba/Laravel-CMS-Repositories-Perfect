<?php

namespace Modules\Frontend\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
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
        $loggedInUser = \Session::get('logged_in_user');

        if (isset($loggedInUser) && !empty($loggedInUser)) {
            return redirect('/')->send();
        }

        return $next($request);
    }
}

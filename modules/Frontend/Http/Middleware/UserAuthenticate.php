<?php

namespace Modules\Frontend\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class UserAuthenticate
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

        if (empty($loggedInUser)) {
            return redirect('user/login')->send();
        }

        return $next($request);
    }
}

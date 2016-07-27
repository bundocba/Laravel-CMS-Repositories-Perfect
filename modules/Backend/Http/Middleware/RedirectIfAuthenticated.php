<?php

namespace Modules\Backend\Http\Middleware;

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
        $loggedInAdmin = \Session::get('logged_in_admin');

        if (isset($loggedInAdmin) && !empty($loggedInAdmin)) {
            return redirect('admin/dashboard/index')->send();
        }

        return $next($request);
    }
}

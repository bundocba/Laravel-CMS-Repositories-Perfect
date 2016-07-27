<?php

namespace Modules\Backend\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

use Modules\Backend\Repositories\AdminUserRepository;
//use Modules\Backend\Repositories\AdminPermissionRepository;
use Modules\Backend\Repositories\AdminUserTokenRepository;

class AdminAuthenticate
{
    protected $adminUserRepository;
    protected $adminUserTokenRepository;

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
        $this->loginByCookie();

        $loggedInAdmin = \Session::get('logged_in_admin');

        if (empty($loggedInAdmin)) {
            return redirect('admin/auth/login')->send();
        }

        return $next($request);
    }

    protected function loginByCookie()
    {
        $this->adminUserRepository = new AdminUserRepository();
        $this->adminUserTokenRepository = new AdminUserTokenRepository();

        $loggedInAdmin = \Session::get('logged_in_admin');

        if (empty($loggedInAdmin) && \Cookie::get('user_token')) {

            $token = \Cookie::get('user_token');
            $adminUserToken = $this->adminUserTokenRepository->findBy('token', '=', $token)->first();

            //var_dump($adminUserToken->expired_date); //->expired_date > \Carbon\Carbon::now());
            //exit();

            if ($adminUserToken
                && ($adminUserToken->expired_date > \Carbon\Carbon::now())
                && $adminUserToken->status == 0) {

                $adminUser = $this->adminUserRepository->find($adminUserToken->user_id);

                $loggedInAdmin = new \stdClass();
                $loggedInAdmin->id = $adminUser->id;
                $loggedInAdmin->email = $adminUser->email;
                $loggedInAdmin->name = $adminUser->name;
                $loggedInAdmin->role_id = $adminUser->role_id;
                $loggedInAdmin->role_name = $adminUser->role_name;

                \Session::put('logged_in_admin', $loggedInAdmin);

                \Session::regenerate();
            }
        }
    }


}

<?php

namespace Modules\Backend\Http\Controllers;

use Pingpong\Modules\Routing\Controller as PingpongController;

use Modules\Backend\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Modules\Backend\Repositories\SettingRepository;
use Modules\Backend\Repositories\AdminUserRepository;
//use Modules\Backend\Repositories\AdminPermissionRepository;
use Modules\Backend\Repositories\AdminUserTokenRepository;

//use App\Entities\Role;
use App\Entities\AdminUserToken;

use Modules\Backend\Helpers\Token;

class AuthController extends PingpongController
{
    protected $settingRepository;
    protected $adminUserRepository;
    //protected $adminPermissionRepository;
    protected $adminUserTokenRepository;

    protected $data = [];

    public function __construct()
    {
        $this->settingRepository = new SettingRepository();

        $settings = $this->settingRepository->findAll();
        foreach ($settings as $setting) {
            $this->data['settings'][$setting->name] = $setting['value'];
        }


        $this->adminUserRepository = new AdminUserRepository();
        $this->adminUserTokenRepository = new AdminUserTokenRepository();
        //$this->adminPermissionRepository = new AdminPermissionRepository();

        $this->resolveRoute();

        $this->data['url'] = \Request::url();

        \View::share('data', $this->data);
    }

    public function redirect($route)
    {
        return redirect($this->data['prefix'] . '/' . $route);
    }

    public function view($view, $data = [])
    {
        return \View::make($this->data['module_name'] . '::' . $view, $data);
    }

    public function resolveRoute()
    {
        $routeName = \Route::getCurrentRoute()->getActionName();

        $segments = explode('\\', $routeName);

        $this->data['module_name'] = strtolower($segments[1]);

        $lastSegment = $segments[count($segments) - 1];
        $pos = strpos($lastSegment, '@');
        $this->data['controller'] = substr($lastSegment, 0, $pos);

        if (strpos($routeName, '@') >= 0) {
            $actionName = substr($routeName, strpos($routeName, '@') + 1);
            $this->data['action_name']= strtolower($actionName);
        }

        $this->data['prefix'] = \Request::route()->getPrefix();
    }

    public function getLogin()
    {
        $loggedInAdmin = \Session::get('logged_in_admin');

        if (isset($loggedInAdmin) && !empty($loggedInAdmin)) {
            return redirect('admin/dashboard/index')->send();
        }

        return $this->view('auth.login');
    }

    public function postLogin(Request $request)
    {
        $email = trim($request->get('email'));
        $password = $request->get('password');

        $rules = [
            'email' => 'required|email',
            'password' => 'required',
        ];

        $messages = [
            'email_required' => trans('frontend::register.email.required'),
            'password_required' => trans('frontend::register.password.required'),
        ];

        $validator = \Validator::make($request->all(), $rules, $messages);

        if (!$validator->fails()) {

            $adminUser = $this->adminUserRepository->authenticate($email, $password);

            if (!$adminUser) {
                $adminUser = $this->adminUserRepository->findByEmail($email);
                $result = $this->authenticateByFptEmail($email, $password);
            } else {
                $result = 1;
            }

            if ($adminUser && $result) {

                $loggedInAdmin = new \stdClass();
                $loggedInAdmin->id = $adminUser->id;
                $loggedInAdmin->email = $adminUser->email;
                $loggedInAdmin->name = $adminUser->name;
                $loggedInAdmin->role_id = $adminUser->role_id;
                $loggedInAdmin->role_name = $adminUser->role_name;

                if ($request->get('remember_me') == 1) {

                    $token = Token::genRnd(64);

                    $now = \Carbon\Carbon::now($this->data['settings']['time_zone']);

                    $adminUserToken = new AdminUserToken();
                    $adminUserToken->user_id = $adminUser->id;
                    $adminUserToken->token = $token;
                    $adminUserToken->type = 1;
                    $adminUserToken->created_date = $now;
                    $adminUserToken->expired_date = date('Y-m-d H:i:s', strtotime($now) + 1 * 86400);
                    $adminUserToken->status = 0;
                    $this->adminUserTokenRepository->save($adminUserToken);

                    \Session::regenerate();

                    \Session::put('logged_in_admin', $loggedInAdmin);
                    $cookie = \Cookie('user_token', $token, 30 * 24 * 60);
                    return $this->redirect('dashboard/index')->withCookie($cookie);
                }

                \Session::put('logged_in_admin', $loggedInAdmin);
                
                return $this->redirect('dashboard/index');

            } else {

                $validator->errors()->add('summary', trans('backend::auth.login_failure'));
                return $this->redirect('auth/login')
                        ->withErrors($validator)
                        ->withInput();

            }

        } else {

            return $this->redirect('auth/login')
                    ->withErrors($validator)
                    ->withInput();

        }
    }

    public function authenticateByFptEmail($email, $password)
    {
        if (config('app.env') == 'local') {
            $client = new \SoapClient('http://login.ho.fpt.vn/fpter?wsdl');
            $parameters = array('username' => $email, 'password' => $password);
            $result = $client->__call('authentication', $parameters);
            return $result;
        } else {
            $ldapconn = ldap_connect("ldap://210.245.0.150:389");
            ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
            ldap_set_option($ldapconn, LDAP_OPT_REFERRALS, 0);
            if ($ldapconn) {
                try {
                    $ldapbind = ldap_bind($ldapconn, $email, $password);
                } catch (\Exception $ex) {
                    return false;
                }
                if ($ldapbind) {
                    return true;
                } else {
                    return false;
                }
            }
        }
    }

    public function getLogout(Request $request)
    {
        \Session::remove('logged_in_admin');

        $cookie = \Cookie::forget('user_token');

        //\Response::setLastModified(new \DateTime('now'));
        //\Response::setExpires(new \DateTime('now'));
        \Session::regenerate();
        $headers = array('Cache-Control' => 'no-cache, no-store, max-age=0, must-revalidate', 'Pragma' => 'no-cache', 'Expires' => 'Fri, 01 Jan 1990 00:00:00 GMT');
        //return $this->view('auth.logout'); //->withCookie($cookie)->withHeaders($headers);
        //header('Location: ' . url('admin/dashboard/index'));
        //exit();
        
        return $this->redirect('auth/login', 302)->withCookie($cookie);
        //return $this->view('auth.logout')->withHeaders($headers)->withCookie($cookie);
        //return $this->redirect('auth/login', 302);//->withCookie($cookie)->withHeaders($headers);
    }

    public function postLogout(Request $request)
    {
//        \Session::remove('logged_in_admin');
//
//        $cookie = \Cookie::forget('user_token');
//
//        //\Response::setLastModified(new \DateTime('now'));
//        //\Response::setExpires(new \DateTime('now'));
//
        $headers = array('Cache-Control' => 'no-cache, no-store, max-age=0, must-revalidate', 'Pragma' => 'no-cache', 'Expires' => 'Fri, 01 Jan 1990 00:00:00 GMT');
//        return $this->view('auth.logout')->withCookie($cookie)->withHeaders($headers);

        return $this->redirect('dashboard/index', 302)->withHeaders($headers);
    }
}

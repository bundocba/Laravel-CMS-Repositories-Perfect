<?php

namespace Modules\Frontend\Http\Controllers;

use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Validator;

use App\Entities\User;
use App\Entities\UserToken;

use Modules\Frontend\Repositories\UserRepository;
use Modules\Frontend\Repositories\UserTokenRepository;

use Modules\Frontend\Helpers\Token;

// 2-factor authentication
use App\Entities\UserSetting;
use Modules\Frontend\Repositories\UserSettingRepository;
use PragmaRX\Google2FA\Google2FA;

class UserController extends BaseController
{
    protected $userRepository;
    protected $userTokenRepository;
    protected $userSettingRepository;

    public function __construct()
    {
        parent::__construct();

        $this->userRepository = new UserRepository();
        $this->userTokenRepository = new UserTokenRepository();
        $this->userSettingRepository = new UserSettingRepository();
    }

    public function getRegister(Request $request)
    {
        return $this->view('user.register');
    }

    public function postRegister(Request $request)
    {
        $rules = [
            'email' => 'required|email',
            'password' => 'required|min:6',
            'retype_password' => 'required|min:6|same:password',
            'first_name' => 'required',
            'last_name' => 'required',
        ];

        $messages = [
            'email.required' => trans('frontend::register.email.required'),
            'password.required' => trans('frontend::register.password.required'),
            'retype_password.required' => trans('frontend::register.retype_password.required'),
            'first_name.required' => trans('frontend::register.first_name.required'),
            'last_name.required' => trans('frontend::register.last_name.required'),
        ];

        $validator = \Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {

            return $this->redirect('user/register')
                        ->withErrors($validator)
                        ->withInput();

        } else {

            $user = new User();
            $user->email = $request->get('email');
            $user->password = md5(md5(md5($request->get('password'))));
            $user->first_name = $request->get('first_name');
            $user->last_name = $request->get('last_name');
            $user->status = 1;

            try {

                $this->userRepository->save($user);

                \Session::flash('message', 'Inserted successfully!');

                return $this->redirect('user/registersuccess');

            } catch (\Exception $ex) {

                \Session::flash('error', $ex->getMessage());
                return $this->redirect('user/register')
                        ->withInput();

            }

        }
    }

    public function getRegistersuccess()
    {
        return $this->view('user.registersuccess');
    }

    public function getLogin()
    {
        return $this->view('user.login');
    }

    public function postLogin(Request $request)
    {
        $email = $request->get('email');
        $password = $request->get('password');

        $rules = [
            'email' => 'required|email',
            'password' => 'required',
        ];

        $messages = [
            'email.required' => trans('frontend::login.email.required'),
            'password.required' => trans('frontend::login.password.required'),
        ];

        $validator = \Validator::make($request->all(), $rules, $messages);

        if (!$validator->fails()) {

            $user = $this->userRepository->authenticate($email, $password);

            if ($user) {

                $loggedInUser = new \stdClass();
                $loggedInUser->id = $user->id;
                $loggedInUser->email = $user->email;
                $loggedInUser->first_name = $user->first_name;
                $loggedInUser->last_name = $user->last_name;

                $userSetting = $this->userSettingRepository->find($user->id);

                if ($userSetting && $userSetting->two_factor_auth) {

                    $user->remember_me = $request->get('remember_me');

                    \Session::put('logged_in_user_tmp', $loggedInUser);

                    return $this->redirect('user/login-verify');

                } else {

                    \Session::put('logged_in_user', $user);

                    if ($request->get('remember_me') == 1) {

                        $token = Token::genRnd(64);

                        $now = \Carbon\Carbon::now($this->data['settings']['time_zone']);

                        $userToken = new UserToken();
                        $userToken->user_id = $user->id;
                        $userToken->token = $token;
                        $userToken->type = 1;
                        $userToken->created_date = $now;
                        $userToken->expired_date = date('Y-m-d H:i:s', strtotime($now) + 30*86400);
                        $userToken->status = 0;
                        $this->userTokenRepository->save($userToken);

                        \Session::regenerate();

                        $cookie = \Cookie('user_token', $token, 24*60);
                        return $this->redirect('/')->withCookie($cookie);

                    }
                }

                return $this->redirect('/');

            }

            $validator->errors()->add('summary', 'Email and password does not match!');
                    return $this->redirect('user/login')
                            ->withErrors($validator)
                            ->withInput();

        } else {
            return $this->redirect('user/login')
                    ->withErrors($validator)
                    ->withInput();
        }

    }

    public function getLoginVerify()
    {
        return $this->view('user.login_verify');
    }

    public function postLogin_verify(Request $request)
    {
        $token = $request->get('token');

        $rules = [
            'token' => 'required',
        ];

        $messages = [
            'token.required' => trans('frontend::login-verify.token.required'),
        ];

        $validator = \Validator::make($request->all(), $rules, $messages);

        if (!$validator->fails()) {

            $google2fa = new Google2FA();

            $loggedInUser = \Session::get('logged_in_user_tmp');

            if (!$loggedInUser) {

                exit();
            }

            $userId = $loggedInUser->id;

            $userSetting = $this->userSettingRepository->find($userId);

            if ($userSetting) {

                $expectedToken = $google2fa->getCurrentOtp($userSetting->secret_key);

                //echo $token . ' ' . $expectedToken;
                //exit();

                if ($token == $expectedToken) {

                    \Session::put('logged_in_user', $loggedInUser);

                    //echo 'OK';
                    //exit();

                    \Session::remove('logged_in_user_tmp');

                    if ($loggedInUser->remember_me == 1) {

                        $token = Token::genRnd(64);

                        $now = \Carbon\Carbon::now($this->data['settings']['time_zone']);

                        $userToken = new UserToken();
                        $userToken->user_id = $$loggedInUser->id;
                        $userToken->token = $token;
                        $userToken->type = 1;
                        $userToken->created_date = $now;
                        $userToken->expired_data = date('Y-m-d H:i:s', strtotime($now) + 30*86400);
                        $userToken->status = 0;
                        $this->userTokenRepository->save($userToken);

                        \Session::regenerate();

                        $cookie = \Cookie('user_token', $token, 24*60);
                        return $this->redirect('/')->withCookie($cookie);

                    }

                    return $this->redirect('/');
                }
            }

            $validator->errors()->add('summary', 'Token does not match!');
            return $this->redirect('user/login-verify')
                        ->withErrors($validator);

        } else {

            return $this->redirect('user/login-verify')
                ->withErrors($validator);
        }
    }

}

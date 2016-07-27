<?php

namespace Modules\Frontend\Http\Controllers;

use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Validator;

use App\Entities\User;
use App\Entities\UserSetting;

use Modules\Frontend\Repositories\UserRepository;
use Modules\Frontend\Repositories\UserSettingRepository;

use PragmaRX\Google2FA\Google2FA;

class AccountController extends BaseController
{
    protected $userRepository;
    protected $userSettingRepository;

    public function __construct()
    {
        parent::__construct();

        $this->userRepository = new UserRepository();
        $this->userSettingRepository = new UserSettingRepository();
    }

    public function getProfile()
    {
        $userId = $this->loggedInUser->id;
        $model = $this->userRepository->find($userId);

        return $this->view('account.profile', compact('model'));
    }

    public function getUpdateprofile()
    {
        $userId = $this->loggedInUser->id;
        $model = $this->userRepository->find($userId);

        return $this->view('account.updateprofile', compact('model'));
    }

    public function postUpdateprofile(Request $request)
    {
        $rules = [
            'email' => 'required|email|max:50',
            'first_name' => 'required|max:50',
            'last_name' => 'required|max:50',
        ];

        $messages = [
            'first_name.required' => trans('frontend::register.first_name.required'),
            'last_name.required' => trans('frontend::register.last_name.required'),
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {

            return $this->redirect('account/updateprofile')
                    ->withErrors($validator)
                    ->withInput();

        } else {

            $userId = $this->loggedInUser->id;
            $user = $this->userRepository->find($userId);

            $user->first_name = $request->get('first_name');
            $user->last_name = $request->get('last_name');

            try {

                $this->userRepository->save($user);

                \Session::flash('message', 'Updated successfully!');

                return $this->redirect('account/updateprofile');
            } catch (\Exception $ex) {

                \Session::flash('error', $ex->getMessage());

                return $this->redirect('account/updateprofile')
                        ->withInput();
            }
        }
    }

    public function getChangepassword()
    {
        return $this->view('account.changepassword');
    }

    public function postChangepassword(Request $request)
    {
        $rules = [
            'password' => 'required|min:6',
            'new_password' => 'required|min:6',
            'retype_password' => 'required|min:6|same:new_password',
        ];

        $messages = [
            'password.required' => trans('frontend::register.password.required'),
            'retype_password.required' => trans('frontend::register.retype_password.required'),
            'new_password.required' => trans('frontend::register.new_password.required'),
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {

            return $this->redirect('account/changepassword')
                    ->withErrors($validator)
                    ->withInput();

        } else {

            try {

                $userId = $this->loggedInUser->id;
                $user = $this->userRepository->find($userId);

                $user->password = md5(md5(md5($request->get('password'))));

                $this->userRepository->save($user);

                \Session::flash('message', 'Change password successfully!');

                return $this->redirect('account/changepassword');

            } catch (\Exception $ex) {

                \Session::flash('error', $ex->getMessage());

                return $this->redirect('account/changepassword')->withInput();
            }
        }
    }

    public function getSetting()
    {
        $userId = $this->loggedInUser->id;
        $model = $this->userRepository->find($userId);

        $google2faUrl = '';

        $userSetting = $this->userSettingRepository->find($userId);

        if (!$userSetting) {
            $userSetting = new UserSetting();
            $userSetting->id = $userId;
            $this->userSettingRepository->save($userSetting);

        } else {

//            $google2fa = new Google2FA();
//            $google2faUrl = $google2fa->getQRCodeGoogleUrl(
//                config('name'),
//                $this->loggedInUser->email,
//                $userSetting->secret_key
//            );

            $appName = config('name');
            $secretKey = $userSetting->secret_key;
        }

        $model = $userSetting;

        return $this->view('account.setting', compact('model', 'appName', 'secretKey'));
    }

    public function postSetting(Request $request)
    {
        $userId = $this->loggedInUser->id;

        $userSetting = $this->userSettingRepository->find($userId);

        $userSetting->two_factor_auth = $request->get('two_factor_auth');

        if ($request->get('two_factor_auth')) {

            $google2fa = new Google2FA();
            $secretKey = $google2fa->generateSecretKey(32);

            $userSetting->secret_key = $secretKey;

        }

         try {

            $this->userSettingRepository->save($userSetting);

            \Session::flash('message', 'Updated successfully!');

            return $this->redirect('account/setting');

        } catch (\Exception $ex) {

            \Session::flash('error', $ex->getMessage());

            return $this->redirect('account/setting')->withInput();
        }
    }

    public function getLogout()
    {
        \Session::remove('logged_in_user');

        $cookie = \Cookie::forget('user_token');

        return $this->redirect('/')->withCookie($cookie);
    }

}

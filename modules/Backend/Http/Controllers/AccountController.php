<?php

namespace Modules\Backend\Http\Controllers;

use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Validator;

use App\Entities\AdminUser;

use Modules\Backend\Repositories\AdminUserRepository;

class AccountController extends BaseController
{
    protected $adminUserRepository;

    public function __construct()
    {
        parent::__construct();

        $this->adminUserRepository = new AdminUserRepository();
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

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {

            return $this->redirect('account/changepassword')
                    ->withErrors($validator)
                    ->withInput();

        } else {

            try {

                $adminUserId = $this->loggedInAdmin->id;
                $adminUser = $this->adminUserRepository->find($adminUserId);

                $adminUser->password = md5(md5(md5($request->get('new_password'))));

                $this->adminUserRepository->save($adminUser);

                \Session::flash('message', trans('backend::global.updated_successfully'));

                return $this->redirect('account/changepassword');

            } catch (\Exception $ex) {

                \Session::flash('error', $ex->getMessage());

                return $this->redirect('account/changepassword')->withInput();
            }
        }
    }
}

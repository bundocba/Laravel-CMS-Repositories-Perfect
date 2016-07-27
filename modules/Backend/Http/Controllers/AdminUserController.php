<?php

namespace Modules\Backend\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Entities\AdminUser;
use App\Entities\Role;

use Modules\Backend\Repositories\AdminUserRepository;
use Modules\Backend\Repositories\RoleRepository;

class AdminUserController extends BaseController
{
    protected $adminUserRepository;
    protected $roleRepository;

    public function __construct()
    {
        parent::__construct();

        $this->adminUserRepository = new AdminUserRepository();
        $this->roleRepository = new RoleRepository();
    }

    public function getList(Request $request)
    {
        $page = $request->query('page', 1);
        $perPage = $request->query('per_page', $this->data['settings']['per_page']);
        $sortBy = $request->query('sort_by', 'email');
        $sortDirection = $request->query('sort_direction', 'asc');

        $email = $request->query('email', null);
        $name = $request->query('name', null);
        $roleId = $request->query('role_id', null);
        $status = $request->query('status', null);

        $roleList = $this->getRoleList();
        $statusList = $this->getStatusList();

        $role = $this->roleRepository->find($this->loggedInAdmin->role_id);

        $models = $this->adminUserRepository->paginate($role->priority, $email, $name, $roleId, $status, $perPage, $sortBy, $sortDirection);

        return $this->view('admin_user.list', compact('roleList', 'statusList', 'models'));
    }

    public function getAdd()
    {
        $roleList = $this->getRoleList();
        $statusList = $this->getStatusList();

        return $this->view('admin_user.add', compact('roleList', 'statusList'));
    }

    public function postAdd(Request $request)
    {
        $rules = [
            'email' => 'required|email|max:50',
            'password' => 'required|min:6|max:20',
            'retype_password' => 'required|same:password',
            'name' => 'required',
            'role_id' => 'required',
            'status' => 'required',
        ];

        $validator = \Validator::make($request->all(), $rules);

        $validator->after(function($validator) use ($request) {
            $email = trim($request->get('email'));
            $existing = $this->adminUserRepository->exists('email', '=', $email);
            if ($existing) {
                $validator->addError('email', 'exists');
                //$validator->errors()->add('email', trans('backend::validation.exists'));
            }
        });

        if ($validator->fails()) {

            return $this->redirect('admin_user/add')
                        ->withErrors($validator)
                        ->withInput();

        } else {

            $adminUser = new AdminUser();
            $adminUser->email = trim($request->get('email'));
            $password = $request->get('password');
            $adminUser->password = md5(md5(md5($password)));
            $adminUser->role_id = $request->get('role_id');
            $adminUser->name = $request->get('name');
            $adminUser->status = $request->get('status');
            $adminUser->created_by = $this->loggedInAdmin->id;
            $adminUser->created_date = \Carbon\Carbon::now($this->data['settings']['time_zone']);

            try {

                $this->adminUserRepository->save($adminUser);

                \Session::flash('message', trans('backend::global.inserted_successfully'));
                return $this->redirectBackUrl('admin_user/list');

            } catch (\Exception $ex) {
                \Session::flash('error', $ex->getMessage());
                return $this->redirect('admin_user/add')
                        ->withInput();

            }
        }
    }

    public function getEdit($id)
    {
        $model = $this->adminUserRepository->find($id);

        // Check exist
        if (!$model) {
            \Session::flash('error', trans('backend::validation.does_not_exist'));
            return $this->redirectBackUrl('admin_user/list');
        }

        $roleList = $this->getRoleList();
        $statusList = $this->getStatusList();

        return $this->view('admin_user.edit', compact('id', 'model', 'roleList', 'statusList'));
    }

    public function postEdit($id, Request $request)
    {
        if ($request->get('password')) {
            $rules = [
                'email' => 'required|email|max:50',
                'password' => 'required|min:6|max:20',
                'retype_password' => 'required|same:password',
                'name' => 'required',
                'role_id' => 'required',
                'status' => 'required',
            ];
        } else {
            $rules = [
                'email' => 'required|email|max:50',
                'name' => 'required',
                'role_id' => 'required',
                'status' => 'required',
            ];
        }

        $validator = Validator::make($request->all(), $rules);

        $validator->after(function($validator) use ($id, $request) {
            $email = trim($request->get('email'));
            $existing = $this->adminUserRepository->exists('email', '=', $email);
            if ($existing && $existing->id != $id) {
                $validator->addError('email', 'exists');
                //$validator->errors()->add('email', trans('backend::validation.exists'));
            }
        });

        if ($validator->fails()) {

            return $this->redirect('admin_user/edit/' . $id)
                    ->withErrors($validator)
                    ->withInput();
        } else {

            $adminUser = $this->adminUserRepository->find($id);

            // Check exist
            if (!$adminUser) {
                \Session::flash('error', trans('backend::validation.does_not_exist'));
                return $this->redirectBackUrl('admin_user/list');
            }

            $adminUser->email = trim($request->get('email'));
            $adminUser->role_id = $request->get('role_id');
            $adminUser->name = $request->get('name');
            $adminUser->status = $request->get('status');
            $adminUser->modified_by = $this->loggedInAdmin->id;
            $adminUser->modified_date = \Carbon\Carbon::now($this->data['settings']['time_zone']);

            if ($request->get('password')) {
                $password = $request->get('password');
                $adminUser->password = md5(md5(md5($password)));
            }

            try {

                $this->adminUserRepository->save($adminUser);

                \Session::flash('message', trans('backend::global.updated_successfully'));

                return $this->redirectBackUrl('admin_user/list');

            } catch (\Exception $ex) {
                \Session::flash('error', $ex->getMessage());
                return $this->redirect('admin_user/edit/' . $id)
                        ->withInput();

            }
        }
    }

    public function getView($id)
    {
        $model = $this->adminUserRepository->find($id);

        // Check exist
        if (!$model) {
            \Session::flash('error', trans('backend::validation.does_not_exist'));
            return $this->redirectBackUrl('admin_user/list');
        }

        return $this->view('admin_user.view', compact('model'));
    }

    public function postDelete($id, Request $request)
    {
        $admin = $this->adminUserRepository->find($id);

        if ($admin->role_id == Role::SUPER_ADMINISTRATOR) {

            \Session::flash('error', trans('backend::admin_user.cannot_deleted_administrator'));

        } else {

            try {

                $this->adminUserRepository->delete($id);
                \Session::flash('message', trans('backend::global.deleted_successfully'));

            } catch (\Exception $ex) {

                \Session::flash('error', $ex->getMessage());
            }
        }

        return $this->redirectBackUrl('admin_user/list');
    }

    public function postMassactivate(Request $request)
    {
        $ids = $request->get('ids');

        try {

            $this->adminUserRepository->massUpdate($ids, ['status' => '1']);

            \Session::flash('message', trans('backend::global.mass_activate_successfully'));

        } catch (\Exception $ex) {

            \Session::flash('error', $ex->getMessage());
        }

        return $this->redirectBackUrl('admin_user/list');
    }

    public function postMassdeactivate(Request $request)
    {
        $ids = $request->get('ids');

        try {

            $this->adminUserRepository->massUpdate($ids, ['status' => '0']);

            \Session::flash('message', trans('backend::global.mass_deactivate_successfully'));

        } catch (\Exception $ex) {

            \Session::flash('error', $ex->getMessage());
        }

        return $this->redirectBackUrl('admin_user/list');
    }

    public function postMassdelete(Request $request)
    {
        $ids = $request->get('ids');

        try {

            $this->adminUserRepository->massDelete($ids);

            \Session::flash('message', trans('backend::global.mass_deleted_successfully'));

        } catch (\Exception $ex) {

            \Session::flash('error', $ex->getMessage());
        }

        return $this->redirectBackUrl('admin_user/list');
    }

    public function getRoleList()
    {
        $role = $this->roleRepository->find($this->loggedInAdmin->role_id);

        $roles = $this->roleRepository->findWithScope($role->priority, 'id', 'name');
        $roles = ['' => trans('backend::global.select')] + $roles;
        return $roles;
    }
}

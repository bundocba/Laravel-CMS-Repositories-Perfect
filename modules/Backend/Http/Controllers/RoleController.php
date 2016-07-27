<?php

namespace Modules\Backend\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Entities\AdminUser;
use App\Entities\Role;

use Modules\Backend\Repositories\AdminUserRepository;
use Modules\Backend\Repositories\RoleRepository;

class RoleController extends BaseController
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
        $sortBy = $request->query('sort_by', 'priority');
        $sortDirection = $request->query('sort_direction', 'asc');

        $role = $this->roleRepository->find($this->loggedInAdmin->role_id);

        $models = $this->roleRepository->paginate($role->priority, $perPage, $sortBy, $sortDirection);
        return $this->view('role.list', compact('models'));
    }

    public function getAdd()
    {
        $role = $this->roleRepository->find($this->loggedInAdmin->role_id);

        $priorityList = $this->getPriorityList($role->priority);
        $statusList = $this->getStatusList();

        return $this->view('role.add', compact('priorityList', 'statusList'));
    }

    public function postAdd(Request $request)
    {
        $rules = [
            'name' => 'required|max:255',
            'priority' => 'required',
            'status' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        $validator->after(function($validator) use ($request) {
            $name = trim($request->get('name'));
            $existing = $this->roleRepository->exists('name', '=', $name);
            if ($existing) {
                $validator->addError('name', 'exists');
                //$validator->errors()->add('name', trans('backend::validation.exists'));
            }
        });


        if ($validator->fails()) {

            return $this->redirect('role/add')
                    ->withErrors($validator)
                    ->withInput();

        } else {

            $role = new Role();
            $role->name = trim($request->get('name'));
            $role->priority = $request->get('priority');
            $role->description = trim($request->get('description'));
            $role->status = $request->get('status');

            try {

                $this->roleRepository->save($role);

                \Session::flash('message', trans('backend::global.inserted_successfully'));

                return $this->redirectBackUrl('role/list');
            } catch (\Exception $ex) {

                \Session::flash('error', $ex->getMessage());
                return $this->redirect('role/add')
                        ->withInput();
            }
        }
    }

    public function getEdit($id)
    {
        $role = $this->roleRepository->find($this->loggedInAdmin->role_id);

        $model = $this->roleRepository->find($id);

        // Check exist
        if (!$model) {
            \Session::flash('error', trans('backend::validation.does_not_exist'));
            return $this->redirectBackUrl('role/list');
        }

        $priorityList = $this->getPriorityList($role->priority);
        $statusList = $this->getStatusList();

        return $this->view('role.edit', compact('id', 'model', 'priorityList', 'statusList'));
    }

    public function postEdit($id, Request $request)
    {
        $rules = [
            'name' => 'required|max:255',
            'priority' => 'required',
            'status' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        $validator->after(function($validator) use ($id, $request) {
            $name = trim($request->get('name'));
            $existing = $this->roleRepository->exists('name', '=', $name);
            if ($existing && $existing->id != $id) {
                $validator->addError('name', 'exists');
                //$validator->errors()->add('name', trans('backend::validation.exists'));
            }
        });

        if ($validator->fails()) {

            return $this->redirect('role/edit/' . $id)
                    ->withErrors($validator)
                    ->withInput();
        } else {

            $role = $this->roleRepository->find($id);

            // Check exist
            if (!$role) {
                \Session::flash('error', trans('backend::validation.does_not_exist'));
                return $this->redirectBackUrl('role/list');
            }

            $role->name = trim($request->get('name'));
            $role->priority = $request->get('priority');
            $role->description = trim($request->get('description'));
            $role->status = $request->get('status');

            try {

                $this->roleRepository->save($role);
                \Session::flash('message', trans('backend::global.updated_successfully'));
                return $this->redirectBackUrl('role/list');

            } catch (\Exception $ex) {
                \Session::flash('error', $ex->getMessage());
                return $this->redirect('role/edit/' . $id)
                        ->withInput();
            }
        }
    }

    public function getView($id)
    {
        $model = $this->roleRepository->find($id);

        // Check exist
        if (!$model) {
            \Session::flash('error', trans('backend::validation.does_not_exist'));
            return $this->redirectBackUrl('role/list');
        }

        return $this->view('role.view', compact('model'));
    }

    public function postDelete($id, Request $request)
    {
        $role = $this->roleRepository->find($id);

        if (!$role) {
            \Session::flash('error', trans('backend::validation.does_not_exist'));
            return $this->redirectBackUrl('role/list');
        }

        $children = $this->adminUserRepository->findBy('role_id', '=', $id);

        if (count($children)) {
            \Session::flash('error', trans('backend::role.cannot_delete_this_item_because_it_contains_users'));
            return $this->redirectBackUrl('role/list');
        }

        try {

            $this->roleRepository->delete($id);

            \Session::flash('message', trans('backend::global.deleted_successfully'));
        } catch (\Exception $ex) {

            \Session::flash('error', $ex->getMessage());
        }

        return $this->redirectBackUrl('role/list');
    }

    protected function getPriorityList($priority)
    {
        $priorityList = ['' => trans('backend::global.select')];

        for ($i = 2; $i <= 5; $i++) {
            if ($i > $priority) {
                $priorityList[$i] = $i;
            }
        }

        return $priorityList;
    }
}

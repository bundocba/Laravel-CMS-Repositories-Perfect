<?php

namespace Modules\Backend\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Entities\User;
use App\Entities\Menu;

use Modules\Backend\Repositories\UserRepository;
use Modules\Backend\Repositories\MenuRepository;
use Modules\Backend\Repositories\MenuLinkRepository;

class MenuController extends BaseController
{
    protected $menuRepository;
    protected $menuLinkRepository;

    public function __construct()
    {
        parent::__construct();

        $this->menuRepository = new MenuRepository();
        $this->menuLinkRepository = new MenuLinkRepository();
    }

    public function getList(Request $request)
    {
        $page = $request->query('page', 1);
        $perPage = $request->query('per_page', $this->data['settings']['per_page']);

        $models = $this->menuRepository->paginate($this->data['lang'], $perPage);
        return $this->view('menu.list', compact('models'));
    }

    public function getAdd()
    {

        $statusList = $this->getStatusList();

        return $this->view('menu.add', compact('statusList'));
    }

    public function postAdd(Request $request)
    {

        $rules = [
            'name' => 'required|max:255',
            'status' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        $validator->after(function($validator) use ($request) {
            $name = trim($request->get('name'));
            $existing = $this->menuRepository->exists('name', '=', $name);
            if ($existing) {
                $validator->addError('name', 'exists');
                //$validator->errors()->add('name', trans('backend::validation.exists'));
            }
        });


        if ($validator->fails()) {

            return $this->redirect('menu/add')
                    ->withErrors($validator)
                    ->withInput();
        } else {

            $menu = new Menu();
            $menu->name = trim($request->get('name'));
            $menu->description = trim($request->get('description'));
            $menu->status = $request->get('status');

            try {

                $this->menuRepository->save($menu);

                \Session::flash('message', trans('backend::global.inserted_successfully'));

                return $this->redirectBackUrl('menu/list');

            } catch (\Exception $ex) {
                \Session::flash('error', $ex->getMessage());
                return $this->redirect('menu/add')
                        ->withInput();

            }
        }
    }

    public function getEdit($id)
    {
        $model = $this->menuRepository->find($id);

        // Check exist
        if (!$model) {
            \Session::flash('error', trans('backend::validation.does_not_exist'));
            return $this->redirectBackUrl('menu/list');
        }

        $statusList = $this->getStatusList();

        return $this->view('menu.edit', compact('id', 'model', 'statusList'));
    }

    public function postEdit($id, Request $request)
    {

        $rules = [
            'name' => 'required|max:255',
            'status' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        $validator->after(function($validator) use ($id, $request) {
            $name = trim($request->get('name'));
            $existing = $this->menuRepository->exists('name', '=', $name);
            if ($existing && $existing->id != $id) {
                $validator->addError('name', 'exists');
                //$validator->errors()->add('name', trans('backend::validation.exists'));
            }
        });

        if ($validator->fails()) {

            return $this->redirect('menu/edit/' . $id)
                    ->withErrors($validator)
                    ->withInput();
        } else {

            $menu = $this->menuRepository->find($id);

            // Check exist
            if (!$menu) {
                \Session::flash('error', trans('backend::validation.does_not_exist'));
                return $this->redirectBackUrl('menu/list');
            }

            $menu->name = trim($request->get('name'));
            $menu->description = trim($request->get('description'));
            $menu->status = $request->get('status');

            try {

                $this->menuRepository->save($menu);

                \Session::flash('message', trans('backend::global.updated_successfully'));

                return $this->redirectBackUrl('menu/list');

            } catch (\Exception $ex) {
                \Session::flash('error', $ex->getMessage());
                return $this->redirect('menu/edit/' . $id)
                        ->withInput();

            }
        }
    }

    public function getView($id)
    {
        $model = $this->menuRepository->find($id);

        // Check exist
        if (!$model) {
            \Session::flash('error', trans('backend::validation.does_not_exist'));
            return $this->redirectBackUrl('menu/list');
        }

        return $this->view('menu.view', compact('model'));
    }

    public function getDelete($id)
    {
        return $this->view('menu.delete', compact('id', 'model'));
    }

    public function postDelete($id, Request $request)
    {
        $children = $this->menuLinkRepository->findBy('menu_id', '=', $id);

        if (count($children)) {
            \Session::flash('error', trans('backend::menu.cannot_delete_this_item_because_it_contains_children'));
            return $this->redirectBackUrl('menu/list');
        }

        try {

            $this->menuRepository->delete($id);

            \Session::flash('message', trans('backend::global.deleted_successfully'));

        } catch (\Exception $ex) {

            \Session::flash('error', $ex->getMessage());
        }

        return $this->redirectBackUrl('menu/list');
    }
}

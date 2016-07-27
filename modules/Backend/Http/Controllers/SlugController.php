<?php

namespace Modules\Backend\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Entities\AdminUser;
use App\Entities\Slug;

use Modules\Backend\Repositories\SlugRepository;

class SlugController extends BaseController
{
    protected $slugRepository;

    public function __construct()
    {
        parent::__construct();

        $this->slugRepository = new SlugRepository();
    }

    public function getList(Request $request)
    {
        $page = $request->query('page', 1);
        $perPage = $request->query('per_page', $this->data['settings']['per_page']);
        $sortBy = $request->query('sort_by', 'id');
        $sortDirection = $request->query('sort_direction', 'asc');

        $models = $this->slugRepository->paginate($this->data['lang'], $perPage, $sortBy, $sortDirection);
        return $this->view('slug.list', compact('models'));
    }

    public function getAdd()
    {
        $priorityList = $this->getPriorityList();
        $statusList = $this->getStatusList();

        return $this->view('slug.add', compact('priorityList', 'statusList'));
    }

    public function postAdd(Request $request)
    {

        $rules = [
            'alias' => 'required|max:2000',
            'url' => 'required|max:2000',
        ];

        $validator = Validator::make($request->all(), $rules);

        $validator->after(function($validator) use ($request) {
            $name = trim($request->get('alias'));
            $existing = $this->slugRepository->exists('alias', '=', $name);
            if ($existing) {
                $validator->addError('alias', 'exists');
                //$validator->errors()->add('alias', trans('backend::validation.exists'));
            }
        });

        if ($validator->fails()) {

            return $this->redirect('slug/add')
                    ->withErrors($validator)
                    ->withInput();

        } else {

            $slug = new Slug();
            $slug->alias = trim($request->get('alias'));
            $slug->url = trim($request->get('url'));

            try {

                $this->slugRepository->save($slug);

                \Session::flash('message', trans('backend::global.inserted_successfully'));

                return $this->redirectBackUrl('slug/list');
            } catch (\Exception $ex) {

                \Session::flash('error', $ex->getMessage());
                return $this->redirect('slug/add')
                        ->withInput();
            }
        }
    }

    public function getEdit($id)
    {
        $model = $this->slugRepository->find($id);

        // Check exist
        if (!$model) {
            \Session::flash('error', trans('backend::validation.does_not_exist'));
            return $this->redirectBackUrl('slug/list');
        }

        $priorityList = $this->getPriorityList();
        $statusList = $this->getStatusList();

        return $this->view('slug.edit', compact('id', 'model', 'priorityList', 'statusList'));
    }

    public function postEdit($id, Request $request)
    {

        $rules = [
            'alias' => 'required|max:2000',
            'url' => 'required|max:2000',
        ];

        $validator = Validator::make($request->all(), $rules);

        $validator->after(function($validator) use ($id, $request) {
            $name = trim($request->get('alias'));
            $existing = $this->slugRepository->exists('alias', '=', $name);
            if ($existing && $existing->id != $id) {
                $validator->addError('alias', 'exists');
                //$validator->errors()->add('alias', trans('backend::validation.exists'));
            }
        });

        if ($validator->fails()) {

            return $this->redirect('slug/edit/' . $id)
                    ->withErrors($validator)
                    ->withInput();
        } else {

            $slug = $this->slugRepository->find($id);

            // Check exist
            if (!$slug) {
                \Session::flash('error', trans('backend::validation.does_not_exist'));
                return $this->redirectBackUrl('slug/list');
            }

            $slug->alias = trim($request->get('alias'));
            $slug->url = trim($request->get('url'));

            try {

                $this->slugRepository->save($slug);

                \Session::flash('message', trans('backend::global.updated_successfully'));

                return $this->redirectBackUrl('slug/list');
            } catch (\Exception $ex) {
                \Session::flash('error', $ex->getMessage());
                return $this->redirect('slug/edit/' . $id)
                        ->withInput();
            }
        }
    }

    public function getView($id)
    {
        $model = $this->slugRepository->find($id);

        // Check exist
        if (!$model) {
            \Session::flash('error', trans('backend::validation.does_not_exist'));
            return $this->redirectBackUrl('slug/list');
        }

        return $this->view('slug.view', compact('model'));
    }

    public function postDelete($id, Request $request)
    {
        $slug = $this->slugRepository->find($id);

        if (!$slug) {
            \Session::flash('error', trans('backend::validation.does_not_exist'));
            return $this->redirectBackUrl('slug/list');
        }

        try {

            $this->slugRepository->delete($id);

            \Session::flash('message', trans('backend::global.deleted_successfully'));
        } catch (\Exception $ex) {

            \Session::flash('error', $ex->getMessage());
        }

        return $this->redirectBackUrl('slug/list');
    }

    public function postMassdelete(Request $request)
    {
        $ids = $request->get('ids');

        try {

            $this->slugRepository->massDelete($ids);

            \Session::flash('message', trans('backend::global.mass_deleted_successfully'));

        } catch (\Exception $ex) {

            \Session::flash('error', $ex->getMessage());
        }

        return $this->redirectBackUrl('slug/list/?lang=' . $this->data['lang']);
    }


    protected function getPriorityList()
    {
        $priorityList = ['' => trans('backend::global.select')];

        for ($i = 1; $i <= 5; $i++) {
            $priorityList[$i] = $i;
        }

        return $priorityList;
    }
}

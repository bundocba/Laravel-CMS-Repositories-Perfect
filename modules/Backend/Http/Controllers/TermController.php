<?php

namespace Modules\Backend\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Entities\Term;
use App\Entities\Slug;

use Modules\Backend\Repositories\TermRepository;
use Modules\Backend\Repositories\SlugRepository;
use Modules\Backend\Repositories\PostRepository;

use Modules\Backend\Helpers\Hierarchical;
use Illuminate\Pagination\LengthAwarePaginator;

use Modules\Backend\Helpers\String;
use Modules\Backend\Helpers\Validation;

class TermController extends BaseController
{
    protected $termRepository;
    protected $slugRepository;
    protected $postRepository;

    public function __construct()
    {
        parent::__construct();

        $this->termRepository = new TermRepository();
        $this->slugRepository = new SlugRepository();
        $this->postRepository = new PostRepository();
    }

    public function getList($taxonomyId, Request $request)
    {
        $page = $request->query('page', 1);
        $perPage = $request->query('per_page', $this->data['settings']['per_page']);

        $terms = $this->termRepository->findByTaxonomyId($this->data['lang'], $taxonomyId);

        $hierarchical = new Hierarchical($terms);
        $hierarchical->build();
        $total = count($hierarchical->collection);
        $models = $hierarchical->collection->forPage($page, $perPage);

        $models= new LengthAwarePaginator($models, $total, $perPage, $page, [
            'path'  => $request->url(),
            'query' => $request->query()
            ]);

        return $this->view('term.list', compact('models', 'taxonomyId'));
    }

    public function getAdd($taxonomyId)
    {
        $termList = $this->getTermList($taxonomyId);
        $weightList = $this->getWeightList();
        $statusList = $this->getStatusList();

        return $this->view('term.add', compact('termList', 'weightList', 'statusList', 'taxonomyId'));
    }

    public function postAdd($taxonomyId, Request $request)
    {

        $rules = [
            'name' => 'required|max:255',
            'weight' => 'required|integer|max:100',
            'status' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        $validator->after(function($validator) use ($request) {

            if (trim($request->get('thumb_url'))) {
//                $rule = [
//                    'thumb_url' => 'image',
//                ];
//                $subValidator = Validator::make($request->all(), $rule);
//                if ($subValidator->fails()) {
//                    $validator->addError('thumb_url', 'image');
//                }

                if (trim($request->get('thumb_url'))) {
                    $thumbUrl = trim($request->get('thumb_url'));
                    $filePath = substr($thumbUrl, 0, strrpos($thumbUrl, '/', 0));
                    $fileName = substr($thumbUrl, strrpos($thumbUrl, '/', 0) + 1);
//                    echo $filePath;
//                    echo '<br />';
//                    echo $fileName;

                    if (!Validation::isImage($fileName)) {
                        $validator->addError('thumb_url', 'image');
                    }

                    //exit();
//                    $rule = [
//                        'thumb_url' => 'image',
//                    ];
//                    $request['thumb_url'] = $fileName;
//                    $subValidator = Validator::make($request->all(), $rule);
//                    if ($subValidator->fails()) {
//                        print_r($subValidator->errors());
//                        exit();
//                        //$validator->addError('thumb_url', 'image');
//                    }
                }
            }

            $slug = String::toSlug(trim($request->get('slug')));
            if ($slug != '') {
                $existing = $this->slugRepository->findByAlias($this->data['lang'], $slug)->first();
                if ($existing) {
                    $validator->addError('slug', 'exists');
                    //$validator->errors()->add('slug', trans('backend::validation.exists'));
                }
            }
        });

        if ($validator->fails()) {

            return $this->redirect('term/add/' . $taxonomyId . '/?lang=' . $this->data['lang'])
                    ->withErrors($validator)
                    ->withInput();

        } else {

            $term = new Term();
            $term->name = trim($request->get('name'));
            //$term->slug = $request->get('slug');
            $term->taxonomy_id = $taxonomyId;
            $term->weight = $request->get('weight');
            $term->lang = $this->data['lang'];
            $term->weight = $request->get('weight');
            $term->status = $request->get('status');

            $term->thumb_url = str_replace($this->data['base_url'], '', $request->get('thumb_url'));

            //if ($request->get('parent_id')) {
                $term->parent_id = $request->get('parent_id');
            //}

            try {
                $this->termRepository->save($term);

                $id = $term->id;

                $term = $this->termRepository->find($id);

                $term->url = '/term/list/' . $term->id;

                $this->termRepository->save($term);

                $slug = new Slug();
                $slug->url = $term->url;
                //$slug->alias = trim($request->get('slug'));
                $slug->alias = String::toSlug(trim($request->get('slug')));
                $slug->lang = $this->data['lang'];

                $this->slugRepository->save($slug);

                \Session::flash('message', trans('backend::global.inserted_successfully'));

                return $this->redirectBackUrl('term/list/' . $taxonomyId . '/?lang=' . $this->data['lang']);

            } catch (\Exception $ex) {

                \Session::flash('error', $ex->getMessage());
                return $this->redirect('term/add')
                        ->withInput();

            }
        }
    }

    public function getEdit($taxonomyId, $id)
    {
        $model = $this->termRepository->find($id);

        // Check exist
        if (!$model) {
            \Session::flash('error', trans('backend::validation.does_not_exist'));
            return $this->redirect('term/list/' . $taxonomyId . '/?lang=' . $this->data['lang']);
        }

        $slug = $this->slugRepository->findBy('url', '=', $model->url);

        if ($slug->first()) {
            $model->slug = $slug->first()->alias;
        }

        $model->full_url = url('/') . '/' . $model->lang . $this->getSlugPath($model);

        $termList = $this->getTermList($taxonomyId, $id);
        $weightList = $this->getWeightList();
        $statusList = $this->getStatusList();

//        if ($model->thumb_url) {
//            if (substr($model->thumb_url, 0, 4) != 'http') {
//                $model->thumb_url = $this->data['base_url'] . $model->thumb_url;
//            }
//        }

        return $this->view('term.edit', compact('id', 'model', 'termList', 'weightList', 'statusList', 'taxonomyId'));
    }

    public function postEdit($taxonomyId, $id, Request $request)
    {

        $rules = [
            'name' => 'required|max:255',
            'weight' => 'required|integer|max:100',
            'status' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        $validator->after(function($validator) use ($id,$request) {

            if (trim($request->get('thumb_url'))) {
                $thumbUrl = trim($request->get('thumb_url'));
                $filePath = substr($thumbUrl, 0, strrpos($thumbUrl, '/', 0));
                $fileName = substr($thumbUrl, strrpos($thumbUrl, '/', 0) + 1);

                if (!Validation::isImage($fileName)) {
                    $validator->addError('thumb_url', 'image');
                }
            }

            $slug = trim($request->get('slug'));
            if ($slug != '') {
                $existing = $this->slugRepository->findByAlias($this->data['lang'], $slug)->first();
                if ($existing && $existing->url != '/term/list/' . $id) {
                    $validator->addError('slug', 'exists');
                    //$validator->errors()->add('slug', trans('backend::validation.exists'));
                }
            }
        });

        if ($validator->fails()) {

            return $this->redirect('term/edit/' . $taxonomyId . '/' . $id  . '/?lang=' . $this->data['lang'])
                    ->withErrors($validator)
                    ->withInput();

        } else {

            $term = $this->termRepository->find($id);

            // Check exist
            if (!$term) {
                \Session::flash('error', trans('backend::validation.does_not_exist'));
                return $this->redirect('term/list/' . $taxonomyId . '/?lang=' . $this->data['lang']);
            }

            $term->name = trim($request->get('name'));
            //$term->slug = $request->get('slug');
            $term->taxonomy_id = $taxonomyId;
            $term->weight = $request->get('weight');
            $term->lang = $this->data['lang'];
            $term->status = $request->get('status');
            $term->weight = $request->get('weight');

            //if ($request->get('parent_id')) {
                $term->parent_id = $request->get('parent_id');
            //}

            $term->thumb_url = str_replace($this->data['base_url'], '', $request->get('thumb_url'));

            $term->url = '/term/list/' . $term->id;

            try {

                $this->termRepository->save($term);

                $slug = new Slug();
                $slug->url = $term->url;
                //$slug->alias = trim($request->get('slug'));
                $slug->alias = String::toSlug(trim($request->get('slug')));
                $slug->lang = $this->data['lang'];

                //$this->slugRepository->deleteBy('alias', '=', $slug->alias);
                $this->slugRepository->deleteBy('url', '=', $slug->url);

                $this->slugRepository->save($slug);

                \Session::flash('message', trans('backend::global.updated_successfully'));

                return $this->redirectBackUrl('term/list/' . $taxonomyId . '/?lang=' . $this->data['lang']);

            } catch (\Exception $ex) {

                \Session::flash('error', $ex->getMessage());
                return $this->redirect('term/edit/' . $taxonomyId . '/' . $id . '/?lang=' . $this->data['lang'])
                        ->withInput();

            }
        }
    }

    public function getView($taxonomyId, $id, Request $request)
    {
        $model = $this->termRepository->find($id);

        // Check exist
        if (!$model) {
            \Session::flash('error', trans('backend::validation.does_not_exist'));
            return $this->redirect('term/list/' . $taxonomyId . '/?lang=' . $this->data['lang']);
        }

        $model->full_url = url('/') . '/' . $model->lang . $this->getSlugPath($model);

//        if ($model->thumb_url) {
//            if (substr($model->thumb_url, 0, 4) != 'http') {
//                $model->thumb_url = $this->data['base_url'] . $model->thumb_url;
//            }
//        }

        return $this->view('term.view', compact('model', 'taxonomyId'));
    }

    public function postDelete($taxonomyId, $id, Request $request)
    {
        $children = $this->termRepository->findBy('parent_id', '=', $id);

        if (count($children)) {
            \Session::flash('error', trans('backend::term.cannot_delete_this_item_because_it_contains_children'));
            return $this->redirectBackUrl('term/list/' . $taxonomyId . '/?lang=' . $this->data['lang']);
        }

        $children = $this->postRepository->findByTermId($this->data['lang'], $id);

        if (count($children)) {
            \Session::flash('error', trans('backend::menu.cannot_delete_this_item_because_it_contains_posts'));
            return $this->redirectBackUrl('term/list/' . $taxonomyId . '/?lang=' . $this->data['lang']);
        }

        try {

            $this->termRepository->delete($id);

            \Session::flash('message', trans('backend::global.deleted_successfully'));

        } catch (\Exception $ex) {

            \Session::flash('error', $ex->getMessage());
        }

        return $this->redirectBackUrl('term/list/' . $taxonomyId . '/?lang=' . $this->data['lang']);
    }

    public function postUpdateweight($taxonomyId, Request $request)
    {
        $ids = $request->get('weight_ids');
        $weights = $request->get('weights');

        try {

            for ($i = 0; $i < count($ids); $i++) {
                $id = $ids[$i];
                $term = $this->termRepository->find($id);
                $term->weight = $weights[$i];
                $this->termRepository->save($term);
            }

            \Session::flash('message', trans('backend::global.updated_successfully'));

        } catch (\Exception $ex) {

            \Session::flash('error', $ex->getMessage());
        }

        return $this->redirectBackUrl('term/list/' . $taxonomyId . '/?lang=' . $this->data['lang']);
    }

    protected function getTermList($taxonomyId, $except = 0)
    {
        $terms = $this->termRepository->findByTaxonomyId($this->data['lang'], $taxonomyId, $except);

        $hierarchical = new Hierarchical($terms);
        $hierarchical->build();

        $terms = $hierarchical->collection;

        $items = [];
        $count = 0;

        foreach ($terms as $term) {

            $indentation = \Widget::indentation($term->depth);

            $items[$term->id] = $indentation . $term->name;
            $count++;
        }

        $terms = ['' => trans('backend::global.no_parent')] + $items;
        return $terms;

    }
}

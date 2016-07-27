<?php

namespace Modules\Backend\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Entities\MenuLink;

use Modules\Backend\Repositories\MenuLinkRepository;
use Modules\Backend\Repositories\TermRepository;
use Modules\Backend\Repositories\SlugRepository;
use Modules\Backend\Repositories\PostRepository;

use Modules\Backend\Helpers\Hierarchical;

use Illuminate\Pagination\LengthAwarePaginator;

class MenuLinkController extends BaseController
{
    protected $menuLinkRepository;
    protected $termRepository;
    protected $slugRepository;
    protected $postRepository;

    public function __construct()
    {
        parent::__construct();

        $this->menuLinkRepository = new MenuLinkRepository();
        $this->termRepository = new TermRepository();
        $this->slugRepository = new SlugRepository();
        $this->postRepository = new PostRepository();
    }

    public function getList(Request $request)
    {
        $menuId = 1;
        $page = $request->query('page', 1);
        $perPage = $request->query('per_page', $this->data['settings']['per_page']);

        $menuLinks = $this->menuLinkRepository->findByMenuId($this->data['lang'], $menuId);

        $hierarchical = new Hierarchical($menuLinks);
        $hierarchical->build();
        $total = count($hierarchical->collection);
        $models = $hierarchical->collection->forPage($page, $perPage);

        foreach ($models as $model) {
            if ($model->url) {
                $model->full_url = url('/') . '/' . $this->data['lang'] . $this->getSlugByUrl($model->lang . $model->url);
            }

            $contentName = $this->getContentNameByUrl($model->url);
            if ($contentName) {
                $model->content_name = $contentName;
            }
        }

        $models= new LengthAwarePaginator($models, $total, $perPage, $page, [
            'path'  => $request->url(),
            'query' => $request->query()
            ]);

        return $this->view('menu_link.list', compact('models', 'menuId'));
    }

    public function getAdd(Request $request)
    {
        $menuId = 1;

        $linkTargetList = $this->getlinkTargetList();
        $parentList = $this->getParentList($this->data['lang'], $menuId);
        $statusList = $this->getStatusList();

        return $this->view('menu_link.add', compact('linkTargetList', 'parentList', 'statusList', 'menuId'));
    }

    public function postAdd(Request $request)
    {
        $menuId = 1;

        $rules = [
            'name' => 'required|max:255',
            'weight' => 'required|integer|max:100',
            'status' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {

            return $this->redirect('menu_link/add/?lang=' . $this->data['lang'])
                    ->withErrors($validator)
                    ->withInput();

        } else {

            $menuLink = new MenuLink();
            $menuLink->name = trim($request->get('name'));
            $menuLink->menu_id = $menuId;

            $menuLink->url = $request->get('url');
            $menuLink->content_type_id = $request->get('content_type_id');
            $menuLink->content_name = $request->get('content_name');
            $menuLink->type = $request->get('type');

            $menuLink->target = $request->get('link_target');
            $menuLink->weight = $request->get('weight');
            $menuLink->lang = $this->data['lang'];
            $menuLink->status = $request->get('status');

            $menuLink->parent_id = $request->get('parent_id');

            try {
                $this->menuLinkRepository->save($menuLink);

                \Session::flash('message', trans('backend::global.inserted_successfully'));

                return $this->redirectBackUrl('menu_link/list/' . $menuId . '/?lang=' . $this->data['lang']);

            } catch (\Exception $ex) {
                \Session::flash('error', $ex->getMessage());
                return $this->redirect('menu_link/add/' . $menuId . '/?lang=' . $this->data['lang'])
                        ->withInput();

            }
        }
    }

    public function getEdit($id, Request $request)
    {
        $menuId = 1;

        $model = $this->menuLinkRepository->find($id);

        // Check exist
        if (!$model) {
            \Session::flash('error', trans('backend::validation.does_not_exist'));
            return $this->redirect('menu_link/list/' . $menuId . '/?lang=' . $this->data['lang']);
        }

        $contentName = $this->getContentNameByUrl($model->url);
        if ($contentName) {
            $model->content_name = $contentName;
        }

        $linkTargetList = $this->getLinkTargetList();
        $parentList = $this->getParentList($this->data['lang'], $menuId);
        $statusList = $this->getStatusList();

        return $this->view('menu_link.edit', compact('id', 'model', 'linkTargetList', 'parentList', 'statusList', 'menuId'));
    }

    public function postEdit($id, Request $request)
    {
        $menuId = 1;

        $rules = [
            'name' => 'required|max:255',
            'weight' => 'required|integer|max:100',
            'status' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {

                return $this->redirect('menu_link/edit/?lang=' . $this->data['lang'])
                    ->withErrors($validator)
                    ->withInput();

        } else {

            $menuLink = $this->menuLinkRepository->find($id);

            // Check exist
            if (!$menuLink) {
                \Session::flash('error', trans('backend::validation.does_not_exist'));
                return $this->redirect('menu_link/list/' . $menuId . '/?lang=' . $this->data['lang']);
            }


            $menuLink->name = trim($request->get('name'));
            $menuLink->menu_id = $menuId;

            $menuLink->url = $request->get('url');
            $menuLink->content_type_id = $request->get('content_type_id');
            $menuLink->content_name = $request->get('content_name');
            $menuLink->type = $request->get('type');

            $menuLink->target = $request->get('link_target');
            $menuLink->weight = $request->get('weight');
            $menuLink->lang = $this->data['lang'];
            $menuLink->status = $request->get('status');

            $menuLink->parent_id = $request->get('parent_id');

            try {

                $this->menuLinkRepository->save($menuLink);
                \Session::flash('message', trans('backend::global.updated_successfully'));
                return $this->redirectBackUrl('menu_link/list/?lang=' . $this->data['lang']);

            } catch (\Exception $ex) {

                \Session::flash('error', $ex->getMessage());
                return $this->redirect('menu_link/edit/?lang=' . $this->data['lang'])
                        ->withInput();

            }
        }
    }

    public function getView($id, Request $request)
    {
        $menuId = 1;
        $model = $this->menuLinkRepository->find($id);

        // Check exist
        if (!$model) {
            \Session::flash('error', trans('backend::validation.does_not_exist'));
            return $this->redirect('menu_link/list/' . $menuId . '/?lang=' . $this->data['lang']);
        }

        $contentName = $this->getContentNameByUrl($model->url);
        if ($contentName) {
            $model->content_name = $contentName;
        }

        if ($model->url) {
            $model->full_url = url('/') . '/' . $this->data['lang'] . $this->getSlugByUrl($model->lang . $model->url);
        }

        return $this->view('menu_link.view', compact('model', 'taxonomyId'));
    }

    public function postDelete($id, Request $request)
    {
        $menuId = 1;

        $children = $this->menuLinkRepository->findBy('parent_id', '=', $id);

        if (count($children)) {
            \Session::flash('error', trans('backend::menu_link.cannot_delete_this_item_because_it_contains_children'));
            return $this->redirectBackUrl('menu_link/list/?lang=' . $this->data['lang']);
        }

        try {

            $this->menuLinkRepository->delete($id);

            \Session::flash('message', trans('backend::global.deleted_successfully'));

        } catch (\Exception $ex) {

            \Session::flash('error', $ex->getMessage());
        }

        return $this->redirectBackUrl('menu_link/list/?lang=' . $this->data['lang']);
    }

    public function postUpdateweight(Request $request)
    {
        $menuId = 1;

        $ids = $request->get('weight_ids');
        $weights = $request->get('weights');

        try {

            for ($i = 0; $i < count($ids); $i++) {
                $id = $ids[$i];
                $menuLink = $this->menuLinkRepository->find($id);
                $menuLink->weight = $weights[$i];
                $this->menuLinkRepository->save($menuLink);
            }

            \Session::flash('message', trans('backend::global.updated_successfully'));

        } catch (\Exception $ex) {

            \Session::flash('error', $ex->getMessage());
        }

        return $this->redirectBackUrl('menu_link/list/?lang=' . $this->data['lang']);
    }

    public function getParentList($lang, $menuId, $id = null)
    {
        $menuLinks = $this->menuLinkRepository->findByMenuId($lang, $menuId);
        $hierarchical = new Hierarchical($menuLinks);
        $hierarchical->build();

        $menuLinks = $hierarchical->collection;

        $items = [];
        $count = 0;

        foreach ($menuLinks as $menuLink) {

            $indentation = \Widget::indentation($menuLink->depth);

            $items[$menuLink->id] = $indentation . $menuLink->name;
            $count++;
        }

        $menuLinks = ['' => trans('backend::global.no_parent')] + $items;
        return $menuLinks;
    }

    protected function getSlugByUrl($url)
    {
        $path = '';

        if ($url != '') {

            $arr = explode('/', $url);

            if (is_array($arr) && count($arr) > 1) {

                switch ($arr[1]) {
                    case 'post':
                        $id = $arr[3];
                        //$post = $this->postRepository->find($id);
                        $url = '/post/show/' . $id;
                        $slug = $this->slugRepository->findBy('url', '=', $url)->first();
                        if ($slug) {
                            //echo $slug->alias;
                            //if ($post->alias) {
                                $path .= '/' . $slug->alias;
                            //}
                            $term = $this->termRepository->findByPostId($this->data['lang'], $id)->first();
                            if ($term) {
                                $path = $this->getSlugPath($term) . $path;
                            }
                        }
                        break;
                    case 'term':
                        $id = $arr[3];
                        $term = $this->termRepository->find($id);
                        if ($term) {
                            $path = $this->getSlugPath($term);
                        }
                        break;
                    default:
                }
            }
        }

        return $path;
    }

    protected function getContentNameByUrl($url)
    {
        $path = '';

        if ($url != '') {

            $arr = explode('/', $url);

            if (is_array($arr) && count($arr) > 1) {

                switch ($arr[1]) {
                    case 'post':
                        $id = $arr[3];
                        $post = $this->postRepository->find($id);
                        if ($post) {
                            if ($post) {
                                $path = $post->title;
                            }
                        }
                        break;
                    case 'term':
                        $id = $arr[3];
                        $term = $this->termRepository->find($id);
                        if ($term) {
                            $path = $term->name;
                        }
                        break;
                    default:
                }
            }
        }

        return $path;
    }

    public function getLinkTargetList()
    {
        $linkTargetList = ['_self' => trans('backend::menu_link.load_in_the_same_window'), '_blank' => trans('backend::menu_link.load_in_new_window')];

        return $linkTargetList;
    }
}

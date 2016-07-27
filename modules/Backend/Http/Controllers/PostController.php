<?php

namespace Modules\Backend\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Modules\Backend\Repositories\TermRepository;
use Modules\Backend\Repositories\PostRepository;
use Modules\Backend\Repositories\PostTermRepository;
use Modules\Backend\Repositories\ContentTypeRepository;
use Modules\Backend\Repositories\SlugRepository;

use Modules\Backend\Helpers\Hierarchical;

class PostController extends BaseController
{

    protected $postRepository;
    protected $postTermRepository;
    protected $contentTypeRepository;
    protected $termRepository;
    protected $slugRepository;

    public function __construct()
    {
        parent::__construct();

        $this->postRepository = new PostRepository();
        $this->contentTypeRepository = new ContentTypeRepository();
        $this->termRepository = new TermRepository();
        $this->postTermRepository = new PostTermRepository();
        $this->slugRepository = new SlugRepository();
    }

    public function getList(Request $request)
    {
        $page = $request->query('page', 1);
        $perPage = $request->query('per_page', $this->data['settings']['per_page']);
        $sortBy = $request->query('sort_by', 'id');
        $sortDirection = $request->query('sort_direction', 'desc');

        $title = $request->get('title');
        $lang = $request->get('lang', $this->data['lang']);
        $termId = $request->get('term_id');
        $contentTypeId = $request->get('content_type_id');

        $models = $this->postRepository->ormPaginate($lang, $title, $contentTypeId, $termId, $perPage, $sortBy, $sortDirection);

        $termList = $this->getTermList(1);

        $contentTypeList = $this->getContentTypeList();

        return $this->view('post.list', compact('models', 'contentTypeList', 'termList'));
    }

    public function getAdd(Request $request)
    {
        return $this->view('post.add');
    }

    public function postDelete($id, Request $request)
    {
        \DB::beginTransaction();

        try {

            $this->postTermRepository->deleteBy('post_id', '=', $id);

            $this->slugRepository->deleteBy('url', '=', '/post/show/' . $id);

            $this->postRepository->delete($id);

            \DB::commit();

            \Session::flash('message', trans('backend::global.deleted_successfully'));

        } catch (\Exception $ex) {

            \DB::rollback();

            \Session::flash('error', $ex->getMessage());
        }

        return $this->redirectBackUrl('post/list/?lang=' . $this->data['lang']);
    }

    public function postMassdelete(Request $request)
    {
        $ids = $request->get('ids');

        \DB::beginTransaction();

        try {

            $this->postRepository->massDelete($ids);

            foreach ($ids as $id) {
                $this->postTermRepository->deleteBy('post_id', '=', $id);
                $this->slugRepository->deleteBy('url', '=', '/post/show/' . $id);
            }

            \DB::commit();

            \Session::flash('message', trans('backend::global.mass_deleted_successfully'));

        } catch (\Exception $ex) {

            \DB::rollback();

            \Session::flash('error', $ex->getMessage());
        }

        return $this->redirectBackUrl('post/list/?lang=' . $this->data['lang']);
    }

    public function postMassactivate(Request $request)
    {
        $ids = $request->get('ids');

        try {

            $this->postRepository->massUpdate($ids, ['status' => '1']);

            \Session::flash('message', trans('backend::global.mass_activate_successfully'));

        } catch (\Exception $ex) {

            \Session::flash('error', $ex->getMessage());
        }

        return $this->redirectBackUrl('post/list/?lang=' . $this->data['lang']);
    }

    public function postMassdeactivate(Request $request)
    {
        $ids = $request->get('ids');

        try {

            $this->postRepository->massUpdate($ids, ['status' => '0']);

            \Session::flash('message', trans('backend::global.mass_deactivate_successfully'));

        } catch (\Exception $ex) {

            \Session::flash('error', $ex->getMessage());
        }

        return $this->redirectBackUrl('post/list/?lang=' . $this->data['lang']);
    }

    protected function getContentTypeList()
    {
        $contentTypes = $this->contentTypeRepository->findWithScope('id', 'name');

        $contentTypes = ['' => trans('backend::global.select')] + $contentTypes;

        return $contentTypes;
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

        $terms = ['' => trans('backend::global.select')] + $items;
        return $terms;
    }
}

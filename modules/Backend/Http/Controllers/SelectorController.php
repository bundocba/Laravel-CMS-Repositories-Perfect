<?php

namespace Modules\Backend\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Modules\Backend\Repositories\TermRepository;
use Modules\Backend\Repositories\PostRepository;
use Modules\Backend\Repositories\ContentTypeRepository;
use Modules\Backend\Repositories\SlugRepository;

use Modules\Backend\Helpers\Hierarchical;
use Illuminate\Pagination\LengthAwarePaginator;

class SelectorController extends PopupController
{
    protected $postRepository;
    protected $contentTypeRepository;
    protected $termRepository;
    protected $slugRepository;

    public function __construct()
    {
        parent::__construct();

        $this->postRepository = new PostRepository();
        $this->contentTypeRepository = new ContentTypeRepository();
        $this->termRepository = new TermRepository();

    }

    public function getPage(Request $request)
    {
        $page = $request->query('page', 1);
        $perPage = $request->get('per_page', $this->data['settings']['per_page']);
        $sortBy = $request->query('sort_by', 'title');
        $sortDirection = $request->query('sort_direction', 'asc');

        $title = $request->get('title');
        $lang = $request->get('lang', $this->data['lang']);
        $termId = $request->get('term_id');
        $contentTypeId = $request->get('content_type_id');

        //$models = $this->postRepository->ormPaginate($lang, $title, $contentTypeId, $termId, $perPage);
        $models = $this->postRepository->ormPaginate($lang, $title, $contentTypeId, $termId, $perPage, $sortBy, $sortDirection);

        $termList = $this->getTermList(1);

        $contentTypeList = $this->getContentTypeList();

        return $this->view('selector.page', compact('models', 'contentTypeList', 'termList'));
    }

    public function getCategory(Request $request)
    {
        $taxonomyId = 1;

        $perPage = $request->get('per_page', $this->data['settings']['per_page']);

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

        return $this->view('selector.category', compact('models', 'taxonomyId'));
    }

    public function getCustomlink(Request $request)
    {
        return $this->view('selector.custom_link', compact('models', 'taxonomyId'));
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

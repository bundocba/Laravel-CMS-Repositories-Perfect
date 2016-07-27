<?php

namespace Modules\Backend\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Modules\Backend\Repositories\PostRepository;
use Modules\Backend\Repositories\PostTermRepository;
use Modules\Backend\Repositories\SlugRepository;
use Modules\Backend\Repositories\TermRepository;

use Modules\Backend\Helpers\Hierarchical;

use App\Entities\ContentType;
use App\Entities\Slug;
use App\Entities\Term;
use App\Entities\Post;
use App\Entities\PostTerm;

use Modules\Backend\Helpers\String;

class PageController extends BaseController
{
    protected $termRepository;
    protected $postRepository;
    protected $postTermRepository;
    protected $slugRepository;

    public function __construct()
    {
        parent::__construct();

        $this->termRepository = new TermRepository();
        $this->postRepository = new PostRepository();
        $this->postTermRepository = new PostTermRepository();
        $this->slugRepository = new SlugRepository();
    }

    public function getAdd()
    {
        $statusList = $this->getStatusList();

        $termList = $this->getTermList(1);

        return $this->view('page.add', compact('termList', 'statusList'));
    }

    public function postAdd(Request $request)
    {
        $rules = [
            'title' => 'required|max:255',
            'status' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        $validator->after(function($validator) use ($request) {
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

            return $this->redirect('page/add/?lang=' . $this->data['lang'])
                    ->withErrors($validator)
                    ->withInput();

        } else {

            $post = new Post();
            $post->title = trim($request->get('title'));
            $post->intro_text = trim($request->get('intro_text'));
            $post->body = $request->get('body');

//            $body = $request->get('body');
//            $body = preg_replace('/' . str_replace('/', '\/', $this->data['base_url']) . '/', '', $body);
//            $post->body = $body;

            $terms = $request->get('term_id');

            if ($request->get('lang')) {
                $post->lang = $request->get('lang');
            }

            $post->content_type_id = ContentType::PAGE;

            $post->status = $request->get('status');
            $post->created_by = $this->loggedInAdmin->id;
            $post->created_date = \Carbon\Carbon::now($this->data['settings']['time_zone']);

            try {

                $this->postRepository->save($post);

                $id = $post->id;

                $post = $this->postRepository->find($id);
                $post->url = '/post/show/' . $post->id;
                $this->postRepository->save($post);

                if (is_array($terms)) {
                    foreach ($terms as $term) {
                        $postTerm = new PostTerm();
                        $postTerm->term_id = $term;
                        $postTerm->post_id = $post->id;
                        $this->postTermRepository->save($postTerm);
                    }
                }

                $slug = new Slug();
                $slug->url = $post->url;
                $slug->alias = String::toSlug(trim($request->get('slug')));
                $slug->lang = $this->data['lang'];

                $this->slugRepository->save($slug);

                \Session::flash('message', trans('backend::global.inserted_successfully'));

                return $this->redirectBackUrl('post/list/?lang=' . $this->data['lang']);

            } catch (\Exception $ex) {

                \Session::flash('error', $ex->getMessage());
                return $this->redirect('page/add/?lang=' . $this->data['lang'])
                        ->withInput();

            }
        }

    }

    public function getEdit($id)
    {
        $model = $this->postRepository->find($id);

        // Check exist
        if (!$model) {
            \Session::flash('error', trans('backend::validation.does_not_exist'));
            return $this->redirectBackUrl('post/list/?lang=' . $this->data['lang']);
        }

        $slug = $this->slugRepository->findBy('url', '=', $model->url);

        if ($slug->first()) {
            $model->slug = $slug->first()->alias;
        }

        $termList = $this->getTermList(1);

        $terms = $model->terms()->lists('term_id')->toArray();

        $term = $model->terms()->first();
        if ($term) {
            $slugPath = $this->getSlugPath($term);
            $model->full_url = url('/') . '/'. $model->lang . $slugPath . '/' . $model->slug;
        } else {
            $model->full_url = url('/') . '/'. $model->lang . '/' . $model->slug;
        }

        $statusList = $this->getStatusList();

        return $this->view('page.edit', compact('id', 'model', 'termList', 'statusList', 'terms'));
    }

    public function postEdit($id, Request $request)
    {
        $rules = [
            'title' => 'required|max:255',
            'status' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        $validator->after(function($validator) use ($id, $request) {
            $slug = String::toSlug(trim($request->get('slug')));
            if ($slug != '') {
                $existing = $this->slugRepository->findByAlias($this->data['lang'], $slug)->first();
                if ($existing && $existing->url != '/post/show/' . $id) {
                    $validator->addError('slug', 'exists');
                    //$validator->errors()->add('slug', trans('backend::validation.exists'));
                }
            }
        });

        if ($validator->fails()) {

            return $this->redirect('page/edit/' . $id . '/?lang=' . $this->data['lang'])
                    ->withErrors($validator)
                    ->withInput();

        } else {

            $post = $this->postRepository->find($id);

            // Check exist
            if (!$post) {
                \Session::flash('error', trans('backend::validation.does_not_exist'));
                return $this->redirectBackUrl('post/list/?lang=' . $this->data['lang']);
            }

            $post->title = trim($request->get('title'));
            $post->intro_text = trim($request->get('intro_text'));
            $post->body = $request->get('body');

//            $body = $request->get('body');
//            $body = preg_replace('/' . str_replace('/', '\/', $this->data['base_url']) . '/', '', $body);
//            $post->body = $body;

            $terms = $request->get('term_id');

            if ($request->get('lang')) {
                $post->lang = $request->get('lang');
            }

            $post->content_type_id = ContentType::PAGE;

            $post->status = $request->get('status');
            $post->modified_by = $this->loggedInAdmin->id;
            $post->modified_date = \Carbon\Carbon::now($this->data['settings']['time_zone']);

            $post->url = '/post/show/' . $post->id;

            try {

                $this->postRepository->save($post);

                $this->postTermRepository->deleteBy('post_id', '=', $id);

                if (is_array($terms)) {
                    foreach ($terms as $term) {
                        $postTerm = new PostTerm();
                        $postTerm->term_id = $term;
                        $postTerm->post_id = $post->id;
                        $this->postTermRepository->save($postTerm);
                    }
                }

                $slug = new Slug();
                $slug->url = $post->url;
                $slug->alias = String::toSlug(trim($request->get('slug')));
                $slug->lang = $this->data['lang'];

                $this->slugRepository->deleteBy('url', '=', $slug->url);

                $this->slugRepository->save($slug);

                \Session::flash('message', trans('backend::global.updated_successfully'));

                return $this->redirectBackUrl('post/list/?lang=' . $this->data['lang']);

            } catch (\Exception $ex) {

                \Session::flash('error', $ex->getMessage());
                return $this->redirect('page/edit/' . $id . '/?lang=' . $this->data['lang'])
                        ->withInput();

            }

        }
    }

    public function getView($id)
    {
        $model = $this->postRepository->find($id);

        // Check exist
        if (!$model) {
            \Session::flash('error', trans('backend::validation.does_not_exist'));
            return $this->redirectBackUrl('post/list/?lang=' . $this->data['lang']);
        }

        $slug = $this->slugRepository->findBy('url', '=', $model->url);

        if ($slug->first()) {
            $model->slug = $slug->first()->alias;
        }

        $terms = $model->terms()->get();

        $term = $model->terms()->first();
        if ($term) {
            $slugPath = $this->getSlugPath($term);
            $model->full_url = url('/') . '/'. $model->lang . $slugPath . '/' . $model->slug;
        } else {
            $model->full_url = url('/') . '/'. $model->lang . '/' . $model->slug;
        }

        return $this->view('page.view', compact('id', 'model', 'terms'));
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

            //$items[$term->id] = $indentation . $term->name;
            $items[] = ['id' => $term->id, 'name'  => $indentation . $term->name];
            $count++;
        }

        //$terms = ['' => ''] + $items;
        return $items;
    }

//    public function getStatusList()
//    {
//        $statusList = ['' => trans('backend::global.select'), '0' => 'Unpublished', '1' => 'Published'];
//        return $statusList;
//    }
}

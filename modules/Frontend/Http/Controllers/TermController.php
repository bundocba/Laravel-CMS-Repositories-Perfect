<?php


namespace Modules\Frontend\Http\Controllers;

use Modules\Frontend\Repositories\TermRepository;
use Modules\Frontend\Repositories\PostRepository;
use Modules\Frontend\Repositories\SlugRepository;

use Modules\Frontend\Helpers\Hierarchical;
use Modules\Frontend\Helpers\Breadcrumb;

class TermController extends BaseController
{
    protected $termRepository;
    protected $postRepository;
    protected $slugRepository;

    public function __construct()
    {
        parent::__construct();

        $this->termRepository = new TermRepository();
        $this->postRepository = new PostRepository();
        $this->slugRepository = new SlugRepository();
    }

    public function getList($id)
    {
        $term = $this->termRepository->find($this->data['lang'], $id);

        if (!$term) {
            \App::abort(404);
        }

        $models = [];

        $mostViewedPosts = [];
        $lastestPosts = [];

        $breadcrumbTerms = $this->getBreadcrumbs($term);

        $slugPath = $this->getSlugPath($term);

        $models = $this->postRepository->paginateByTermId($this->data['lang'], $id);


        foreach ($models as $model) {
            if ($model->alias) {
                $model->full_url = url('/') . '/' . $this->data['lang'] . $slugPath . '/' . $model->alias;
            } else {
                $model->full_url = url('/') . '/' . $this->data['lang'] . $model->url;
            }

//            if ($model->thumb_url) {
//                if (substr($model->thumb_url, 0, 4) != 'http') {
//                    $model->thumb_url = $this->data['base_url'] . $model->thumb_url;
//                }
//            }
        }


        $mostViewedPosts = $this->postRepository->findMostViewedByTermId($this->data['lang'], $term->id);
        $lastestPosts = $this->postRepository->findLastestByTermId($this->data['lang'], $term->id);

        foreach ($mostViewedPosts as $post) {
            if ($post->alias) {
                $post->full_url = url('/') . '/' . $this->data['lang'] . $slugPath . '/' . $post->alias;
            } else {
                $post->full_url = url('/') . '/' . $this->data['lang'] . $post->url;
            }

//            if ($post->thumb_url) {
//                if (substr($post->thumb_url, 0, 4) != 'http') {
//                    $post->thumb_url = $this->data['base_url'] . $post->thumb_url;
//                }
//            }
        }

        foreach ($lastestPosts as $post) {
            if ($post->alias) {
                $post->full_url = url('/') . '/' . $this->data['lang'] . $slugPath . '/' . $post->alias;
            } else {
                $post->full_url = url('/') . '/' . $this->data['lang'] . $post->url;
            }

//            if ($post->thumb_url) {
//                if (substr($post->thumb_url, 0, 4) != 'http') {
//                    $post->thumb_url = $this->data['base_url'] . $post->thumb_url;
//                }
//            }
        }


        \View::share('mostViewedPosts', $mostViewedPosts);
        \View::share('lastestPosts', $lastestPosts);

        \View::share('title', $term->name);

        return $this->view('term.list', compact('models'));
    }

}

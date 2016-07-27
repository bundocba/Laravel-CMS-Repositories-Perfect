<?php

namespace Modules\Frontend\Http\Controllers;

use Modules\Frontend\Repositories\PostRepository;
use Modules\Frontend\Repositories\TermRepository;
use Modules\Frontend\Repositories\PostTermRepository;
use Modules\Frontend\Repositories\SlugRepository;
use Modules\Frontend\Repositories\MenuLinkRepository;

class PostController extends BaseController
{
    protected $postRepository;
    protected $termRepository;
    protected $postTermRepository;
    protected $slugRepository;
    protected $menuLinkRepository;

    public function __construct()
    {
        parent::__construct();

        $this->postRepository = new PostRepository();
        $this->termRepository = new TermRepository();
        $this->postTermRepository = new PostTermRepository();
        $this->slugRepository = new SlugRepository();
        $this->menuLinkRepository = new MenuLinkRepository();
    }

    public function getShow($id)
    {
        $model = $this->postRepository->find($this->data['lang'], $id);

        if (!$model) {
            \App::abort(404);
        }

        $model->view_count = $model->view_count + 1;
        $this->postRepository->save($model);


        $mostViewedPosts = [];
        $lastestPosts = [];

        $term = $this->termRepository->findByPostId($this->data['lang'], $id)->first();

        if ($term) {
            $this->getBreadcrumbs($term);

            $slugPath = $this->getSlugPath($term);

            $mostViewedPosts = $this->postRepository->findMostViewedByTermId($this->data['lang'], $term->id);
            $lastestPosts = $this->postRepository->findLastestByTermId($this->data['lang'], $term->id);

            foreach ($mostViewedPosts as $post) {
                if ($post->alias) {
                    $post->full_url = url('/') . '/' . $this->data['lang'] . $slugPath . '/' . $post->alias;
                } else {
                    $post->full_url = url('/') . '/' . $this->data['lang'] . $post->url;
                }

//                if ($post->thumb_url) {
//                    if (substr($post->thumb_url, 0, 4) != 'http') {
//                        $post->thumb_url = $this->data['base_url'] . $post->thumb_url;
//                    }
//                }
            }

            foreach ($lastestPosts as $post) {
                if ($post->alias) {
                    $post->full_url = url('/') . '/' . $this->data['lang'] . $slugPath . '/' . $post->alias;
                } else {
                    $post->full_url = url('/') . '/' . $this->data['lang'] . $post->url;
                }

//                if ($post->thumb_url) {
//                    if (substr($post->thumb_url, 0, 4) != 'http') {
//                        $post->thumb_url = $this->data['base_url'] . $post->thumb_url;
//                    }
//                }
            }
        }

        \View::share('mostViewedPosts', $mostViewedPosts);
        \View::share('lastestPosts', $lastestPosts);

        \View::share('title', $model->title);

        return $this->view('post.show', compact('model'));
    }
}

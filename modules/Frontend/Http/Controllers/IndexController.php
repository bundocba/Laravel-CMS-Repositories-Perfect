<?php


namespace Modules\Frontend\Http\Controllers;

use Modules\Frontend\Repositories\MenuLinkRepository;
use Modules\Frontend\Repositories\PostRepository;
use Modules\Frontend\Repositories\TermRepository;

class IndexController extends BaseController
{
    protected $menuLinkRepository;
    protected $postRepository;
    protected $termRepository;

    public function __construct()
    {
        parent::__construct();

        $this->menuLinkRepository = new MenuLinkRepository();
        $this->postRepository = new PostRepository();
        $this->termRepository = new TermRepository();
    }

    public function getIndex()
    {
        $model = '';

        $posts = $this->postRepository->findByContentTypeId($this->data['lang'], 1);
        if ($posts->first()) {
            $model = $posts->first();
            \View::share('ipv6', $model->intro_text);
            \View::share('title', $model->title);
        } else {
            \View::share('ipv6', '');
            \View::share('title', '');
        }

        $collection = collect($this->data['menu_links']);
        $filtered = $collection->filter(function ($item) {
            return $item->parent_id == null;
        });
        $menuLinks = $filtered->all();

        foreach ($menuLinks as $menuLink) {

            $menuLink->posts = [];

            $url = $menuLink->url;

            //echo $menuLink->full_url;

            if ($url != '') {
                $arr = explode('/', $url);

                if (is_array($arr) && count($arr) > 1) {

                    //echo $arr[1];

                    switch ($arr[1]) {
                        case 'term':
                            $termId = $arr[3];
                            //
                            $term = $this->termRepository->find($this->data['lang'], $termId);
                            //$term = $this->data['terms'][$termId];
                            $slugPath = $this->getSlugPath($term);

                            $posts = $this->postRepository->findPromotedByTermId($this->data['lang'], $termId);

                            foreach ($posts as $post) {
                                if ($post->alias) {
                                    $post->full_url = url('/') . '/' . $this->data['lang'] . $slugPath . '/' . $post->alias;
                                } else {
                                    $post->full_url = url('/') . '/' . $this->data['lang'] . $post->url;
                                }

            //                    if ($post->thumb_url) {
            //                        if (substr($post->thumb_url, 0, 4) != 'http') {
            //                            $post->thumb_url = $this->data['base_url'] . $post->thumb_url;
            //                        }
            //                    }
                            }
                            $menuLink->posts = $posts;
                            break;
                        case 'post':
                            $postId = $arr[3];
                            $post = $this->postRepository->find($this->data['lang'], $postId);
                            if ($post) {
                                $menuLink->posts = [$post];
                            }
                            break;
                        default:
                            break;

                    }
                }
            }

        }

        return $this->view('index.index', compact('menuLinks', 'model'));
    }

}

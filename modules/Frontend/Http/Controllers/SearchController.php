<?php


namespace Modules\Frontend\Http\Controllers;

use Modules\Frontend\Repositories\PostRepository;

use Illuminate\Http\Request;

class SearchController extends BaseController
{
    protected $postRepository;

    public function __construct()
    {
        parent::__construct();

        $this->postRepository = new PostRepository();
    }

    public function getResult(Request $request)
    {
        $lang = $this->data['lang'];
        $keywords = $request->get('keywords');

        $models = $this->postRepository->paginateByKeywords($lang, $keywords);

        return $this->view('search.result', compact('models'));
    }

}

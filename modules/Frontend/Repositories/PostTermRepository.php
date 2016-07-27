<?php

namespace Modules\Frontend\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Entities\PostTerm;

class PostTermRepository extends BaseRepository
{
    public function __construct()
    {
        $this->model = new PostTerm();
    }

//    public function findByPostId($lang, $postId)
//    {
//        $results = $this->model
//            ->where('status', '=', 1)
//            ->leftJoin('slugs', 'terms.url', '=', 'slugs.url')
//            ->where('terms.lang', '=', $lang)
//            ->where('post_id', '=', $postId)
//            ->orderBy('weight')
//            ->select('terms.*', 'slugs.alias')
//            ->get();
//
//        return $results;
//    }

}

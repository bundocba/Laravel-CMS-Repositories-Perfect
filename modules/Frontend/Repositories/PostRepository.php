<?php

namespace Modules\Frontend\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Entities\Post;

class PostRepository extends BaseRepository
{
    public function __construct()
    {
        $this->model = new Post();
    }

    public function find($lang, $id)
    {
        $result = $this->model
                        ->leftJoin('content_types', 'posts.content_type_id', '=', 'content_types.id')
                        ->leftJoin('slugs', 'posts.url', '=', 'slugs.url')
                        ->where('posts.status', '=', 1)
                        ->where('posts.lang', '=', $lang)
                        ->where('posts.id', '=', $id)
                        //->select('posts.id', 'posts.title', 'posts.intro_text', 'posts.url', 'posts.thumb_url', 'posts.published_date', 'content_types.name as content_type_name', 'slugs.alias')
                        ->select('posts.*', 'content_types.name as content_type_name', 'slugs.alias')
                        ->first();
        return $result;
    }

    public function paginateByTermId($lang, $id, $perPage = 5)
    {
        $results = $this->model
            ->leftJoin('content_types', 'posts.content_type_id', '=', 'content_types.id')
            ->leftJoin('posts_terms', 'posts.id', '=', 'posts_terms.post_id')
            ->leftJoin('slugs', 'posts.url', '=', 'slugs.url')
            ->where('posts.status', '=', 1)
            ->where('posts.lang', '=', $lang)
            ->where('term_id', '=', $id)
            ->orderBy(\DB::raw('case when posts.sticked = 0 or posts.sticked is null then 10000 else posts.sticked end'), 'asc')
            ->orderBy('posts.published_date', 'desc')
            ->orderBy('posts.id', 'desc')
            ->select('posts.id', 'posts.title', 'posts.intro_text', 'posts.url', 'posts.thumb_url', 'posts.published_date', 'slugs.alias')
            ->paginate($perPage);

        return $results;
    }
    
    public function paginateByKeywords($lang, $keywords, $perPage = 10)
    {
        $keywords = '%' . $keywords . '%';
        $results = $this->model
            ->leftJoin('content_types', 'posts.content_type_id', '=', 'content_types.id')
            ->leftJoin('posts_terms', 'posts.id', '=', 'posts_terms.post_id')
            ->leftJoin('slugs', 'posts.url', '=', 'slugs.url')
            ->where('posts.status', '=', 1)
            ->where('posts.lang', '=', $lang)
            ->where('posts.title', 'like', $keywords)
            ->select('posts.id', 'posts.title', 'posts.intro_text', 'posts.url', 'posts.thumb_url', 'posts.published_date', 'slugs.alias')
            ->paginate($perPage);

        return $results;
    }

    public function findPromotedByTermId($lang, $id, $limit = 3)
    {
        $results = $this->model
            ->leftJoin('content_types', 'posts.content_type_id', '=', 'content_types.id')
            ->leftJoin('posts_terms', 'posts.id', '=', 'posts_terms.post_id')
            ->leftJoin('slugs', 'posts.url', '=', 'slugs.url')
            ->where('posts.status', '=', 1)
            ->where('posts.lang', '=', $lang)
            ->where('term_id', '=', $id)
            ->orderBy(\DB::raw('case when posts.promoted = 0 or posts.promoted is null then 10000 else posts.promoted end'), 'asc')
            ->orderBy('posts.published_date', 'desc')
            ->orderBy('posts.id', 'desc')
            ->select('posts.id', 'posts.title', 'posts.intro_text', 'posts.url', 'posts.thumb_url', 'posts.published_date', 'slugs.alias')
            ->take($limit)
            ->get();
            //->paginate($limit);

        return $results;
    }

    public function findLastestByTermId($lang, $id, $limit = 4)
    {
        $results = $this->model
            ->leftJoin('content_types', 'posts.content_type_id', '=', 'content_types.id')
            ->leftJoin('posts_terms', 'posts.id', '=', 'posts_terms.post_id')
            ->leftJoin('slugs', 'posts.url', '=', 'slugs.url')
            ->where('posts.status', '=', 1)
            ->where('posts.lang', '=', $lang)
            ->where('term_id', '=', $id)
            ->orderBy('posts.published_date', 'desc')
            ->orderBy('posts.id', 'desc')
            ->select('posts.id', 'posts.title', 'posts.intro_text', 'posts.url', 'posts.thumb_url', 'posts.published_date', 'slugs.alias')
            ->take($limit)
            ->get();

        return $results;
    }

    public function findMostViewedByTermId($lang, $id, $limit = 4)
    {
        $results = $this->model
            ->leftJoin('content_types', 'posts.content_type_id', '=', 'content_types.id')
            ->leftJoin('posts_terms', 'posts.id', '=', 'posts_terms.post_id')
            ->leftJoin('slugs', 'posts.url', '=', 'slugs.url')
            ->where('posts.status', '=', 1)
            ->where('posts.lang', '=', $lang)
            ->where('term_id', '=', $id)
            ->orderBy('posts.view_count', 'desc')
            ->orderBy('posts.published_date', 'desc')
            ->orderBy('posts.id', 'desc')
            ->select('posts.id', 'posts.title', 'posts.intro_text', 'posts.url', 'posts.thumb_url', 'posts.published_date', 'slugs.alias')
            ->take($limit)
            ->get();

        return $results;
    }

    public function findByContentTypeId($lang, $contentTypeId, $limit = 1)
    {
        $results = $this->model
            ->leftJoin('content_types', 'posts.content_type_id', '=', 'content_types.id')
            ->leftJoin('posts_terms', 'posts.id', '=', 'posts_terms.post_id')
            ->leftJoin('slugs', 'posts.url', '=', 'slugs.url')
            ->where('posts.status', '=', 1)
            ->where('posts.lang', '=', $lang)
            ->where('content_type_id', '=', $contentTypeId)
            ->orderBy('posts.id', 'asc')
            ->select('posts.id', 'posts.title', 'posts.intro_text', 'posts.body', 'posts.url', 'posts.thumb_url', 'posts.published_date', 'slugs.alias')
            ->take($limit)
            ->get();

        return $results;
    }
}

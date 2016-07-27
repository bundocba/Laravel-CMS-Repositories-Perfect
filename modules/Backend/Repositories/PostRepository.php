<?php

namespace Modules\Backend\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Entities\Post;
use App\Entities\Entity;

class PostRepository extends BaseRepository
{
    public function __construct()
    {
        $this->model = new Post();
    }

    public function find($id)
    {
        $result = $this->model
            ->leftJoin('admin_users as creator', 'posts.created_by', '=', 'creator.id')
            ->leftJoin('admin_users as modifier', 'posts.modified_by', '=', 'modifier.id')
            ->where('posts.id', '=', $id)
            ->select('posts.*', 'creator.name as creator_name', 'modifier.name as modifier_name')
            ->first();
        return $result;
    }

    public function findByTermId($lang, $id)
    {
        $results = $this->model
            ->leftJoin('content_types', 'posts.content_type_id', '=', 'content_types.id')
            ->leftJoin('posts_terms', 'posts.id', '=', 'posts_terms.post_id')
            ->leftJoin('slugs', 'posts.url', '=', 'slugs.url')
            ->where('posts.lang', '=', $lang)
            ->where('term_id', '=', $id)
//            ->orderBy(\DB::raw('case when posts.sticked = 0 or posts.sticked is null then 100000 else posts.sticked end'), 'asc')
//            ->orderBy('posts.published_date', 'desc')
            ->select('posts.id', 'posts.title', 'posts.intro_text', 'posts.url', 'posts.thumb_url', 'posts.published_date', 'slugs.alias')
            ->get();

        return $results;
    }

    public function ormPaginate($lang = '', $title = '', $contentTypeId = '', $termId = '', $perPage = 10, $orderBy = null, $direction = 'asc')
    {
        $results = $this->model
                    ->leftJoin('content_types', 'posts.content_type_id', '=', 'content_types.id');

        if ($lang != '') {
            $results->where('lang', '=', $lang);
        }

        if ($title != '') {
            $title = '%' . $title . '%';
            $results->where('posts.title', 'like', $title);
        }

        if ($contentTypeId != '') {
            $results->where('content_type_id', '=', $contentTypeId);
        }

        if ($termId != '') {
            $results->whereHas('terms', function($q) use ($termId) {
                $q->where('term_id', '=', $termId);
            });
        }

//        $results->select('posts.*')
//            ->with('terms');

        $results->select('posts.id', 'posts.title', 'posts.intro_text', 'posts.url', 'posts.thumb_url', 'posts.published_date', 'posts.view_count', 'posts.status', 'posts.content_type_id')
            ->with('terms', 'contentType');

        $results = $results->orderBy($orderBy, $direction)->paginate($perPage);

        return $results;
    }
}

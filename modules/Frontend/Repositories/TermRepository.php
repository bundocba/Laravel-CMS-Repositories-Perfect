<?php

namespace Modules\Frontend\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Entities\Term;

class TermRepository extends BaseRepository
{
    public function __construct()
    {
        $this->model = new Term();
    }

    public function find($lang, $id)
    {
        $result = $this->model
            ->where('status', '=', 1)
            ->where('lang', '=', $lang)
            ->where($this->primaryKey, '=', $id)
            ->first();

        return $result;
    }

    public function findAll($lang)
    {
        $results = $this->model
            ->where('status', '=', 1)
            ->where('lang', '=', $lang)
            ->get();
        return $results;
    }

    public function findByPostId($lang, $postId)
    {
        $results = $this->model
            ->where('status', '=', 1)
            ->leftJoin('posts_terms', 'terms.id', '=', 'posts_terms.term_id')
            ->leftJoin('slugs', 'terms.url', '=', 'slugs.url')
            ->where('terms.lang', '=', $lang)
            ->where('post_id', '=', $postId)
            ->orderBy('weight')
            ->select('terms.*', 'slugs.alias')
            ->get();

        return $results;
    }

    public function findByTaxonomyId($lang, $taxonomyId)
    {
        $results = $this->model
            ->where('status', '=', 1)
            ->leftJoin('slugs', 'terms.url', '=', 'slugs.url')
            ->where('terms.lang', '=', $lang)
            ->where('taxonomy_id', '=', $taxonomyId)
            ->orderBy('weight')
            ->select('terms.*', 'slugs.alias')
            ->get();

        return $results;
    }

//    public function findByTaxonomyId($lang, $taxonomyId)
//    {
//        $results = $this->model
//            ->leftJoin('slugs', 'terms.url', '=', 'slugs.url')
//            ->where('status', '=', 1)
//            ->where('terms.lang', '=', $lang)
//            ->where('taxonomy_id', '=', $taxonomyId)
//            ->orderBy('weight')
//            ->get();
//
//        return $results;
//    }

//    public function findBy($key, $value, $operator = '=')
//    {
//        $results = $this->model
//            ->where('status', '=', 1)
//            ->where($key, $operator, $value)
//            ->get();
//        return $results;
//    }
//
//    public function findAll()
//    {
//        $results = $this->model
//            ->where('status', '=', 1)
//            ->get();
//        return $results;
//    }
}

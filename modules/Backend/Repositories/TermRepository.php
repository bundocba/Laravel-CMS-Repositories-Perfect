<?php

namespace Modules\Backend\Repositories;

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

    public function findAll()
    {
        $results = $this->model
            ->leftJoin('slugs', 'terms.url', '=', 'slugs.url')
            ->orderBy('weight')
            ->select('terms.*', 'slugs.alias')
            ->get();

        return $results;
    }

    public function findByTaxonomyId($lang, $taxonomyId, $except = 0)
    {
        $results = $this->model
            ->leftJoin('slugs', 'terms.url', '=', 'slugs.url')
            ->where('terms.lang', '=', $lang)
            ->where('taxonomy_id', '=', $taxonomyId)
            ->where('terms.id', '<>', $except)
            ->orderBy('weight')
            ->select('terms.*', 'slugs.alias')
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


}

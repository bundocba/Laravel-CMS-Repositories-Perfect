<?php

namespace Modules\Frontend\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Entities\Slug;

class SlugRepository extends BaseRepository
{
    public function __construct()
    {
        $this->model = new Slug();
    }

    public function findBy($lang, $key, $value, $operator = '=')
    {
        $results = $this->model
            ->where('lang', '=', $lang)
            ->where($key, $operator, $value)->get();
        return $results;
    }

    public function findAll($lang)
    {
        $results = $this->model
            ->where('lang', '=', $lang)
            ->get();
        return $results;
    }
}

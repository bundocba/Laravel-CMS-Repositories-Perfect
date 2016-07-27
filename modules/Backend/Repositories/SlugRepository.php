<?php

namespace Modules\Backend\Repositories;

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

    public function paginate($lang, $perPage = 10, $orderBy = null, $direction = 'asc')
    {
        $results = $this->model
            ->where('lang', '=', $lang);

        $results = $results->orderBy($orderBy, $direction)
            ->paginate($perPage);

        return $results;
    }
    
    public function findByAlias($lang, $alias)
    {
        $results = $this->model
            ->where('lang', '=', $lang)
            ->where('alias', '=', $alias)
            ->get();
        return $results;
    }
    
    public function findByUrl($lang, $url)
    {
        $results = $this->model
            ->where('lang', '=', $lang)
            ->where('url', '=', $url)
            ->get();
        return $results;
    }

    public function findAll()
    {
        $results = $this->model
                        ->get();

        return $results;
    }
}

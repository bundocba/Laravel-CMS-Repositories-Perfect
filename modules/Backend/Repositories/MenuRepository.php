<?php

namespace Modules\Backend\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Entities\Menu;

class MenuRepository extends BaseRepository
{
    public function __construct()
    {
        $this->model = new Menu();
    }

    public function paginate($lang, $perPage = 10)
    {
        $results = $this->model
            ->where('lang', '=', $lang)
            ->orderBy('name')
            ->paginate($perPage);

        return $results;
    }
}

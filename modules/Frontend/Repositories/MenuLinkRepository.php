<?php

namespace Modules\Frontend\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Entities\MenuLink;

class MenuLinkRepository extends BaseRepository
{
    public function __construct()
    {
        $this->model = new MenuLink();
    }

    public function findByMenuId($lang, $menuId)
    {
        $results = $this->model
            ->where('status', '=', 1)
            ->where('lang', '=', $lang)
            ->where('menu_id', '=', $menuId)
            ->orderBy('weight')
            ->get();

        return $results;
    }
}

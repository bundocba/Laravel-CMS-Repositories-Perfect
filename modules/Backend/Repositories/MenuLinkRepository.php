<?php

namespace Modules\Backend\Repositories;

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

    public function findByMenuId($lang, $menuId, $except = 0)
    {
        $results = $this->model
            ->where('lang', '=', $lang)
            ->where('menu_id', '=', $menuId)
            ->where('id', '<>', $except)
            ->orderBy('weight')
            ->get();

        return $results;
    }

//    public function findByMenuId($lang, $menuId, $except = 0)
//    {
//        $results = $this->model
//            ->leftJoin('content_types', 'menu_links.content_type_id', '=', 'content_types.id')
//            ->select('menu_links.*', 'content_types.name as content_type_name')
//            ->where('menu_links.lang', '=', $lang)
//            ->where('menu_links.menu_id', '=', $menuId)
//            ->where('menu_links.id', '<>', $except)
//            ->orderBy('menu_links.weight')
//            ->get();
//
//        return $results;
//    }

}

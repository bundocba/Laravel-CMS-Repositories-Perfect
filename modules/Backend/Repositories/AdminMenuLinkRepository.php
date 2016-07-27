<?php

namespace Modules\Backend\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Entities\AdminMenuLink;

class AdminMenuLinkRepository extends BaseRepository
{

    public function __construct()
    {
        $this->model = new AdminMenuLink();
    }

    public function findByMenuId($menuId, $except = 0)
    {
        $results = $this->model
            ->where('menu_id', '=', $menuId)
            ->where('id', '<>', $except)
            ->orderBy('weight')
            ->get();

        return $results;
    }

    public function findActivatedByMenuIdAndRoleId($menuId, $roleId, $except = 0)
    {
        $results = $this->model
            ->join('admin_permissions', 'admin_menu_links.id', '=', 'admin_permissions.menu_link_id')
            ->where('menu_id', '=', $menuId)
            ->where('role_id', '=', $roleId)
            ->where('admin_menu_links.status', '=', 1)
            ->where('admin_permissions.status', '=', 1)
            ->select('admin_menu_links.*')
            ->orderBy('weight')
            ->get();

        return $results;
    }

    public function findActivatedByMenuId($menuId, $except = 0)
    {
        $results = $this->model
            ->where('menu_id', '=', $menuId)
            ->where('status', '=', 1)
            ->where('id', '<>', $except)
            ->orderBy('weight')
            ->get();

        return $results;
    }

}

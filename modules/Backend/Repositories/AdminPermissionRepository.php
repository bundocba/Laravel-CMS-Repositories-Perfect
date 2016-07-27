<?php

namespace Modules\Backend\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Entities\AdminPermission;

class AdminPermissionRepository extends BaseRepository
{
    public function __construct()
    {
        $this->model = new AdminPermission();
    }

    public function findByRoleId($roleId)
    {
        $results = $this->model
            ->where('role_id', '=', $roleId)
            ->get();
        
        return $results;
    }
}

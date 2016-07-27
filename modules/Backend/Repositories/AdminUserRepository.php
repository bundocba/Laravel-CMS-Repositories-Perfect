<?php

namespace Modules\Backend\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Entities\AdminUser;

class AdminUserRepository extends BaseRepository
{
    public function __construct()
    {
        $this->model = new AdminUser();
    }

    public function paginate($priority, $email = null, $name = null, $roleId = null, $status = null, $perPage = 10, $orderBy = null, $direction = 'asc')
    {
        $results = $this->model
            ->leftJoin('roles', 'admin_users.role_id', '=', 'roles.id')
            ->select('admin_users.*', 'roles.name as role_name')
            ->where('priority', '>', $priority);

        if ($email != null) {
            $email = '%' . $email . '%';
            $results->where('email', 'like', $email);
        }

        if ($name != null) {
            $name = '%' . $name . '%';
            $results->where('admin_users.name', 'like', $name);
        }

        if ($roleId != null) {
            $results->where('role_id', '=', $roleId);
        }

        if ($status != null) {
            $results->where('admin_users.status', '=', $status);
        }

        $results = $results->orderBy($orderBy, $direction)
            ->paginate($perPage);

        return $results;
    }

    public function authenticate($email, $password)
    {
        $result = $this->model
                ->leftJoin('roles', 'admin_users.role_id', '=', 'roles.id')
                ->where('email', '=', $email)
                ->where('password', '=', md5(md5(md5($password))))
                ->where('admin_users.status', '=', 1)
                ->select('admin_users.*', 'roles.name as role_name')
                ->first();

        return $result;
    }

    public function findByEmail($email)
    {
        $result = $this->model
                ->leftJoin('roles', 'admin_users.role_id', '=', 'roles.id')
                ->where('email', '=', $email)
                ->where('admin_users.status', '=', 1)
                ->select('admin_users.*', 'roles.name as role_name')
                ->first();

        return $result;
    }
}

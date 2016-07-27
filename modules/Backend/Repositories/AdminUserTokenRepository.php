<?php

namespace Modules\Backend\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Entities\AdminUserToken;

class AdminUserTokenRepository extends BaseRepository
{

    public function __construct()
    {
        $this->model = new AdminUserToken();
    }

    public function find($id)
    {
        $result = $this->model
            ->where($this->primaryKey, '=', $id)
            ->first();
        return $result;
    }

    public function findBy($key, $value, $operator = '=')
    {
        $results = $this->model
                ->where($key, $operator, $value)->get();
        return $results;
    }

}

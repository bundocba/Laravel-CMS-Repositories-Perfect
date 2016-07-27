<?php

namespace Modules\Backend\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Entities\AdminUserPreference;

class AdminUserPreferenceRepository extends BaseRepository
{

    public function __construct()
    {
        $this->model = new AdminUserPreference();
    }

    public function find($id)
    {
        $result = $this->model
//            ->where('status', '=', 1)
            ->where($this->primaryKey, '=', $id)
            ->first();
        return $result;
    }

//    public function findBy($key, $value, $operator = '=')
//    {
//        $results = $this->model
//            ->where('status', '=', 1)
//            ->where($key, $operator, $value)->get();
//        return $results;
//    }

}

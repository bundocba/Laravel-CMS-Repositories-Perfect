<?php

namespace Modules\Frontend\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Entities\UserSetting;

class UserSettingRepository extends BaseRepository
{

    public function __construct()
    {
        $this->model = new UserSetting();
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

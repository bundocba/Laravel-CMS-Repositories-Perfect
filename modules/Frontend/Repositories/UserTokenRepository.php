<?php

namespace Modules\Frontend\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Entities\UserToken;

class UserTokenRepository extends BaseRepository
{

    public function __construct()
    {
        $this->model = new UserToken();
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

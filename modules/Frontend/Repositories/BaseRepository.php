<?php

namespace Modules\Frontend\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Entities\Entity;

class BaseRepository
{
    protected $model;

    protected $primaryKey = 'id';

    public function findWithScope($key, $name)
    {
        $results = $this->model->where('status', '=', 1)
                                ->orderBy('name')
                                ->lists($name, $key)
                                ->toArray();
        return $results;
    }

    public function delete($id)
    {
        $result = $this->model
            ->where($this->primaryKey, '=', $id)
            ->delete();
        return $result;
    }

    public function update($id, $values)
    {
        $result = $this->model
            ->where($this->primaryKey, '=', $id)
            ->update($values);
        return $result;
    }

//    public function deleteBy($key, $value, $operator = '=')
//    {
//        $results = $this->model->where($key, $operator, $value)->delete();
//        return $results;
//    }

    public function save(Entity $entity)
    {
        $result = $entity->save();
        return $result;
    }
}

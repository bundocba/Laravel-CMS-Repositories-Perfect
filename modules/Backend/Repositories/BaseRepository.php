<?php

namespace Modules\Backend\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Entities\Entity;

class BaseRepository
{
    protected $model;

    protected $primaryKey = 'id';

    public function find($id)
    {
        $result = $this->model
            ->where($this->primaryKey, '=', $id)
            ->first();
        return $result;
    }

    public function findBy($key, $operator, $value)
    {
        $results = $this->model
            ->where($key, $operator, $value)
            ->get();
        return $results;
    }

    public function exists($key, $operator, $value)
    {
        $results = $this->model
            ->where($key, $operator, $value)
            ->first();
        return $results;
    }

    public function findAll()
    {
        $results = $this->model
                    ->get();
        return $results;
    }

    public function count()
    {
        $result = $this->model
            ->count();
        return $result;
    }

    public function countBy($key, $operator, $value)
    {
        $result = $this->model
            ->where($key, $operator, $value)
            ->count();
        return $result;
    }

//    public function findWithScope($key, $name)
//    {
//        $results = $this->model
//                        ->where('status', '=', 1)
//                        ->orderBy('name')
//                        ->lists($name, $key)
//                        ->toArray();
//        return $results;
//    }

//    public function paginate($perPage = 10)
//    {
//        $model = $this->model;
//        $results = $model::paginate($perPage);
//        return $results;
//    }

    public function save(Entity $entity)
    {
        $result = $entity->save();
        return $result;
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
            ->whereIn($this->primaryKey, $id)
            ->update($values);
        return $result;
    }

    public function massUpdate($ids, $values)
    {
        $result = $this->model
            ->whereIn($this->primaryKey, $ids)
            ->update($values);
        return $result;
    }

    public function massDelete($ids)
    {
        $result = $this->model
            ->whereIn($this->primaryKey, $ids)
            ->delete();
        return $result;
    }

    public function deleteBy($key, $operator, $value)
    {
        $results = $this->model
            ->where($key, $operator, $value)
            ->delete();

        return $results;
    }

}

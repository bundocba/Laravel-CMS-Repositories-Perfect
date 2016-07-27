<?php

namespace Modules\Backend\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Entities\Role;

class RoleRepository extends BaseRepository
{
    public function __construct()
    {
        $this->model = new Role();
    }

    public function paginate($priority, $perPage = 10, $orderBy = null, $direction = 'asc')
    {
        $results = $this->model->select('*');

        $results = $results
            ->where('priority', '>' , $priority)
            ->orderBy($orderBy, $direction)
            ->paginate($perPage);

        return $results;
    }

    public function findWithScope($priority, $key, $name)
    {
        $results = $this->model
                        ->where('status', '=', 1)
                        ->where('priority', '>', $priority)
                        ->orderBy('priority')
                        ->lists($name, $key)
                        ->toArray();
        
        return $results;
    }
}

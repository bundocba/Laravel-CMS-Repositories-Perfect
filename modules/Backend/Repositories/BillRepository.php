<?php

namespace Modules\Backend\Repositories;
use App\Entities\Bill;

class BillRepository extends BaseRepository
{
    public function __construct()
    {
            $this->model= new Bill();
    }
    public function paginate($perPage = 10, $orderBy = null, $direction = 'asc')
    {
        $results = $this->model->select('*');

        $results = $results
            ->orderBy($orderBy, $direction)
            ->paginate($perPage);
        return $results;
    }
}


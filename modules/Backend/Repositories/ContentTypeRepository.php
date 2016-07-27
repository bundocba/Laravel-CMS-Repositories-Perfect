<?php

namespace Modules\Backend\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Entities\ContentType;

class ContentTypeRepository extends BaseRepository
{
    public function __construct()
    {
        $this->model = new ContentType();
    }

    public function findWithScope($key, $name)
    {
        $results = $this->model
                        ->where('status', '=', 1)
                        ->orderBy('name')
                        ->lists($name, $key)
                        ->toArray();
        return $results;
    }
}

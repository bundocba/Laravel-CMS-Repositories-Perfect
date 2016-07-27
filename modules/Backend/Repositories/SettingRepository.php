<?php

namespace Modules\Backend\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Entities\Setting;

class SettingRepository extends BaseRepository
{
    public function __construct()
    {
        $this->model = new Setting();
    }
}

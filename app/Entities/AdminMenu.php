<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdminMenu extends Entity
{
    protected $table = 'admin_menus';

    public function menuLinks()
    {
        return $this->hasMany( __NAMESPACE__ . '\AdminMenuLink');
    }
}

<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Entity
{
    protected $table = 'menus';

    public function menuLinks()
    {
        return $this->hasMany( __NAMESPACE__ . '\MenuLink');
    }
}

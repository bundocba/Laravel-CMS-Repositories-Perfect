<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdminMenuLink extends Entity
{
    protected $table = 'admin_menu_links';

    public function menu()
    {
        return $this->belongsTo(__NAMESPACE__ . '\Menu');
    }
}

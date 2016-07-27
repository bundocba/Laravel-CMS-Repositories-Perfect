<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Entity
{

    protected $table = 'roles';

    const SUPER_ADMINISTRATOR = 1;
    const ADMINISTRATOR = 2;
}

<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Entity
{
    protected $table = 'users';

    protected $hidden = ['password'];
}

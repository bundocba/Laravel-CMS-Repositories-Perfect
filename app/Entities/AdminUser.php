<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;
use Illuminate\Database\Eloquent\SoftDeletes;
class AdminUser extends Entity
{
    protected $table = 'admin_users';

    protected $hidden = ['password'];
    
    public function role()
    {
        return $this->belongsTo(__NAMESPACE__ . '\Role');
    }
}

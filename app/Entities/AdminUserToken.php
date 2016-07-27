<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdminUserToken extends Entity
{
    protected $table = 'admin_user_tokens';

    public function adminUser()
    {
        return $this->belongsTo(__NAMESPACE__ . '\AdminUser');
    }
}

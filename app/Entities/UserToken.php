<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserToken extends Entity
{
    protected $table = 'user_tokens';

    public function user()
    {
        return $this->belongsTo(__NAMESPACE__ . '\User');
    }
}

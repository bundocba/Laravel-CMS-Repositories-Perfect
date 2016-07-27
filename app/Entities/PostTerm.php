<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;
use Illuminate\Database\Eloquent\SoftDeletes;

class PostTerm extends Entity
{
    protected $table = 'posts_terms';

    public function post()
    {
        return $this->belongsTo(__NAMESPACE__ . '\Post');
    }

    public function term()
    {
        return $this->belongsTo(__NAMESPACE__ . '\Term');
    }
}

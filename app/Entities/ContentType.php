<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContentType extends Entity
{
    protected $table = 'content_types';

    const PAGE = 1;
    const ARTICLE = 2;
    const CONTACT = 3;

    public function posts()
    {
        return $this->hasMany( __NAMESPACE__ . '\Post');
    }
}

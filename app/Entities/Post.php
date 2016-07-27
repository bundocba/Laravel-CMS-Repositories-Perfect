<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Entity
{
    protected $table = 'posts';

    public function contentType()
    {
        return $this->belongsTo(__NAMESPACE__ . '\ContentType');
    }

    public function postTerms()
    {
        return $this->hasMany( __NAMESPACE__ . '\PostTerm');
    }

    public function slugs()
    {
        return $this->hasMany( __NAMESPACE__ . '\Slug', 'url', 'url');
    }

    public function terms()
    {
        return $this->belongsToMany( __NAMESPACE__ . '\Term', 'posts_terms', 'post_id', 'term_id');
    }
}

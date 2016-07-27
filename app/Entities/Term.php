<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;
use Illuminate\Database\Eloquent\SoftDeletes;

class Term extends Entity
{
    protected $table = 'terms';

    public function postTerms()
    {
        return $this->hasMany( __NAMESPACE__ . '\PostTerm');
    }
}

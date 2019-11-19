<?php

namespace App\Repositories\Mongo\Models;

use Moloquent;

class Category extends Moloquent
{
    protected $fillable = [
        'name'
    ];

    public function transactions()
    {
        return $this->hasMany('App\Transaction');
    }

    public function owner()
    {
        return $this->belongsTo('App\Repositories\Mongo\Models\User');
    }
}

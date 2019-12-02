<?php

namespace App\Repositories\Mongo\Models;

use Moloquent;

class PlannedMonthlySpending extends Moloquent
{
    protected $fillable = [
        'value'
    ];

    public function owner()
    {
        return $this->belongsTo('App\Repositories\Mongo\Models\User');
    }
}

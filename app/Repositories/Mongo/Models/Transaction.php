<?php

namespace App\Repositories\Mongo\Models;

use Moloquent;

class Transaction extends Moloquent
{
    protected $fillable = [
        'description', 'amount', 'user_id', 'transaction_category_id',
    ];

    public function category()
    {
        return $this->belongsTo('App\Repositories\Mongo\Models\Category');
    }

    public function owner()
    {
        return $this->belongsTo('App\Repositories\Mongo\Models\User');
    }
}

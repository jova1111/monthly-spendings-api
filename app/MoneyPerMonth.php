<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MoneyPerMonth extends Model
{
    protected $fillable = [
        'value'
    ];
    public function user(){
        return $this->belongsTo('App\User');
    }
}

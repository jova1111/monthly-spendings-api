<?php

namespace App\Repositories\Mongo\Models;

use Moloquent;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\Authenticable as AuthenticableTrait;
use Illuminate\Contracts\Authenticable;

class User extends Moloquent
{
    use AuthenticableTrait;
    use Notifiable;

    protected $connection = 'mongodb';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function transactions() {
        return $this->hasMany('App\Transaction');
    }

    public function transactionCategories() {
        return $this->hasMany('App\TransactionCategory');
    }
    public function monthlyMoney() {
        return $this->hasMany('App\MoneyPerMonth');
    }
}   
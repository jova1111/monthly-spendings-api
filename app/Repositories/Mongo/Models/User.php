<?php

namespace App\Repositories\Mongo\Models;

use Moloquent;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\Authenticatable as AuthenticableTrait;
use Illuminate\Contracts\Auth\Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Moloquent implements Authenticatable, JWTSubject
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
        'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getJWTIdentifier()
    {
        return $this->id;
    }
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function transactions()
    {
        return $this->hasMany('App\Repositories\Mongo\Models\Transaction', 'owner_id');
    }

    public function categories()
    {
        return $this->hasMany('App\Repositories\Mongo\Models\Category', 'owner_id');
    }
    public function plannedMonthlySpendings()
    {
        return $this->hasMany('App\Repositories\Mongo\Models\PlannedMonthlySpending', 'owner_id');
    }
}

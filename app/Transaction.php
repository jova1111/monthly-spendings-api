<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'description', 'moneyspent', 'user_id', 'transaction_category_id',
    ];

    public function transactionCategory() {
        return $this->belongsTo('App\TransactionCategory');
    }
}

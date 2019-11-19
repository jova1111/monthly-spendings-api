<?php

namespace App\Services\Contracts;

use App\Models\Transaction;

interface TransactionService
{
    public function create(Transaction $transaction);

    public function get(int $id);

    public function getAll(int $owner_id = null);

    public function update(Transaction $transaction);

    public function delete($id);
}

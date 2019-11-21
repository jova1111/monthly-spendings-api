<?php

namespace App\Repositories;

use App\Models\Transaction;

interface TransactionRepository
{
    public function create(Transaction $transaction): Transaction;
    public function get(string $id): ?Transaction;
    public function getAll(string $ownerId = null);
    public function update(Transaction $transaction);
    public function delete(string $id);
}

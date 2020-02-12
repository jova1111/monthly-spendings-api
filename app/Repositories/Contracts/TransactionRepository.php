<?php

namespace App\Repositories\Contracts;

use App\Models\Transaction;
use DateTime;

interface TransactionRepository
{
    public function create(Transaction $transaction): Transaction;
    public function get(string $id): ?Transaction;
    public function getAll(string $ownerId = null, DateTime $startDate = null, DateTime $endDate = null);
    public function update(Transaction $transaction): ?Transaction;
    public function delete(string $id);
    public function getAverageSpendingsOfOtherUsers($userId);
}

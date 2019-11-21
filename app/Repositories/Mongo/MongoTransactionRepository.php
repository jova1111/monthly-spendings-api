<?php

namespace App\Repositories\Mongo;

use App\Models\Transaction;
use App\Repositories\Mongo\Models\Transaction as RepoTransaction;
use App\Repositories\TransactionRepository;

class MongoTransactionRepository implements TransactionRepository
{
    public function create(Transaction $transaction): Transaction
    {
        $newTransaction = new RepoTransaction;
        $newTransaction->description = $transaction->getDescription();
        $newTransaction->amount = $transaction->getAmonut();
        $newTransaction->category_id = $transaction->getCategory()->getId();
        $newTransaction->owner_id = $transaction->getOwner()->getId();
        $newTransaction->save();

        $transaction->setId($newTransaction->id);
        $transaction->setCreationDate($newTransaction->created_at->toDateTimeString());
        return $transaction;
    }

    public function get(string $id): ?Transaction
    { }

    public function getAll(string $ownerId = null)
    { }

    public function update(Transaction $transaction)
    { }

    public function delete(string $id)
    { }
}

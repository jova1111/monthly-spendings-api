<?php

namespace App\Repositories\Mongo;

use App\Models\Transaction;
use App\Repositories\Mongo\Models\Transaction as RepoTransaction;
use App\Repositories\Mongo\Utils\MongoMapper;
use App\Repositories\Contracts\TransactionRepository;
use DateTime;

class MongoTransactionRepository implements TransactionRepository
{
    public function create(Transaction $transaction): Transaction
    {
        $newTransaction = new RepoTransaction;
        $newTransaction->description = $transaction->getDescription();
        $newTransaction->amount = $transaction->getAmount();
        $newTransaction->category_id = $transaction->getCategory()->getId();
        $newTransaction->owner_id = $transaction->getOwner()->getId();
        $newTransaction->save();

        $transaction->setId($newTransaction->id);
        $transaction->setCreationDate($newTransaction->created_at->toDateTimeString());
        $transaction->setCategory(MongoMapper::mapRepoCategoryToCategory($newTransaction->category));
        return $transaction;
    }

    public function get(string $id): ?Transaction
    {
        $repoTransaction = RepoTransaction::find($id);
        return MongoMapper::mapRepoTransactionToTransaction($repoTransaction);
    }

    public function getAll(string $ownerId = null, DateTime $startDate = null, DateTime $endDate = null)
    {
        $transactions = array();
        $repoTransactions = RepoTransaction::query();
        if ($ownerId) {
            $repoTransactions->where('owner_id', $ownerId);
        }
        if ($startDate) {
            $repoTransactions->where('created_at', '>=', $startDate);
        }
        if ($endDate) {
            $repoTransactions->where('created_at', '<=', $endDate);
        }
        foreach ($repoTransactions->with('category')->latest()->get() as $repoTransaction) {
            array_push($transactions, MongoMapper::mapRepoTransactionToTransaction($repoTransaction));
        }
        return $transactions;
    }

    public function update(Transaction $transaction)
    {
        $repoTransaction = RepoTransaction::find($transaction->getId());
        $repoTransaction->category_id = $transaction->getCategory()->getId();
        $repoTransaction->amount = $transaction->getAmount();
        $repoTransaction->description = $transaction->getDescription();
        $repoTransaction->save();
        return MongoMapper::mapRepoTransactionToTransaction($repoTransaction);
    }

    public function delete(string $id)
    {
        RepoTransaction::destroy($id);
    }

    public function getAverageSpendingsOfOtherUsers($userId)
    {
        return RepoTransaction::where('owner_id', '!=', $userId)->avg('amount');
    }
}

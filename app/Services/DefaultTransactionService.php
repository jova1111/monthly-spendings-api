<?php

namespace App\Services;

use App\Models\Transaction;
use App\Repositories\TransactionRepository;
use App\Services\Contracts\TransactionService;

class DefaultTransactionService implements TransactionService
{
    private $_transactions;

    public function __construct(TransactionRepository $transactions)
    {
        $this->_transactions = $transactions;
    }

    public function create(Transaction $transaction)
    {
        return $this->_transactions->create($transaction);
    }

    public function get(int $id)
    {
        return $this->_transactions->get($id);
    }

    public function getAll(int $owner_id = null)
    {
        return $this->_transactions->getAll($owner_id);
    }

    public function update(Transaction $transaction)
    {
        return $this->_transactions->update($transaction);
    }

    public function delete($id)
    {
        return $this->_transactions->delete($id);
    }
}

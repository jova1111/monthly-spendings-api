<?php

namespace App\Services;

use App\Models\Transaction;
use App\Repositories\TransactionRepository;
use App\Services\Contracts\TransactionService;

class DefaultTransactionService implements TransactionService
{
    private $transactionRepository;

    public function __construct(TransactionRepository $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
    }

    public function create(Transaction $transaction): Transaction
    {
        return $this->transactionRepository->create($transaction);
    }

    public function get(string $id): ?Transaction
    {
        return $this->transactionRepository->get($id);
    }

    public function getAll(string $ownerId = null)
    {
        return $this->transactionRepository->getAll($ownerId);
    }

    public function update(Transaction $transaction)
    {
        return $this->transactionRepository->update($transaction);
    }

    public function delete(string $id)
    {
        return $this->transactionRepository->delete($id);
    }
}

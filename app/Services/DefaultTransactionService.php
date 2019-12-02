<?php

namespace App\Services;

use App\Exceptions\ResourceNotFoundException;
use App\Models\Transaction;
use App\Repositories\Contracts\TransactionRepository;
use App\Services\Contracts\TransactionService;
use DateTime;

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
        $transaction = $this->transactionRepository->get($id);
        if (!$transaction) {
            throw new ResourceNotFoundException('Transaction with an id ' . $id . ' not found.');
        }
        return $transaction;
    }

    public function getAll(string $ownerId = null, DateTime $startDate = null, DateTime $endDate = null)
    {
        return $this->transactionRepository->getAll($ownerId, $startDate, $endDate);
    }

    public function update(Transaction $transaction)
    {

        return $this->transactionRepository->update($transaction);
    }

    public function delete(string $id)
    {
        $transaction = $this->get($id);
        return $this->transactionRepository->delete($id);
    }
}

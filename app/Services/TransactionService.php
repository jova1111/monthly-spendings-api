<?php

namespace App\Services;

use App\Exceptions\ResourceNotFoundException;
use App\Models\Transaction;
use App\Repositories\Contracts\CategoryRepository;
use App\Repositories\Contracts\TransactionRepository;
use DateTime;

class TransactionService
{
    private $transactionRepository;
    private $categoryRepository;

    public function __construct(TransactionRepository $transactionRepository, CategoryRepository $categoryRepository)
    {
        $this->transactionRepository = $transactionRepository;
        $this->categoryRepository = $categoryRepository;
    }

    public function create(Transaction $transaction): Transaction
    {
        $category = $this->categoryRepository->get($transaction->getCategory()->getId());
        if (!$category) {
            throw new ResourceNotFoundException('Category with an id ' . $transaction->getCategory()->getId() . ' not found. Cannot create transaction.');
        }
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

    public function getAll(string $ownerId = null, DateTime $startDate = null, DateTime $endDate = null, string $groupBy = null)
    {
        $allTransactions = $this->transactionRepository->getAll($ownerId, $startDate, $endDate);
        if ($groupBy == 'month') {
            $groupedTransactions = array();
            foreach ($allTransactions as $transaction) {
                $groupedTransactions[date('n', strtotime($transaction->getCreationDate()))][] = $transaction;
            }
            foreach (array_keys($groupedTransactions) as $key) {
                $sum = 0;
                foreach ($groupedTransactions[$key] as $transaction) {
                    $sum += $transaction->getAmount();
                }
                $groupedTransactions[$key] = $sum;
            }
            $allTransactions = $groupedTransactions;
        }
        return $allTransactions;
    }

    public function update(Transaction $transaction)
    {
        $category = $this->categoryRepository->get($transaction->getCategory()->getId());
        if (!$category) {
            throw new ResourceNotFoundException('Category with an id ' . $transaction->getCategory()->getId() . ' not found. Cannot update transaction.');
        }
        return $this->transactionRepository->update($transaction);
    }

    public function delete(string $id)
    {
        $transaction = $this->get($id);
        return $this->transactionRepository->delete($id);
    }
}

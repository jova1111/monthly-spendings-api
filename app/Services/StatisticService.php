<?php

namespace App\Services;

use App\Repositories\Contracts\TransactionRepository;
use DateTime;

class StatisticService
{
    private $transactionRepository;

    public function __construct(TransactionRepository $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
    }

    public function getMonthlySpendingsByCategory(string $userId, int $year = null)
    {
        $transactions = null;
        if ($year) {
            $startDate = new DateTime('first day of january ' . $year);
            $endDate = new DateTime('last day of december ' . $year);
            $transactions = $this->transactionRepository->getAll($userId, $startDate, $endDate);
        } else {
            $transactions = $this->transactionRepository->getAll($userId);
        }

        // group by category name
        $groupedTransactions = array();
        foreach ($transactions as $transaction) {
            $groupedTransactions[$transaction->getCategory()->getName()][] = $transaction;
        }
        foreach (array_keys($groupedTransactions) as $categoryKey) {
            // group by month in category
            $groupedTransactionsByMonth = array();
            foreach ($groupedTransactions[$categoryKey] as $categoryTransaction) {
                $groupedTransactionsByMonth[date('n', strtotime($categoryTransaction->getCreationDate()))][] = $categoryTransaction;
            }
            // sum all spendings for that month
            foreach (array_keys($groupedTransactionsByMonth) as $monthKey) {
                $sum = 0;
                foreach ($groupedTransactionsByMonth[$monthKey] as $transactionByMonth) {
                    $sum += $transactionByMonth->getAmount();
                }
                $groupedTransactionsByMonth[$monthKey] = $sum;
            }
            $groupedTransactions[$categoryKey] = $groupedTransactionsByMonth;
        }

        return $groupedTransactions;
    }

    public function getAverageSpendingsOfOtherUsers($userId, $year = null)
    {
        if ($year) {
            $startDate = new DateTime('first day of january ' . $year);
            $endDate = new DateTime('last day of december ' . $year);
            $allTransactions = $this->transactionRepository->getAll(null, $startDate, $endDate);
            $filteredTransactions = array_filter($allTransactions, function ($transaction) use ($userId) {
                return $transaction->getOwner()->getId() != $userId;
            });
            if (count($filteredTransactions) == 0) {
                return 0;
            }
            $sum = array_reduce($filteredTransactions, function ($carry, $transaction) {
                return $carry + $transaction->getAmount();
            });

            return $sum / count($filteredTransactions);
        }
        return $this->transactionRepository->getAverageSpendingsOfOtherUsers($userId);
    }

    public function getAverageMonthlySpendingsByUsers(string $userId, int $year = null)
    {
        $transactions = null;
        if ($year) {
            $startDate = new DateTime('first day of january ' . $year);
            $endDate = new DateTime('last day of december ' . $year);
            $transactions = $this->transactionRepository->getAll(null, $startDate, $endDate);
        } else {
            $transactions = $this->transactionRepository->getAll();
        }
        $userMonthlyTransactions = array();
        $otherUsersMonthlyTransactions = array();
        foreach ($transactions as $transaction) {
            if ($transaction->getOwner()->getId() == $userId) {
                $userMonthlyTransactions[date('n', strtotime($transaction->getCreationDate()))][] = $transaction;
            } else {
                $otherUsersMonthlyTransactions[date('n', strtotime($transaction->getCreationDate()))][] = $transaction;
            }
        }

        // get total monthly spendings by user
        $totalUserSpendingsByMonth = array();
        foreach (array_keys($userMonthlyTransactions) as $monthKey) {
            $sum = 0;
            foreach ($userMonthlyTransactions[$monthKey] as $transactionByMonth) {
                $sum += $transactionByMonth->getAmount();
            }
            $totalUserSpendingsByMonth[$monthKey] = $sum;
        }

        // get average monthly spendings by other users
        $otherUsersAverageSpendingsByMonth = array();
        foreach (array_keys($otherUsersMonthlyTransactions) as $monthKey) {
            $sum = 0;
            foreach ($otherUsersMonthlyTransactions[$monthKey] as $transactionByMonth) {
                $sum += $transactionByMonth->getAmount();
            }
            $otherUsersAverageSpendingsByMonth[$monthKey] = count($otherUsersMonthlyTransactions[$monthKey]) > 0 ? $sum / count($otherUsersMonthlyTransactions[$monthKey]) : 0;
        }

        return [
            'userTotalMonthlySpendings' => $totalUserSpendingsByMonth,
            'otherUsersAverageMonthlySpendings' => $otherUsersAverageSpendingsByMonth
        ];
    }
}

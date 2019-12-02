<?php

namespace App\Services;

use App\Exceptions\ResourceConflictException;
use App\Models\PlannedMonthlySpending;
use App\Repositories\Contracts\PlannedMonthlySpendingRepository;
use App\Services\Contracts\PlannedMonthlySpendingService;
use DateTime;

class DefaultPlannedMonthlySpendingService implements PlannedMonthlySpendingService
{
    private $plannedMonthlySpendingRepository;

    public function __construct(PlannedMonthlySpendingRepository $plannedMonthlySpendingRepository)
    {
        $this->plannedMonthlySpendingRepository = $plannedMonthlySpendingRepository;
    }

    public function create(PlannedMonthlySpending $plannedMonthlySpending): PlannedMonthlySpending
    {
        $startDate = new DateTime('first day of this month');
        $endDate = new DateTime('last day of this month');
        if ($this->plannedMonthlySpendingRepository->getAll(
            $plannedMonthlySpending->getOwner()->getId(),
            $startDate,
            $endDate
        )) {
            throw new ResourceConflictException('You already planned spendings for this month.');
        }
        return $this->plannedMonthlySpendingRepository->create($plannedMonthlySpending);
    }

    public function get(string $id): ?PlannedMonthlySpending
    {
        $plannedMonthlySpending = $this->plannedMonthlySpendingRepository->get($id);
        if (!$plannedMonthlySpending) {
            throw new ResourceNotFoundException('Planned monthly spending with an id ' . $id . ' not found.');
        }
        return $plannedMonthlySpending;
    }

    public function getAll(string $ownerId = null, DateTime $startDate = null, DateTime $endDate = null)
    {
        return $this->plannedMonthlySpendingRepository->getAll($ownerId, $startDate, $endDate);
    }

    public function update(PlannedMonthlySpending $plannedMonthlySpending)
    {
        $oldPlannedMonthlySpending = $this->get($plannedMonthlySpending->getId());
        return $this->plannedMonthlySpendingRepository->update($plannedMonthlySpending);
    }

    public function delete(string $id)
    { }
}

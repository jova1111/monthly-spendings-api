<?php

namespace App\Repositories\Mongo;

use App\Models\PlannedMonthlySpending;
use App\Repositories\Contracts\PlannedMonthlySpendingRepository;
use App\Repositories\Mongo\Models\PlannedMonthlySpending as RepoPlannedMonthlySpending;
use App\Repositories\Mongo\Utils\MongoMapper;
use DateTime;

class MongoPlannedMonthlySpendingRepository implements PlannedMonthlySpendingRepository
{
    public function create(PlannedMonthlySpending $plannedMonthlySpending): PlannedMonthlySpending
    {
        $repoPlannedMonthlySpending = new RepoPlannedMonthlySpending;
        $repoPlannedMonthlySpending->value = $plannedMonthlySpending->getValue();
        $repoPlannedMonthlySpending->owner_id = $plannedMonthlySpending->getOwner()->getId();
        $repoPlannedMonthlySpending->save();
        $plannedMonthlySpending->setId($repoPlannedMonthlySpending->id);
        return $plannedMonthlySpending;
    }

    public function get(string $id): ?PlannedMonthlySpending
    {
        $repoPlannedMonthlySpending = RepoPlannedMonthlySpending::find($id);
        return MongoMapper::mapRepoPlannedMonthlySpendingToPlannedMonthlySpending($repoPlannedMonthlySpending);
    }

    public function getAll(string $ownerId = null, DateTime $startDate = null, DateTime $endDate = null)
    {
        $plannedSpendings = array();
        $repoPlannedSpendings = RepoPlannedMonthlySpending::query();
        if ($ownerId) {
            $repoPlannedSpendings->where('owner_id', $ownerId);
        }
        if ($startDate) {
            $repoPlannedSpendings->where('created_at', '>=', $startDate);
        }
        if ($endDate) {
            $repoPlannedSpendings->where('created_at', '<=', $endDate);
        }
        foreach ($repoPlannedSpendings->get() as $repoPlannedSpending) {
            array_push($plannedSpendings, MongoMapper::mapRepoPlannedMonthlySpendingToPlannedMonthlySpending($repoPlannedSpending));
        }
        return $plannedSpendings;
    }

    public function update(PlannedMonthlySpending $plannedMonthlySpending): PlannedMonthlySpending
    {
        $repoPlannedMonthlySpending = RepoPlannedMonthlySpending::find($plannedMonthlySpending->getId());
        $repoPlannedMonthlySpending->update(['value' => $plannedMonthlySpending->getValue()]);
        return MongoMapper::mapRepoPlannedMonthlySpendingToPlannedMonthlySpending($repoPlannedMonthlySpending);
    }

    public function delete(string $id)
    {
    }
}

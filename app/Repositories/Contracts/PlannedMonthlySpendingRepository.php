<?php

namespace App\Repositories\Contracts;

use App\Models\PlannedMonthlySpending;
use DateTime;

interface PlannedMonthlySpendingRepository
{
    public function create(PlannedMonthlySpending $plannedMonthlySpending): PlannedMonthlySpending;

    public function get(string $id): ?PlannedMonthlySpending;

    public function getAll(string $ownerId = null, DateTime $startDate = null, DateTime $endDate = null);

    public function update(PlannedMonthlySpending $plannedMonthlySpending);

    public function delete(string $id);
}

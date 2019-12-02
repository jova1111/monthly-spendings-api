<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePlannedMonthlySpendingRequest;
use App\Http\Requests\UpdatePlannedMonthlySpendingRequest;
use App\Models\PlannedMonthlySpending;
use App\Models\User;
use App\Services\Contracts\PlannedMonthlySpendingService;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class PlannedMonthlySpendingController extends Controller
{
    private $plannedMonthlySpendingService;

    public function __construct(PlannedMonthlySpendingService $plannedMonthlySpendingService)
    {
        $this->plannedMonthlySpendingService = $plannedMonthlySpendingService;
    }

    public function create(CreatePlannedMonthlySpendingRequest $request)
    {
        $owner = new User;
        $owner->setId(auth()->user()->id);

        $plannedSpending = new PlannedMonthlySpending;
        $plannedSpending->setValue($request['value']);
        $plannedSpending->setOwner($owner);
        return response()->json($this->plannedMonthlySpendingService->create($plannedSpending), 201);
    }

    public function getUserPlannedMonthlySpendings(Request $request)
    {
        $startDate = null;
        $endDate = null;
        if ($request->startDate) {
            $startDate = new DateTime($request->startDate);
        }
        if ($request->endDate) {
            $endDate = new DateTime($request->endDate);
        }
        return response()->json($this->plannedMonthlySpendingService->getAll(auth()->user()->id, $startDate, $endDate));
    }

    public function update(UpdatePlannedMonthlySpendingRequest $request)
    {
        $owner = new User;
        $owner->setId(auth()->user()->id);

        $plannedMonthlySpending = new PlannedMonthlySpending;
        $plannedMonthlySpending->setId($request['id']);
        $plannedMonthlySpending->setValue($request['value']);
        $plannedMonthlySpending->setOwner($owner);
        $this->plannedMonthlySpendingService->update($plannedMonthlySpending);
        return Response::make("", 204);
    }
}

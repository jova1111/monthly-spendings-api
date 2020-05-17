<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\StatisticService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class StatisticController extends Controller
{
    private $statisticService;

    public function __construct()
    {
        $this->statisticService = App::make(StatisticService::class);
    }

    public function getMonthlySpendingsByCategory(Request $request)
    {
        return response()->json($this->statisticService->getMonthlySpendingsByCategory(auth()->user()->id, $request['year']));
    }

    public function getAverageSpendingsOfOtherUsers(Request $request)
    {
        return response()->json($this->statisticService->getAverageSpendingsOfOtherUsers(auth()->user()->id, $request['year']));
    }

    public function getAverageMonthlySpendingsByUsers(Request $request)
    {
        return response()->json($this->statisticService->getAverageMonthlySpendingsByUsers(auth()->user()->id, $request['year']));
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\StatisticService;
use Illuminate\Support\Facades\App;

class StatisticController extends Controller
{
    private $statisticService;

    public function __construct()
    {
        $this->statisticService = App::make(StatisticService::class);
    }

    public function getMonthlySpendingsByCategory($year)
    {
        return response()->json($this->statisticService->getMonthlySpendingsByCategory(auth()->user()->id, $year));
    }
}

<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\User;
use App\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CreateTransaction;
use Illuminate\Support\Facades\DB;

class TransactionsController extends Controller
{
    function show(Request $request)
    {
        return auth()->user()->transactions()->whereYear('created_at', '=', $request->Year)->get();
    }

    function getAllYears()
    {
        return auth()->user()->transactions()->select(DB::raw('DISTINCT YEAR(created_at) as year'))->pluck('year');
        
        /*->groupBy(function($item){
             return $item->created_at->format('Y');
            });*/
    }

    function showMonth(Request $request)
    {
        return auth()->user()->transactions()->whereMonth('created_at','=', $request->Month)->whereYear('created_at', '=', $request->Year)->latest()->get();
    }

    function create(CreateTransaction $request)
    {
        return auth()->user()->transactions()->save(new Transaction(
            $request->only(['description', 'moneyspent'])
        ));
    }
}

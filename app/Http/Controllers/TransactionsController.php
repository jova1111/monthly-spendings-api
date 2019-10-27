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
        return auth()->user()->transactions()->with('transactionCategory')->whereYear('created_at', '=', $request->Year)->get();
    }

    function getAllYears()
    {
        return auth()->user()->transactions()->select(DB::raw('DISTINCT YEAR(created_at) as year'))->pluck('year');
    }

    function getAllByYear(Request $request)
    {
        return auth()->user()->transactions()->with('transactionCategory')->whereYear('created_at', '=', $request->year)->get();
    }

    function showMonth(Request $request)
    {   
        return auth()->user()->transactions()->with('transactionCategory')->whereMonth('created_at','=', $request->Month)->whereYear('created_at', '=', $request->Year)->latest()->get();
    }

    function create(CreateTransaction $request)
    {
        $transaction = new Transaction();
        $transaction->description = $request['description'];
        $transaction->moneyspent = $request['moneyspent'];
        $transaction->transaction_category_id = $request['category']['id'];
        auth()->user()->transactions()->save($transaction);
        return response(auth()->user()->transactions()->with('transactionCategory')->where('id', '=', $transaction->id)->first(), 201);
    }

    function delete($id) {
        
        if (Transaction::where('id', '=', $id)->exists()) {
            Transaction::destroy($id);
            return response('Successfully deleted.', 200);
        }
        return response('No transaction with that id.', 400);
    }

    public function getTransactionsGroupedByCategoryByYear($year) {
        return auth()
            ->user()
            ->transactions()
            ->whereYear('created_at', '=', $year)
            ->get()
            ->makeHidden('transactionCategory')
            ->groupBy(function($d) {
                return $d->transactionCategory->name;
            });
            
        }
}

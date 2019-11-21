<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreateTransactionRequest;
use App\Models\Category;
use App\Models\Transaction;
use App\Models\User;
use App\Services\Contracts\TransactionService;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    private $transactionService;

    public function __construct(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    function getAllUserTransactions(Request $request)
    {
        return auth()->user()->transactions()->with('transactionCategory')->whereYear('created_at', '=', $request->year)->get();
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
        return auth()->user()->transactions()->with('transactionCategory')->whereMonth('created_at', '=', $request->Month)->whereYear('created_at', '=', $request->Year)->latest()->get();
    }

    function create(CreateTransactionRequest $request)
    {
        $owner = new User;
        $owner->setId(auth()->user()->id);

        $category = new Category;
        $category->setId($request['category']['id']);

        $transaction = new Transaction;
        $transaction->setDescription($request['description']);
        $transaction->setAmount($request['amount']);
        $transaction->setOwner($owner);
        $transaction->setCategory($category);
        return response()->json($this->transactionService->create($transaction), 201);
    }

    function delete($id)
    {

        if (Transaction::where('id', '=', $id)->exists()) {
            Transaction::destroy($id);
            return response('Successfully deleted.', 200);
        }
        return response('No transaction with that id.', 400);
    }

    public function getTransactionsGroupedByCategoryByYear($year)
    {
        return auth()
            ->user()
            ->transactions()
            ->whereYear('created_at', '=', $year)
            ->get()
            ->makeHidden('transactionCategory')
            ->groupBy(function ($d) {
                return $d->transactionCategory->name;
            });
    }
}

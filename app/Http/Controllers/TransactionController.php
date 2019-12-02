<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreateTransactionRequest;
use App\Http\Requests\DeleteTransactionRequest;
use App\Models\Category;
use App\Models\Transaction;
use App\Models\User;
use App\Services\Contracts\TransactionService;
use DateTime;
use Illuminate\Support\Facades\Response;

class TransactionController extends Controller
{
    private $transactionService;

    public function __construct(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    function getUserTransactions(Request $request)
    {
        $startDate = null;
        $endDate = null;
        if ($request->startDate) {
            $startDate = new DateTime($request->startDate);
        }
        if ($request->endDate) {
            $endDate = new DateTime($request->endDate);
        }
        return $this->transactionService->getAll(auth()->user()->id, $startDate, $endDate);
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

    function delete(DeleteTransactionRequest $request)
    {
        $this->transactionService->delete($request['id']);
        return Response::make("", 204);
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

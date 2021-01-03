<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreateTransactionRequest;
use App\Http\Requests\DeleteTransactionRequest;
use App\Http\Requests\UpdateTransactionRequest;
use App\Models\Category;
use App\Models\Transaction;
use App\Models\User;
use App\Services\TransactionService;
use DateTime;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Response;

class TransactionController extends Controller
{
    private $transactionService;

    public function __construct()
    {
        $this->transactionService = App::make(TransactionService::class);
    }

    function getUserTransactions(Request $request)
    {
        $cacheId = 'transactions' . auth()->user()->id;
        if ($request->cached == 'true' && Cache::has($cacheId)) {
            return response()->json(Cache::get($cacheId));
        }
        $startDate = null;
        $endDate = null;
        $groupBy = $request->groupBy;
        if ($request->startDate) {
            $startDate = new DateTime($request->startDate);
        }
        if ($request->endDate) {
            $endDate = new DateTime($request->endDate);
        }
        $transactions = $this->transactionService->getAll(auth()->user()->id, $startDate, $endDate, $groupBy);
        if ($request->cached == 'true') {
            Cache::put($cacheId, $transactions, 60);
        }
        return $transactions;
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

    function update(UpdateTransactionRequest $request)
    {
        $owner = new User;
        $owner->setId(auth()->user()->id);

        $category = new Category;
        $category->setId($request['category']['id']);

        $transaction = new Transaction;
        $transaction->setId($request['id']);
        $transaction->setDescription($request['description']);
        $transaction->setAmount($request['amount']);
        $transaction->setCategory($category);
        $transaction->setOwner($owner);
        return response()->json($this->transactionService->update($transaction));
    }
}

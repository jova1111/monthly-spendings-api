<?php

namespace App\Http\Requests;

use App\Services\Contracts\TransactionService;
use Illuminate\Foundation\Http\FormRequest;

class DeleteTransactionRequest extends FormRequest
{
    private $transactionService;

    public function __construct(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $transaction = $this->transactionService->get($this->route('id'));
        if (auth()->user()->id != $transaction->getOwner()->getId()) {
            return false;
        }
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [];
    }
}

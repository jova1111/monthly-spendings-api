<?php

namespace App\Http\Requests;

use App\Services\TransactionService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\App;

class DeleteTransactionRequest extends FormRequest
{
    private $transactionService;

    public function __construct()
    {
        $this->transactionService = App::make(TransactionService::class);;
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

<?php

namespace App\Http\Requests;

use App\Services\Contracts\PlannedMonthlySpendingService;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePlannedMonthlySpendingRequest extends FormRequest
{
    private $plannedMonthlySpendingService;

    public function __construct(PlannedMonthlySpendingService $plannedMonthlySpendingService)
    {
        $this->plannedMonthlySpendingService = $plannedMonthlySpendingService;
    }
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $plannedMonthlySpending = $this->plannedMonthlySpendingService->get($this->route('id'));
        if (auth()->user()->id != $plannedMonthlySpending->getOwner()->getId()) {
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
        return [
            'value' => 'required|numeric'
        ];
    }
}

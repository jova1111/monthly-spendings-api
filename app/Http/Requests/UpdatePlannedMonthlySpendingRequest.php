<?php

namespace App\Http\Requests;

use App\Services\PlannedMonthlySpendingService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\App;

class UpdatePlannedMonthlySpendingRequest extends FormRequest
{
    private $plannedMonthlySpendingService;

    public function __construct()
    {
        $this->plannedMonthlySpendingService = App::make(PlannedMonthlySpendingService::class);;
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
            'value' => 'required|numeric|min:0'
        ];
    }
}

<?php

namespace App\Http\Controllers;

use App\MoneyPerMonth;
use Illuminate\Http\Request;

class MoneyPerMonthController extends Controller
{
    public function update(Request $request)
    {
        $request->validate(
            ['value' => 'required']
        );
        $moneyPerMonth = auth()->user()->monthlyMoney()->whereMonth('created_at','=', \Carbon\Carbon::now()->month)->whereYear('created_at', '=', \Carbon\Carbon::now()->year)->first();
        if ($moneyPerMonth) $moneyPerMonth->update(['value' => $request->value]);
        else {
            $moneyPerMonth = new MoneyPerMonth(
                $request->only('value')
            );
            auth()->user()->monthlyMoney()->save($moneyPerMonth);
        }
        return response($moneyPerMonth, 200);
    }

    public function getMoneyPerMonth(Request $request){
        return auth()->user()->monthlyMoney()->whereMonth('created_at','=', $request->Month)->whereYear('created_at', '=', $request->Year)->get();
    }

    
}

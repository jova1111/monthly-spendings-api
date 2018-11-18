<?php

namespace App\Http\Controllers;

use App\TransactionCategory;
use Illuminate\Http\Request;

class TransactionCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllUserCategories()
    {
        $categories = auth()->user()->transactionCategories()->get();
        return response($categories, 200);
    }

    /**
     * Create new category.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request->validate(
            ['name' => 'required']
        );

        if(TransactionCategory::where('name', '=', $request['name'])->exists()) {
            return response('Transaction category with given name already exists.', 400);
        }
        
        $category = new TransactionCategory(
            $request->only(['name'])
        );
        auth()->user()->transactionCategories()->save($category);

        return response($category, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TransactionCategory  $transactionCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TransactionCategory $transactionCategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TransactionCategory  $transactionCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(TransactionCategory $transactionCategory)
    {
        //
    }
}

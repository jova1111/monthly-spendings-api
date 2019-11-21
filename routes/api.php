<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::get('/view/transactions', 'TransactionController@showMonth')->middleware('jwt.auth');
Route::get('/transactions/getYears', 'TransactionController@getAllYears')->middleware('jwt.auth');
Route::get('/transactions', 'TransactionController@getAllUserTransactions')->middleware('jwt.auth');
Route::post('/transactions', 'TransactionController@create')->middleware('jwt.auth');
Route::delete('/transactions/{id}', 'TransactionsController@delete')->middleware('jwt.auth');
Route::get('/transactions/year/{year}', 'TransactionController@getAllByYear')->middleware('jwt.auth');
Route::get('/transaction/year/{year}/category_groups', 'TransactionController@getTransactionsGroupedByCategoryByYear')->middleware('jwt.auth');

Route::post('/categories', 'CategoryController@create')->middleware('jwt.auth');
Route::get('/categories', 'CategoryController@getAllUserCategories')->middleware('jwt.auth');
Route::put('/transactions/money_per_month', 'MoneyPerMonthController@update')->middleware('jwt.auth');
Route::get('/transactions/money_per_month', 'MoneyPerMonthController@getMoneyPerMonth')->middleware('jwt.auth');

Route::post('/register', 'AuthenticationController@create');
Route::post('/login', 'AuthenticationController@authenticate');

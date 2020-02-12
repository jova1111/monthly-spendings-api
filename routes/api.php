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

Route::get('/transactions', 'TransactionController@getUserTransactions')->middleware('jwt.auth');
Route::post('/transactions', 'TransactionController@create')->middleware('jwt.auth');
Route::delete('/transactions/{id}', 'TransactionController@delete')->middleware('jwt.auth');
Route::patch('/transactions/{id}', 'TransactionController@update')->middleware('jwt.auth');
Route::get('/transaction/year/{year}/category_groups', 'TransactionController@getTransactionsGroupedByCategoryByYear')->middleware('jwt.auth');

Route::post('/categories', 'CategoryController@create')->middleware('jwt.auth');
Route::get('/categories', 'CategoryController@getAllUserCategories')->middleware('jwt.auth');
Route::delete('/categories/{id}', 'CategoryController@delete')->middleware('jwt.auth');

Route::post('/planned-monthly-spendings', 'PlannedMonthlySpendingController@create')->middleware('jwt.auth');
Route::get('/planned-monthly-spendings', 'PlannedMonthlySpendingController@getUserPlannedMonthlySpendings')->middleware('jwt.auth');
Route::patch('/planned-monthly-spendings/{id}', 'PlannedMonthlySpendingController@update')->middleware('jwt.auth');

Route::post('/register', 'UserController@create');
Route::post('/login', 'UserController@authenticate');
Route::get('/users', 'UserController@getAll')->middleware('jwt.auth');
Route::get('/users/{id}/active-years', 'UserController@getActiveYears')->middleware('jwt.auth');

Route::get('/statistics/spendings-by-category', 'StatisticController@getMonthlySpendingsByCategory')->middleware('jwt.auth');
Route::get('/statistics/other-users-spendings', 'StatisticController@getAverageSpendingsOfOtherUsers')->middleware('jwt.auth');

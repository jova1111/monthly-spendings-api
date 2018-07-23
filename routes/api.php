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


Route::get('/view/transactions', 'TransactionsController@showMonth')->middleware('jwt.auth');
Route::get('/transactions/getYears','TransactionsController@getAllYears')->middleware('jwt.auth');
Route::get('/transactions', 'TransactionsController@show')->middleware('jwt.auth');
Route::post('/transactions', 'TransactionsController@create')->middleware('jwt.auth');

Route::post('/register','AuthenticateController@create');
Route::post('/login','AuthenticateController@authenticate');
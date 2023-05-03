<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::group(['middleware' => ['bengkel']],function(){

    Route::get('bengkel/list-service', 'App\Http\Controllers\Bengkel\Service@index');
    Route::get('bengkel/direct-service', 'App\Http\Controllers\Bengkel\DirectService@index');
    Route::get('bengkel/history-service', 'App\Http\Controllers\Bengkel\HistoryService@index');
    Route::get('bengkel/over-budget', 'App\Http\Controllers\Bengkel\OverBudget@index');
    Route::get('bengkel/invoice', 'App\Http\Controllers\Bengkel\Invoice@index');

});
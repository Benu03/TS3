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
Route::group(['middleware' => ['pic']],function(){

    Route::get('pic/dasbor', 'App\Http\Controllers\Pic\Dasbor@index');
    Route::get('pic/profile', 'App\Http\Controllers\Pic\Profile@index');
    Route::get('pic/list-service', 'App\Http\Controllers\Pic\Service@index');
    Route::get('pic/direct-service', 'App\Http\Controllers\Pic\Service@direct');
    Route::get('pic/advisor-service', 'App\Http\Controllers\Pic\Service@advisor');
    Route::get('pic/history-service', 'App\Http\Controllers\Pic\Service@history_service');
    
    Route::post('pic/service/tambah-direct-service', 'App\Http\Controllers\Pic\Service@tambah_direct_service');
    Route::get('pic/service/edit-direct-service/{par1}', 'App\Http\Controllers\Pic\Service@edit_direct_service');
    Route::post('pic/service/proses-direct-service', 'App\Http\Controllers\Pic\Service@proses_direct_service');

});
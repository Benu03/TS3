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

    Route::get('bengkel/profile', 'App\Http\Controllers\Bengkel\Profile@index');
    Route::post('bengkel/profile/ubah-password', 'App\Http\Controllers\Bengkel\Profile@ubah_password');
    Route::get('bengkel/dasbor', 'App\Http\Controllers\Bengkel\Dasbor@index');
    Route::get('bengkel/list-service', 'App\Http\Controllers\Bengkel\Service@index');
    Route::get('bengkel/direct-service', 'App\Http\Controllers\Bengkel\Service@direct_service');
    Route::get('bengkel/history-service', 'App\Http\Controllers\Bengkel\Service@history_service');
    Route::get('bengkel/invoice', 'App\Http\Controllers\Bengkel\Invoice@index');
    Route::get('bengkel/summary-bengkel', 'App\Http\Controllers\Bengkel\Invoice@summary_bengkel');


    

    Route::get('bengkel/service-proses-page/{par1}', 'App\Http\Controllers\Bengkel\Service@service_proses_page');
    Route::post('bengkel/service-proses', 'App\Http\Controllers\Bengkel\Service@service_proses');
    


});
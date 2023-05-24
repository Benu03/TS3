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
    Route::get('bengkel/summary-bengkel', 'App\Http\Controllers\Bengkel\Invoice@summary_bengkel');
    Route::get('bengkel/service-proses-page/{par1}', 'App\Http\Controllers\Bengkel\Service@service_proses_page');
    Route::post('bengkel/service-proses', 'App\Http\Controllers\Bengkel\Service@service_proses');
    Route::get('bengkel/invoice', 'App\Http\Controllers\Bengkel\Invoice@index');
    Route::get('bengkel/invoice-create', 'App\Http\Controllers\Bengkel\Invoice@invoice_create');
    Route::post('bengkel/invoice-create-detail-proses', 'App\Http\Controllers\Bengkel\Invoice@invoice_create_detail');
    

    Route::get('bengkel/service/get-image_direct/{par1}', 'App\Http\Controllers\Bengkel\Service@get_image_direct');
    // Route::get('bengkel/direct_service_estimate/{par1}', 'App\Http\Controllers\Bengkel\Service@direct_service_estimate');
    // Route::post('bengkel/direct-service-estimate-proses', 'App\Http\Controllers\Bengkel\Service@direct_service_estimate_proses');
    Route::get('bengkel/service/get-image_direct/{par1}', 'App\Http\Controllers\Bengkel\Service@get_image_direct');
    
    Route::post('bengkel/service/get-service', 'App\Http\Controllers\Bengkel\Invoice@get_service');   
    Route::get('bengkel/invoice-detail/delete/{par1}', 'App\Http\Controllers\Bengkel\Invoice@invoice_delete_detail');
    Route::post('bengkel/invoice/submit', 'App\Http\Controllers\Bengkel\Invoice@invoice_submit');   
    Route::get('bengkel/invoice-generate/{par1}', 'App\Http\Controllers\Bengkel\Invoice@invoice_generate');




    
});
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
    Route::post('pic/profile/ubah-password', 'App\Http\Controllers\Pic\Profile@ubah_password');
    Route::get('pic/list-service', 'App\Http\Controllers\Pic\Service@index');
    Route::get('pic/direct-service', 'App\Http\Controllers\Pic\Service@direct');

    Route::get('pic/history-service', 'App\Http\Controllers\Pic\Service@history_service');
    
    Route::post('pic/service/tambah-direct-service', 'App\Http\Controllers\Pic\Service@tambah_direct_service');
    Route::get('pic/service/edit-direct-service/{par1}', 'App\Http\Controllers\Pic\Service@edit_direct_service');
    Route::post('pic/service/proses-direct-service', 'App\Http\Controllers\Pic\Service@proses_direct_service');

    Route::post('pic/service/service-remark', 'App\Http\Controllers\Pic\Service@service_remark');
    Route::post('pic/service/get-vehicle', 'App\Http\Controllers\Pic\Service@get_vehicle');
    Route::get('pic/service/delete-direct-service/{par1}', 'App\Http\Controllers\Pic\Service@delete_direct_service');

    Route::get('pic/service/get-image_direct/{par1}', 'App\Http\Controllers\Pic\Service@get_image_direct');

    Route::get('pic/service/get-image-service-detail/{par1}', 'App\Http\Controllers\Pic\Service@get_image_service_detail');
    Route::get('pic/service/service-advisor/{par1}', 'App\Http\Controllers\Pic\Service@service_advisor');
    Route::post('pic/service/service-advisor-proses', 'App\Http\Controllers\Pic\Service@service_advisor_proses');
   

    Route::get('pic/report/get-image-service-detail/{par1}', 'App\Http\Controllers\Pic\report@get_image_service_detail');
    Route::get('pic/report/history-service', 'App\Http\Controllers\Pic\report@history_service');
    Route::get('pic/report/history-service-detail/{par1}', 'App\Http\Controllers\Pic\report@history_service_detail');
    Route::post('pic/get-history-service', 'App\Http\Controllers\Pic\report@getHistoryService');


     
    Route::get('pic/notification', 'App\Http\Controllers\Pic\Notif@index');
    Route::post('pic/notification-read', 'App\Http\Controllers\Pic\Notif@read');
    Route::get('pic/notification-data', 'App\Http\Controllers\Pic\Notif@getdata');

    Route::get('pic/get-service-due-date', 'App\Http\Controllers\Pic\Service@ServiceDueDate');

    Route::get('pic/service/get-image-service-detail/{par1}', 'App\Http\Controllers\Pic\Service@get_image_service_detail_pic');


    Route::get('pic/spk-status', 'App\Http\Controllers\Pic\Spk@spk_status');
    Route::get('pic/spk-history', 'App\Http\Controllers\Pic\Spk@spk_history');
    Route::get('pic/spk-file/{par1}', 'App\Http\Controllers\Pic\Spk@spk_file');
    Route::post('pic/get-spk-history', 'App\Http\Controllers\Pic\Spk@getSPKHistory');




});
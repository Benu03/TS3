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
Route::group(['middleware' => ['pic_reg']],function(){

    Route::get('pic-regional/dasbor', 'App\Http\Controllers\PicReg\Dasbor@index');
    Route::get('pic-regional/profile', 'App\Http\Controllers\PicReg\Profile@index');
    Route::post('pic-regional/profile/ubah-password', 'App\Http\Controllers\PicReg\Profile@ubah_password');
    Route::get('pic-regional/get-service-due-date', 'App\Http\Controllers\PicReg\Service@ServiceDueDate');
    Route::get('pic-regional/vehicle-schedule-service', 'App\Http\Controllers\PicReg\vehicle@vehicle_schedule_service');
    Route::get('pic-regional/vehicle-schedule-service-excel', 'App\Http\Controllers\PicReg\vehicle@vehicle_schedule_service_excel');
    Route::get('pic-regional/service/get-image-service-detail/{par1}', 'App\Http\Controllers\PicReg\Service@get_image_service_detail');


    Route::get('pic-regional/report/get-image-service-detail/{par1}', 'App\Http\Controllers\PicReg\report@get_image_service_detail');
    Route::get('pic-regional/report/history-service', 'App\Http\Controllers\PicReg\report@history_service');
    Route::get('pic-regional/report/history-service-detail/{par1}', 'App\Http\Controllers\PicReg\report@history_service_detail');
    Route::post('pic-regional/get-history-service', 'App\Http\Controllers\PicReg\report@getHistoryService');
    Route::post('pic-regional/export-history-service', 'App\Http\Controllers\PicReg\report@exportHistoryService');





});
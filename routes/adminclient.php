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
Route::group(['middleware' => ['adminclient']],function(){

    Route::get('admin-client/dasbor', 'App\Http\Controllers\AdminClient\Dasbor@index');
    Route::get('admin-client/profile', 'App\Http\Controllers\AdminClient\Profile@index');
    Route::post('admin-client/profile/ubah-password', 'App\Http\Controllers\AdminClient\Profile@ubah_password');

    Route::get('admin-client/spk', 'App\Http\Controllers\AdminClient\Spk@index');
    Route::get('admin-client/template-upload', 'App\Http\Controllers\AdminClient\Spk@template_upload');
    Route::post('admin-client/spk-upload', 'App\Http\Controllers\AdminClient\Spk@spk_upload');
    Route::post('admin-client/spk-posting', 'App\Http\Controllers\AdminClient\Spk@spk_posting');
    Route::get('admin-client/spk-temp-detail/{par1}', 'App\Http\Controllers\AdminClient\Spk@spk_temp_detail');


    Route::get('admin-client/invoice', 'App\Http\Controllers\AdminClient\Invoice@index');
    Route::get('admin-client/invoice-detail', 'App\Http\Controllers\AdminClient\Invoice@invoice_detail');


    Route::get('admin-client/pic-cabang', 'App\Http\Controllers\AdminClient\pic_cabang@index');
    Route::get('admin-client/pic-cabang-update', 'App\Http\Controllers\AdminClient\pic_cabang@pic_update');
    Route::get('admin-client/pic-cabang/detail/{par1}', 'App\Http\Controllers\AdminClient\pic_cabang@detail');

   

    Route::get('admin-client/vehicle', 'App\Http\Controllers\AdminClient\vehicle@index');
    Route::get('admin-client/vehicle/detail/{par1}', 'App\Http\Controllers\AdminClient\vehicle@detail');


    Route::get('admin-client/report/spk-history', 'App\Http\Controllers\AdminClient\report@spk_history');
    Route::get('admin-client/report/vehicle-service', 'App\Http\Controllers\AdminClient\report@vehicle_service');




});
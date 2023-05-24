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
    Route::get('admin-client/spk-detail/{par1}', 'App\Http\Controllers\AdminClient\Spk@spk_detail');
    Route::get('admin-client/spk-temp-detail/{par1}', 'App\Http\Controllers\AdminClient\Spk@spk_temp_detail');
    Route::get('admin-client/spk-reset/{par1}', 'App\Http\Controllers\AdminClient\Spk@spk_temp_reset');
    Route::get('admin-client/spk-posting/{par1}', 'App\Http\Controllers\AdminClient\Spk@spk_posting');


    Route::get('admin-client/invoice', 'App\Http\Controllers\AdminClient\Invoice@index');
    Route::get('admin-client/invoice-detail', 'App\Http\Controllers\AdminClient\Invoice@invoice_detail');


    Route::get('admin-client/pic-cabang', 'App\Http\Controllers\AdminClient\pic_cabang@index');
    Route::get('admin-client/pic-cabang-update', 'App\Http\Controllers\AdminClient\pic_cabang@pic_update');
    Route::get('admin-client/pic-cabang/detail/{par1}', 'App\Http\Controllers\AdminClient\pic_cabang@detail');

   

    Route::get('admin-client/vehicle', 'App\Http\Controllers\AdminClient\vehicle@index');
    Route::get('admin-client/vehicle/detail/{par1}', 'App\Http\Controllers\AdminClient\vehicle@detail');


    Route::get('admin-client/report/spk-history', 'App\Http\Controllers\AdminClient\report@spk_history');
    Route::get('admin-client/report/vehicle-service', 'App\Http\Controllers\AdminClient\report@vehicle_service');


    Route::get('admin-client/area', 'App\Http\Controllers\AdminClient\Area@index');
    Route::post('admin-client/area/tambah', 'App\Http\Controllers\AdminClient\Area@tambah');
    Route::post('admin-client/area/proses', 'App\Http\Controllers\AdminClient\Area@proses');
    Route::get('admin-client/area/edit/{par1}', 'App\Http\Controllers\AdminClient\Area@edit');
    Route::post('admin-client/area/proses_edit', 'App\Http\Controllers\AdminClient\Area@proses_edit');
    Route::get('admin-client/area/delete/{par1}', 'App\Http\Controllers\AdminClient\Area@delete');

    
    Route::get('admin-client/branch', 'App\Http\Controllers\AdminClient\Branch@index');
    Route::post('admin-client/branch/tambah', 'App\Http\Controllers\AdminClient\Branch@tambah');
    Route::post('admin-client/branch/proses', 'App\Http\Controllers\AdminClient\Branch@proses');
    Route::get('admin-client/branch/edit/{par1}', 'App\Http\Controllers\AdminClient\Branch@edit');
    Route::post('admin-client/branch/proses_edit', 'App\Http\Controllers\AdminClient\Branch@proses_edit');
    Route::get('admin-client/branch/delete/{par1}', 'App\Http\Controllers\AdminClient\Branch@delete');

    Route::get('admin-client/regional', 'App\Http\Controllers\AdminClient\Regional@index');
    Route::post('admin-client/regional/tambah', 'App\Http\Controllers\AdminClient\Regional@tambah');
    Route::post('admin-client/regional/proses', 'App\Http\Controllers\AdminClient\Regional@proses');
    Route::get('admin-client/regional/edit/{par1}', 'App\Http\Controllers\AdminClient\Regional@edit');
    Route::post('admin-client/regional/proses_edit', 'App\Http\Controllers\AdminClient\Regional@proses_edit');
    Route::get('admin-client/regional/delete/{par1}', 'App\Http\Controllers\AdminClient\Regional@delete');

    Route::get('admin-client/get-image-service-detail/{par1}', 'App\Http\Controllers\AdminClient\Approval@get_image_service_detail');
    Route::get('admin-client/approval', 'App\Http\Controllers\AdminClient\Approval@index');
    Route::post('admin-client/approval/service-approval-remark', 'App\Http\Controllers\AdminClient\Approval@service_approval_remark');
    Route::get('admin-client/approval/service-approval/{par1}', 'App\Http\Controllers\AdminClient\Approval@service_approval');
    Route::post('admin-client/approval/service-approval-proses', 'App\Http\Controllers\AdminClient\Approval@service_approval_proses');


    
});
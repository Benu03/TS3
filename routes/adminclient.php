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





    Route::get('admin-client/pic-cabang', 'App\Http\Controllers\AdminClient\pic_cabang@index');
    Route::get('admin-client/pic-cabang-update', 'App\Http\Controllers\AdminClient\pic_cabang@pic_update');
    Route::get('admin-client/pic-cabang/detail/{par1}', 'App\Http\Controllers\AdminClient\pic_cabang@detail');

   

    Route::get('admin-client/vehicle', 'App\Http\Controllers\AdminClient\vehicle@index');
    Route::post('admin-client/vehicle/tambah', 'App\Http\Controllers\AdminClient\vehicle@tambah');
    Route::post('admin-client/vehicle/proses', 'App\Http\Controllers\AdminClient\vehicle@proses');
    Route::get('admin-client/vehicle/edit/{par1}', 'App\Http\Controllers\AdminClient\vehicle@edit');
    Route::post('admin-client/vehicle/proses-edit', 'App\Http\Controllers\AdminClient\vehicle@proses_edit');
    Route::get('admin-client/vehicle/delete/{par1}', 'App\Http\Controllers\AdminClient\vehicle@delete');
    Route::get('admin-client/vehicle/detail/{par1}', 'App\Http\Controllers\AdminClient\vehicle@detail');
    
    Route::get('admin-client/vehicle-type', 'App\Http\Controllers\AdminClient\vehicle@index_vehicle_type');
    Route::post('admin-client/vehicle-type/tambah-vehicle-type', 'App\Http\Controllers\AdminClient\vehicle@tambah_vehicle_type');
    Route::post('admin-client/vehicle-type/proses-vehicle-type', 'App\Http\Controllers\AdminClient\vehicle@proses_vehicle_type');
    Route::get('admin-client/vehicle-type/edit-vehicle-type/{par1}', 'App\Http\Controllers\AdminClient\vehicle@edit_vehicle_type');
    Route::post('admin-client/vehicle-type/proses-edit-vehicle-type', 'App\Http\Controllers\AdminClient\vehicle@proses_edit_vehicle_type');
    Route::get('admin-client/vehicle-type/delete-vehicle-type/{par1}', 'App\Http\Controllers\AdminClient\vehicle@delete_vehicle_type');

    Route::get('admin-client/get-vehicle', 'App\Http\Controllers\AdminClient\vehicle@getVehicle');
    Route::get('admin-client/get-vehicle-type', 'App\Http\Controllers\AdminClient\vehicle@getVehicletype');


    Route::get('admin-client/report/spk-history', 'App\Http\Controllers\AdminClient\report@spk_history');
    // Route::get('admin-client/report/vehicle-service', 'App\Http\Controllers\AdminClient\report@vehicle_service');


    Route::get('admin-client/area', 'App\Http\Controllers\AdminClient\Area@index');
    Route::post('admin-client/area/tambah', 'App\Http\Controllers\AdminClient\Area@tambah');
    Route::post('admin-client/area/proses', 'App\Http\Controllers\AdminClient\Area@proses');
    Route::get('admin-client/area/edit/{par1}', 'App\Http\Controllers\AdminClient\Area@edit');
    Route::post('admin-client/area/proses_edit', 'App\Http\Controllers\AdminClient\Area@proses_edit');
    Route::get('admin-client/area/delete/{par1}', 'App\Http\Controllers\AdminClient\Area@delete');
   
    Route::get('admin-client/get-area', 'App\Http\Controllers\AdminClient\Area@getArea');
    
    Route::get('admin-client/branch', 'App\Http\Controllers\AdminClient\Branch@index');
    Route::post('admin-client/branch/tambah', 'App\Http\Controllers\AdminClient\Branch@tambah');
    Route::post('admin-client/branch/proses', 'App\Http\Controllers\AdminClient\Branch@proses');
    Route::get('admin-client/branch/edit/{par1}', 'App\Http\Controllers\AdminClient\Branch@edit');
    Route::post('admin-client/branch/proses_edit', 'App\Http\Controllers\AdminClient\Branch@proses_edit');
    Route::get('admin-client/branch/delete/{par1}', 'App\Http\Controllers\AdminClient\Branch@delete');

    Route::get('admin-client/get-branch', 'App\Http\Controllers\AdminClient\Branch@getBranch');

    Route::get('admin-client/regional', 'App\Http\Controllers\AdminClient\Regional@index');
    Route::post('admin-client/regional/tambah', 'App\Http\Controllers\AdminClient\Regional@tambah');
    Route::post('admin-client/regional/proses', 'App\Http\Controllers\AdminClient\Regional@proses');
    Route::get('admin-client/regional/edit/{par1}', 'App\Http\Controllers\AdminClient\Regional@edit');
    Route::post('admin-client/regional/proses_edit', 'App\Http\Controllers\AdminClient\Regional@proses_edit');
    Route::get('admin-client/regional/delete/{par1}', 'App\Http\Controllers\AdminClient\Regional@delete');

    Route::get('admin-client/get-regional', 'App\Http\Controllers\AdminClient\Regional@getRegional');

    Route::get('admin-client/get-image-service-detail/{par1}', 'App\Http\Controllers\AdminClient\Approval@get_image_service_detail');
    Route::get('admin-client/approval', 'App\Http\Controllers\AdminClient\Approval@index');
    Route::post('admin-client/approval/service-approval-remark', 'App\Http\Controllers\AdminClient\Approval@service_approval_remark');
    Route::get('admin-client/approval/service-approval/{par1}', 'App\Http\Controllers\AdminClient\Approval@service_approval');
    Route::post('admin-client/approval/service-approval-proses', 'App\Http\Controllers\AdminClient\Approval@service_approval_proses');


    Route::get('admin-client/approval/direct', 'App\Http\Controllers\AdminClient\Approval@direct');
    Route::get('admin-client/approval/direct-service-approval/{par1}', 'App\Http\Controllers\AdminClient\Approval@direct_service_approval');
    Route::post('admin-client/approval/direct-service-approval-proses', 'App\Http\Controllers\AdminClient\Approval@direct_service_approval_proses');
    Route::get('admin-client/approval/get-image_direct/{par1}', 'App\Http\Controllers\AdminClient\Approval@get_image_direct');



    Route::get('admin-client/invoice', 'App\Http\Controllers\AdminClient\Invoice@index');
    Route::get('admin-client/invoice-detail', 'App\Http\Controllers\AdminClient\Invoice@invoice_detail');
    Route::get('admin-client/invoice-generate-ts3/{par1}', 'App\Http\Controllers\AdminClient\Invoice@invoice_generate_ts3');
    Route::post('admin-client/invoice-admin-proses', 'App\Http\Controllers\AdminClient\Invoice@invoice_admin_proses');

    Route::get('admin-client/vehicle-schedule-service', 'App\Http\Controllers\AdminClient\vehicle@vehicle_schedule_service');
    Route::get('admin-client/vehicle-schedule-service-excel', 'App\Http\Controllers\AdminClient\vehicle@vehicle_schedule_service_excel');

  

    Route::get('admin-client/report/history-service', 'App\Http\Controllers\AdminClient\report@history_service');
    Route::get('admin-client/report/get-image-service-detail/{par1}', 'App\Http\Controllers\AdminClient\report@get_image_service_detail');




    
});
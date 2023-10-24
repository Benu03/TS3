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
    Route::get('pic-regional/list-service', 'App\Http\Controllers\PicReg\Service@index');





});
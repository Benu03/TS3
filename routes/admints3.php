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
Route::group(['middleware' => ['admints3']],function(){
    Route::get('admin-ts3/dasbor', 'App\Http\Controllers\AdminTs3\Dasbor@index');
    Route::get('admin-ts3/user', 'App\Http\Controllers\AdminTs3\User@index');
    Route::post('admin-ts3/user/tambah', 'App\Http\Controllers\AdminTs3\User@tambah');
    Route::get('admin-ts3/user/edit/{par1}', 'App\Http\Controllers\AdminTs3\User@edit');
    Route::post('admin-ts3/user/proses_edit', 'App\Http\Controllers\AdminTs3\User@proses_edit');
    Route::get('admin-ts3/user/delete/{par1}', 'App\Http\Controllers\AdminTs3\User@delete');
    Route::post('admin-ts3/user/proses', 'App\Http\Controllers\AdminTs3\User@proses');

    Route::get('admin-ts3/client', 'App\Http\Controllers\AdminTs3\ClientProduct@index');
    Route::post('admin-ts3/client/tambah', 'App\Http\Controllers\AdminTs3\ClientProduct@tambah');
    Route::post('admin-ts3/client/proses', 'App\Http\Controllers\AdminTs3\ClientProduct@proses');
    Route::get('admin-ts3/client/edit/{par1}', 'App\Http\Controllers\AdminTs3\ClientProduct@edit');
    Route::post('admin-ts3/client/proses_edit', 'App\Http\Controllers\AdminTs3\ClientProduct@proses_edit');
    Route::get('admin-ts3/client/delete/{par1}', 'App\Http\Controllers\AdminTs3\ClientProduct@delete');

    Route::get('admin-ts3/product', 'App\Http\Controllers\AdminTs3\ClientProduct@index_product');
    Route::post('admin-ts3/product/tambah-product', 'App\Http\Controllers\AdminTs3\ClientProduct@tambah_product');
    Route::post('admin-ts3/product/proses-product', 'App\Http\Controllers\AdminTs3\ClientProduct@proses_product');
    Route::get('admin-ts3/product/edit-product/{par1}', 'App\Http\Controllers\AdminTs3\ClientProduct@edit_product');
    Route::post('admin-ts3/product/proses-edit-product', 'App\Http\Controllers\AdminTs3\ClientProduct@proses_edit_product');
    Route::get('admin-ts3/product/delete-product/{par1}', 'App\Http\Controllers\AdminTs3\ClientProduct@delete_product');

    Route::get('admin-ts3/heading', 'App\Http\Controllers\AdminTs3\Heading@index');
    Route::post('admin-ts3/heading/tambah', 'App\Http\Controllers\AdminTs3\Heading@tambah');
    Route::post('admin-ts3/heading/edit', 'App\Http\Controllers\AdminTs3\Heading@edit');
    Route::get('admin-ts3/heading/delete/{par1}', 'App\Http\Controllers\AdminTs3\Heading@delete');
    
    Route::get('admin-ts3/konfigurasi', 'App\Http\Controllers\AdminTs3\Konfigurasi@index');
    Route::get('admin-ts3/konfigurasi/logo', 'App\Http\Controllers\AdminTs3\Konfigurasi@logo');
    Route::get('admin-ts3/konfigurasi/profil', 'App\Http\Controllers\AdminTs3\Konfigurasi@profil');
    Route::get('admin-ts3/konfigurasi/icon', 'App\Http\Controllers\AdminTs3\Konfigurasi@icon');
    Route::get('admin-ts3/konfigurasi/email', 'App\Http\Controllers\AdminTs3\Konfigurasi@email');
    Route::get('admin-ts3/konfigurasi/gambar', 'App\Http\Controllers\AdminTs3\Konfigurasi@gambar');
    Route::get('admin-ts3/konfigurasi/pembayaran', 'App\Http\Controllers\AdminTs3\Konfigurasi@pembayaran');
    Route::post('admin-ts3/konfigurasi/proses', 'App\Http\Controllers\AdminTs3\Konfigurasi@proses');
    Route::post('admin-ts3/konfigurasi/proses_logo', 'App\Http\Controllers\AdminTs3\Konfigurasi@proses_logo');
    Route::post('admin-ts3/konfigurasi/proses_icon', 'App\Http\Controllers\AdminTs3\Konfigurasi@proses_icon');
    Route::post('admin-ts3/konfigurasi/proses_email', 'App\Http\Controllers\AdminTs3\Konfigurasi@proses_email');
    Route::post('admin-ts3/konfigurasi/proses_gambar', 'App\Http\Controllers\AdminTs3\Konfigurasi@proses_gambar');
    Route::post('admin-ts3/konfigurasi/proses_pembayaran', 'App\Http\Controllers\AdminTs3\Konfigurasi@proses_pembayaran');
    Route::post('admin-ts3/konfigurasi/proses_profil', 'App\Http\Controllers\AdminTs3\Konfigurasi@proses_profil');

    Route::get('admin-ts3/galeri', 'App\Http\Controllers\AdminTs3\Galeri@index');
    Route::get('admin-ts3/galeri/cari', 'App\Http\Controllers\AdminTs3\Galeri@cari');
    Route::get('admin-ts3/galeri/status_galeri/{par1}', 'App\Http\Controllers\AdminTs3\Galeri@status_galeri');
    Route::get('admin-ts3/galeri/kategori/{par1}', 'App\Http\Controllers\AdminTs3\Galeri@kategori');
    Route::get('admin-ts3/galeri/tambah', 'App\Http\Controllers\AdminTs3\Galeri@tambah');
    Route::get('admin-ts3/galeri/edit/{par1}', 'App\Http\Controllers\AdminTs3\Galeri@edit');
    Route::get('admin-ts3/galeri/delete/{par1}', 'App\Http\Controllers\AdminTs3\Galeri@delete');
    Route::post('admin-ts3/galeri/tambah_proses', 'App\Http\Controllers\AdminTs3\Galeri@tambah_proses');
    Route::post('admin-ts3/galeri/edit_proses', 'App\Http\Controllers\AdminTs3\Galeri@edit_proses');
    Route::post('admin-ts3/galeri/proses', 'App\Http\Controllers\AdminTs3\Galeri@proses');

    Route::get('admin-ts3/kategori_galeri', 'App\Http\Controllers\AdminTs3\Kategori_galeri@index');
    Route::post('admin-ts3/kategori_galeri/tambah', 'App\Http\Controllers\AdminTs3\Kategori_galeri@tambah');
    Route::post('admin-ts3/kategori_galeri/edit', 'App\Http\Controllers\AdminTs3\Kategori_galeri@edit');
    Route::get('admin-ts3/kategori_galeri/delete/{par1}', 'App\Http\Controllers\AdminTs3\Kategori_galeri@delete');

    Route::get('admin-ts3/berita', 'App\Http\Controllers\AdminTs3\Berita@index');
    Route::get('admin-ts3/berita/cari', 'App\Http\Controllers\AdminTs3\Berita@cari');
    Route::get('admin-ts3/berita/status_berita/{par1}', 'App\Http\Controllers\AdminTs3\Berita@status_berita');
    Route::get('admin-ts3/berita/kategori/{par1}', 'App\Http\Controllers\AdminTs3\Berita@kategori');
    Route::get('admin-ts3/berita/jenis_berita/{par1}', 'App\Http\Controllers\AdminTs3\Berita@jenis_berita');
    Route::get('admin-ts3/berita/author/{par1}', 'App\Http\Controllers\AdminTs3\Berita@author');
    Route::get('admin-ts3/berita/tambah', 'App\Http\Controllers\AdminTs3\Berita@tambah');
    Route::get('admin-ts3/berita/edit/{par1}', 'App\Http\Controllers\AdminTs3\Berita@edit');
    Route::get('admin-ts3/berita/delete/{par1}/{par2}', 'App\Http\Controllers\AdminTs3\Berita@delete');
    Route::post('admin-ts3/berita/tambah_proses', 'App\Http\Controllers\AdminTs3\Berita@tambah_proses');
    Route::post('admin-ts3/berita/edit_proses', 'App\Http\Controllers\AdminTs3\Berita@edit_proses');
    Route::post('admin-ts3/berita/proses', 'App\Http\Controllers\AdminTs3\Berita@proses');
    Route::get('admin-ts3/berita/add', 'App\Http\Controllers\AdminTs3\Berita@add');



    Route::get('admin-ts3/staff', 'App\Http\Controllers\AdminTs3\Staff@index');
    Route::get('admin-ts3/staff/cari', 'App\Http\Controllers\AdminTs3\Staff@cari');
    Route::get('admin-ts3/staff/status_staff/{par1}', 'App\Http\Controllers\AdminTs3\Staff@status_staff');
    Route::get('admin-ts3/staff/kategori/{par1}', 'App\Http\Controllers\AdminTs3\Staff@kategori');
    Route::get('admin-ts3/staff/detail/{par1}', 'App\Http\Controllers\AdminTs3\Staff@detail');
    Route::get('admin-ts3/staff/tambah', 'App\Http\Controllers\AdminTs3\Staff@tambah');
    Route::get('admin-ts3/staff/edit/{par1}', 'App\Http\Controllers\AdminTs3\Staff@edit');
    Route::get('admin-ts3/staff/delete/{par1}', 'App\Http\Controllers\AdminTs3\Staff@delete');
    Route::post('admin-ts3/staff/tambah_proses', 'App\Http\Controllers\AdminTs3\Staff@tambah_proses');
    Route::post('admin-ts3/staff/edit_proses', 'App\Http\Controllers\AdminTs3\Staff@edit_proses');
    Route::post('admin-ts3/staff/proses', 'App\Http\Controllers\AdminTs3\Staff@proses');



    Route::get('admin-ts3/kategori_staff', 'App\Http\Controllers\AdminTs3\Kategori_staff@index');
    Route::post('admin-ts3/kategori_staff/tambah', 'App\Http\Controllers\AdminTs3\Kategori_staff@tambah');
    Route::post('admin-ts3/kategori_staff/edit', 'App\Http\Controllers\AdminTs3\Kategori_staff@edit');
    Route::get('admin-ts3/kategori_staff/delete/{par1}', 'App\Http\Controllers\AdminTs3\Kategori_staff@delete');

    Route::get('admin-ts3/regional', 'App\Http\Controllers\AdminTs3\Regional@index');
    Route::post('admin-ts3/regional/tambah', 'App\Http\Controllers\AdminTs3\Regional@tambah');
    Route::post('admin-ts3/regional/proses', 'App\Http\Controllers\AdminTs3\Regional@proses');
    Route::get('admin-ts3/regional/edit/{par1}', 'App\Http\Controllers\AdminTs3\Regional@edit');
    Route::post('admin-ts3/regional/proses_edit', 'App\Http\Controllers\AdminTs3\Regional@proses_edit');
    Route::get('admin-ts3/regional/delete/{par1}', 'App\Http\Controllers\AdminTs3\Regional@delete');


    Route::get('admin-ts3/bengkel', 'App\Http\Controllers\AdminTs3\Bengkel@index');
    Route::post('admin-ts3/bengkel/tambah', 'App\Http\Controllers\AdminTs3\Bengkel@tambah');
    Route::post('admin-ts3/bengkel/proses', 'App\Http\Controllers\AdminTs3\Bengkel@proses');
    Route::get('admin-ts3/bengkel/edit/{par1}', 'App\Http\Controllers\AdminTs3\Bengkel@edit');
    Route::post('admin-ts3/bengkel/proses_edit', 'App\Http\Controllers\AdminTs3\Bengkel@proses_edit');
    Route::get('admin-ts3/bengkel/delete/{par1}', 'App\Http\Controllers\AdminTs3\Bengkel@delete');


    Route::get('admin-ts3/area', 'App\Http\Controllers\AdminTs3\Area@index');
    Route::post('admin-ts3/area/tambah', 'App\Http\Controllers\AdminTs3\Area@tambah');
    Route::post('admin-ts3/area/proses', 'App\Http\Controllers\AdminTs3\Area@proses');
    Route::get('admin-ts3/area/edit/{par1}', 'App\Http\Controllers\AdminTs3\Area@edit');
    Route::post('admin-ts3/area/proses_edit', 'App\Http\Controllers\AdminTs3\Area@proses_edit');
    Route::get('admin-ts3/area/delete/{par1}', 'App\Http\Controllers\AdminTs3\Area@delete');

    
    Route::get('admin-ts3/branch', 'App\Http\Controllers\AdminTs3\Branch@index');
    Route::post('admin-ts3/branch/tambah', 'App\Http\Controllers\AdminTs3\Branch@tambah');
    Route::post('admin-ts3/branch/proses', 'App\Http\Controllers\AdminTs3\Branch@proses');
    Route::get('admin-ts3/branch/edit/{par1}', 'App\Http\Controllers\AdminTs3\Branch@edit');
    Route::post('admin-ts3/branch/proses_edit', 'App\Http\Controllers\AdminTs3\Branch@proses_edit');
    Route::get('admin-ts3/branch/delete/{par1}', 'App\Http\Controllers\AdminTs3\Branch@delete');

    Route::get('admin-ts3/general', 'App\Http\Controllers\AdminTs3\General@index');
    Route::post('admin-ts3/general/tambah', 'App\Http\Controllers\AdminTs3\General@tambah');
    Route::post('admin-ts3/general/proses', 'App\Http\Controllers\AdminTs3\General@proses');
    Route::get('admin-ts3/general/edit/{par1}', 'App\Http\Controllers\AdminTs3\General@edit');
    Route::post('admin-ts3/general/proses_edit', 'App\Http\Controllers\AdminTs3\General@proses_edit');
    Route::get('admin-ts3/general/delete/{par1}', 'App\Http\Controllers\AdminTs3\General@delete');


    Route::get('admin-ts3/price-service', 'App\Http\Controllers\AdminTs3\PriceService@index');
    Route::post('admin-ts3/price-service/tambah', 'App\Http\Controllers\AdminTs3\PriceService@tambah');
    Route::post('admin-ts3/price-service/proses', 'App\Http\Controllers\AdminTs3\PriceService@proses');
    Route::get('admin-ts3/price-service/edit/{par1}', 'App\Http\Controllers\AdminTs3\PriceService@edit');
    Route::post('admin-ts3/price-service/proses_edit', 'App\Http\Controllers\AdminTs3\PriceService@proses_edit');
    Route::get('admin-ts3/price-service/delete/{par1}', 'App\Http\Controllers\AdminTs3\PriceService@delete');


    Route::get('admin-ts3/vehicle', 'App\Http\Controllers\AdminTs3\Vehicle@index');
    Route::post('admin-ts3/vehicle/tambah', 'App\Http\Controllers\AdminTs3\Vehicle@tambah');
    Route::post('admin-ts3/vehicle/proses', 'App\Http\Controllers\AdminTs3\Vehicle@proses');
    Route::get('admin-ts3/vehicle/edit/{par1}', 'App\Http\Controllers\AdminTs3\Vehicle@edit');
    Route::post('admin-ts3/vehicle/proses-edit', 'App\Http\Controllers\AdminTs3\Vehicle@proses_edit');
    Route::get('admin-ts3/vehicle/delete/{par1}', 'App\Http\Controllers\AdminTs3\Vehicle@delete');
    Route::get('admin-ts3/vehicle/detail/{par1}', 'App\Http\Controllers\AdminTs3\Vehicle@detail');
    
    Route::get('admin-ts3/vehicle-type', 'App\Http\Controllers\AdminTs3\Vehicle@index_vehicle_type');
    Route::post('admin-ts3/vehicle-type/tambah-vehicle-type', 'App\Http\Controllers\AdminTs3\Vehicle@tambah_vehicle_type');
    Route::post('admin-ts3/vehicle-type/proses-vehicle-type', 'App\Http\Controllers\AdminTs3\Vehicle@proses_vehicle_type');
    Route::get('admin-ts3/vehicle-type/edit-vehicle-type/{par1}', 'App\Http\Controllers\AdminTs3\Vehicle@edit_vehicle_type');
    Route::post('admin-ts3/vehicle-type/proses-edit-vehicle-type', 'App\Http\Controllers\AdminTs3\Vehicle@proses_edit_vehicle_type');
    Route::get('admin-ts3/vehicle-type/delete-vehicle-type/{par1}', 'App\Http\Controllers\AdminTs3\Vehicle@delete_vehicle_type');


    Route::get('admin-ts3/spare-part', 'App\Http\Controllers\AdminTs3\SparepartPekerjaan@index');
    Route::post('admin-ts3/spare-part/tambah', 'App\Http\Controllers\AdminTs3\SparepartPekerjaan@tambah');
    Route::post('admin-ts3/spare-part/proses', 'App\Http\Controllers\AdminTs3\SparepartPekerjaan@proses');
    Route::get('admin-ts3/spare-part/edit/{par1}', 'App\Http\Controllers\AdminTs3\SparepartPekerjaan@edit');
    Route::post('admin-ts3/spare-part/proses_edit', 'App\Http\Controllers\AdminTs3\SparepartPekerjaan@proses_edit');
    Route::get('admin-ts3/spare-part/delete/{par1}', 'App\Http\Controllers\AdminTs3\SparepartPekerjaan@delete');

    Route::get('admin-ts3/pekerjaan', 'App\Http\Controllers\AdminTs3\SparepartPekerjaan@index_pekerjaan');
    Route::post('admin-ts3/pekerjaan/tambah-pekerjaan', 'App\Http\Controllers\AdminTs3\SparepartPekerjaan@tambah_pekerjaan');
    Route::post('admin-ts3/pekerjaan/proses-pekerjaan', 'App\Http\Controllers\AdminTs3\SparepartPekerjaan@proses_pekerjaan');
    Route::get('admin-ts3/pekerjaan/edit-pekerjaan/{par1}', 'App\Http\Controllers\AdminTs3\SparepartPekerjaan@edit_pekerjaan');
    Route::post('admin-ts3/pekerjaan/proses-edit-pekerjaan', 'App\Http\Controllers\AdminTs3\SparepartPekerjaan@proses_edit_pekerjaan');
    Route::get('admin-ts3/pekerjaan/delete-pekerjaan/{par1}', 'App\Http\Controllers\AdminTs3\SparepartPekerjaan@delete_pekerjaan');


    Route::get('admin-ts3/spk-list', 'App\Http\Controllers\AdminTs3\Spk@spk_list');
    Route::get('admin-ts3/spk-status', 'App\Http\Controllers\AdminTs3\Spk@spk_status');
    Route::get('admin-ts3/invoice', 'App\Http\Controllers\AdminTs3\Invoice@index');
    Route::get('admin-ts3/direct-service', 'App\Http\Controllers\AdminTs3\Service@direct_service');


    Route::get('admin-ts3/report/history-service', 'App\Http\Controllers\AdminTs3\Report@history_service');
    Route::get('admin-ts3/report/summary-bengkel', 'App\Http\Controllers\AdminTs3\Report@summary_bengkel');
    Route::get('admin-ts3/report/rekap-invoice', 'App\Http\Controllers\AdminTs3\Report@rekap_invoice');
    Route::get('admin-ts3/report/due-date-service', 'App\Http\Controllers\AdminTs3\Report@due_date_service');
    Route::get('admin-ts3/report/ar', 'App\Http\Controllers\AdminTs3\Report@ar');
    Route::get('admin-ts3/report/laba-rugi', 'App\Http\Controllers\AdminTs3\Report@laba_rugi');
    Route::get('admin-ts3/report/export-laba-rugi', 'App\Http\Controllers\AdminTs3\Report@export_laba_rugi');
    Route::get('admin-ts3/report/export-ar', 'App\Http\Controllers\AdminTs3\Report@export_ar');
});

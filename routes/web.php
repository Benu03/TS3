<?php
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/testdb', function () {
//     try {
//         DB::connection('ts3')->getPdo();
//         echo "Connected successfully to: " . DB::connection('ts3')->getDatabaseName();
//     } catch (\Exception $e) {
//         die("Could not connect to the database. Please check your configuration. error:" . $e );
//     }
// });

/* FRONT END */
// Home
Route::get('/', 'App\Http\Controllers\ComPro\Home@index');
Route::get('home', 'App\Http\Controllers\ComPro\Home@index');
Route::get('kontak', 'App\Http\Controllers\ComPro\Home@kontak');
Route::get('pemesanan', 'App\Http\Controllers\ComPro\Home@pemesanan');
Route::get('konfirmasi', 'App\Http\Controllers\ComPro\Home@konfirmasi');
Route::get('pembayaran', 'App\Http\Controllers\ComPro\Home@pembayaran');
Route::post('proses_pemesanan', 'App\Http\Controllers\ComPro\Home@proses_pemesanan');
Route::get('berhasil/{par1}', 'App\Http\Controllers\ComPro\Home@berhasil');
Route::get('cetak/{par1}', 'App\Http\Controllers\ComPro\Home@cetak');
Route::get('ts3', 'App\Http\Controllers\ComPro\Home@ts3');

// Login
Route::get('login', 'App\Http\Controllers\ComPro\Login@index');
Route::post('login/check', 'App\Http\Controllers\ComPro\Login@check');
Route::get('login/lupa', 'App\Http\Controllers\ComPro\Login@lupa');
Route::get('login/logout', 'App\Http\Controllers\ComPro\Login@logout');

// Berita
Route::get('berita', 'App\Http\Controllers\ComPro\Berita@index');
Route::get('berita/read/{par1}', 'App\Http\Controllers\ComPro\Berita@read');
Route::get('berita/layanan/{par1}', 'App\Http\Controllers\ComPro\Berita@layanan');
Route::get('berita/terjadi/{par1}', 'App\Http\Controllers\ComPro\Berita@terjadi');
Route::get('berita/kategori/{par1}', 'App\Http\Controllers\ComPro\Berita@kategori');

// download
Route::get('download', 'App\Http\Controllers\ComPro\Download@index');
Route::get('download/unduh/{par1}', 'App\Http\Controllers\ComPro\Download@unduh');
Route::get('download/kategori/{par1}', 'App\Http\Controllers\ComPro\Download@kategori');
Route::get('dokumen', 'App\Http\Controllers\ComPro\Download@index');
Route::get('dokumen/unduh/{par1}', 'App\Http\Controllers\ComPro\Download@unduh');
Route::get('dokumen/detail/{par1}/{par2}', 'App\Http\Controllers\ComPro\Download@detail');
Route::get('download/detail/{par1}/{par2}', 'App\Http\Controllers\ComPro\Download@detail');

// galeri
Route::get('galeri', 'App\Http\Controllers\ComPro\Galeri@index');
Route::get('galeri/detail/{par1}', 'App\Http\Controllers\ComPro\Galeri@detail');

// video
Route::get('video', 'App\Http\Controllers\ComPro\Video@index');
Route::get('video/detail/{par1}', 'App\Http\Controllers\ComPro\Video@detail');
Route::get('webinar', 'App\Http\Controllers\ComPro\Video@index');
Route::get('webinar/detail/{par1}/{par2}', 'App\Http\Controllers\ComPro\Video@detail');


// dasbor
Route::get('admin-cms/dasbor', 'App\Http\Controllers\AdminCms\Dasbor@index');
Route::get('admin-cms/dasbor/konfigurasi', 'App\Http\Controllers\AdminCms\Dasbor@konfigurasi');

// pemesanan
Route::get('admin-cms/pemesanan', 'App\Http\Controllers\AdminCms\Pemesanan@index');
Route::get('admin-cms/pemesanan/tambah', 'App\Http\Controllers\AdminCms\Pemesanan@tambah');
Route::get('admin-cms/pemesanan/detail/{par1}', 'App\Http\Controllers\AdminCms\Pemesanan@detail');
Route::get('admin-cms/pemesanan/status_pemesanan/{par1}', 'App\Http\Controllers\AdminCms\Pemesanan@status_pemesanan');
Route::get('admin-cms/pemesanan/cetak/{par1}', 'App\Http\Controllers\AdminCms\Pemesanan@cetak');
Route::get('admin-cms/pemesanan/edit/{par1}', 'App\Http\Controllers\AdminCms\Pemesanan@edit');
Route::get('admin-cms/pemesanan/filter/{par1}/{par2}/{par3}', 'App\Http\Controllers\AdminCms\Pemesanan@filter');
Route::get('admin-cms/pemesanan/cari', 'App\Http\Controllers\AdminCms\Pemesanan@cari');
Route::post('admin-cms/pemesanan/proses', 'App\Http\Controllers\AdminCms\Pemesanan@proses');
Route::post('admin-cms/pemesanan/tambah_proses', 'App\Http\Controllers\AdminCms\Pemesanan@tambah_proses');
Route::post('admin-cms/pemesanan/edit_proses', 'App\Http\Controllers\AdminCms\Pemesanan@edit_proses');
// user
Route::get('admin-cms/user', 'App\Http\Controllers\AdminCms\User@index');
Route::post('admin-cms/user/tambah', 'App\Http\Controllers\AdminCms\User@tambah');
Route::get('admin-cms/user/edit/{par1}', 'App\Http\Controllers\AdminCms\User@edit');
Route::post('admin-cms/user/proses_edit', 'App\Http\Controllers\AdminCms\User@proses_edit');
Route::get('admin-cms/user/delete/{par1}', 'App\Http\Controllers\AdminCms\User@delete');
Route::post('admin-cms/user/proses', 'App\Http\Controllers\AdminCms\User@proses');
// konfigurasi
Route::get('admin-cms/konfigurasi', 'App\Http\Controllers\AdminCms\Konfigurasi@index');
Route::get('admin-cms/konfigurasi/logo', 'App\Http\Controllers\AdminCms\Konfigurasi@logo');
Route::get('admin-cms/konfigurasi/profil', 'App\Http\Controllers\AdminCms\Konfigurasi@profil');
Route::get('admin-cms/konfigurasi/icon', 'App\Http\Controllers\AdminCms\Konfigurasi@icon');
Route::get('admin-cms/konfigurasi/email', 'App\Http\Controllers\AdminCms\Konfigurasi@email');
Route::get('admin-cms/konfigurasi/gambar', 'App\Http\Controllers\AdminCms\Konfigurasi@gambar');
Route::get('admin-cms/konfigurasi/pembayaran', 'App\Http\Controllers\AdminCms\Konfigurasi@pembayaran');
Route::post('admin-cms/konfigurasi/proses', 'App\Http\Controllers\AdminCms\Konfigurasi@proses');
Route::post('admin-cms/konfigurasi/proses_logo', 'App\Http\Controllers\AdminCms\Konfigurasi@proses_logo');
Route::post('admin-cms/konfigurasi/proses_icon', 'App\Http\Controllers\AdminCms\Konfigurasi@proses_icon');
Route::post('admin-cms/konfigurasi/proses_email', 'App\Http\Controllers\AdminCms\Konfigurasi@proses_email');
Route::post('admin-cms/konfigurasi/proses_gambar', 'App\Http\Controllers\AdminCms\Konfigurasi@proses_gambar');
Route::post('admin-cms/konfigurasi/proses_pembayaran', 'App\Http\Controllers\AdminCms\Konfigurasi@proses_pembayaran');
Route::post('admin-cms/konfigurasi/proses_profil', 'App\Http\Controllers\AdminCms\Konfigurasi@proses_profil');

// berita
Route::get('admin-cms/berita', 'App\Http\Controllers\AdminCms\Berita@index');
Route::get('admin-cms/berita/cari', 'App\Http\Controllers\AdminCms\Berita@cari');
Route::get('admin-cms/berita/status_berita/{par1}', 'App\Http\Controllers\AdminCms\Berita@status_berita');
Route::get('admin-cms/berita/kategori/{par1}', 'App\Http\Controllers\AdminCms\Berita@kategori');
Route::get('admin-cms/berita/jenis_berita/{par1}', 'App\Http\Controllers\AdminCms\Berita@jenis_berita');
Route::get('admin-cms/berita/author/{par1}', 'App\Http\Controllers\AdminCms\Berita@author');
Route::get('admin-cms/berita/tambah', 'App\Http\Controllers\AdminCms\Berita@tambah');
Route::get('admin-cms/berita/edit/{par1}', 'App\Http\Controllers\AdminCms\Berita@edit');
Route::get('admin-cms/berita/delete/{par1}/{par2}', 'App\Http\Controllers\AdminCms\Berita@delete');
Route::post('admin-cms/berita/tambah_proses', 'App\Http\Controllers\AdminCms\Berita@tambah_proses');
Route::post('admin-cms/berita/edit_proses', 'App\Http\Controllers\AdminCms\Berita@edit_proses');
Route::post('admin-cms/berita/proses', 'App\Http\Controllers\AdminCms\Berita@proses');
Route::get('admin-cms/berita/add', 'App\Http\Controllers\AdminCms\Berita@add');
// agenda
Route::get('admin-cms/agenda', 'App\Http\Controllers\AdminCms\Agenda@index');
Route::get('admin-cms/agenda/cari', 'App\Http\Controllers\AdminCms\Agenda@cari');
Route::get('admin-cms/agenda/status_agenda/{par1}', 'App\Http\Controllers\AdminCms\Agenda@status_agenda');
Route::get('admin-cms/agenda/kategori/{par1}', 'App\Http\Controllers\AdminCms\Agenda@kategori');
Route::get('admin-cms/agenda/jenis_agenda/{par1}', 'App\Http\Controllers\AdminCms\Agenda@jenis_agenda');
Route::get('admin-cms/agenda/author/{par1}', 'App\Http\Controllers\AdminCms\Agenda@author');
Route::get('admin-cms/agenda/tambah', 'App\Http\Controllers\AdminCms\Agenda@tambah');
Route::get('admin-cms/agenda/edit/{par1}', 'App\Http\Controllers\AdminCms\Agenda@edit');
Route::get('admin-cms/agenda/delete/{par1}', 'App\Http\Controllers\AdminCms\Agenda@delete');
Route::post('admin-cms/agenda/tambah_proses', 'App\Http\Controllers\AdminCms\Agenda@tambah_proses');
Route::post('admin-cms/agenda/edit_proses', 'App\Http\Controllers\AdminCms\Agenda@edit_proses');
Route::post('admin-cms/agenda/proses', 'App\Http\Controllers\AdminCms\Agenda@proses');
Route::get('admin-cms/agenda/add', 'App\Http\Controllers\AdminCms\Agenda@add');
// rekening
Route::get('admin-cms/rekening', 'App\Http\Controllers\AdminCms\Rekening@index');
Route::get('admin-cms/rekening/edit/{par1}', 'App\Http\Controllers\AdminCms\Rekening@edit');
Route::post('admin-cms/rekening/tambah', 'App\Http\Controllers\AdminCms\Rekening@tambah');
Route::post('admin-cms/rekening/proses_edit', 'App\Http\Controllers\AdminCms\Rekening@proses_edit');
Route::get('admin-cms/rekening/delete/{par1}', 'App\Http\Controllers\AdminCms\Rekening@delete');
Route::post('admin-cms/rekening/proses', 'App\Http\Controllers\AdminCms\Rekening@proses');
// kategori
Route::get('admin-cms/kategori', 'App\Http\Controllers\AdminCms\Kategori@index');
Route::post('admin-cms/kategori/tambah', 'App\Http\Controllers\AdminCms\Kategori@tambah');
Route::post('admin-cms/kategori/edit', 'App\Http\Controllers\AdminCms\Kategori@edit');
Route::get('admin-cms/kategori/delete/{par1}', 'App\Http\Controllers\AdminCms\Kategori@delete');
// status
Route::get('admin-cms/status_site', 'App\Http\Controllers\AdminCms\Status_site@index');
Route::post('admin-cms/status_site/tambah', 'App\Http\Controllers\AdminCms\Status_site@tambah');
Route::post('admin-cms/status_site/edit', 'App\Http\Controllers\AdminCms\Status_site@edit');
Route::get('admin-cms/status_site/delete/{par1}', 'App\Http\Controllers\AdminCms\Status_site@delete');
// status
Route::get('admin-cms/heading', 'App\Http\Controllers\AdminCms\Heading@index');
Route::post('admin-cms/heading/tambah', 'App\Http\Controllers\AdminCms\Heading@tambah');
Route::post('admin-cms/heading/edit', 'App\Http\Controllers\AdminCms\Heading@edit');
Route::get('admin-cms/heading/delete/{par1}', 'App\Http\Controllers\AdminCms\Heading@delete');
// status
Route::get('admin-cms/status_proyek', 'App\Http\Controllers\AdminCms\Status_proyek@index');
Route::post('admin-cms/status_proyek/tambah', 'App\Http\Controllers\AdminCms\Status_proyek@tambah');
Route::post('admin-cms/status_proyek/edit', 'App\Http\Controllers\AdminCms\Status_proyek@edit');
Route::get('admin-cms/status_proyek/delete/{par1}', 'App\Http\Controllers\AdminCms\Status_proyek@delete');
// video
Route::get('admin-cms/video', 'App\Http\Controllers\AdminCms\Video@index');
Route::get('admin-cms/video/edit/{par1}', 'App\Http\Controllers\AdminCms\Video@edit');
Route::post('admin-cms/video/tambah', 'App\Http\Controllers\AdminCms\Video@tambah');
Route::post('admin-cms/video/proses_edit', 'App\Http\Controllers\AdminCms\Video@proses_edit');
Route::get('admin-cms/video/delete/{par1}', 'App\Http\Controllers\AdminCms\Video@delete');
Route::post('admin-cms/video/proses', 'App\Http\Controllers\AdminCms\Video@proses');
// kategori_proyek
Route::get('admin-cms/kategori_proyek', 'App\Http\Controllers\AdminCms\Kategori_proyek@index');
Route::post('admin-cms/kategori_proyek/tambah', 'App\Http\Controllers\AdminCms\Kategori_proyek@tambah');
Route::post('admin-cms/kategori_proyek/edit', 'App\Http\Controllers\AdminCms\Kategori_proyek@edit');
Route::get('admin-cms/kategori_proyek/delete/{par1}', 'App\Http\Controllers\AdminCms\Kategori_proyek@delete');
// kategori_download
Route::get('admin-cms/kategori_download', 'App\Http\Controllers\AdminCms\Kategori_download@index');
Route::post('admin-cms/kategori_download/tambah', 'App\Http\Controllers\AdminCms\Kategori_download@tambah');
Route::post('admin-cms/kategori_download/edit', 'App\Http\Controllers\AdminCms\Kategori_download@edit');
Route::get('admin-cms/kategori_download/delete/{par1}', 'App\Http\Controllers\AdminCms\Kategori_download@delete');
// kategori_galeri
Route::get('admin-cms/kategori_galeri', 'App\Http\Controllers\AdminCms\Kategori_galeri@index');
Route::post('admin-cms/kategori_galeri/tambah', 'App\Http\Controllers\AdminCms\Kategori_galeri@tambah');
Route::post('admin-cms/kategori_galeri/edit', 'App\Http\Controllers\AdminCms\Kategori_galeri@edit');
Route::get('admin-cms/kategori_galeri/delete/{par1}', 'App\Http\Controllers\AdminCms\Kategori_galeri@delete');
// kategori_staff
Route::get('admin-cms/kategori_staff', 'App\Http\Controllers\AdminCms\Kategori_staff@index');
Route::post('admin-cms/kategori_staff/tambah', 'App\Http\Controllers\AdminCms\Kategori_staff@tambah');
Route::post('admin-cms/kategori_staff/edit', 'App\Http\Controllers\AdminCms\Kategori_staff@edit');
Route::get('admin-cms/kategori_staff/delete/{par1}', 'App\Http\Controllers\AdminCms\Kategori_staff@delete');
// kategori_agenda
Route::get('admin-cms/kategori_agenda', 'App\Http\Controllers\AdminCms\Kategori_agenda@index');
Route::post('admin-cms/kategori_agenda/tambah', 'App\Http\Controllers\AdminCms\Kategori_agenda@tambah');
Route::post('admin-cms/kategori_agenda/edit', 'App\Http\Controllers\AdminCms\Kategori_agenda@edit');
Route::get('admin-cms/kategori_agenda/delete/{par1}', 'App\Http\Controllers\AdminCms\Kategori_agenda@delete');
// kategori_akreditasi
Route::get('admin-cms/kategori_akreditasi', 'App\Http\Controllers\AdminCms\Kategori_akreditasi@index');
Route::post('admin-cms/kategori_akreditasi/tambah', 'App\Http\Controllers\AdminCms\Kategori_akreditasi@tambah');
Route::post('admin-cms/kategori_akreditasi/edit', 'App\Http\Controllers\AdminCms\Kategori_akreditasi@edit');
Route::get('admin-cms/kategori_akreditasi/delete/{par1}', 'App\Http\Controllers\AdminCms\Kategori_akreditasi@delete');
// galeri
Route::get('admin-cms/galeri', 'App\Http\Controllers\AdminCms\Galeri@index');
Route::get('admin-cms/galeri/cari', 'App\Http\Controllers\AdminCms\Galeri@cari');
Route::get('admin-cms/galeri/status_galeri/{par1}', 'App\Http\Controllers\AdminCms\Galeri@status_galeri');
Route::get('admin-cms/galeri/kategori/{par1}', 'App\Http\Controllers\AdminCms\Galeri@kategori');
Route::get('admin-cms/galeri/tambah', 'App\Http\Controllers\AdminCms\Galeri@tambah');
Route::get('admin-cms/galeri/edit/{par1}', 'App\Http\Controllers\AdminCms\Galeri@edit');
Route::get('admin-cms/galeri/delete/{par1}', 'App\Http\Controllers\AdminCms\Galeri@delete');
Route::post('admin-cms/galeri/tambah_proses', 'App\Http\Controllers\AdminCms\Galeri@tambah_proses');
Route::post('admin-cms/galeri/edit_proses', 'App\Http\Controllers\AdminCms\Galeri@edit_proses');
Route::post('admin-cms/galeri/proses', 'App\Http\Controllers\AdminCms\Galeri@proses');
// staff
Route::get('admin-cms/staff', 'App\Http\Controllers\AdminCms\Staff@index');
Route::get('admin-cms/staff/cari', 'App\Http\Controllers\AdminCms\Staff@cari');
Route::get('admin-cms/staff/status_staff/{par1}', 'App\Http\Controllers\AdminCms\Staff@status_staff');
Route::get('admin-cms/staff/kategori/{par1}', 'App\Http\Controllers\AdminCms\Staff@kategori');
Route::get('admin-cms/staff/detail/{par1}', 'App\Http\Controllers\AdminCms\Staff@detail');
Route::get('admin-cms/staff/tambah', 'App\Http\Controllers\AdminCms\Staff@tambah');
Route::get('admin-cms/staff/edit/{par1}', 'App\Http\Controllers\AdminCms\Staff@edit');
Route::get('admin-cms/staff/delete/{par1}', 'App\Http\Controllers\AdminCms\Staff@delete');
Route::post('admin-cms/staff/tambah_proses', 'App\Http\Controllers\AdminCms\Staff@tambah_proses');
Route::post('admin-cms/staff/edit_proses', 'App\Http\Controllers\AdminCms\Staff@edit_proses');
Route::post('admin-cms/staff/proses', 'App\Http\Controllers\AdminCms\Staff@proses');
// site
Route::get('admin-cms/site', 'App\Http\Controllers\AdminCms\Site@index');
Route::get('admin-cms/site/cari', 'App\Http\Controllers\AdminCms\Site@cari');
Route::get('admin-cms/site/status_site/{par1}', 'App\Http\Controllers\AdminCms\Site@status_site');
Route::get('admin-cms/site/kategori/{par1}', 'App\Http\Controllers\AdminCms\Site@kategori');
Route::get('admin-cms/site/detail/{par1}', 'App\Http\Controllers\AdminCms\Site@detail');
Route::get('admin-cms/site/tambah', 'App\Http\Controllers\AdminCms\Site@tambah');
Route::get('admin-cms/site/edit/{par1}', 'App\Http\Controllers\AdminCms\Site@edit');
Route::get('admin-cms/site/status/{par1}', 'App\Http\Controllers\AdminCms\Site@status');
Route::get('admin-cms/site/delete/{par1}', 'App\Http\Controllers\AdminCms\Site@delete');
Route::post('admin-cms/site/tambah_proses', 'App\Http\Controllers\AdminCms\Site@tambah_proses');
Route::post('admin-cms/site/edit_proses', 'App\Http\Controllers\AdminCms\Site@edit_proses');
Route::post('admin-cms/site/proses', 'App\Http\Controllers\AdminCms\Site@proses');
// proyek
Route::get('admin-cms/proyek', 'App\Http\Controllers\AdminCms\Proyek@index');
Route::get('admin-cms/proyek/cari', 'App\Http\Controllers\AdminCms\Proyek@cari');
Route::get('admin-cms/proyek/status_proyek/{par1}', 'App\Http\Controllers\AdminCms\Proyek@status_proyek');
Route::get('admin-cms/proyek/kategori/{par1}', 'App\Http\Controllers\AdminCms\Proyek@kategori');
Route::get('admin-cms/proyek/detail/{par1}', 'App\Http\Controllers\AdminCms\Proyek@detail');
Route::get('admin-cms/proyek/tambah', 'App\Http\Controllers\AdminCms\Proyek@tambah');
Route::get('admin-cms/proyek/edit/{par1}', 'App\Http\Controllers\AdminCms\Proyek@edit');
Route::get('admin-cms/proyek/status/{par1}', 'App\Http\Controllers\AdminCms\Proyek@status');
Route::get('admin-cms/proyek/delete/{par1}', 'App\Http\Controllers\AdminCms\Proyek@delete');
Route::post('admin-cms/proyek/tambah_proses', 'App\Http\Controllers\AdminCms\Proyek@tambah_proses');
Route::post('admin-cms/proyek/edit_proses', 'App\Http\Controllers\AdminCms\Proyek@edit_proses');
Route::post('admin-cms/proyek/proses', 'App\Http\Controllers\AdminCms\Proyek@proses');
// akreditasi
Route::get('admin-cms/akreditasi', 'App\Http\Controllers\AdminCms\Akreditasi@index');
Route::get('admin-cms/akreditasi/cari', 'App\Http\Controllers\AdminCms\Akreditasi@cari');
Route::get('admin-cms/akreditasi/status_akreditasi/{par1}', 'App\Http\Controllers\AdminCms\Akreditasi@status_akreditasi');
Route::get('admin-cms/akreditasi/kategori/{par1}', 'App\Http\Controllers\AdminCms\Akreditasi@kategori');
Route::get('admin-cms/akreditasi/detail/{par1}', 'App\Http\Controllers\AdminCms\Akreditasi@detail');
Route::get('admin-cms/akreditasi/tambah', 'App\Http\Controllers\AdminCms\Akreditasi@tambah');
Route::get('admin-cms/akreditasi/edit/{par1}', 'App\Http\Controllers\AdminCms\Akreditasi@edit');
Route::get('admin-cms/akreditasi/delete/{par1}', 'App\Http\Controllers\AdminCms\Akreditasi@delete');
Route::post('admin-cms/akreditasi/tambah_proses', 'App\Http\Controllers\AdminCms\Akreditasi@tambah_proses');
Route::post('admin-cms/akreditasi/edit_proses', 'App\Http\Controllers\AdminCms\Akreditasi@edit_proses');
Route::post('admin-cms/akreditasi/proses', 'App\Http\Controllers\AdminCms\Akreditasi@proses');
// download
Route::get('admin-cms/download', 'App\Http\Controllers\AdminCms\Download@index');
Route::get('admin-cms/download/cari', 'App\Http\Controllers\AdminCms\Download@cari');
Route::get('admin-cms/download/status_download/{par1}', 'App\Http\Controllers\AdminCms\Download@status_download');
Route::get('admin-cms/download/kategori/{par1}', 'App\Http\Controllers\AdminCms\Download@kategori');
Route::get('admin-cms/download/tambah', 'App\Http\Controllers\AdminCms\Download@tambah');
Route::get('admin-cms/download/edit/{par1}', 'App\Http\Controllers\AdminCms\Download@edit');
Route::get('admin-cms/download/unduh/{par1}', 'App\Http\Controllers\AdminCms\Download@unduh');
Route::get('admin-cms/download/delete/{par1}', 'App\Http\Controllers\AdminCms\Download@delete');
Route::post('admin-cms/download/tambah_proses', 'App\Http\Controllers\AdminCms\Download@tambah_proses');
Route::post('admin-cms/download/edit_proses', 'App\Http\Controllers\AdminCms\Download@edit_proses');
Route::post('admin-cms/download/proses', 'App\Http\Controllers\AdminCms\Download@proses');

/* END BACK END*/

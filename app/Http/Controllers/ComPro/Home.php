<?php
namespace App\Http\Controllers\ComPro;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Rekening_model;
use App\Models\Berita_model;
use App\Models\Staff_model;
use App\Models\Download_model;
use PDF;
use App\Http\Controllers\Feature\EmailContoller;
use App\Jobs\SendEmailAutomatic;
use Log;

class Home extends Controller
{
    // Homepage
    public function index()
    {
        
    	$site_config   =  DB::connection('ts3')->table('cp.konfigurasi')->first();
        // $video          = DB::connection('ts3')->table('cp.video')->orderBy('id_video','DESC')->first();
    	$slider         = DB::connection('ts3')->table('cp.galeri')->where('jenis_galeri','Homepage')->limit(5)->orderBy('id_galeri', 'DESC')->get();
        $layanan        = DB::connection('ts3')->table('cp.berita')->where(array('jenis_berita'=>'Layanan','status_berita'=>'Publish'))->limit(3)->orderBy('urutan', 'ASC')->get();
        $news           = new Berita_model();
        $berita         = $news->home();



         
        $bengkels = DB::connection('ts3')
        ->table('cp.temp_bengkel')
        ->whereNotNull('LATITUDE')
        ->whereNotNull('LONGITUDE')
        ->get();
    
        foreach ($bengkels as $bengkel) {
            $provinsi = $bengkel->PROVINSI;
            $kota = $bengkel->KOTA;
            
         
            if (!isset($locations[$provinsi])) {
                $locations[$provinsi] = [];
            }
        
            // Tambahkan bengkel ke dalam daftar kota di provinsi
            $locations[$provinsi][] = [
                'name'    => $kota,
                'gmap'    => "{$bengkel->LATITUDE},{$bengkel->LONGITUDE}",
                'address' => $bengkel->ALAMAT,
            ];
            }
            $locations2 = DB::connection('ts3')
            ->table('cp.temp_bengkel')
            ->whereNotNull('LATITUDE')
            ->whereNotNull('LONGITUDE')
            ->get()
            ->map(function ($bengkel) {
                return [
                    'lat'     => (float) $bengkel->LATITUDE,
                    'lng'     => (float) $bengkel->LONGITUDE,
                    'title'   => $bengkel->KOTA,
                    'address' => $bengkel->ALAMAT,
                ];
            });

        $data = array(  'title'         => $site_config->namaweb,
                        'deskripsi'     => $site_config->namaweb.' - '.$site_config->tagline,
                        'keywords'      => $site_config->namaweb.' - '.$site_config->tagline,
                        'slider'        => $slider,
                        'site_config'   => $site_config,
                        // 'berita'        => $berita,
                        // 'beritas'       => $berita,
                        'layanan'       => $layanan,
                        // 'video'         => $video,
                        'locations'   => $locations,
                        'locations2'   => $locations2,
                        'content'       => 'home/index'
                    );
        return view('layout/wrapper',$data);
    }

    // Homepage
    public function ts3()
    {
        $site_config   = DB::connection('ts3')->table('cp.konfigurasi')->first();
        $news   = new Berita_model();
        $berita = $news->home();
           // Staff
        $kategori_staff  = DB::connection('ts3')->table('cp.kategori_staff')->orderBy('urutan','ASC')->get();
        $layanan = DB::connection('ts3')->table('cp.berita')->where(array('jenis_berita' => 'Layanan','status_berita' => 'Publish'))->orderBy('urutan', 'ASC')->get();


        $data = array(  'title'     => 'Tentang '.$site_config->namaweb,
                        'deskripsi' => 'Tentang '.$site_config->namaweb,
                        'keywords'  => 'Tentang '.$site_config->namaweb,
                        'site_config'      => $site_config,
                        'berita'    => $berita,
                        'layanan'   => $layanan,
                        'kategori_staff'     => $kategori_staff,
                        'content'   => 'home/about'
                    );
        return view('layout/wrapper',$data);
    }

    // kontak
    public function kontak()
    {
        $site_config   = DB::connection('ts3')->table('cp.konfigurasi')->first();

        $data = array(  'title'     => 'Menghubungi '.$site_config->namaweb,
                        'deskripsi' => 'Kontak '.$site_config->namaweb,
                        'keywords'  => 'Kontak '.$site_config->namaweb,
                        'site_config'      => $site_config,
                        'content'   => 'home/kontak'
                    );
        return view('layout/wrapper',$data);
    }

    public function kirim_kontak(Request $request)
    {
      
        if (!isset($request->fullname) || !isset($request->email) || !isset($request->contact) || !isset($request->subject) || !isset($request->pesan)) {
            return redirect('kontak')->with(['warning' => 'Form Anda tidak boleh kosong']);
        }
        
        
        try {
            DB::connection('ts3')->beginTransaction();
            
            DB::connection('ts3')->table('cp.kontak')->insert([
                'fullname'    => $request->fullname,
                'email'       => $request->email,
                'phone'       => $request->contact,
                'subject'     => $request->subject,
                'message'     => $request->pesan,
                'is_reply'    => false,
                'created_by'  => $request->email
            ]);
        
            DB::connection('ts3')->commit();
            
            return redirect('kontak')->with(['sukses' => 'Pesan Anda Telah Terkirim Ke Admin TS3..!!']);
         } catch (\Illuminate\Database\QueryException $e) {
            DB::connection('ts3')->rollback();
            Log::channel('slack')->critical("Critical error occurred while inserting contact: " . $e->getMessage());
            
            return redirect('kontak')->with(['warning' => 'Terjadi kesalahan saat menyimpan data. Mohon coba lagi nanti.']);
        }
    }


    public function academy()
    {
        $site_config   = DB::connection('ts3')->table('cp.konfigurasi')->first();
    
        $bg   = DB::connection('ts3')->table('cp.heading')->where('halaman','Kontak')->orderBy('id_heading','DESC')->first();

        $galeri = DB::connection('ts3')->table('cp.galeri')->where('id_galeri',4)->first();



        $data = array(  'title'     => 'TS3 Academy ',
                        'deskripsi' => 'TS3 Academy ',
                        'keywords'  => 'TS3 Academy ',
                        'bg'  => $bg,
                        'galeri'  => $galeri,
                        'site_config'      => $site_config,
                        'content'   => 'home/academy'
                    );
        return view('layout/wrapper',$data);
    }

    public function jaringan()
    {
        $site_config   = DB::connection('ts3')->table('cp.konfigurasi')->first();
        $bg   = DB::connection('ts3')->table('cp.heading')->where('halaman','Jaringan')->orderBy('id_heading','DESC')->first();
   
        $bengkels = DB::connection('ts3')
        ->table('cp.temp_bengkel')
        ->whereNotNull('LATITUDE')
        ->whereNotNull('LONGITUDE')
        ->get();
    
        foreach ($bengkels as $bengkel) {
            $provinsi = $bengkel->PROVINSI;
            $kota = $bengkel->KOTA;
            
         
            if (!isset($locations[$provinsi])) {
                $locations[$provinsi] = [];
            }
        
            // Tambahkan bengkel ke dalam daftar kota di provinsi
            $locations[$provinsi][] = [
                'name'    => $kota,
                'gmap'    => "{$bengkel->LATITUDE},{$bengkel->LONGITUDE}",
                'address' => $bengkel->ALAMAT,
            ];
            }
            $locations2 = DB::connection('ts3')
            ->table('cp.temp_bengkel')
            ->whereNotNull('LATITUDE')
            ->whereNotNull('LONGITUDE')
            ->get()
            ->map(function ($bengkel) {
                return [
                    'lat'     => (float) $bengkel->LATITUDE,
                    'lng'     => (float) $bengkel->LONGITUDE,
                    'title'   => $bengkel->KOTA,
                    'address' => $bengkel->ALAMAT,
                ];
            });

     

        $data = array(  'title'     => 'Jaringan Kami ',
                        'deskripsi' => 'Jaringan ',
                        'keywords'  => 'Jaringan ',
                        'bg'  => $bg,
                        'site_config'      => $site_config,
                        'locations'   => $locations,
                        'locations2'   => $locations2,
                        'content'   => 'home/jaringan'
                    );
    
        return view('layout/wrapper',$data);
    }
}

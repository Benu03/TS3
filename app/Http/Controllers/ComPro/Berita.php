<?php
namespace App\Http\Controllers\ComPro;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use App\Models\Berita_model;
Paginator::useBootstrap();

class Berita extends Controller
{
 
    // Beritapage
    public function index()
    {
        Paginator::useBootstrap();
    	$site 	= DB::connection('ts3')->table('cp.konfigurasi')->first();
    	$model 	= new Berita_model();
		$berita = $model->listing();

        $data = array(  'title'     => 'Berita dan Update',
                        'deskripsi' => 'Berita dan Update',
                        'keywords'  => 'Berita dan Update',
                        'site'		=> $site,
                        'berita'	=> $berita,
                        'beritas'    => $berita,
                        'content'   => 'berita/index'
                    );
        return view('layout/wrapper',$data);
    }

    // Beritapage
    public function kategori($slug_kategori)
    {
        Paginator::useBootstrap();
        $site       = DB::connection('ts3')->table('cp.konfigurasi')->first();
        $kategori   = DB::connection('ts3')->table('cp.kategori')->where('slug_kategori',$slug_kategori)->first();
         if(!$kategori)
        {
            return redirect('berita');
        }
        $id_kategori= $kategori->id_kategori;
        $model      = new Berita_model();
        $berita     = $model->kategori_depan($id_kategori);


        $data = array(  'title'     => $kategori->nama_kategori,
                        'deskripsi' => $kategori->nama_kategori,
                        'keywords'  => $kategori->nama_kategori,
                        'site'      => $site,
                        'berita'    => $berita,
                        'beritas'    => $berita,
                        'content'   => 'berita/index'
                    );
        return view('layout/wrapper',$data);
    }

    // kontak
    public function layanan($slug_berita)
    {
        Paginator::useBootstrap();
        $site   = DB::connection('ts3')->table('cp.konfigurasi')->first();
        $model  = new Berita_model();
        $berita = $model->read($slug_berita);
        $layanan = DB::connection('ts3')->table('cp.berita')->where(array('jenis_berita' => 'Layanan','status_berita' => 'Publish'))->orderBy('urutan', 'ASC')->get();

    
        $bg   = DB::connection('ts3')->table('cp.heading')->where('halaman','Layanan')->orderBy('id_heading','DESC')->first();
               
       
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
        if(!$berita)
        {
            return redirect('berita');
        }

        $data = array(  'title'     => $berita->judul_berita,
                        'deskripsi' => $berita->judul_berita,
                        'keywords'  => $berita->judul_berita,
                        'site'      => $site,
                        'berita'    => $berita,
                        'layanan'   => $layanan,
                        'bg'   => $bg,
                        'locations'   => $locations,
                        'locations2'   => $locations2,
                        'content'   => 'berita/layanan'
                    );
        return view('layout/wrapper',$data);
    }

    // kontak
    public function terjadi($slug_berita)
    {
        Paginator::useBootstrap();
        $site   = DB::connection('ts3')->table('cp.konfigurasi')->first();
        $model  = new Berita_model();
        $berita = $model->read($slug_berita);
        $layanan = DB::connection('ts3')->table('cp.berita')->where(array('jenis_berita' => 'Layanan','status_berita' => 'Publish'))->orderBy('urutan', 'ASC')->get();
        if(!$berita)
        {
            return redirect('berita');
        }

        $data = array(  'title'     => $berita->judul_berita,
                        'deskripsi' => $berita->judul_berita,
                        'keywords'  => $berita->judul_berita,
                        'site'      => $site,
                        'berita'    => $berita,
                        'layanan'   => $layanan,
                        'content'   => 'berita/terjadi'
                    );
        return view('layout/wrapper',$data);
    }

    // kontak
    public function read($slug_berita)
    {
        Paginator::useBootstrap();
        $site   = DB::connection('ts3')->table('cp.konfigurasi')->first();
        $slider = DB::connection('ts3')->table('cp.galeri')->where('jenis_galeri','Beritapage')->orderBy('id_galeri', 'DESC')->first();
        // $berita = DB::connection('ts3')->table('berita')->where('status_berita','Publish')->orderBy('id_berita', 'DESC')->get();
        $model  = new Berita_model();
        $read   = $model->read($slug_berita);
        

        if(!$read)
        {
            return redirect('berita');
        }

        $data = array(  'title'     => $read->judul_berita,
                        'deskripsi' => $read->judul_berita,
                        'keywords'  => $read->judul_berita,
                        'slider'    => $slider,
                        'site'      => $site,
                        'read'      => $read,
                        'content'   => 'berita/read'
                    );
        return view('layout/wrapper',$data);
    }

    public function sop_layanan($sop_layanan)
    {

        $file = storage_path('data/template/').$sop_layanan.'.pdf';       
        if(file_exists($file)) 
        {            
        $headers = ['Content-Type' => 'application/pdf'];            
        return response()->download($file, 'Test File', $headers, 'inline');
        } else {            
        abort(404, 'File not found!');        
        }    
    }
    
}
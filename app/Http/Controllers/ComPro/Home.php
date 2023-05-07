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

class Home extends Controller
{
    // Homepage
    public function index()
    {
        
    	$site_config   =  DB::connection('ts3')->table('cp.konfigurasi')->first();
        $video          = DB::connection('ts3')->table('cp.video')->orderBy('id_video','DESC')->first();
    	$slider         = DB::connection('ts3')->table('cp.galeri')->where('jenis_galeri','Homepage')->limit(5)->orderBy('id_galeri', 'DESC')->get();
        $layanan        = DB::connection('ts3')->table('cp.berita')->where(array('jenis_berita'=>'Layanan','status_berita'=>'Publish'))->limit(3)->orderBy('urutan', 'ASC')->get();
        $news           = new Berita_model();
        $berita         = $news->home();


        $data = array(  'title'         => $site_config->namaweb,
                        'deskripsi'     => $site_config->namaweb.' - '.$site_config->tagline,
                        'keywords'      => $site_config->namaweb.' - '.$site_config->tagline,
                        'slider'        => $slider,
                        'site_config'   => $site_config,
                        // 'berita'        => $berita,
                        // 'beritas'       => $berita,
                        'layanan'       => $layanan,
                        'video'         => $video,
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
      
        $site = DB::connection('ts3')->table('cp.konfigurasi')->first();
        $email = $site->smtp_user;

       $token = hash('sha256',random_bytes(64).$site->namaweb);
      
             DB::connection('ts3')->table('auth.user_token')->insert([
                'email'	=> $email,
                'token'   => $token,
                'created_date'    => date("Y-m-d h:i:sa")
            ]);
            $url_img = 'http://34.101.109.41:8080/assets/upload/image/2.png';
        

            $body = '<b>Dear Rekan TS3</b><br><br>Nama Lengkap : '.$request->fullname.'<br>Email : '.$request->email.'<br>Contact : '.$request->contact.'<br>Pesan : '.$request->pesan.'<br><br>Best Regards<br>TS3 Indonesia<br><img src="'.$url_img.'"   width="70" height="70"  class="img-fluid" ><hr><b>TS3 Indonesia<br>Jl. Imam Bonjol No 47-48, Ruko Metro Square Blok B8, Semarang Kel Pandansari, <br>Kec Semarang Tengah 50139</b>';
             
            DB::connection('ts3')->table('auth.user_mail')->insert([
                'type_request' => 'CONTACT US',
                'from' => $site->smtp_user,
                'to' => $email,
                'cc' => null,
                'bcc' => null,
                'subject' => 'CONTACT US - '.$request->subject,
                'body' => $body,
                'attachment' => null
            ]);

            return redirect('/')->with(['sukses' => 'Pesan Anda Telah Terkirim Ke Admin TS3..!!']);
    }


}

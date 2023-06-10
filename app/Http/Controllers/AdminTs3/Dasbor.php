<?php

namespace App\Http\Controllers\AdminTs3;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Konfigurasi_model;
use Image;
use PDF;

class Dasbor extends Controller
{


    // Index
    public function index()
    {
        if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }
    	$mysite = new Konfigurasi_model();
		$site 	= $mysite->listing();

        $berita = DB::connection('ts3')->table('cp.v_list_berita')->count();     
        $product = DB::connection('ts3')->table('mst.mst_product')->count();           
        $galeri = DB::connection('ts3')->table('cp.galeri')->count();     
        $staff = DB::connection('ts3')->table('cp.staff')->count(); 
       
        $rating = DB::connection('ts3')->table('mvm.v_rating_mvm')->get(); 

        $dataPoints = [];

        foreach ($rating as $rt) {
            
            $dataPoints[] = [
                "name" => $rt->rating,
                "y" => $rt->total
            ];
        }


		$data = array(  'title'     => $site->namaweb,
                        'content'   => 'admin-ts3/dasbor/index',
                        'berita'    => $berita,
                        'product'    => $product,
                        'galeri'    => $galeri,
                        'staff'    => $staff,
                        "dataPoints" => json_encode($dataPoints)
                    );
        return view('admin-ts3/layout/wrapper',$data);
    }


   
    


}

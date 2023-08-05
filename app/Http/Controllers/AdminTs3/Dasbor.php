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
        $motor = DB::connection('ts3')->table('mst.v_chart_vehicle_motor')->get(); 
        

        $dataPointsrating = [];
        $dataPointsmotor = [];

        foreach ($rating as $rt) {            
            $dataPointsrating[] = [
                "name" => $rt->rating,
                "y" => $rt->total
            ];
        }

        foreach ($motor as $mt) {            
            $dataPointsmotor[] = [
                "name" => $mt->client_name,
                "y" => $mt->total
            ];


        }

		$data = array(  'title'     => $site->namaweb,
                        'content'   => 'admin-ts3/dasbor/index',
                        'berita'    => $berita,
                        'product'    => $product,
                        'galeri'    => $galeri,
                        'staff'    => $staff,
                        "dataPointsrating" => json_encode($dataPointsrating),
                        "dataPointsmotor" => $dataPointsmotor
                    );
        return view('admin-ts3/layout/wrapper',$data);
    }


   
    


}

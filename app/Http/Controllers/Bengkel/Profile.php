<?php

namespace App\Http\Controllers\Bengkel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Konfigurasi_model;
use Image;
use PDF;

class Profile extends Controller
{



    public function index()
    {
        if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }
    	$mysite = new Konfigurasi_model();
		$site 	= $mysite->listing();

        
                    $vehicle 	= DB::connection('ts3')->table('mst.v_vehicle')->get();
                    $client 	= DB::connection('ts3')->table('mst.mst_client')->where('client_type','B2B')->get();
                    $vehicle_type 	= DB::connection('ts3')->table('mst.mst_vehicle_type')->get();
            
                    $data = array(  'title'     => 'Vehicle',
                                    'vehicle'      => $vehicle,
                                    'vehicle_type'      => $vehicle_type,
                                    'client'      => $client,
                                    'content'   => 'bengkel/dasbor/profile'
                                );            
        return view('bengkel/layout/wrapper',$data);
    }
}

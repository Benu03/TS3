<?php

namespace App\Http\Controllers\AdminTs3;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Konfigurasi_model;
use Image;
use PDF;
use DataTables;
use Log;

class OtherFeature extends Controller
{




    public function VehicleCheck()
    {
        if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }
    
		$data = array(   'title'     => 'Vehicle Check',
                      
                        'content'   => 'admin-ts3/other_feature/vehicle_check'
                    );
        return view('admin-ts3/layout/wrapper',$data);

    }

    public function GpsCheck()
    {
        if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }
    
		$data = array(   'title'     => 'GPS Check',
                      
                        'content'   => 'admin-ts3/other_feature/gps_check'
                    );
        return view('admin-ts3/layout/wrapper',$data);


    }
 
  

   
}

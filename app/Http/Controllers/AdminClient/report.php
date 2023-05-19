<?php

namespace App\Http\Controllers\AdminClient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Konfigurasi_model;
use Image;
use PDF;

class report extends Controller
{


    // Index
    public function spk_history()
    {
        if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }
    
        $spk_history = DB::connection('ts3')->table('mst.v_regional')->get();

		$data = array(   'title'     => 'SPK History',
                         'spk_history'      => $spk_history,
                        'content'   => 'admin-client/report/spk_history'
                    );
        return view('admin-client/layout/wrapper',$data);
    }

    public function vehicle_service()
    {
        if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }
    
        $vehicle_service = DB::connection('ts3')->table('mst.v_regional')->get();

		$data = array(   'title'     => 'Vehicle Service',
                         'vehicle_service'      => $vehicle_service,
                        'content'   => 'admin-client/report/vehicle_service'
                    );
        return view('admin-client/layout/wrapper',$data);
    }

  

   
}

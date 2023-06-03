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

  

    public function history_service()
    {
        if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }
        

        $userclient = DB::connection('ts3')->table('mst.v_user_client')->where('username', Session()->get('username'))->first();

        $history = DB::connection('ts3')->table('mvm.v_service_history')->where('mst_client_id',$userclient->mst_client_id)->get();
        // $history = DB::connection('ts3')->table('mvm.v_service_history')->get();

		$data = array(   'title'     => 'History Service',
                         'history'      => $history,
                        'content'   => 'admin-client/report/history_service'
                    );
        return view('admin-client/layout/wrapper',$data);


    }


    public function get_image_service_detail($id)
    {
        if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }

        $image = DB::connection('ts3')->table('mvm.mvm_service_vehicle_d')->where('unique_data',$id)->first();

        $service = DB::connection('ts3')->table('mvm.mvm_service_vehicle_h')->where('id',$image->mvm_service_vehicle_h_id)->first();
        
        $storagePath =  storage_path('data/service/').$service->service_no.'/'. $image->unique_data;

        if(!file_exists($storagePath))
        return redirect('pic/list-service')->with(['warning' => 'Fila Tidak Di temukan']);
        
        else{
            return response()->file($storagePath);
        }

    }  

   
}

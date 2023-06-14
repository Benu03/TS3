<?php

namespace App\Http\Controllers\AdminClient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Konfigurasi_model;
use Image;
use PDF;
use DataTables;
use Log;

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

 

  

    public function history_service()
    {
        if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }
       


      

		$data = array(   'title'     => 'History Service',
                        //  'history'      => $history,
                        'content'   => 'admin-client/report/history_service'
                    );
        return view('admin-client/layout/wrapper',$data);


    }

    public function getHistoryService(Request $request)
    {
        if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
        if ($request->ajax()) {
            $user_client 	= DB::connection('ts3')->table('auth.v_user_client')->where('username',Session()->get('username'))->first();
        $service 	= DB::connection('ts3')->table('mvm.v_service_history')->where('mst_client_id',$user_client->mst_client_id)->get();
        return DataTables::of($service)->addColumn('action', function($row){
               $btn = '<a href="'. asset('admin-client/report/history-service-detail/'.$row->service_no).'" 
               class="btn btn-success btn-sm" target="_blank"><i class="fa fa-eye"></i></a>';
                return $btn;
                })
        ->rawColumns(['action'])->make(true);
       
        }

    }


    public function history_service_detail($id)
    {
        if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }
    

        $ar = DB::connection('ts3')->table('mvm.v_service_history')->where('service_no', $id)->first();

		$data = array(   'title'     => 'History Service '.$ar->service_no,
                         'ar'      => $ar,
                        'content'   => 'admin-client/report/service_detail_history'
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
        
        $storagePath =  $image->source.'/'.$image->unique_data;

        if(!file_exists($storagePath))
        return redirect('admin-client/list-service')->with(['warning' => 'Fila Tidak Di temukan']);
        
        else{
            return response()->file($storagePath);
        }

    }  


   
}

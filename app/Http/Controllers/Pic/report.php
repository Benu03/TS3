<?php

namespace App\Http\Controllers\Pic;

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
                        'content'   => 'pic/report/spk_history'
                    );
        return view('pic/layout/wrapper',$data);
    }

 

  

    public function history_service()
    {
        if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }
       


      

		$data = array(   'title'     => 'History Service',
                        //  'history'      => $history,
                        'content'   => 'pic/report/history_service'
                    );
        return view('pic/layout/wrapper',$data);


    }

    public function getHistoryService(Request $request)
    {
        if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
        if ($request->ajax()) {



            $user_client 	= DB::connection('ts3')->table('auth.v_user_client')->where('username',Session()->get('username'))->first();
            $branch_user    = DB::connection('ts3')->table('mst.v_branch_client')->selectRaw('branch')->where('pic_branch',Session()->get('username'))->get();

               foreach($branch_user  as $key => $val){
                $branch[] =  $val->branch;
                }


            if(empty($request->from_date) == true) {
       

                $service 	= DB::connection('ts3')->table('mvm.v_service_history')
                                    ->where('mst_client_id',$user_client->mst_client_id)
                                    ->whereIn('branch',$branch)->get();
             
        

            } else {
               

                $service 	= DB::connection('ts3')->table('mvm.v_service_history')
                                    ->where('mst_client_id',$user_client->mst_client_id)
                                    ->whereIn('branch',$branch)
                                    ->whereBetween('tanggal_service', array($request->from_date, $request->to_date))->get();

                

            }


       

        return DataTables::of($service)->addColumn('action', function($row){
               $btn = '<a href="'. asset('pic/report/history-service-detail/'.$row->service_no).'" 
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
                        'content'   => 'pic/report/service_detail_history'
                    );
        return view('pic/layout/wrapper',$data);
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

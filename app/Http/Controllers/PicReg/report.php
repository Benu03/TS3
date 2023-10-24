<?php

namespace App\Http\Controllers\PicReg;

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


  

    public function history_service()
    {
        if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }
       


      

		$data = array(   'title'     => 'History Service',
                        //  'history'      => $history,
                        'content'   => 'pic-regional/report/history_service'
                    );
        return view('pic-regional/layout/wrapper',$data);


    }

    public function getHistoryService(Request $request)
    {
        if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
        if ($request->ajax()) {
            $user_client 	= DB::connection('ts3')->table('auth.v_user_client')->where('username',Session()->get('username'))->first();
            if(!empty($request->from_date)) {

                $service 	= DB::connection('ts3')->table('mvm.v_service_history')->where('pic_regional',Session()->get('username'))
                ->whereBetween('tanggal_service', array($request->from_date, $request->to_date))->get();

            } else {
            $service 	= DB::connection('ts3')->table('mvm.v_service_history')->where('pic_regional',Session()->get('username'))->get();

            }

        return DataTables::of($service)->addColumn('action', function($row){
               $btn = '<a href="'. asset('pic-regional/report/history-service-detail/'.$row->service_no).'" 
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
                        'content'   => 'pic-regional/report/service_detail_history'
                    );
        return view('pic-regional/layout/wrapper',$data);
    }  

        
    public function exportHistoryService(Request $request)
    {

        if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
        if ($request->ajax()) 
        {
            $user_client 	= DB::connection('ts3')->table('auth.v_user_client')->where('username',Session()->get('username'))->first();
            if(!empty($request->from_date))
             {

                $service 	= DB::connection('ts3')->table('mvm.v_service_history')->selectRaw("spk_no,
                service_no, nopol, norangka, nomesin, tahun, 
                type as tipe,  status_service, tanggal_service, 
                nama_driver, last_km,bengkel_name  as bengkel, mekanik,
                tgl_last_service,regional,area, branch as cabang, pic_branch as pic_cabang, 
                tanggal_schedule,remark_ts3 as remark")->where('pic_regional',Session()->get('username'))
                ->whereBetween('tanggal_service', array($request->from_date, $request->to_date))->get();

            } else {
                $service 	= DB::connection('ts3')->table('mvm.v_service_history')->selectRaw("spk_no,
                service_no, nopol, norangka, nomesin, tahun, 
                type as tipe,  status_service, tanggal_service, 
                nama_driver, last_km,bengkel_name  as bengkel, mekanik,
                tgl_last_service,regional,area, branch as cabang, pic_branch as pic_cabang, 
                tanggal_schedule,remark_ts3 as remark")->where('pic_regional',Session()->get('username'))->get();

            }
        }
            return response()->json(['data' => $service]);
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
        return redirect('pic-regional/dasbor')->with(['warning' => 'File Tidak Di temukan']);
        
        else{
            return response()->file($storagePath);
        }

    }  


  


   
}

<?php

namespace App\Http\Controllers\AdminTs3;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Konfigurasi_model;
use Image;
use PDF;

class Report extends Controller
{




    public function history_service()
    {
        if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }
    

        $history = DB::connection('ts3')->table('mvm.v_service_history')->get();

		$data = array(   'title'     => 'History Service',
                         'history'      => $history,
                        'content'   => 'admin-ts3/report/history_service'
                    );
        return view('admin-ts3/layout/wrapper',$data);


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
        return redirect('pic/list-service')->with(['warning' => 'Fila Tidak Di temukan']);
        
        else{
            return response()->file($storagePath);
        }

    }  

    public function summary_bengkel()
    {
        if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }
    
        $nopol = DB::connection('ts3')->table('mst.v_vehicle')->get();

		$data = array(   'title'     => 'Summary Bengkel',
                         'nopol'      => $nopol,
                        'content'   => 'admin-ts3/report/summary_bengkel'
                    );
        return view('admin-ts3/layout/wrapper',$data);
    }

    public function rekap_invoice()
    {
        if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }
    
        $nopol = DB::connection('ts3')->table('mst.v_vehicle')->get();

		$data = array(   'title'     => 'Rekapitulasi Invoice',
                         'nopol'      => $nopol,
                        'content'   => 'admin-ts3/report/rekap_invoice'
                    );
        return view('admin-ts3/layout/wrapper',$data);
    }

    public function due_date_service()
    {
        if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }
    
        $nopol = DB::connection('ts3')->table('mst.v_vehicle')->get();

		$data = array(   'title'     => 'Due Date Service',
                         'nopol'      => $nopol,
                        'content'   => 'admin-ts3/report/due_date_service'
                    );
        return view('admin-ts3/layout/wrapper',$data);
    }

    public function ar()
    {
        if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }
    
        $nopol = DB::connection('ts3')->table('mst.v_vehicle')->get();

		$data = array(   'title'     => 'Report AR',
                         'nopol'      => $nopol,
                        'content'   => 'admin-ts3/report/ar'
                    );
        return view('admin-ts3/layout/wrapper',$data);
    }

    public function laba_rugi()
    {
        if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }
    
        $nopol = DB::connection('ts3')->table('mst.v_vehicle')->get();

		$data = array(   'title'     => 'Laba Rugi',
                         'nopol'      => $nopol,
                        'content'   => 'admin-ts3/report/laba_rugi'
                    );
        return view('admin-ts3/layout/wrapper',$data);
    }

   


  

   
}

<?php

namespace App\Http\Controllers\Bengkel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Konfigurasi_model;
use Image;
use PDF;

class Service extends Controller
{




    public function index()
    {
        if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }
    
        $bengkel 	= DB::connection('ts3')->table('mst.mst_bengkel')->where('pic_bengkel',Session()->get('username'))->first();

        $countservice = DB::connection('ts3')->table('mvm.v_spk_detail')->where('spk_status','ONPROGRESS')->wherein('status_service',['ONSCHEDULE'])
        ->where('mst_bengkel_id',$bengkel->id)->count();
        $service = DB::connection('ts3')->table('mvm.v_spk_detail')->where('spk_status','ONPROGRESS')
        ->wherein('status_service',['ONSCHEDULE'])->where('mst_bengkel_id',$bengkel->id)->orderByRaw('tanggal_schedule')->get();

		$data = array(   'title'     => 'List Service',
                         'countservice'      => $countservice,
                         'service'      => $service,
                        'content'   => 'bengkel/service/list_service'
                    );
        return view('bengkel/layout/wrapper',$data);
    }

   
    public function direct_service()
    {
        if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }
    
        $nopol = DB::connection('ts3')->table('mst.v_vehicle')->get();

		$data = array(   'title'     => 'Direct Service',
                         'nopol'      => $nopol,
                        'content'   => 'bengkel/service/direct_service'
                    );
        return view('bengkel/layout/wrapper',$data);
    }

    public function history_service()
    {
        if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }
    
        $nopol = DB::connection('ts3')->table('mst.v_vehicle')->get();

		$data = array(   'title'     => 'History Service',
                         'nopol'      => $nopol,
                        'content'   => 'bengkel/service/history_service'
                    );
        return view('bengkel/layout/wrapper',$data);
    }

    public function service_proses_page($id)
    {
        if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}

        $bengkel 	= DB::connection('ts3')->table('mst.mst_bengkel')->where('pic_bengkel',Session()->get('username'))->first();
        $service = DB::connection('ts3')->table('mvm.v_spk_detail')->where('spk_status','ONPROGRESS')->wherein('status_service',['ONSCHEDULE'])->where('mst_bengkel_id',$bengkel->id)->where('mst_bengkel_id',$bengkel->id)->where('id',$id)->first();
        $part 	= DB::connection('ts3')->table('mst.mst_spare_part')->get();
        $jobs 	= DB::connection('ts3')->table('mst.mst_pekerjaan')->get();

        $data = array(   'title'     => 'Service '.$service->nopol,
                         'service'      => $service,
                         'part'      => $part,
                         'jobs'      => $jobs,
                        'content'   => 'bengkel/service/service_proses_page'
                    );
        return view('bengkel/layout/wrapper',$data);
    }
    




  

   
}

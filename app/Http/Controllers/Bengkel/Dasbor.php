<?php

namespace App\Http\Controllers\Bengkel;

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

        $bengkel 	= DB::connection('ts3')->table('mst.mst_bengkel')->where('pic_bengkel',Session()->get('username'))->first();

        $countservice = DB::connection('ts3')->table('mvm.v_spk_detail')->where('spk_status','ONPROGRESS')->wherein('status_service',['ONSCHEDULE'])
        ->where('mst_bengkel_id',$bengkel->id)->count();  
        
        $direct = DB::connection('ts3')->table('mvm.v_spk_detail')->where('spk_status','ONPROGRESS')->wherein('status_service',['ONSCHEDULE'])
        ->where('mst_bengkel_id',$bengkel->id)->where('source','Direct')->count();  

        $invoice = DB::connection('ts3')->table('mvm.mvm_invoice_h')->where('create_by',Session()->get('username'))->whereIn('status',['PROSES','REQUEST'])->count();

       
		$data = array(  'title'     => $site->namaweb,
                        'content'   => 'bengkel/dasbor/index',
                        'service'   => $countservice,
                        'direct'   => $direct,
                        'invoice'   => $invoice
                    );
        return view('bengkel/layout/wrapper',$data);
    }
}

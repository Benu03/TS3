<?php

namespace App\Http\Controllers\Bengkel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Konfigurasi_model;
use Image;
use PDF;

class Invoice extends Controller
{




    public function index()
    {
        if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }
    
        
        $count_req = DB::connection('ts3')->table('mvm.mvm_invoice_h')->where('create_by',Session()->get('username'))->where('status','REQUEST')->count();
        $count_pro = DB::connection('ts3')->table('mvm.mvm_invoice_h')->where('create_by',Session()->get('username'))->where('status','PROSES')->count();
        $invoice = DB::connection('ts3')->table('mvm.mvm_invoice_h')->where('create_by',Session()->get('username'))->get();
		$data = array(   'title'        => 'Invoice',
                         'invoice'      => $invoice,
                         'count_req'    => $count_req,
                         'count_pro'    => $count_pro,
                        'content'       => 'bengkel/invoice/index'
                    );
        return view('bengkel/layout/wrapper',$data);
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
                        'content'   => 'bengkel/invoice/summary_bengkel'
                    );
        return view('bengkel/layout/wrapper',$data);
    }






   


  

   
}

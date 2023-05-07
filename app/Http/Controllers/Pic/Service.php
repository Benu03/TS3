<?php

namespace App\Http\Controllers\Pic;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Konfigurasi_model;
use Image;
use PDF;

class Service extends Controller
{


    // Index
    public function index()
    {
        if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }
    
        $invoice = DB::connection('ts3')->table('mst.v_regional')->get();

		$data = array(   'title'     => 'List Service',
                         'invoice'      => $invoice,
                        'content'   => 'pic/service/index'
                    );
        return view('pic/layout/wrapper',$data);
    }

    public function direct()
    {
        if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }
    
        $nopol = DB::connection('ts3')->table('mst.v_vehicle')->get();

		$data = array(   'title'     => 'Direct Service',
                         'nopol'      => $nopol,
                        'content'   => 'pic/service/direct'
                    );
        return view('pic/layout/wrapper',$data);
    }

    public function advisor()
    {
        if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }
    
        $invoice = DB::connection('ts3')->table('mst.v_regional')->get();

		$data = array(   'title'     => 'Advisor Service',
                         'invoice'      => $invoice,
                        'content'   => 'pic/service/advisor'
                    );
        return view('pic/layout/wrapper',$data);
    }


    public function history_service()
    {
        if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }
    
        $invoice = DB::connection('ts3')->table('mst.v_regional')->get();

		$data = array(   'title'     => 'History Service',
                         'invoice'      => $invoice,
                        'content'   => 'pic/service/history'
                    );
        return view('pic/layout/wrapper',$data);
    }


  

   
}

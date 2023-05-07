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
    
        $nopol = DB::connection('ts3')->table('mst.v_vehicle')->get();

		$data = array(   'title'     => 'List Service',
                         'nopol'      => $nopol,
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




  

   
}

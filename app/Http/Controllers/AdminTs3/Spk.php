<?php

namespace App\Http\Controllers\AdminTs3;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Konfigurasi_model;
use Image;
use PDF;

class Spk extends Controller
{




    public function spk_list()
    {
        if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }
    
        $nopol = DB::connection('ts3')->table('mst.v_vehicle')->get();

		$data = array(   'title'     => 'SPK List',
                         'nopol'      => $nopol,
                        'content'   => 'admin-ts3/spk/spk_list'
                    );
        return view('admin-ts3/layout/wrapper',$data);
    }

    
    public function spk_status()
    {
        if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }
    
        $nopol = DB::connection('ts3')->table('mst.v_vehicle')->get();

		$data = array(   'title'     => 'SPK Status',
                         'nopol'      => $nopol,
                        'content'   => 'admin-ts3/spk/spk_status'
                    );
        return view('admin-ts3/layout/wrapper',$data);
    }

   


  

   
}

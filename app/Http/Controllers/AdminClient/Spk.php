<?php

namespace App\Http\Controllers\AdminClient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Konfigurasi_model;
use Image;
use PDF;

class Spk extends Controller
{


    // Index
    public function index()
    {
        if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }
    
        $spk = DB::connection('ts3')->table('mst.v_regional')->get();
		       
		$data = array(   'title'     => 'SPK Proses',
                         'spk'      => $spk,
                        'content'   => 'admin-client/spk/index'
                    );
        return view('admin-client/layout/wrapper',$data);
    }


    public function template_upload()
    {
        if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }
    
        $file_path = storage_path('data/template/SPK_LIST_TEMPLATE.xlsx');
        return response()->download($file_path);
    }


   
}

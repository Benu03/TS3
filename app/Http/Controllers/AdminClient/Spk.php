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


    public function spk_posting(Request $request)
    {

        if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
    	request()->validate([
                            'spk_no'     => 'required',
                            'count_vehicle' => 'required',
					        'tanggal_pengerjaan' => 'required',
                            'tanggal_last_spk' => 'required',
                            'spk_file'   => 'file|mimes:xlsx,xls|max:8024|required',
					        ]);

        $spk_file       = $request->file('spk_file');
        

    }
    

    public function review_spk()
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






   
}

<?php

namespace App\Http\Controllers\AdminClient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Konfigurasi_model;
use Image;
use Illuminate\Support\Facades\File;
use PDF;
use App\Imports\SPKTempImport;
use Maatwebsite\Excel\Facades\Excel;
use Log;



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


    public function spk_upload(Request $request)
    {

        if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
    	request()->validate([
                            'spk_no'     => 'required',
                            'count_vehicle' => 'required',
					        'tanggal_pengerjaan' => 'required',
                            'tanggal_last_spk' => 'required',
                            'spk_file'   => 'file|mimes:xlsx,xls|max:5120|required',
					        ]);

        $spk_file       = $request->file('spk_file');

        $nama_file = rand().'_'.$spk_file->getClientOriginalName();
 
        $DirFile ='data/spk/'.date("Y").'/'.date("m").'/';
        // $DirFile ='data/spk/';
        if (!file_exists(storage_path($DirFile))) {
          File::makeDirectory(storage_path($DirFile),0777,true);
          }
        
        File::put(storage_path($DirFile.$nama_file), $spk_file); 
        Log::info('done upload '.$nama_file);
        Excel::import(new SPKTempImport, $spk_file);

        // Excel::import(new AccountStatementsImport, $request->file('file')->store('temp'));
        // return back();


        $userclient = DB::connection('ts3')->table('mst.v_user_client')->where('username', Session()->get('username'))->first();

        DB::connection('ts3')->table('mvm.mvm_temp_spk')->where('user_upload',Session()->get('username'))->update([
            'mst_client_id'	        => $userclient->mst_client_id,
            'spk_no'	            => $request->spk_no,
            'count_vehicle'	        => $request->count_vehicle,
            'tanggal_pengerjaan'    => $request->tanggal_pengerjaan,
            'tanggal_last_spk'      => $request->tanggal_last_spk,
            'status'	            => 'Review',
            'upload_date'	         => date("Y-m-d h:i:sa")            
        ]);  

        return redirect('admin-client/spk-temp-detail/'.$request->spk_no)->with(['sukses' => 'File berhasil Di Upload,ohon Untuk Di Review']);  

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
    
    

    public function spk_temp_detail($spk_no)
    {
        if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }

        $spk = DB::connection('ts3')->table('mvm.v_temp_spk_h')->where('spk_no', $spk_no)->first();
        $spk_detail = DB::connection('ts3')->table('mvm.mvm_temp_spk')->where('spk_no', $spk_no)->get();
		       
		$data = array(   'title'     => 'SPK Review',
                         'spk'      => $spk,
                         'spk_detail'      => $spk_detail,
                        'content'   => 'admin-client/spk/spk_review'
                    );
        return view('admin-client/layout/wrapper',$data);
    }






   
}

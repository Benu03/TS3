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
        $countspk = DB::connection('ts3')->table('mvm.v_spk_detail')->where('spk_status','ONPROGRESS')->wherein('status_service',['PLANING', 'ONSCHEDULE'])->count();
        $spkservice = DB::connection('ts3')->table('mvm.v_spk_detail')->where('spk_status','ONPROGRESS')
        ->wherein('status_service',['PLANING', 'ONSCHEDULE'])->orderByRaw('tanggal_schedule')->get();
        $bengkel 	= DB::connection('ts3')->table('mst.v_bengkel')->get();
		$data = array(   'title'     => 'SPK List Service',
                         'countspk'      => $countspk,
                         'spkservice'      => $spkservice,
                         'bengkel'  => $bengkel,
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
    
        $waiting = DB::connection('ts3')->table('mvm.mvm_spk_h')->where('status','WAITING')->count();
        $onprogress = DB::connection('ts3')->table('mvm.mvm_spk_h')->where('status','ONPROGRESS')->count();
        $spk = DB::connection('ts3')->table('mvm.mvm_spk_h')->get();

		$data = array(   'title'     => 'SPK Status',
                            'waiting'      => $waiting,
                            'onprogress'      => $onprogress,
                            'spk'      => $spk,
                        'content'   => 'admin-ts3/spk/spk_status'
                    );
        return view('admin-ts3/layout/wrapper',$data);
    }

   
    public function spk_file($file_name)
    {
        if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }
        $dir_file ='data/spk/';
        $file_path = storage_path('data/spk/'.$file_name);
        return response()->download($file_path);


    }


    public function spk_proses(Request $request)
    {
        if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }
         request()->validate([
            'tanggal_proses' => 'required',
            'mst_bengkel_id' => 'required',
            'remark' 	   => 'required',
            ]);


            DB::connection('ts3')->table('mvm.mvm_spk_h')->where('spk_seq',$request->spk_seq)->update([
                'remark'   => $request->remark,
                'status'   => 'ONPROGRESS',
                'user_proses'	    => $request->session()->get('username'),
                'proses_date'    => $request->tanggal_proses
        
            ]);   

        return redirect('admin-ts3/spk-status')->with(['sukses' => 'Data Berhasil Di Proses']);
    }

    

    public function spk_service_proses(Request $request)
    {
        if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }
  
        if($request->id == null)
        {
            return redirect('admin-ts3/spk-list')->with(['sukses' => 'Data Tidak Ada Yang Di pilih']);
        }


       
            $id       = $request->id;
       
            for($i=0; $i < sizeof($id);$i++) {
                      
      
               DB::connection('ts3')->table('mvm.mvm_spk_d')->where('id',$id[$i])->update([
                'remark_ts3'   => $request->remark,
                'tanggal_schedule'   => $request->tanggal_schedule,
                'mst_bengkel_id'   => $request->mst_bengkel_id,
                'status_service'   => 'ONSCHEDULE'             
                ]);   

                //insert ke table service bengkel

                
                // DB::connection('ts3')->table('mvm.mst_area')->insert([
                //     'mvm_spk_d_id'   => $id[$i],
                //     'mst_bengkel_id'	=>  $request->mst_bengkel_id,  
                //     'created_date'    => date("Y-m-d h:i:sa"),
                //     'create_by'         => $request->session()->get('username')
                // ]);


             
            }
        
            return redirect('admin-ts3/spk-list')->with(['sukses' => 'Data telah dihapus']);
       
        
    }


    public function spk_service_edit($id)
    {
        if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
           
        $spk 	= DB::connection('ts3')->table('mvm.v_spk_detail')->where('id',$id)->first();
        $bengkel 	= DB::connection('ts3')->table('mst.v_bengkel')->get();
       
        $data = array(  'title'         => 'Edit SPK Service',
                        'spk'           => $spk,
                        'bengkel'        => $bengkel,
                        'content'       => 'admin-ts3/spk/spk_service_edit'
                );
    
         return view('admin-ts3/layout/wrapper',$data);

    }

    public function spk_service_edit_proses(Request $request)
    {
        if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
        request()->validate([
            'tanggal_schedule' => 'required',
            'mst_bengkel_id' => 'required',
            'remark' 	   => 'required',
            ]);

         
            DB::connection('ts3')->table('mvm.mvm_spk_d')->where('id',$request->id)->update([
                'remark_ts3'   => $request->remark,
                'tanggal_schedule'   => $request->tanggal_schedule,
                'mst_bengkel_id'   => $request->mst_bengkel_id,
                'status_service'   => 'ONSCHEDULE'             
                ]);   


        return redirect('admin-ts3/spk-list')->with(['sukses' => 'Data telah diupdate']);             


    }

    
    
    

   
  

   
}

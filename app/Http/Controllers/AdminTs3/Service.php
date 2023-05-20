<?php

namespace App\Http\Controllers\AdminTs3;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Konfigurasi_model;
use Image;
use PDF;

class Service extends Controller
{




    public function direct_service()
    {
        if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }
    
        $countreq = DB::connection('ts3')->table('mvm.mvm_direct_service')->where('status','REQUEST')->count();
        $countestimate = DB::connection('ts3')->table('mvm.mvm_direct_service')->where('status','ESTIMATE')->count();
        $countproses = DB::connection('ts3')->table('mvm.mvm_direct_service')->where('status','PROSES')->count();
        $direct = DB::connection('ts3')->table('mvm.v_service_direct')->whereNotIn('status',['DONE'])->get();
        $bengkel 	= DB::connection('ts3')->table('mst.v_bengkel')->get();
		$data = array(   'title'     => 'Direct Service',
                         'countreq'      => $countreq,
                         'countestimate'      => $countestimate,
                         'countproses'      => $countproses,
                         'direct'      => $direct,
                         'bengkel'      => $bengkel,
                        'content'   => 'admin-ts3/service/direct'
                    );
        return view('admin-ts3/layout/wrapper',$data);
    }

   

    public function get_image_direct($id)
    {
        if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }
        $direct = DB::connection('ts3')->table('mvm.v_service_direct')->where('id',$id)->first();

       
        $storagePath =  storage_path('data/direct/'). $direct->foto_kendaraan;
        return response()->file($storagePath);

    }

    public function direct_service_proses(Request $request)
    {

        if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }
  
        if($request->id == null)
        {
            return redirect('admin-ts3/direct-service')->with(['warning' => 'Data Tidak Ada Yang Di pilih']);
        }

        $id       = $request->id;  
        for($i=0; $i < sizeof($id);$i++) {
           DB::connection('ts3')->table('mvm.mvm_direct_service')->where('id',$id[$i])->update([
            'remark_ts3'   => $request->remark_ts3,
            'mst_bengkel_id'   => $request->mst_bengkel_id,
            'status'   => 'ESTIMATE',
            'updated_at'    => date("Y-m-d h:i:sa"),
            'update_by'         => $request->session()->get('username')
            ]);    
        }
        return redirect('admin-ts3/direct-service')->with(['sukses' => 'Data telah Proses']);

    }
    

    public function direct_service_edit($id)
    {
        if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
      
        $direct = DB::connection('ts3')->table('mvm.v_service_direct')->where('id',$id)->first();
        $bengkel 	= DB::connection('ts3')->table('mst.v_bengkel')->get();
        
        $data = array(  'title'         => 'Edit Direct Service',
                        'direct'           => $direct,
                        'bengkel'        => $bengkel,
                        'content'       => 'admin-ts3/service/direct_service_edit'
                );
    
         return view('admin-ts3/layout/wrapper',$data);

    }


    
    public function direct_service_edit_proses(Request $request)
    {
        if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
        request()->validate([
            'mst_bengkel_id' => 'required',
            'remark_ts3' 	   => 'required',
            ]);

         
            DB::connection('ts3')->table('mvm.mvm_direct_service')->where('id',$request->id)->update([
                'remark_ts3'   => $request->remark_ts3,
                'mst_bengkel_id'   => $request->mst_bengkel_id,
                'status'   => 'ESTIMATE',
                'updated_at'    => date("Y-m-d h:i:sa"),
                'update_by'         => $request->session()->get('username')    
                ]);   


        return redirect('admin-ts3/direct-service')->with(['sukses' => 'Data telah diupdate']);             


    }



    

    
  

   
}

<?php

namespace App\Http\Controllers\AdminClient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Konfigurasi_model;
use Image;
use PDF;

class Approval extends Controller
{


    // Index
    public function index()
    {
        if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }
        $user_client 	= DB::connection('ts3')->table('auth.v_user_client')->where('username',Session()->get('username'))->first();
   

        $countapproval = DB::connection('ts3')->table('mvm.v_service_admin_client')->where('mst_client_id',$user_client->mst_client_id )->where('status_service','APPROVAL')->count();
        $approval = DB::connection('ts3')->table('mvm.v_service_admin_client')->where('mst_client_id',$user_client->mst_client_id )->where('status_service','APPROVAL')->get();

		$data = array(   'title'     => 'Approval',
                         'approval'      => $approval,
                         'countapproval'      => $countapproval,
                        'content'   => 'admin-client/approval/index'
                    );
        return view('admin-client/layout/wrapper',$data);
    }

    public function get_image_service_detail($id)
    {
        if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }

        $image = DB::connection('ts3')->table('mvm.mvm_service_vehicle_d')->where('unique_data',$id)->first();

        $service = DB::connection('ts3')->table('mvm.mvm_service_vehicle_h')->where('id',$image->mvm_service_vehicle_h_id)->first();
        
        $storagePath =  storage_path('data/service/').$service->service_no.'/'. $image->unique_data;

        if(!file_exists($storagePath))
        return redirect('admin-client/approval')->with(['warning' => 'Fila Tidak Di temukan']);
        
        else{
            return response()->file($storagePath);
        }

    }   

    public function service_approval_remark(Request $request)
    {

        if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }
  
        if($request->id == null)
        {
            return redirect('admin-client/approval')->with(['warning' => 'Data Tidak Ada Yang Di pilih']);
        }

        $id       = $request->id;   
       
        for($i=0; $i < sizeof($id);$i++) {

            if($id[$i] == null)
            {
                return redirect('admin-client/approval')->with(['warning' => 'Data Menunggu Proses Service Terlebih Dahulu']);
            }

            $id_spk_d =  DB::connection('ts3')->table('mvm.mvm_service_vehicle_h')->where('id',$id[$i])->first();

            DB::connection('ts3')->table('mvm.mvm_service_vehicle_h')->where('id',$id[$i])->update([
                'remark_admin_client'   => $request->remark,
                'admin_client_date_post'   => date("Y-m-d h:i:sa")          
                ]); 
                
            DB::connection('ts3')->table('mvm.mvm_spk_d')->where('id',$id_spk_d->mvm_spk_d_id)->update([
                    'status_service'   => 'ONINVOICE'             
                    ]);

                    $approval_no  = 'APV-'.date("Ymdhis");     
                 DB::connection('ts3')->table('mvm.mvm_approval')->insert([
                                'approval_no'   => $approval_no,
                                'user_approval'	=> Session()->get('username'),
                                'date_approval'    => date("Y-m-d h:i:sa"),
                                'type_approval'   => 'SERVICE',
                                'unique_approval'   => $id_spk_d->service_no,
                                'remark_approval'   => $request->remark
                            ]);        
   
        }

        return redirect('admin-client/approval')->with(['sukses' => 'Data telah Proses']);

    }
    

    public function service_approval($id)
    {
        if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }

        $service = DB::connection('ts3')->table('mvm.v_service_admin_client')->where('id',$id)->first();

        $sdetail  = DB::connection('ts3')->table('mvm.v_service_detail')->where('mvm_service_vehicle_h_id',$id)->get();

        $data = array(   'title'     => 'Service Approval',
            'service'      => $service,
            'sdetail' => $sdetail,
            'content'   => 'admin-client/approval/service_approval'
            );
            return view('admin-client/layout/wrapper',$data);


    }


    public function service_approval_proses(Request $request)
    {

        if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }

       
        $id       = $request->id;
        $id_spk_d =  DB::connection('ts3')->table('mvm.mvm_service_vehicle_h')->where('id',$id)->first();

        DB::connection('ts3')->table('mvm.mvm_service_vehicle_h')->where('id',$id)->update([
            'remark_admin_client'   => $request->remark,
                'admin_client_date_post'   => date("Y-m-d h:i:sa")           
            ]); 
            
        DB::connection('ts3')->table('mvm.mvm_spk_d')->where('id',$id_spk_d->mvm_spk_d_id)->update([
                'status_service'   => 'ONINVOICE'             
                ]);

         $approval_no  = 'APV-'.date("Ymdhis");     
        DB::connection('ts3')->table('mvm.mvm_approval')->insert([
                    'approval_no'   => $approval_no,
                    'user_approval'	=> Session()->get('username'),
                    'date_approval'    => date("Y-m-d h:i:sa"),
                    'type_approval'   => 'SERVICE',
                    'unique_approval'   => $id_spk_d->service_no,
                    'remark_approval'   => $request->remark
                ]);        

        return redirect('admin-client/approval')->with(['sukses' => 'Data telah Proses']);

    }
  

   
}

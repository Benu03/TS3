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
        
        $storagePath = $image->source.'/'.$image->unique_data;

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
                
                             
               //insert notif to bengkel.
               DB::connection('ts3')->table('ntf.ntf_notification')->insert([
                'title'   => $id_spk_d->service_no. ' Approved Admin Client',
                'detail'	=> 'Service '.$id_spk_d->service_no.' Approved',
                'created_date'    => date("Y-m-d h:i:sa"),
                'username'   => $id_spk_d->user_created,
                'ntf_category_id'   => 1
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

        $sdetail  = DB::connection('ts3')->table('mvm.v_service_detail_history')->where('id',$id)->get();
      

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
                
                DB::connection('ts3')->table('ntf.ntf_notification')->insert([
                    'title'   => $id_spk_d->service_no. ' Approved Admin Client',
                    'detail'	=> 'Service '.$id_spk_d->service_no.' Approved',
                    'created_date'    => date("Y-m-d h:i:sa"),
                    'username'   => $id_spk_d->user_created,
                    'ntf_category_id'   => 1
                ]);          


        return redirect('admin-client/approval')->with(['sukses' => 'Data telah Proses']);

    }
  

    public function direct()
    {
        if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }
        $user_client 	= DB::connection('ts3')->table('auth.v_user_client')->where('username',Session()->get('username'))->first();
        

        $countestimate = DB::connection('ts3')->table('mvm.mvm_direct_service')->where('status','ESTIMATE')->count();
        $direct = DB::connection('ts3')->table('mvm.v_service_direct')->where('status','ESTIMATE')->get();

		$data = array(   'title'     => 'Approval Direct Service',
                         'direct'      => $direct,
                         'countestimate'      => $countestimate,
                        'content'   => 'admin-client/approval/direct'
                    );
        return view('admin-client/layout/wrapper',$data);
    }

    public function get_image_direct($id)
    {
        if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }
        $direct = DB::connection('ts3')->table('mvm.v_service_direct')->where('id',$id)->first();

       
        $storagePath =  $direct->path_foto.$direct->foto_kendaraan;
        return response()->file($storagePath);

    }
    

    public function direct_service_approval($id)
    {

        if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
      
        $direct = DB::connection('ts3')->table('mvm.v_service_direct')->where('id',$id)->first();
    
       

        $priceJobs  = DB::connection('ts3')->table('mst.v_price_regional_client')
        ->select('kode', 'service_name','price_bengkel_to_ts3','price_ts3_to_client')
        ->where('mst_client_id',$direct->mst_client_id)
        ->where('mst_regional_id',$direct->mst_regional_id)
        ->where('price_service_type','Jasa')
        ->groupBy('kode', 'service_name','price_bengkel_to_ts3','price_ts3_to_client')
        ->get();
       

        $pricePart = DB::connection('ts3')->table('mst.v_price_regional_client')
        ->select('kode', 'service_name','price_bengkel_to_ts3','price_ts3_to_client')
        ->where('mst_client_id',$direct->mst_client_id)
        ->where('mst_regional_id',$direct->mst_regional_id)
        ->where('price_service_type','Part')
        ->groupBy('kode', 'service_name','price_bengkel_to_ts3','price_ts3_to_client')
        ->get();            

        $data = array(   'title'     => 'Direct Service Estimate '. $direct->nopol,
                         'direct'     => $direct,
                         'pricePart'      => $pricePart,
                         'priceJobs'      => $priceJobs,
                        'content'       => 'admin-client/approval/direct_service_approval'
                );
    
         return view('admin-client/layout/wrapper',$data);

    }

    public function direct_service_approval_proses(Request $request)
    {

        if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }


            DB::connection('ts3')->table('mvm.mvm_direct_service')->where('id',$request->id)->update([
            'spk_no' =>     $request->spk_no,
            'remark_admin_client'   => $request->remark,
            'status'   => 'PROSES',            
            'date_post_spk'    => date("Y-m-d h:i:sa"),
            'admin_client_post'       => $request->session()->get('username')    
            ]);   

            $userclient = DB::connection('ts3')->table('mst.v_user_client')->where('username', Session()->get('username'))->first();
                
            $spk_seq = $userclient->client_name.'-'.date("his");

            DB::connection('ts3')->table('mvm.mvm_spk_h')->insert([
                'spk_seq'   => $spk_seq,
                'spk_no'	=> $request->spk_no,
                'count_vehicle'	=> 1,
                'tanggal_pengerjaan'	=> $request->tanggal_pengerjaan,
                'tanggal_last_spk'	=> $request->tanggal_last_spk,
                'status'	=> 'WAITING',
                'user_posting'     => Session()->get('username'),
                'posting_date'    => date("Y-m-d h:i:sa")
                ]);


                DB::connection('ts3')->table('mvm.mvm_spk_d')->insert([
                    'spk_seq'   => $spk_seq,
                    'spk_no'	=> $request->spk_no,
                    'nopol'	    => $request->nopol,
                    'mst_branch_id'	=> $request->mst_branch_id,
                    'status_service'	=> 'PLANING',
                    'remark'        => $request->remark,
                    'created_date'     => date("Y-m-d h:i:sa"),
                    'create_by'     => Session()->get('username'),
                    'source'        => 'Direct'
                     ]);       
            $approval_no  = 'APV-'.date("Ymdhis");     
                     DB::connection('ts3')->table('mvm.mvm_approval')->insert([
                                 'approval_no'   => $approval_no,
                                 'user_approval'	=> Session()->get('username'),
                                 'date_approval'    => date("Y-m-d h:i:sa"),
                                 'type_approval'   => 'DIRECT SEVICE',
                                 'unique_approval'   => $request->spk_no,
                                 'remark_approval'   => $request->remark
                             ]);        


        return redirect('admin-client/approval/direct')->with(['sukses' => 'Data telah Proses']);
    }
    




   
}

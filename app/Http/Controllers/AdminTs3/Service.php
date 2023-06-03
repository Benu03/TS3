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
        $direct = DB::connection('ts3')->table('mvm.v_service_direct')->whereNotIn('status',['PROSES'])->get();
        $bengkel 	= DB::connection('ts3')->table('mst.v_bengkel')->get();
		$data = array(   'title'     => 'Direct Service',
                         'countreq'      => $countreq,
                         'countestimate'      => $countestimate,
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

       
        $storagePath =  $direct->path_foto.$direct->foto_kendaraan;
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
                        'content'       => 'admin-ts3/service/direct_service_edit'
                );
    
         return view('admin-ts3/layout/wrapper',$data);

    }

    
    public function direct_service_edit_proses(Request $request)
    {
        if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
        request()->validate([
            'remark' 	   => 'required',
            ]);
         
            DB::connection('ts3')->table('mvm.mvm_direct_service')->where('id',$request->id)->update([
                'remark_ts3'   => $request->remark,
                'status'   => 'ESTIMATE',
                'updated_at'    => date("Y-m-d h:i:sa"),
                'update_by'         => $request->session()->get('username')    
                ]);   

                foreach($request->jasa_id as $val){
                    $price = DB::connection('ts3')->table('mst.mst_price_service')->where('kode',$val)->first();
                    $datajobs = [
                        'mvm_direct_service_id' => $request->id,
                        'created_date'    => date("Y-m-d h:i:sa"),
                        'create_by'     => $request->session()->get('username'),
                        'mst_price_service_id' => $val,
                        'price_bengkel_to_ts3' => $price->price_bengkel_to_ts3,
                        'price_type' => $price->price_service_type,
                        'price_ts3_to_client' => $price->price_ts3_to_client,
                    ];
    
                    DB::connection('ts3')->table('mvm.mvm_direct_service_estimate')->insert($datajobs);
                }
    
                foreach($request->part_id as $val){
        
                   
                    $price = DB::connection('ts3')->table('mst.mst_price_service')->where('kode',$val)->first();
                    $datapart = [
                        'mvm_direct_service_id' => $request->id,
                        'created_date'    => date("Y-m-d h:i:sa"),
                        'create_by'     => $request->session()->get('username'),
                        'mst_price_service_id' => $val,
                        'price_bengkel_to_ts3' => $price->price_bengkel_to_ts3,
                        'price_type' => $price->price_service_type,
                        'price_ts3_to_client' => $price->price_ts3_to_client,
                    ];
    
                    DB::connection('ts3')->table('mvm.mvm_direct_service_estimate')->insert($datapart);
    
    
                }
         



        return redirect('admin-ts3/direct-service')->with(['sukses' => 'Data telah diupdate']);             


    }
   
   
    



    

    
  

   
}

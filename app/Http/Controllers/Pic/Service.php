<?php

namespace App\Http\Controllers\Pic;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Konfigurasi_model;
use Image;
use PDF;

class Service extends Controller
{


    // Index
    public function index()
    {
        if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }
        
        $user_branch = DB::connection('ts3')->table('mst.v_branch')->where('pic_branch',Session()->get('username'))->get();
        $branch_id = [];

        foreach($user_branch  as $key => $val){
            $branch_id[] = $val->id;
        }


        $countservice = DB::connection('ts3')->table('mvm.v_service_pic_branch')->wherein('mst_branch_id',$branch_id )->where('status_service','SERVICE')->count();
        $service = DB::connection('ts3')->table('mvm.v_service_pic_branch')->wherein('mst_branch_id',$branch_id )->get();

		$data = array(   'title'     => 'List Service',
                         'service'      => $service,
                         'countservice' => $countservice,
                        'content'   => 'pic/service/index'
                    );
        return view('pic/layout/wrapper',$data);
    }

    public function direct()
    {
        if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }
    
        $nopol = DB::connection('ts3')->table('mst.v_vehicle')->get();

		$data = array(   'title'     => 'Direct Service',
                         'nopol'      => $nopol,
                        'content'   => 'pic/service/direct'
                    );
        return view('pic/layout/wrapper',$data);
    }

    public function advisor()
    {
        if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }
    
        $invoice = DB::connection('ts3')->table('mst.v_regional')->get();

		$data = array(   'title'     => 'Advisor Service',
                         'invoice'      => $invoice,
                        'content'   => 'pic/service/advisor'
                    );
        return view('pic/layout/wrapper',$data);
    }


    public function history_service()
    {
        if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }
    
        $invoice = DB::connection('ts3')->table('mst.v_regional')->get();

		$data = array(   'title'     => 'History Service',
                         'invoice'      => $invoice,
                        'content'   => 'pic/service/history'
                    );
        return view('pic/layout/wrapper',$data);
    }

    public function service_remark(Request $request)
    {

        if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }
  
        if($request->id == null)
        {
            return redirect('pic/list-service')->with(['warning' => 'Data Tidak Ada Yang Di pilih']);
        }

        $id       = $request->id;


    
       
        for($i=0; $i < sizeof($id);$i++) {

            if($id[$i] == null)
            {
                return redirect('pic/list-service')->with(['warning' => 'Data Menunggu Proses Service Terlebih Dahulu']);
            }

            $id_spk_d =  DB::connection('ts3')->table('mvm.mvm_service_vehicle_h')->where('id',$id[$i])->first();


            DB::connection('ts3')->table('mvm.mvm_service_vehicle_h')->where('id',$id[$i])->update([
                'remark_pic_branch'   => $request->remark,
                'pic_branch_date_post'   => date("Y-m-d h:i:sa")          
                ]); 
                
            DB::connection('ts3')->table('mvm.mvm_spk_d')->where('id',$id_spk_d->mvm_spk_d_id)->update([
                    'status_service'   => 'ONINVOICE'             
                    ]);
   
        }

        return redirect('pic/list-service')->with(['sukses' => 'Data telah Proses']);

    }
    


  

   
}

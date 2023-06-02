<?php

namespace App\Http\Controllers\AdminClient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Konfigurasi_model;
use Image;
use PDF;

class Dasbor extends Controller
{


    // Index
    public function index()
    {
        if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }
    	$mysite = new Konfigurasi_model();
		$site 	= $mysite->listing();
        $user_client 	= DB::connection('ts3')->table('auth.v_user_client')->where('username',Session()->get('username'))->first();
        $approvalCount = DB::connection('ts3')->table('mvm.v_service_admin_client')->where('mst_client_id',$user_client->mst_client_id )->where('status_service','APPROVAL')->count();
        $countestimate = DB::connection('ts3')->table('mvm.mvm_direct_service')->where('status','ESTIMATE')->count();

        $product = DB::connection('ts3')->table('mst.mst_client_product')->where('mst_client_id',$user_client->mst_client_id)->count(); 

        $spk = DB::connection('ts3')->table('mvm.mvm_spk_h')->where('status','ONPROGRESS')->count();

        $vehiclecount =  DB::connection('ts3')->table('mst.v_vehicle_last_service')->where('mst_client_id',$user_client->mst_client_id)->count(); 
        
        
		$data = array(  'title'     => $site->namaweb,
                        'content'   => 'admin-client/dasbor/index',
                        'approval'  => $approvalCount + $countestimate,
                        'product'  => $product,
                        'spk'   => $spk ,
                        'vehiclecount'   => $vehiclecount 
                    );
        return view('admin-client/layout/wrapper',$data);
    }
}

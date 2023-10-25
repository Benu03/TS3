<?php

namespace App\Http\Controllers\PicReg;

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
        // $user_branch = DB::connection('ts3')->table('mst.v_regional')->where('pic_regional',Session()->get('username'))->get();
        // $branch_id = [];

        // foreach($user_branch  as $key => $val){
        //     $branch_id[] = $val->id;
        // }


        // $service = DB::connection('ts3')->table('mvm.v_service_pic_branch')->wherein('mst_branch_id',$branch_id )->where('status_service','SERVICE')->count();

        // $direct = DB::connection('ts3')->table('mvm.v_service_direct')->whereIn('mst_branch_id',$branch_id)->count();

        // $advisor = DB::connection('ts3')->table('mvm.v_service_pic_branch')->wherein('mst_branch_id',$branch_id )->where('status_service','SERVICE')->count();
        $vehiclecount =  DB::connection('ts3')->table('mst.v_vehicle_last_service')->where('mst_client_id',$user_client->mst_client_id)->count(); 
            
		$data = array(  'title'     => $site->namaweb,
                        'content'   => 'pic-regional/dasbor/index',
                        // 'service'    => $service,
                        // 'direct'    => $direct,
                        //  'advisor'  => $advisor,
                        'vehiclecount'   => $vehiclecount 
                    );
        return view('pic-regional/layout/wrapper',$data);
    }
}

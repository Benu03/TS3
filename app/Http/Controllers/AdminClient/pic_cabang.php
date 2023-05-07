<?php

namespace App\Http\Controllers\AdminClient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Konfigurasi_model;
use App\Models\User_model;
use Image;
use PDF;

class pic_cabang extends Controller
{


    // Index
    public function index()
    {
        if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }
    
        $UserModel = new User_model();
		$pic_cabang 	= $UserModel->pic_cabang(Session()->get('username'));
         		       
		$data = array( 'title'     => 'PIC Cabang',
                         'pic_cabang'      => $pic_cabang,
                         'count_pic'      => count($pic_cabang),
                        'content'   => 'admin-client/pic_cabang/index'
                    );
        return view('admin-client/layout/wrapper',$data);
    }


    public function detail($id)
    {
        if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
      
        $branch = DB::connection('ts3')->table('mst.v_branch')->where('id',$id)->first();

        $pic 	= DB::connection('ts3')->table('auth.users')->where('username',$branch->pic_branch)->first();

        $area = DB::connection('ts3')->table('mst.v_branch')->where('id',$id)->first();
        


        $data = array(  'title'             => $vehicle->nopol,
                        'vehicle'             => $vehicle,
                        'content'           => 'admin-client/vehicle/detail'
                    );
        return view('admin-client/layout/wrapper',$data);
    }



  

   
}

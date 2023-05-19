<?php

namespace App\Http\Controllers\AdminClient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Konfigurasi_model;
use Image;
use PDF;

class vehicle extends Controller
{


    // Index
    public function index()
    {
    	if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}

        $user_client 	= DB::connection('ts3')->table('mst.v_user_client')->where('username',Session()->get('username'))->first();       

        $vehicle 	= DB::connection('ts3')->table('mst.v_vehicle')->where('client_name',$user_client->client_name)->get();

        $count_vehicle 	= DB::connection('ts3')->table('mst.v_vehicle')->where('client_name',$user_client->client_name)->count();

        $count_type_vehicle 	= DB::connection('ts3')->table('mst.v_vehicle')->where('client_name',$user_client->client_name)
                            ->groupBy('type')->count();

		$data = array(  'title'     => 'Vehicle',
                        'vehicle'      => $vehicle,
                        'count_vehicle'      => $count_vehicle,
                        'count_type_vehicle'      => $count_type_vehicle,
                        'content'   => 'admin-client/vehicle/index'
                    );
        
        return view('admin-client/layout/wrapper',$data);
    }


    public function detail($id)
    {
        if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
      
        $vehicle 	= DB::connection('ts3')->table('mst.v_vehicle')->where('id',$id)->first();
        $data = array(  'title'             => $vehicle->nopol,
                        'vehicle'             => $vehicle,
                        'content'           => 'admin-client/vehicle/detail'
                    );
        return view('admin-client/layout/wrapper',$data);
    }


  

   
}

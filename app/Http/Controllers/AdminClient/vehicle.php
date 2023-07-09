<?php
namespace App\Http\Controllers\AdminClient;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Image;
use Excel;
use Log;
use App\Exports\AdminClient\Vehicle_schdule_export;
use App\Exports\AdminClient\VehicleExport;
use DataTables;

class Vehicle extends Controller
{
    // Index
    public function index()
    {
    	if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}

        $user_client 	= DB::connection('ts3')->table('auth.v_user_client')->where('username',Session()->get('username'))->first();

        // $vehicle 	= DB::connection('ts3')->table('mst.v_vehicle')->where('mst_client_id',$user_client->mst_client_id)->get();
        $client 	= DB::connection('ts3')->table('mst.mst_client')->where('id',$user_client->mst_client_id)->get();
        $vehicle_type 	= DB::connection('ts3')->table('mst.mst_vehicle_type')->where('id',$user_client->mst_client_id)->get();

		$data = array(  'title'     => 'Vehicle',
                        // 'vehicle'      => $vehicle,
                        'vehicle_type'      => $vehicle_type,
                        'client'      => $client,
                        'content'   => 'admin-client/vehicle/index'
                    );
        
        return view('admin-client/layout/wrapper',$data);
    }


    public function index_vehicle_type()
    {
    	if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}

      
     
        // $vehicle_type 	= DB::connection('ts3')->table('mst.mst_vehicle_type')->get();
        $group_vehicle 	= DB::connection('ts3')->table('mst.mst_general')->where('name','Group Vehicle')->where('value_1','Motor')->get();

		$data = array(  'title'     => 'Vehicle Type',
                        
                        // 'vehicle_type'      => $vehicle_type,
                        'group_vehicle'      => $group_vehicle,
                     
                        'content'   => 'admin-client/vehicle/index_vehicle_type'
                    );
        
        return view('admin-client/layout/wrapper',$data);
    }

    public function tambah(Request $request)
    {
    	if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
    	request()->validate(['nopol' => 'required|unique:ts3.mst.mst_vehicle',
					        'norangka' => 'required|unique:ts3.mst.mst_vehicle',
                            'nomesin' => 'required|unique:ts3.mst.mst_vehicle',
                            'mst_vehicle_type_id' => 'required',
					        ]);

        $userclient = DB::connection('ts3')->table('mst.v_user_client')->where('username', Session()->get('username'))->first();                   
                      
        DB::connection('ts3')->table('mst.mst_vehicle')->insert([
            'mst_client_id'	=> $userclient->mst_client_id,
            'nopol'   => strtoupper(str_replace(' ', '', $request->nopol)),
            'norangka'   => strtoupper(str_replace(' ', '', $request->norangka)),
            'nomesin'   => strtoupper(str_replace(' ', '', $request->nomesin)),
            'mst_vehicle_type_id'   => $request->mst_vehicle_type_id,
            'remark'   => $request->remark,
            'created_date'    => date("Y-m-d h:i:sa"),
            'create_by'     => $request->session()->get('username')
        ]);
        return redirect('admin-client/vehicle')->with(['sukses' => 'Data telah ditambah']);
    }

    public function tambah_vehicle_type(Request $request)
    {
    	if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
    	request()->validate(['group_vehicle' 	   => 'required',
					        'type' => 'required|unique:ts3.mst.mst_vehicle_type',
					        'tahun_pembuatan' 	   => 'required',
					        ]);

         $userclient = DB::connection('ts3')->table('mst.v_user_client')->where('username', Session()->get('username'))->first();            

        DB::connection('ts3')->table('mst.mst_vehicle_type')->insert([
            'group_vehicle'   => $request->group_vehicle,
            'type'   => $request->type,
            'tahun_pembuatan'	=> $request->tahun_pembuatan,
            'desc'	=> $request->desc,
            'mst_client_id'	=> $userclient->mst_client_id,
            'created_date'    => date("Y-m-d h:i:sa"),
            'create_by'     => $request->session()->get('username')
        ]);
        return redirect('admin-client/vehicle-type')->with(['sukses' => 'Data telah ditambah']);
    }

        // Index
    public function edit_vehicle_type($id)
    {
            if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
           
           
            $vehicle_type 	= DB::connection('ts3')->table('mst.mst_vehicle_type')->where('id',$id)->first();
            $group_vehicle 	= DB::connection('ts3')->table('mst.mst_general')->where('name','Group Vehicle')->where('value_1','Motor')->get();
		    $data = array(  'title'     => 'Edit Vehicle Type',						
                            'vehicle_type'      => $vehicle_type,
                            'group_vehicle'      => $group_vehicle,
                            'content'   => 'admin-client/vehicle/edit_vehicle_type'
                    );
        
             return view('admin-client/layout/wrapper',$data);
    }

    public function edit($id)
    {
            if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
           
            $client 	= DB::connection('ts3')->table('mst.mst_client')->where('client_type','B2B')->get();
            $vehicle 	= DB::connection('ts3')->table('mst.v_vehicle')->where('id',$id)->first();
            $vehicle_type 	= DB::connection('ts3')->table('mst.mst_vehicle_type')->get();
		    $data = array(  'title'     => 'Edit Vehicle',						
                        'vehicle'      => $vehicle,
                        'vehicle_type'      => $vehicle_type,
                        'client'      => $client,
                        'content'   => 'admin-client/vehicle/edit'
                    );
        
             return view('admin-client/layout/wrapper',$data);
    }
    
    public function proses_edit(Request $request)
    {
    	if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
    	request()->validate(['mst_client_id' 	   => 'required',
                            'nopol' => 'required',
                            'norangka' => 'required',
                            'nomesin' => 'required',
                            'mst_vehicle_type_id' => 'required',
					        ]);

                            DB::connection('ts3')->table('mst.mst_vehicle')->where('id',$request->id)->update([
                                'mst_client_id'	=> $request->mst_client_id,
                                'nopol'   => strtoupper(str_replace(' ', '', $request->nopol)),
                                'norangka'   => strtoupper(str_replace(' ', '', $request->norangka)),
                                'nomesin'   => strtoupper(str_replace(' ', '', $request->norangka)),
                                'mst_vehicle_type_id'   => $request->mst_vehicle_type_id,
                                'remark'   => $request->remark,
                                'updated_at'    => date("Y-m-d h:i:sa"),
                                'update_by'     => $request->session()->get('username')
                            ]);   
        return redirect('admin-client/vehicle')->with(['sukses' => 'Data telah diupdate']);                                             
    }

    public function proses_edit_vehicle_type(Request $request)
    {
    	if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
    	request()->validate([
                                'group_vehicle' 	   => 'required',
                                'type' => 'required',
                                'tahun_pembuatan' 	   => 'required',
					        ]);

                            DB::connection('ts3')->table('mst.mst_vehicle_type')->where('id',$request->id)->update([
                                'group_vehicle'   => $request->group_vehicle,
                                'type'   => $request->type,
                                'tahun_pembuatan'	=> $request->tahun_pembuatan,
                                'desc'	=> $request->desc,
                                'updated_at'    => date("Y-m-d h:i:sa"),
                                'update_by'     => $request->session()->get('username')
                            ]);   
        return redirect('admin-client/vehicle-type')->with(['sukses' => 'Data telah diupdate']);                                             
    }

    public function delete($id)
    {
    	if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
     
        DB::connection('ts3')->table('mst.mst_vehicle')->where('id',$id)->delete();
        return redirect('admin-client/vehicle')->with(['sukses' => 'Data telah dihapus']);
    }

    public function delete_vehicle_type($id)
    {
    	if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
     
        DB::connection('ts3')->table('mst.mst_vehicle_type')->where('id',$id)->delete();
        return redirect('admin-client/vehicle-type')->with(['sukses' => 'Data telah dihapus']);
    }
       
    public function proses(Request $request)
    {
        $site   =DB::connection('ts3')->table('cp.konfigurasi')->first();
        // PROSES HAPUS MULTIPLE

        if(isset($_POST['hapus'])) {
            $id       = $request->id;
     
            for($i=0; $i < sizeof($id);$i++) {
                      
               DB::connection('ts3')->table('mst.mst_vehicle')->where('id',$id[$i])->delete();
             
            }
        
            return redirect('admin-client/vehicle')->with(['sukses' => 'Data telah dihapus']);
        // PROSES SETTING DRAFT
        }
    }

    public function proses_vehicle_type(Request $request)
    {
        $site   =DB::connection('ts3')->table('cp.konfigurasi')->first();
        // PROSES HAPUS MULTIPLE

        if(isset($_POST['hapus'])) {
            $id       = $request->id;
     
            for($i=0; $i < sizeof($id);$i++) {
                      
               DB::connection('ts3')->table('mst.mst_vehicle_type')->where('id',$id[$i])->delete();
             
            }
        
            return redirect('admin-client/vehicle-type')->with(['sukses' => 'Data telah dihapus']);
        // PROSES SETTING DRAFT
        }
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

    public function vehicle_schedule_service()
    {
    	if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}

        $user_client 	= DB::connection('ts3')->table('auth.v_user_client')->where('username',Session()->get('username'))->first();


        $vehiclecount =  DB::connection('ts3')->table('mst.v_vehicle_last_service')->where('mst_client_id',$user_client->mst_client_id)->count(); 
        $vehicle =  DB::connection('ts3')->table('mst.v_vehicle_last_service')->where('mst_client_id',$user_client->mst_client_id)->get(); 

		$data = array(  'title'     => 'Vehicle Shedule Service',
                        'vehicle'      => $vehicle,
                        'vehiclecount'      => $vehiclecount,
                        'content'   => 'admin-client/vehicle/vehicle_schedule_service'
                    );
        
        return view('admin-client/layout/wrapper',$data);
    }

    public function vehicle_schedule_service_excel()
    {
        if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}

        
        $nama_file = 'vehicle_schdule_service_'.date('Y-m-d_H-i-s').'.xlsx';
        return Excel::download(new Vehicle_schdule_export, $nama_file);
    }

    public function getVehicle(Request $request)
    {
        if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}

        if ($request->ajax()) {
        

            $user_client 	= DB::connection('ts3')->table('auth.v_user_client')->where('username',Session()->get('username'))->first();
      
            $vehicle 	= DB::connection('ts3')->table('mst.v_vehicle')->where('mst_client_id',$user_client->mst_client_id)->get();
        
        return DataTables::of($vehicle)
                ->addColumn('action', function($row){
                    $btn = '<div class="btn-group">
                            <a href="'. asset('admin-client/vehicle/detail/'.$row->id).'" 
                                class="btn btn-success btn-sm"><i class="fa fa-eye"></i></a>
                            <a href="'. asset('admin-client/vehicle/edit/'.$row->id).'" 
                                class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>
                            <a href="'. asset('admin-client/vehicle/delete/'.$row->id).'" class="btn btn-danger btn-sm  delete-link">
                                    <i class="fa fa-trash"></i></a>
                            </div>';
                return $btn; })
                ->addColumn('check', function($row){
                    $check = ' <td class="text-center">
                                <div class="icheck-primary">
                                <input type="checkbox" class="icheckbox_flat-blue " name="id[]" value="'.$row->id.'" id="check'.$row->id.'">
                               <label for="check'.$row->id.'"></label>
                                </div>
                             </td>';
                    return $check; })
                ->rawColumns(['action','check'])
                ->make(true);
       
        }

    }

    public function getVehicletype(Request $request)
    {
        if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}

        if ($request->ajax()) {
        $user_client 	= DB::connection('ts3')->table('auth.v_user_client')->where('username',Session()->get('username'))->first();

        $vehicle_type 	= DB::connection('ts3')->table('mst.mst_vehicle_type')->where('mst_client_id',$user_client->mst_client_id)->get();
        
    
        return DataTables::of($vehicle_type)
                ->addColumn('action', function($row){
                    $btn = '<div class="btn-group">
                            <a href="'. asset('admin-client/vehicle-type/edit-vehicle-type/'.$row->id).'" 
                                class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>
                            <a href="'. asset('admin-client/vehicle-type/delete-vehicle-type/'.$row->id).'" class="btn btn-danger btn-sm  delete-link">
                                    <i class="fa fa-trash"></i></a>
                            </div>';
                return $btn; })
                ->addColumn('check', function($row){
                    $check = ' <td class="text-center">
                                <div class="icheck-primary">
                                <input type="checkbox" class="icheckbox_flat-blue " name="id[]" value="'.$row->id.'" id="check'.$row->id.'">
                               <label for="check'.$row->id.'"></label>
                                </div>
                             </td>';
                    return $check; })
                ->rawColumns(['action','check'])
                ->make(true);
       
        }

    }

    
    public function export()
    {
        if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}

        return Excel::download(new VehicleExport, 'VEHICLE-MVM.xlsx');
    }



}

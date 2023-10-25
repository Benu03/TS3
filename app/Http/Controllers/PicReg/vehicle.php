<?php
namespace App\Http\Controllers\PicReg;
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
 

    public function vehicle_schedule_service()
    {
    	if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}

        $user_client 	= DB::connection('ts3')->table('auth.v_user_client')->where('username',Session()->get('username'))->first();


        $vehiclecount =  DB::connection('ts3')->table('mst.v_vehicle_last_service')->where('mst_client_id',$user_client->mst_client_id)->count(); 
        $vehicle =  DB::connection('ts3')->table('mst.v_vehicle_last_service')->where('mst_client_id',$user_client->mst_client_id)->get(); 

		$data = array(  'title'     => 'Vehicle Shedule Service',
                        'vehicle'      => $vehicle,
                        'vehiclecount'      => $vehiclecount,
                        'content'   => 'pic-regional/vehicle/vehicle_schedule_service'
                    );
        
        return view('pic-regional/layout/wrapper',$data);
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
                            <a href="'. asset('pic-regional/vehicle/detail/'.$row->id).'" 
                                class="btn btn-success btn-sm"><i class="fa fa-eye"></i></a>
                            <a href="'. asset('pic-regional/vehicle/edit/'.$row->id).'" 
                                class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>
                            <a href="'. asset('pic-regional/vehicle/delete/'.$row->id).'" class="btn btn-danger btn-sm  delete-link">
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
                            <a href="'. asset('pic-regional/vehicle-type/edit-vehicle-type/'.$row->id).'" 
                                class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>
                            <a href="'. asset('pic-regional/vehicle-type/delete-vehicle-type/'.$row->id).'" class="btn btn-danger btn-sm  delete-link">
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

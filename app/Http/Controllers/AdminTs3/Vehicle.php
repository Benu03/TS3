<?php
namespace App\Http\Controllers\AdminTs3;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Image;
use Illuminate\Support\Facades\File;
use DataTables;
use Log;
use App\Exports\AdminTs3\VehicleExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\VehicleTempImport;
use Storage;
use App\Models\Vehicle_model;


class Vehicle extends Controller
{
    // Index
    public function index()
    {
    	if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}

      
        // $vehicle 	= DB::connection('ts3')->table('mst.v_vehicle')->get();
        $client 	= DB::connection('ts3')->table('mst.mst_client')->where('client_type','B2B')->get();
        $vehicle_type 	= DB::connection('ts3')->table('mst.mst_vehicle_type')->get();

		$data = array(  'title'     => 'Vehicle',
                        // 'vehicle'      => $vehicle,
                        'vehicle_type'      => $vehicle_type,
                        'client'      => $client,
                        'content'   => 'admin-ts3/vehicle/index'
                    );
        
        return view('admin-ts3/layout/wrapper',$data);
    }


    public function template_upload_vehicle()
    {
        if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }
    
        $file_path = storage_path('data/template/VEHICLE_LIST_TEMPLATE.xlsx');
        return response()->download($file_path);
    }


    

    public function upload_vehicle_proses(Request $request)
    {
        if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}

        request()->validate([
            'vehicle'   => 'file|mimes:xlsx,xls|max:5120|required',
            ]);

            $vehicle_file       = $request->file('vehicle');

            try
            {
                DB::connection('ts3')->beginTransaction();
                $nama_file = date("ymd_s").'_'.$vehicle_file->getClientOriginalName();
                $dir_file =storage_path('data/vehicle/'.date("Y").'/'.date("m").'/');
                // $DirFile ='data/spk/';
                if (!file_exists($dir_file)) {
                File::makeDirectory($dir_file,0777,true);
                }

                Log::info('done upload '.$nama_file);

                Excel::import(new VehicleTempImport(), $vehicle_file);
                $vehicle_file->move($dir_file,$nama_file);

                DB::connection('ts3')->commit();
            }
            catch (\Exception $e) {
                DB::connection('ts3')->rollback();
                return redirect('admin-ts3/vehicle')->with(['warning' => $e]);
            }    

            $return =  $this->postingvehicle($username = Session()->get('username')); 


            return redirect('admin-ts3/vehicle')->with(['sukses' => 'File berhasil Di Upload, mohon Untuk Di Review']);  
    }



    public function postingvehicle($username)
    {
     

        $checkvehicle =  Vehicle_model::GetTempVehicle($username); 

        foreach($checkvehicle as $x => $val) 
        {
             $resultArray = json_decode(json_encode($val), true);

             $checttypeVehicle = DB::connection('ts3')->table('mst.mst_vehicle_type')->select('id')->where('type',$resultArray['type'])->where('tahun_pembuatan',$resultArray['tahun_pembuatan'])->first();

             $checknopol = DB::connection('ts3')->table('mst.mst_vehicle')->select('nopol')->where('nopol',$resultArray['nopol'])->first();

                if(!isset($checknopol))
                {

                        if(isset($checttypeVehicle))
                        {
                            // $check client id di sini
                            $clientCheck = DB::connection('ts3')->table('mst.mst_client')->select('id')->where('client_name',$resultArray['client'])->first();

                            if(isset($clientCheck))
                            {

                                DB::connection('ts3')->table('mst.mst_vehicle')->insert([
                                'mst_client_id'	=> $clientCheck->id,
                                'nopol'   => strtoupper(str_replace(' ', '', $resultArray['nopol'])),
                                'norangka'   => strtoupper(str_replace(' ', '', $resultArray['norangka'])),
                                'nomesin'   => strtoupper(str_replace(' ', '', $resultArray['nomesin'])),
                                'mst_vehicle_type_id'   => $checttypeVehicle->id,
                                'tgl_last_service'   => $resultArray['tgl_last_service'],
                                'last_km'   => $resultArray['last_km'],
                                'nama_stnk'   => $resultArray['nama_stnk'],
                                'remark'   => '',
                                'created_date'    => date("Y-m-d h:i:sa"),
                                'create_by'     => Session()->get('username')
                            ]);        
                                
                            }
                            else
                            {
                                DB::connection('ts3')->table('mst.mst_temp_vehicle')->where('user_upload',$username)->delete();
                                Log::info('Client Tidak Terdaftar '.$resultArray['client']);
                                return 'Data Client Tidak Terdaftar';

                            }
            

                        }
                        else
                        {
                            $clientCheck = DB::connection('ts3')->table('mst.mst_client')->select('id')->where('client_name',$resultArray['client'])->first();

                            if(isset($clientCheck))
                            {


                                 $idType = DB::connection('ts3')->table('mst.mst_vehicle_type')->insertGetId([
                                'group_vehicle'   => 'Motor',
                                'type'   => $resultArray['type'],
                                'tahun_pembuatan'	=> $resultArray['tahun_pembuatan'],
                                'desc'	=> '',
                                'mst_client_id'	=> $clientCheck->id,
                                'created_date'    => date("Y-m-d h:i:sa"),
                                'create_by'     => Session()->get('username')
                            ]);

                            DB::connection('ts3')->table('mst.mst_vehicle')->insert([
                                'mst_client_id'	=> $clientCheck->id,
                                'nopol'   => strtoupper(str_replace(' ', '', $resultArray['nopol'])),
                                'norangka'   => strtoupper(str_replace(' ', '', $resultArray['norangka'])),
                                'nomesin'   => strtoupper(str_replace(' ', '', $resultArray['nomesin'])),
                                'mst_vehicle_type_id'   => $idType,
                                'tgl_last_service'   => $resultArray['tgl_last_service'],
                                'last_km'   => $resultArray['last_km'],
                                'nama_stnk'   => $resultArray['nama_stnk'],
                                'remark'   => '',
                                'created_date'    => date("Y-m-d h:i:sa"),
                                'create_by'     => Session()->get('username')
                            ]);

                            }
                            else
                            {
                                DB::connection('ts3')->table('mst.mst_temp_vehicle')->where('user_upload',$username)->delete();
                                Log::info('Client Tidak Terdaftar '.$resultArray['client']);
                                return 'Data Client Tidak Terdaftar';

                            }


                        }    
                 } 
                 else
                 { 
                    Log::info('Vehcicle Sudah ada '.$resultArray['nopol']);

                 }       

        }


        DB::connection('ts3')->table('mst.mst_temp_vehicle')->where('user_upload',$username)->delete();

        return 'File berhasil Di Upload, mohon Untuk Di Review';

    }


    public function index_vehicle_type()
    {
    	if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}

      
        // $vehicle_type 	= DB::connection('ts3')->table('mst.mst_vehicle_type')->get();
        $group_vehicle 	= DB::connection('ts3')->table('mst.mst_general')->where('name','Group Vehicle')->where('value_1','Motor')->get();

		$data = array(  'title'     => 'Vehicle Type',
                        
                        // 'vehicle_type'      => $vehicle_type,
                        'group_vehicle'      => $group_vehicle,
                     
                        'content'   => 'admin-ts3/vehicle/index_vehicle_type'
                    );
        
        return view('admin-ts3/layout/wrapper',$data);
    }

    public function tambah(Request $request)
    {
    	if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
    	request()->validate(['mst_client_id' 	   => 'required',
					        'nopol' => 'required|unique:ts3.mst.mst_vehicle',
					        'norangka' => 'required|unique:ts3.mst.mst_vehicle',
                            'nomesin' => 'required|unique:ts3.mst.mst_vehicle',
                            'mst_vehicle_type_id' => 'required',
					        ]);

                      
        DB::connection('ts3')->table('mst.mst_vehicle')->insert([
            'mst_client_id'	=> $request->mst_client_id,
            'nopol'   => strtoupper(str_replace(' ', '', $request->nopol)),
            'norangka'   => strtoupper(str_replace(' ', '', $request->norangka)),
            'nomesin'   => strtoupper(str_replace(' ', '', $request->nomesin)),
            'mst_vehicle_type_id'   => $request->mst_vehicle_type_id,
            'remark'   => $request->remark,
            'created_date'    => date("Y-m-d h:i:sa"),
            'create_by'     => $request->session()->get('username')
        ]);
        return redirect('admin-ts3/vehicle')->with(['sukses' => 'Data telah ditambah']);
    }

    public function tambah_vehicle_type(Request $request)
    {
    	if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
    	request()->validate(['group_vehicle' 	   => 'required',
					        'type' => 'required|unique:ts3.mst.mst_vehicle_type',
					        'tahun_pembuatan' 	   => 'required',
					        ]);



        DB::connection('ts3')->table('mst.mst_vehicle_type')->insert([
            'group_vehicle'   => $request->group_vehicle,
            'type'   => $request->type,
            'tahun_pembuatan'	=> $request->tahun_pembuatan,
            'desc'	=> $request->desc,
            'created_date'    => date("Y-m-d h:i:sa"),
            'create_by'     => $request->session()->get('username')
        ]);
        return redirect('admin-ts3/vehicle-type')->with(['sukses' => 'Data telah ditambah']);
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
                            'content'   => 'admin-ts3/vehicle/edit_vehicle_type'
                    );
        
             return view('admin-ts3/layout/wrapper',$data);
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
                        'content'   => 'admin-ts3/vehicle/edit'
                    );
        
             return view('admin-ts3/layout/wrapper',$data);
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
        return redirect('admin-ts3/vehicle')->with(['sukses' => 'Data telah diupdate']);                                             
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
        return redirect('admin-ts3/vehicle-type')->with(['sukses' => 'Data telah diupdate']);                                             
    }

    public function delete($id)
    {
    	if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
     
        DB::connection('ts3')->table('mst.mst_vehicle')->where('id',$id)->delete();
        return redirect('admin-ts3/vehicle')->with(['sukses' => 'Data telah dihapus']);
    }

    public function delete_vehicle_type($id)
    {
    	if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
     
        DB::connection('ts3')->table('mst.mst_vehicle_type')->where('id',$id)->delete();
        return redirect('admin-ts3/vehicle-type')->with(['sukses' => 'Data telah dihapus']);
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
        
            return redirect('admin-ts3/vehicle')->with(['sukses' => 'Data telah dihapus']);
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
        
            return redirect('admin-ts3/vehicle-type')->with(['sukses' => 'Data telah dihapus']);
        // PROSES SETTING DRAFT
        }
    }

    public function detail($id)
    {
        if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
      
        $vehicle 	= DB::connection('ts3')->table('mst.v_vehicle')->where('id',$id)->first();
        $data = array(  'title'             => $vehicle->nopol,
                        'vehicle'             => $vehicle,
                        'content'           => 'admin-ts3/vehicle/detail'
                    );
        return view('admin-ts3/layout/wrapper',$data);
    }


    public function getVehicle(Request $request)
    {
        if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}

        if ($request->ajax()) {
        

        $vehicle 	= DB::connection('ts3')->table('mst.v_vehicle')->get();
        
        return DataTables::of($vehicle)
                ->addColumn('action', function($row){
                    $btn = '<div class="btn-group">
                            <a href="'. asset('admin-ts3/vehicle/detail/'.$row->id).'" 
                                class="btn btn-success btn-sm"><i class="fa fa-eye"></i></a>
                            <a href="'. asset('admin-ts3/vehicle/edit/'.$row->id).'" 
                                class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>
                            <a href="'. asset('admin-ts3/vehicle/delete/'.$row->id).'" class="btn btn-danger btn-sm">
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
        

        $vehiclet 	= DB::connection('ts3')->table('mst.mst_vehicle_type')->get();
        
        return DataTables::of($vehiclet)
                ->addColumn('action', function($row){
                    $btn = '<div class="btn-group">
                            <a href="'. asset('admin-ts3/vehicle-type/edit-vehicle-type/'.$row->id).'" 
                                class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>
                            <a href="'. asset('admin-ts3/vehicle-type/delete-vehicle-type/'.$row->id).'" class="btn btn-danger btn-sm  delete-link">
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

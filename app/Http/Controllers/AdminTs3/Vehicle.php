<?php
namespace App\Http\Controllers\AdminTs3;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Image;

class Vehicle extends Controller
{
    // Index
    public function index()
    {
    	if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}

      
        $vehicle 	= DB::connection('ts3')->table('mst.v_vehicle')->get();
        $client 	= DB::connection('ts3')->table('mst.mst_client')->where('client_type','B2B')->get();
        $vehicle_type 	= DB::connection('ts3')->table('mst.mst_vehicle_type')->get();
        $group_vehicle 	= DB::connection('ts3')->table('mst.mst_general')->where('name','Group Vehicle')->where('value_1','Motor')->get();

		$data = array(  'title'     => 'Vehicle & Vehicle Type',
                        'vehicle'      => $vehicle,
                        'vehicle_type'      => $vehicle_type,
                        'group_vehicle'      => $group_vehicle,
                        'client'      => $client,
                        'content'   => 'admin-ts3/vehicle/index'
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
            'nomesin'   => strtoupper(str_replace(' ', '', $request->norangka)),
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
        return redirect('admin-ts3/vehicle')->with(['sukses' => 'Data telah ditambah']);
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
        return redirect('admin-ts3/vehicle')->with(['sukses' => 'Data telah diupdate']);                                             
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
        return redirect('admin-ts3/vehicle')->with(['sukses' => 'Data telah dihapus']);
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
        
            return redirect('admin-ts3/vehicle')->with(['sukses' => 'Data telah dihapus']);
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


}

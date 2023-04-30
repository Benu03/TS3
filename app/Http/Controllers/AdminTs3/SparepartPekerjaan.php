<?php
namespace App\Http\Controllers\AdminTs3;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Image;

class SparepartPekerjaan extends Controller
{
    // Index
    public function index()
    {
    	if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}

      
        $part 	= DB::connection('ts3')->table('mst.mst_spare_part')->get();
        $group_vehicle 	= DB::connection('ts3')->table('mst.mst_general')->where('name','Group Vehicle')->where('value_1','Motor')->get();

		$data = array(  'title'     => 'Spare Part',
                        'part'      => $part,
                        'group_vehicle'      => $group_vehicle,
                        'content'   => 'admin-ts3/sparepart_pekerjaan/index'
                    );
        
        return view('admin-ts3/layout/wrapper',$data);
    }

    public function index_pekerjaan()
    {
    	if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}

      
       
        $pekerjaan 	= DB::connection('ts3')->table('mst.mst_pekerjaan')->get();
        $group_vehicle 	= DB::connection('ts3')->table('mst.mst_general')->where('name','Group Vehicle')->where('value_1','Motor')->get();

		$data = array(  'title'     => 'Pekerjaan',                   
                        'pekerjaan'      => $pekerjaan,
                        'group_vehicle'      => $group_vehicle,
                        'content'   => 'admin-ts3/sparepart_pekerjaan/index_pekerjaan'
                    );
        
        return view('admin-ts3/layout/wrapper',$data);
    }

    public function tambah(Request $request)
    {
    	if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
    	request()->validate([
					        'name' => 'required|unique:ts3.mst.mst_spare_part',
					      
					        ]);

                      
        DB::connection('ts3')->table('mst.mst_spare_part')->insert([
            'group_vehicle'   => $request->group_vehicle,
            'name'   => strtoupper($request->name),
            'desc'   => $request->desc,
            'created_date'    => date("Y-m-d h:i:sa"),
            'create_by'     => $request->session()->get('username')
        ]);
        return redirect('admin-ts3/spare-part')->with(['sukses' => 'Data telah ditambah']);
    }

    public function tambah_pekerjaan(Request $request)
    {
    	if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
    	request()->validate(['name' => 'required|unique:ts3.mst.mst_pekerjaan',
					        ]);

        DB::connection('ts3')->table('mst.mst_pekerjaan')->insert([
            'group_vehicle'   => $request->group_vehicle,
            'name'   => strtoupper($request->name),
            'desc'   => $request->desc,
            'created_date'    => date("Y-m-d h:i:sa"),
            'create_by'     => $request->session()->get('username')
        ]);
        return redirect('admin-ts3/pekerjaan')->with(['sukses' => 'Data telah ditambah']);
    }

        // Index
    public function edit_pekerjaan($id)
    {
            if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
           
           
            $pekerjaan 	= DB::connection('ts3')->table('mst.mst_pekerjaan')->where('id',$id)->first();
            $group_vehicle 	= DB::connection('ts3')->table('mst.mst_general')->where('name','Group Vehicle')->where('value_1','Motor')->get();
		    $data = array(  'title'     => 'Edit Pekerjaan',						
                            'pekerjaan'      => $pekerjaan,
                            'group_vehicle'      => $group_vehicle,
                            'content'   => 'admin-ts3/sparepart_pekerjaan/edit_pekerjaan'
                    );
        
             return view('admin-ts3/layout/wrapper',$data);
    }

    public function edit($id)
    {
            if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
           
        
            $part 	= DB::connection('ts3')->table('mst.mst_spare_part')->where('id',$id)->first();
            $group_vehicle 	= DB::connection('ts3')->table('mst.mst_general')->where('name','Group Vehicle')->where('value_1','Motor')->get();
		    $data = array(  'title'     => 'Edit Spare Part',						
                                'part'      => $part,
                                'group_vehicle'      => $group_vehicle,
                        'content'   => 'admin-ts3/sparepart_pekerjaan/edit'
                    );
        
             return view('admin-ts3/layout/wrapper',$data);
    }
    
    public function proses_edit(Request $request)
    {
    	if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
    	request()->validate(['group_vehicle' 	   => 'required',
                                'name' 	   => 'required',
                           
					        ]);

                            DB::connection('ts3')->table('mst.mst_spare_part')->where('id',$request->id)->update([
                                'group_vehicle'   => $request->group_vehicle,
                                'name'   => $request->name,
                                'desc'   => $request->desc,
                                'updated_at'    => date("Y-m-d h:i:sa"),
                                'update_by'     => $request->session()->get('username')
                            ]);   
        return redirect('admin-ts3/spare-part')->with(['sukses' => 'Data telah diupdate']);                                             
    }

    public function proses_edit_pekerjaan(Request $request)
    {
    	if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
    	request()->validate([
                                'group_vehicle' 	   => 'required',
                                'name' 	   => 'required',
       
					        ]);

                            DB::connection('ts3')->table('mst.mst_pekerjaan')->where('id',$request->id)->update([
                                'group_vehicle'   => $request->group_vehicle,
                                'name'   => $request->name,
                                'desc'   => $request->desc,
                                'updated_at'    => date("Y-m-d h:i:sa"),
                                'update_by'     => $request->session()->get('username')
                            ]);   
        return redirect('admin-ts3/pekerjaan')->with(['sukses' => 'Data telah diupdate']);                                             
    }

    public function delete($id)
    {
    	if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
     
        DB::connection('ts3')->table('mst.mst_spare_part')->where('id',$id)->delete();
        return redirect('admin-ts3/spare-part')->with(['sukses' => 'Data telah dihapus']);
    }

    public function delete_pekerjaan($id)
    {
    	if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
     
        DB::connection('ts3')->table('mst.mst_pekerjaan')->where('id',$id)->delete();
        return redirect('admin-ts3/pekerjaan')->with(['sukses' => 'Data telah dihapus']);
    }
       

    public function proses(Request $request)
    {
        $site   =DB::connection('ts3')->table('cp.konfigurasi')->first();
        // PROSES HAPUS MULTIPLE

        if(isset($_POST['hapus'])) {
            $id       = $request->id;
     
            for($i=0; $i < sizeof($id);$i++) {
                      
               DB::connection('ts3')->table('mst.mst_spare_part')->where('id',$id[$i])->delete();
             
            }
        
            return redirect('admin-ts3/spare-part')->with(['sukses' => 'Data telah dihapus']);
        // PROSES SETTING DRAFT
        }
    }


    public function proses_pekerjaan(Request $request)
    {
        $site   =DB::connection('ts3')->table('cp.konfigurasi')->first();
        // PROSES HAPUS MULTIPLE

        if(isset($_POST['hapus'])) {
            $id       = $request->id;
     
            for($i=0; $i < sizeof($id);$i++) {
                      
               DB::connection('ts3')->table('mst.mst_pekerjaan')->where('id',$id[$i])->delete();
             
            }
        
            return redirect('admin-ts3/pekerjaan')->with(['sukses' => 'Data telah dihapus']);
        // PROSES SETTING DRAFT
        }
    }

   


}

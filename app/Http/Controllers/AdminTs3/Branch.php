<?php
namespace App\Http\Controllers\AdminTs3;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Image;

class Branch extends Controller
{
    // Index
    public function index()
    {
    	if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
      
        $branch 	= DB::connection('ts3')->table('mst.v_branch')->get();
        $area 	= DB::connection('ts3')->table('mst.mst_area')->get();

		$data = array(  'title'     => 'Branch',
                        'area'      => $area,
                        'branch'      => $branch,
                        'content'   => 'admin-ts3/branch/index'
                    );
        
        return view('admin-ts3/layout/wrapper',$data);
    }

    public function tambah(Request $request)
    {
    	if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
    	request()->validate([
					        'mst_area_id' => 'required',
					        'branch' 	   => 'required|unique:ts3.mst.mst_branch',
					        ]);


        DB::connection('ts3')->table('mst.mst_branch')->insert([
            'mst_area_id'   => $request->mst_area_id,
            'branch'	=> $request->branch,
            'created_date'    => date("Y-m-d h:i:sa"),
            'create_by'     => $request->session()->get('username')
        ]);
        return redirect('admin-ts3/branch')->with(['sukses' => 'Data telah ditambah']);
    }

   
    public function edit($id)
    {
            if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
        
            $branch 	= DB::connection('ts3')->table('mst.v_branch')->where('id',$id)->first();
            $area 	= DB::connection('ts3')->table('mst.mst_area')->get();

     
		    $data = array(  'title'         => 'Edit Branch',
                            'area'          => $area,
                            'branch'        => $branch,
                            'content'       => 'admin-ts3/branch/edit'
                    );
        
             return view('admin-ts3/layout/wrapper',$data);
    }
    
    public function proses_edit(Request $request)
    {
    	if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
    	request()->validate([
					        'mst_area_id'     => 'required',
                            'branch' => 'required',
					        ]);

                            DB::connection('ts3')->table('mst.mst_branch')->where('id',$request->id)->update([
                                'mst_area_id'   => $request->mst_area_id,
                                'branch'	    => $request->branch,
                                'updated_at'    => date("Y-m-d h:i:sa"),
                                'update_by'     => $request->session()->get('username')
                            ]);   
        return redirect('admin-ts3/branch')->with(['sukses' => 'Data telah diupdate']);                                             
    }

  
    public function delete($id)
    {
    	if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
     
        DB::connection('ts3')->table('mst.mst_branch')->where('id',$id)->delete();
        return redirect('admin-ts3/branch')->with(['sukses' => 'Data telah dihapus']);
    }

       

    public function proses(Request $request)
    {
        $site   =DB::connection('ts3')->table('cp.konfigurasi')->first();
        // PROSES HAPUS MULTIPLE

        if(isset($_POST['hapus'])) {
            $id       = $request->id;
     
            for($i=0; $i < sizeof($id);$i++) {
                      
               DB::connection('ts3')->table('mst.mst_branch')->where('id',$id[$i])->delete();
             
            }
        
            return redirect('admin-ts3/branch')->with(['sukses' => 'Data telah dihapus']);
        // PROSES SETTING DRAFT
        }
    }




}

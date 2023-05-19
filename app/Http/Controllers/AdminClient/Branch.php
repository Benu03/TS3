<?php
namespace App\Http\Controllers\AdminClient;
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
        $user_client 	= DB::connection('ts3')->table('auth.v_user_client')->where('username',Session()->get('username'))->first();


        $area 	=DB::connection('ts3')->table('mst.v_area_client')->where('client_name',$user_client->customer_name)->orderBy('area', 'asc')->get();
        $branch 	= DB::connection('ts3')->table('mst.v_branch_client')->where('client_name',$user_client->customer_name)->get();
        $user_branch 	= DB::connection('ts3')->table('auth.v_list_user_client')->where('entity',$user_client->customer_name)->orderBy('nama', 'asc')->get();


		$data = array(  'title'     => 'Branch',
                        'area'      => $area,
                        'branch'      => $branch,
                        'userbranch'      => $user_branch,
                        'content'   => 'admin-client/branch/index'
                    );
        
        return view('admin-client/layout/wrapper',$data);
    }

    public function tambah(Request $request)
    {
    	if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
    	request()->validate([
					        'mst_area_id' => 'required',
					        'branch' 	   => 'required|unique:ts3.mst.mst_branch',
                            'pic_branch' => 'required',
					        ]);


        DB::connection('ts3')->table('mst.mst_branch')->insert([
            'mst_area_id'   => $request->mst_area_id,
            'branch'	=> $request->branch,
            'pic_branch'	=> $request->pic_branch,
            'phone'	=> $request->phone,
            'address'	=> $request->address,
            'created_date'    => date("Y-m-d h:i:sa"),
            'create_by'     => $request->session()->get('username')
        ]);
        return redirect('admin-client/branch')->with(['sukses' => 'Data telah ditambah']);
    }

   
    public function edit($id)
    {
            if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
        
            $user_client 	= DB::connection('ts3')->table('auth.v_user_client')->where('username',Session()->get('username'))->first();

            $branch 	= DB::connection('ts3')->table('mst.v_branch_client')->where('id',$id)->first();
            $area 	=DB::connection('ts3')->table('mst.v_area_client')->where('client_name',$user_client->customer_name)->orderBy('area', 'asc')->get();
            $user_branch 	= DB::connection('ts3')->table('auth.v_list_user_client')->where('entity',$user_client->customer_name)->orderBy('nama', 'asc')->get();
     
		    $data = array(  'title'         => 'Edit Branch',
                            'area'          => $area,
                            'branch'        => $branch,
                            'userbranch'      => $user_branch,
                            'content'       => 'admin-client/branch/edit'
                    );
        
             return view('admin-client/layout/wrapper',$data);
    }
    
    public function proses_edit(Request $request)
    {
    	if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
    	request()->validate([
					        'mst_area_id'     => 'required',
                            'branch' => 'required',
                            'pic_branch' => 'required',
					        ]);

                            DB::connection('ts3')->table('mst.mst_branch')->where('id',$request->id)->update([
                                'mst_area_id'   => $request->mst_area_id,
                                'branch'	    => $request->branch,
                                'pic_branch'	=> $request->pic_branch,
                                'phone'	=> $request->phone,
                                'address'	=> $request->address,
                                'updated_at'    => date("Y-m-d h:i:sa"),
                                'update_by'     => $request->session()->get('username')
                            ]);   
        return redirect('admin-client/branch')->with(['sukses' => 'Data telah diupdate']);                                             
    }

  
    public function delete($id)
    {
    	if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
     
        DB::connection('ts3')->table('mst.mst_branch')->where('id',$id)->delete();
        return redirect('admin-client/branch')->with(['sukses' => 'Data telah dihapus']);
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
        
            return redirect('admin-client/branch')->with(['sukses' => 'Data telah dihapus']);
        // PROSES SETTING DRAFT
        }
    }




}

<?php
namespace App\Http\Controllers\AdminClient;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Image;

class Area extends Controller
{
    // Index
    public function index()
    {
    	if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
        $user_client 	= DB::connection('ts3')->table('auth.v_user_client')->where('username',Session()->get('username'))->first();

      
        $regional 	= DB::connection('ts3')->table('mst.v_regional')->where('client_name',$user_client->customer_name)->orderBy('regional', 'asc')->get();
        
        
        $area 	= DB::connection('ts3')->table('mst.v_area_client')->where('client_name',$user_client->customer_name)->orderBy('area', 'asc')->get();

		$data = array(  'title'     => 'Area',
                        'area'      => $area,
                        'regional'      => $regional,
                        'content'   => 'admin-client/area/index'
                    );
        
        return view('admin-client/layout/wrapper',$data);
    }

    public function tambah(Request $request)
    {
    	if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
    	request()->validate([
					        'mst_regional_id' => 'required',
					        'area' 	   => 'required|unique:ts3.mst.mst_area',
					        ]);


        DB::connection('ts3')->table('mst.mst_area')->insert([
            'mst_regional_id'   => $request->mst_regional_id,
            'area'	=> $request->area,
            'created_date'    => date("Y-m-d h:i:sa"),
            'create_by'     => $request->session()->get('username')
        ]);
        return redirect('admin-client/area')->with(['sukses' => 'Data telah ditambah']);
    }

   
    public function edit($id)
    {
            if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
            $user_client 	= DB::connection('ts3')->table('auth.v_user_client')->where('username',Session()->get('username'))->first();

            $area 	= DB::connection('ts3')->table('mst.v_area_client')->where('id',$id)->first();
            $regional 	= DB::connection('ts3')->table('mst.v_regional')->where('client_name',$user_client->customer_name)->orderBy('regional', 'asc')->get();

           
           
		    $data = array(  'title'         => 'Edit area',
                            'area'          => $area,
                            'regional'        => $regional,
                            'content'       => 'admin-client/area/edit'
                    );
        
             return view('admin-client/layout/wrapper',$data);
    }
    
    public function proses_edit(Request $request)
    {
    	if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
    	request()->validate([
					        'mst_regional_id'     => 'required',
                            'area' => 'required',
					        ]);

                            DB::connection('ts3')->table('mst.mst_area')->where('id',$request->id)->update([
                                'mst_regional_id'   => $request->mst_regional_id,
                                'area'	    => $request->area,
                                'updated_at'    => date("Y-m-d h:i:sa"),
                                'update_by'     => $request->session()->get('username')
                            ]);   
        return redirect('admin-client/area')->with(['sukses' => 'Data telah diupdate']);                                             
    }

  
    public function delete($id)
    {
    	if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
     
        DB::connection('ts3')->table('mst.mst_area')->where('id',$id)->delete();
        return redirect('admin-client/area')->with(['sukses' => 'Data telah dihapus']);
    }

       

    public function proses(Request $request)
    {
        $site   =DB::connection('ts3')->table('cp.konfigurasi')->first();
        // PROSES HAPUS MULTIPLE

        if(isset($_POST['hapus'])) {
            $id       = $request->id;
     
            for($i=0; $i < sizeof($id);$i++) {
                      
               DB::connection('ts3')->table('mst.mst_area')->where('id',$id[$i])->delete();
             
            }
        
            return redirect('admin-client/area')->with(['sukses' => 'Data telah dihapus']);
        // PROSES SETTING DRAFT
        }
    }




}

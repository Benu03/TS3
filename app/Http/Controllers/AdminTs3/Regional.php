<?php
namespace App\Http\Controllers\AdminTs3;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Image;

class Regional extends Controller
{
    // Index
    public function index()
    {
    	if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
      
        $regional 	= DB::connection('ts3')->table('mst.v_regional')->get();
        $client 	= DB::connection('ts3')->table('mst.mst_client')->where('client_type','B2B')->get();

		$data = array(  'title'     => 'Regional',
                        'regional'      => $regional,
                        'client'      => $client,
                        'content'   => 'admin-ts3/regional/index'
                    );
        
        return view('admin-ts3/layout/wrapper',$data);
    }

    public function tambah(Request $request)
    {
    	if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
    	request()->validate([
					        'mst_client_id' => 'required',
					        'regional' 	   => 'required|unique:ts3.mst.mst_regional',
					        ]);


        DB::connection('ts3')->table('mst.mst_regional')->insert([
            'mst_client_id'   => $request->mst_client_id,
            'regional'	=> $request->regional,
            'created_date'    => date("Y-m-d h:i:sa"),
            'create_by'     => $request->session()->get('username')
        ]);
        return redirect('admin-ts3/regional')->with(['sukses' => 'Data telah ditambah']);
    }

   
    public function edit($id)
    {
            if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
           
            $regional 	= DB::connection('ts3')->table('mst.v_regional')->where('id',$id)->first();
            $client 	= DB::connection('ts3')->table('mst.mst_client')->where('client_type','B2B')->get();
           
		    $data = array(  'title'         => 'Edit Regional',
                            'regional'      => $regional,
                            'client'        => $client,
                            'content'       => 'admin-ts3/regional/edit'
                    );
        
             return view('admin-ts3/layout/wrapper',$data);
    }
    
    public function proses_edit(Request $request)
    {
    	if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
    	request()->validate([
					        'client'     => 'required',
                            'regional' => 'required',
					        ]);

                            DB::connection('ts3')->table('mst.mst_regional')->where('id',$request->id)->update([
                                'mst_client_id'   => $request->client,
                                'regional'	    => $request->regional,
                                'updated_at'    => date("Y-m-d h:i:sa"),
                                'update_by'     => $request->session()->get('username')
                            ]);   
        return redirect('admin-ts3/regional')->with(['sukses' => 'Data telah diupdate']);                                             
    }

  
    public function delete($id)
    {
    	if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
     
        DB::connection('ts3')->table('mst.mst_regional')->where('id',$id)->delete();
        return redirect('admin-ts3/regional')->with(['sukses' => 'Data telah dihapus']);
    }

       

    public function proses(Request $request)
    {
     
        if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }
     
        if($request->id == null)
        {
            return redirect('admin-ts3/regional')->with(['warning' => 'Data Tidak Ada Yang Di pilih']);
        }

        if(isset($_POST['hapus'])) {
            $id       = $request->id;
     
            for($i=0; $i < sizeof($id);$i++) {
                      
               DB::connection('ts3')->table('mst.mst_regional')->where('id',$id[$i])->delete();
             
            }
        
            return redirect('admin-ts3/regional')->with(['sukses' => 'Data telah dihapus']);
        // PROSES SETTING DRAFT
        }
    }




}

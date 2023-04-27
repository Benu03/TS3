<?php
namespace App\Http\Controllers\AdminTs3;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Image;

class General extends Controller
{
    // Index
    public function index()
    {
    	if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
      
        $general 	= DB::connection('ts3')->table('mst.mst_general')->get();
       
		$data = array(  'title'     => 'General',
                        'general'      => $general,
                        'content'   => 'admin-ts3/general/index'
                    );
        
        return view('admin-ts3/layout/wrapper',$data);
    }

    public function tambah(Request $request)
    {
    	if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
    	request()->validate([
					        'name' => 'required',
					        'value_1' 	   => 'required',
					        ]);


        DB::connection('ts3')->table('mst.mst_general')->insert([
            'name'   => $request->name,
            'value_1'	=> $request->value_1,
            'value_2'	=> $request->value_2,
            'desc'	=> $request->desc,            
            'created_date'    => date("Y-m-d h:i:sa"),
            'create_by'     => $request->session()->get('username')
        ]);
        return redirect('admin-ts3/general')->with(['sukses' => 'Data telah ditambah']);
    }

   
    public function edit($id)
    {
            if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
            $general 	= DB::connection('ts3')->table('mst.mst_general')->where('id',$id)->first();
          

		    $data = array(  'title'         => 'Edit General',
                            'general'          => $general,
                            'content'       => 'admin-ts3/general/edit'
                    );
             return view('admin-ts3/layout/wrapper',$data);
    }
    
    public function proses_edit(Request $request)
    {
    	if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
    	request()->validate([
					        'name'     => 'required',
                            'value_1' => 'required',
					        ]);

                            DB::connection('ts3')->table('mst.mst_general')->where('id',$request->id)->update([
                                'name'   => $request->name,
                                'value_1'	=> $request->value_1,
                                'value_2'	=> $request->value_2,
                                'desc'	=> $request->desc,          
                                'updated_at'    => date("Y-m-d h:i:sa"),
                                'update_by'     => $request->session()->get('username')
                            ]);   
        return redirect('admin-ts3/general')->with(['sukses' => 'Data telah diupdate']);                                             
    }

  
    public function delete($id)
    {
    	if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
     
        DB::connection('ts3')->table('mst.mst_general')->where('id',$id)->delete();
        return redirect('admin-ts3/general')->with(['sukses' => 'Data telah dihapus']);
    }

       

    public function proses(Request $request)
    {
        $site   =DB::connection('ts3')->table('cp.konfigurasi')->first();
        // PROSES HAPUS MULTIPLE

        if(isset($_POST['hapus'])) {
            $id       = $request->id;
     
            for($i=0; $i < sizeof($id);$i++) {
                      
               DB::connection('ts3')->table('mst.mst_general')->where('id',$id[$i])->delete();
             
            }
        
            return redirect('admin-ts3/general')->with(['sukses' => 'Data telah dihapus']);
        // PROSES SETTING DRAFT
        }
    }




}

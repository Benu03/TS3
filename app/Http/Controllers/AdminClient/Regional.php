<?php
namespace App\Http\Controllers\AdminClient;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Image;
use DataTables;
use Log;
use App\Exports\AdminClient\RegionalExport;
use Maatwebsite\Excel\Facades\Excel;

class Regional extends Controller
{
    // Index
    public function index()
    {
    	if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
        $user_client 	= DB::connection('ts3')->table('auth.v_user_client')->where('username',Session()->get('username'))->first();

        // $regional 	= DB::connection('ts3')->table('mst.v_regional')->where('client_name',$user_client->customer_name)->orderBy('regional', 'asc')->get();
        $client 	= DB::connection('ts3')->table('mst.mst_client')->where('client_name',$user_client->customer_name)->get();

		$data = array(  'title'     => 'Regional',
                        // 'regional'      => $regional,
                        'client'      => $client,
                        'content'   => 'admin-client/regional/index'
                    );
        
        return view('admin-client/layout/wrapper',$data);
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
        return redirect('admin-client/regional')->with(['sukses' => 'Data telah ditambah']);
    }

   
    public function edit($id)
    {
            if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
            $user_client 	= DB::connection('ts3')->table('auth.v_user_client')->where('username',Session()->get('username'))->first();
            $regional 	= DB::connection('ts3')->table('mst.v_regional')->where('id',$id)->first();
            $client 	= DB::connection('ts3')->table('mst.mst_client')->where('client_name',$user_client->customer_name)->get();

           
		    $data = array(  'title'         => 'Edit Regional',
                            'regional'      => $regional,
                            'client'        => $client,
                            'content'       => 'admin-client/regional/edit'
                    );
        
             return view('admin-client/layout/wrapper',$data);
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
        return redirect('admin-client/regional')->with(['sukses' => 'Data telah diupdate']);                                             
    }

  
    public function delete($id)
    {
    	if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
     
        DB::connection('ts3')->table('mst.mst_regional')->where('id',$id)->delete();
        return redirect('admin-client/regional')->with(['sukses' => 'Data telah dihapus']);
    }

       

    public function proses(Request $request)
    {
        $site   =DB::connection('ts3')->table('cp.konfigurasi')->first();
        // PROSES HAPUS MULTIPLE

        if(isset($_POST['hapus'])) {
            $id       = $request->id;
     
            for($i=0; $i < sizeof($id);$i++) {
                      
               DB::connection('ts3')->table('mst.mst_regional')->where('id',$id[$i])->delete();
             
            }
        
            return redirect('admin-client/regional')->with(['sukses' => 'Data telah dihapus']);
        // PROSES SETTING DRAFT
        }
    }



    public function getRegional(Request $request)
    {
        if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}

        
        if ($request->ajax()) {
            $user_client 	= DB::connection('ts3')->table('auth.v_user_client')->where('username',Session()->get('username'))->first();

            $regional 	= DB::connection('ts3')->table('mst.v_regional')->where('client_name',$user_client->customer_name)->get();
        return DataTables::of($regional)->addColumn('action', function($row){
               $btn = '<div class="btn-group">
               <a href="'. asset('admin-client/regional/edit/'.$row->id).'" 
                 class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>
               <a href="'. asset('admin-client/regional/delete/'.$row->id).'" class="btn btn-danger btn-sm  delete-link">
                    <i class="fa fa-trash"></i></a>
               </div>';
                return $btn;
                })->addColumn('check', function($row){
                    $check = ' <td class="text-center">
                                <div class="icheck-primary">
                                <input type="checkbox" class="icheckbox_flat-blue " name="id[]" value="'.$row->id.'" id="check'.$row->id.'">
                               <label for="check'.$row->id.'"></label>
                                </div>
                             </td>';
                    return $check;
                })
        ->rawColumns(['action','check'])->make(true);
       
        }

    }

    public function export()
    {
        if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}


        return Excel::download(new RegionalExport, 'REGIONAL-MVM.xlsx');
    }
    



}

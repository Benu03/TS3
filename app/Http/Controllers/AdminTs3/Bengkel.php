<?php
namespace App\Http\Controllers\AdminTs3;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Image;
use DataTables;
use Log;
use App\Exports\AdminTs3\BengkelExport;
use Maatwebsite\Excel\Facades\Excel;


class Bengkel extends Controller
{
    // Index
    public function index()
    {
    	if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
      
        // $bengkel 	= DB::connection('ts3')->table('mst.v_bengkel')->get();
        $user_bengkel 	= DB::connection('ts3')->table('auth.users')->where('id_role','4')->get();

		$data = array(  'title'     => 'Bengkel',
                        // 'bengkel'      => $bengkel,
                        'userbengkel'      => $user_bengkel,
                        'content'   => 'admin-ts3/bengkel/index'
                    );
        
        return view('admin-ts3/layout/wrapper',$data);
    }

    public function tambah(Request $request)
    {
    	if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
    	request()->validate([
					        'pic_bengkel' => 'required',
					        'bengkel_name' 	   => 'required|unique:ts3.mst.mst_bengkel',
					        ]);
        try{
            DB::connection('ts3')->beginTransaction();
          $maxId = DB::connection('ts3')->table('mst.mst_bengkel')->selectRaw('max(id) as id')->first();
          $seq = $maxId->id + 1;

            DB::connection('ts3')->table('mst.mst_bengkel')->insert([
                'bengkel_name'	=> $request->bengkel_name,
                'bengkel_alias'	=> 'TS3-MITRA-'.$seq,
                'pic_bengkel'   => $request->pic_bengkel,
                'phone'	=> $request->phone,
                'address'	=> $request->address,
                'latitude'	=> $request->latitude,
                'longitude'	=> $request->longitude,
                'created_date'    => date("Y-m-d h:i:sa"),
                'create_by'     => $request->session()->get('username')
            ]);

            DB::commit();
        }
        catch (\Illuminate\Database\QueryException $e) {
            DB::connection('ts3')->rollback();
            return redirect('admin-ts3/bengkel')->with(['warning' => $e]);
        }


        return redirect('admin-ts3/bengkel')->with(['sukses' => 'Data telah ditambah']);
    }

    public function edit($id)
    {
            if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
           
            $bengkel 	= DB::connection('ts3')->table('mst.v_bengkel')->where('id',$id)->first();
            $user_bengkel 	= DB::connection('ts3')->table('auth.users')->where('id_role','4')->get();
           
		    $data = array(  'title'         => 'Edit Bengkel',
                            'bengkel'      => $bengkel,
                            'userbengkel'      => $user_bengkel,
                            'content'       => 'admin-ts3/bengkel/edit'
                    );
        
             return view('admin-ts3/layout/wrapper',$data);
    }
    
    public function proses_edit(Request $request)
    {
    	if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
    	request()->validate([
                                'pic_bengkel' => 'required',
                                'bengkel_name' 	   => 'required',
					        ]);
                            try{
                                DB::connection('ts3')->beginTransaction();
                            DB::connection('ts3')->table('mst.mst_bengkel')->where('id',$request->id)->update([
                                'bengkel_name'	=> $request->bengkel_name,
                                'pic_bengkel'   => $request->pic_bengkel,
                                'phone'	=> $request->phone,
                                'address'	=> $request->address,
                                'latitude'	=> $request->latitude,
                                'longitude'	=> $request->longitude,
                                'updated_at'    => date("Y-m-d h:i:sa"),
                                'update_by'     => $request->session()->get('username')
                            ]);   
                            DB::connection('ts3')->commit();
                        }
                        catch (\Illuminate\Database\QueryException $e) {
                            DB::connection('ts3')->rollback();
                            return redirect('admin-ts3/bengkel')->with(['warning' => $e]);
                        }
        return redirect('admin-ts3/bengkel')->with(['sukses' => 'Data telah diupdate']);                                             
    }

  
    public function delete($id)
    {
    	if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
     
        DB::connection('ts3')->table('mst.mst_bengkel')->where('id',$id)->delete();
        return redirect('admin-ts3/bengkel')->with(['sukses' => 'Data telah dihapus']);
    }

       

    public function proses(Request $request)
    {
        $site   =DB::connection('ts3')->table('cp.konfigurasi')->first();
        // PROSES HAPUS MULTIPLE

        if(isset($_POST['hapus'])) {
            $id       = $request->id;
     
            for($i=0; $i < sizeof($id);$i++) {
                      
               DB::connection('ts3')->table('mst.mst_bengkel')->where('id',$id[$i])->delete();
             
            }
        
            return redirect('admin-ts3/bengkel')->with(['sukses' => 'Data telah dihapus']);
        // PROSES SETTING DRAFT
        }
    }

    public function getBengkel(Request $request)
    {
        if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}

        if ($request->ajax()) {
        

        $bengkel 	= DB::connection('ts3')->table('mst.v_bengkel')->get();
        
        return DataTables::of($bengkel)
                ->addColumn('action', function($row){
                    $btn = '<div class="btn-group">
                            <a href="'. asset('admin-ts3/bengkel/edit/'.$row->id).'" 
                                class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>
                            <a href="'. asset('admin-ts3/bengkel/delete/'.$row->id).'" class="btn btn-danger btn-sm">
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


        return Excel::download(new BengkelExport, 'BENGKEL-MVM.xlsx');
    }
    




}

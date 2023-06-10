<?php
namespace App\Http\Controllers\AdminTs3;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Image;
use DataTables;
use Log;


class Branch extends Controller
{
    // Index
    public function index()
    {
    	if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
      
        // $branch 	= DB::connection('ts3')->table('mst.v_branch')->get();
        $area 	= DB::connection('ts3')->table('mst.v_area')->get();
        $user_branch 	= DB::connection('ts3')->table('auth.users')->where('id_role','5')->get();

		$data = array(  'title'     => 'Branch',
                        'area'      => $area,
                        // 'branch'      => $branch,
                        'userbranch'      => $user_branch,
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
        return redirect('admin-ts3/branch')->with(['sukses' => 'Data telah ditambah']);
    }

   
    public function edit($id)
    {
            if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
        
            $branch 	= DB::connection('ts3')->table('mst.v_branch')->where('id',$id)->first();
            $area 	= DB::connection('ts3')->table('mst.v_area')->get();
            $user_branch 	= DB::connection('ts3')->table('auth.users')->where('id_role','5')->get();
     
		    $data = array(  'title'         => 'Edit Branch',
                            'area'          => $area,
                            'branch'        => $branch,
                            'userbranch'      => $user_branch,
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

    public function getBranch(Request $request)
    {
        if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}

        
        if ($request->ajax()) {
        $branch 	= DB::connection('ts3')->table('mst.v_branch')->get();
        return DataTables::of($branch)->addColumn('action', function($row){
               $btn = '<div class="btn-group">
               <a href="'. asset('admin-ts3/branch/edit/'.$row->id).'" 
                 class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>
               <a href="'. asset('admin-ts3/branch/delete/'.$row->id).'" class="btn btn-danger btn-sm  delete-link">
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




}

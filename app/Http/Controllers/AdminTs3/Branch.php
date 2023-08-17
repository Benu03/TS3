<?php
namespace App\Http\Controllers\AdminTs3;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Image;
use DataTables;
use Log;
use App\Exports\AdminTs3\BranchExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Branch_model;
use App\Imports\BranchTempImport;
use Storage;
use Illuminate\Support\Facades\File;

class Branch extends Controller
{
    // Index
    public function index()
    {
    	if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
      
        // $branch 	= DB::connection('ts3')->table('mst.v_branch')->get();
        // $area 	= DB::connection('ts3')->table('mst.v_area')->get();
        $client 	= DB::connection('ts3')->table('mst.v_client_product')->where('client_type','B2B')->get();
       




		$data = array(  'title'     => 'Branch',
                        // 'area'      => $area,
                         'client'      => $client,
                        // 'userbranch'      => $user_branch,
                        'content'   => 'admin-ts3/branch/index'
                    );
        
        return view('admin-ts3/layout/wrapper',$data);
    }


    

    public function get_area_client()
    {

        if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }

        $client = $_POST['client'];
        log::info($client);

        $area = DB::connection('ts3')->table('mst.v_area')->where('client_name',$client)->pluck('id', 'area_slug');
       

        return response()->json($area);
     
    }

    public function get_pic_client()
    {

        if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }

        $client = $_POST['client'];
        log::info($client);

        $pic = DB::connection('ts3')->table('auth.v_list_user_client')
                ->where('is_active',1)
                ->where('entity',$client)
                ->where('role','pic_client')
                ->pluck('username','nama');
    
        return response()->json($pic);
     
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
        Log::info($id);
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
               <a href="'. asset('admin-ts3/branch/delete/'.$row->id).'"  class="btn btn-danger btn-sm">
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
        return Excel::download(new BranchExport, 'BRANCH-MVM.xlsx');
    }



    
    public function template_upload_branch()
    {
        if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }
    
        $file_path = storage_path('data/template/BRANCH_LIST_TEMPLATE.xlsx');
        return response()->download($file_path);
    }


    

    public function upload_branch_proses(Request $request)
    {
        if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}

        request()->validate([
            'branch'   => 'file|mimes:xlsx,xls|max:5120|required',
            ]);

            $branch_file       = $request->file('branch');

            dd($branch_file);

            try
            {
                DB::connection('ts3')->beginTransaction();
                $nama_file = date("ymd_s").'_'.$branch_file->getClientOriginalName();
                $dir_file =storage_path('data/branch/'.date("Y").'/'.date("m").'/');
                // $DirFile ='data/spk/';
                if (!file_exists($dir_file)) {
                File::makeDirectory($dir_file,0777,true);
                }

                Log::info('done upload '.$nama_file);

                Excel::import(new BranchTempImport(), $branch_file);
                $branch_file->move($dir_file,$nama_file);

                DB::connection('ts3')->commit();
            }
            catch (\Exception $e) {
                DB::connection('ts3')->rollback();
                return redirect('admin-ts3/branch')->with(['warning' => $e]);
            }    

            $return =  $this->postingBranch($username = Session()->get('username')); 


            return redirect('admin-ts3/branch')->with(['sukses' => 'File berhasil Di Upload, mohon Untuk Di Review']);  
    }

    public function postingBranch($username)
    {
     

    }



}

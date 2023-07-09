<?php
namespace App\Http\Controllers\AdminTs3;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Image;
use DataTables;
use Log;
use App\Exports\AdminTs3\AreaExport;
use Maatwebsite\Excel\Facades\Excel;


class Area extends Controller
{
    // Index
    public function index()
    {
    	if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
      
        // $area 	= DB::connection('ts3')->table('mst.v_area')->get();
        $regional 	= DB::connection('ts3')->table('mst.v_regional')->get();

		$data = array(  'title'     => 'Area',
                        // 'area'      => $area,
                        'regional'      => $regional,
                        'content'   => 'admin-ts3/area/index'
                    );
        
        return view('admin-ts3/layout/wrapper',$data);
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
        return redirect('admin-ts3/area')->with(['sukses' => 'Data telah ditambah']);
    }

   
    public function edit($id)
    {
            if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
        
            $area 	= DB::connection('ts3')->table('mst.v_area')->where('id',$id)->first();
            $regional 	= DB::connection('ts3')->table('mst.v_regional')->get();

           
           
		    $data = array(  'title'         => 'Edit area',
                            'area'          => $area,
                            'regional'        => $regional,
                            'content'       => 'admin-ts3/area/edit'
                    );
        
             return view('admin-ts3/layout/wrapper',$data);
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
        return redirect('admin-ts3/area')->with(['sukses' => 'Data telah diupdate']);                                             
    }

  
    public function delete($id)
    {
    	if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
     
        DB::connection('ts3')->table('mst.mst_area')->where('id',$id)->delete();
        return redirect('admin-ts3/area')->with(['sukses' => 'Data telah dihapus']);
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
        
            return redirect('admin-ts3/area')->with(['sukses' => 'Data telah dihapus']);
        // PROSES SETTING DRAFT
        }
    }


    public function getArea(Request $request)
    {
        if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}

        
        if ($request->ajax()) {
        $area 	= DB::connection('ts3')->table('mst.v_area')->get();
        return DataTables::of($area)->addColumn('action', function($row){
               $btn = '<div class="btn-group">
               <a href="'. asset('admin-ts3/area/edit/'.$row->id).'" 
                 class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>
               <a href="'. asset('admin-ts3/area/delete/'.$row->id).'" class="btn btn-danger btn-sm  delete-link">
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
        return Excel::download(new AreaExport, 'AREA-MVM.xlsx');
    }
    


}

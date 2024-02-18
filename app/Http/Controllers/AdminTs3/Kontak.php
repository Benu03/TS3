<?php

namespace App\Http\Controllers\AdminTs3;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Pagination\Paginator;
use Image;
use App\Models\Kontak_model;
use DataTables;
use Log;

class Kontak extends Controller
{
    // Main page
    public function index()
    {
    	if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
       
		$kontak 	=  DB::connection('ts3')->table('cp.kategori')->orderBy('urutan','ASC')->get();

		$data = array(  'title'       => 'Kontak',
						'kontak'    => $kontak,
                        'content'     => 'admin-ts3/kontak/index'
                    );
        return view('admin-ts3/layout/wrapper',$data);
    }


    public function getKontak(Request $request)
    {
        if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}

        
        if ($request->ajax()) {
        $area 	= DB::connection('ts3')->table('cp.kontak')->where('is_reply',false)->get();
        return DataTables::of($area)->addColumn('action', function($row){
               $btn = '<div class="btn-group">
               <a href="'. asset('admin-ts3/kontak/reply/'.$row->id).'" 
                 class="btn btn-warning btn-sm"><i class="fa fa-reply"></i></a>
               <a href="'. asset('admin-ts3/kontak/view/'.$row->id).'" class="btn btn-success btn-sm">
                    <i class="fa fa-eye"></i></a>
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

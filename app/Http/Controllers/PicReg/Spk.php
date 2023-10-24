<?php

namespace App\Http\Controllers\PicReg;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Konfigurasi_model;
use Image;
use PDF;
use DataTables;
use Log;

class Spk extends Controller
{


    public function spk_status()
    {
        if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }

        $user_branch = DB::connection('ts3')->table('mst.v_branch')->where('pic_branch',Session()->get('username'))->get();

        $branch_id = [];

        foreach($user_branch  as $key => $val){
            $regional[] = $val->regional;
        }
    
        $waiting = DB::connection('ts3')->table('mvm.v_spk_status_pic')->wherein('regional',$regional)->where('status','WAITING')->count();
        $onprogress = DB::connection('ts3')->table('mvm.v_spk_status_pic')->wherein('regional',$regional)->where('status','ONPROGRESS')->count();
        $spk = DB::connection('ts3')->table('mvm.v_spk_status_pic')->wherein('regional',$regional)->get();

		$data = array(   'title'     => 'SPK Status',
                            'waiting'      => $waiting,
                            'onprogress'      => $onprogress,
                            'spk'      => $spk,
                        'content'   => 'pic-regional/spk/spk_status'
                    );
        return view('pic-regional/layout/wrapper',$data);
    }



       
    public function spk_file($file_name)
    {
        if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }
        

        $spk = DB::connection('ts3')->table('mvm.mvm_spk_h')->where('nama_file',$file_name)->first();
        $file_path = $spk->path_file.$file_name;
        return response()->download($file_path);


    }

    public function spk_history()
    {
        if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }
    
        // $spk_history = DB::connection('ts3')->table('mst.v_regional')->get();

		$data = array(   'title'     => 'SPK History',
                        //  'spk_history'      => $spk_history,
                        'content'   => 'pic-regional/spk/spk_history'
                    );
        return view('pic-regional/layout/wrapper',$data);
    }

   
    public function getSPKHistory(Request $request)
    {
        if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
        if ($request->ajax()) {

            $user_branch = DB::connection('ts3')->table('mst.v_branch')->where('pic_branch',Session()->get('username'))->get();

            $branch_id = [];
    
            foreach($user_branch  as $key => $val){
                $regional[] = $val->regional;
            }
           
            if(!empty($request->from_date)) {

                $service 	= DB::connection('ts3')->table('mvm.v_spk_status_pic')->wherein('regional',$regional)
                ->whereBetween('posting_date', array($request->from_date, $request->to_date))->get();

            } else {
            $service 	= DB::connection('ts3')->table('mvm.v_spk_status_pic')->wherein('regional',$regional)->get();
            }


        return DataTables::of($service)->addColumn('file', function($row){
               $btn = '<a href="'. asset('pic-regional/spk-file/'.$row->nama_file).'" 
               class="btn btn-success btn-sm" ><i class="fa fa-file"></i></a>';
                return $btn;
                })
        ->rawColumns(['file'])->make(true);
       
        }

    }

}

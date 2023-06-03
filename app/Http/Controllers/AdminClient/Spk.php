<?php

namespace App\Http\Controllers\AdminClient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Konfigurasi_model;
use Image;
use Illuminate\Support\Facades\File;
use PDF;
use App\Imports\SPKTempImport;
use Maatwebsite\Excel\Facades\Excel;
use Log;
use Storage;



class Spk extends Controller
{


    // Index
    public function index()
    {
        if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }

        $spk_detail = DB::connection('ts3')->table('mvm.v_temp_spk_h')->where('user_upload', Session()->get('username'))->get();
       
       
        if(count($spk_detail) > 0)
        {
            $result = json_decode(json_encode($spk_detail), true);
            $spk_seq  = $result[0]['spk_seq']; 
            return redirect('admin-client/spk-temp-detail/'.$spk_seq)->with(['sukses' => 'File berhasil Di Upload, mohon Untuk Di Review']);  
        }
        else
        {
            $spk = DB::connection('ts3')->table('mvm.mvm_spk_h')->get();
                
            $data = array(   'title'     => 'SPK Proses',
                            'spk'      => $spk,
                            'content'   => 'admin-client/spk/index'
                        );
            return view('admin-client/layout/wrapper',$data);
        }
    }



    public function template_upload()
    {
        if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }
    
        $file_path = storage_path('data/template/SPK_LIST_TEMPLATE.xlsx');
        return response()->download($file_path);
    }

    public function spk_upload(Request $request)
    {

        if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
    	request()->validate([
                            'spk_no'     => 'required',
                            'count_vehicle' => 'required',
					        'tanggal_pengerjaan' => 'required',
                            'tanggal_last_spk' => 'required',
                            'spk_file'   => 'file|mimes:xlsx,xls|max:5120|required',
					        ]);

        $spk_file       = $request->file('spk_file');

        $nama_file = date("ymd_s").'_'.$spk_file->getClientOriginalName();
 
        $dir_file =storage_path('data/spk/'.date("Y").'/'.date("m").'/');
        // $DirFile ='data/spk/';
        if (!file_exists($dir_file)) {
          File::makeDirectory($dir_file,0777,true);
          }
        
        // File::put($dir_file.$nama_file, $spk_file); 
       

        // Storage::putFile($dir_file,$request->file('spk_file'));


        Log::info('done upload '.$nama_file);
        $userclient = DB::connection('ts3')->table('mst.v_user_client')->where('username', Session()->get('username'))->first();
        Excel::import(new SPKTempImport(), $spk_file);

        $spk_file->move($dir_file,$nama_file);
       

        $spk_seq = $userclient->client_name.'-'.date("his");
        DB::connection('ts3')->table('mvm.mvm_temp_spk')->where('user_upload',Session()->get('username'))->update([
            'spk_seq'               => $spk_seq,
            'mst_client_id'         => $userclient->mst_client_id,
            'spk_no'	            => $request->spk_no,
            'count_vehicle'	        => $request->count_vehicle,
            'tanggal_pengerjaan'    => $request->tanggal_pengerjaan,
            'tanggal_last_spk'      => $request->tanggal_last_spk,
            'status'	            => 'REVIEW',
            'upload_date'	        => date("Y-m-d h:i:sa"),
            'nama_file'             => $nama_file,
            'path_file'             =>  $dir_file
            
        ]);  

        return redirect('admin-client/spk-temp-detail/'.$spk_seq)->with(['sukses' => 'File berhasil Di Upload, mohon Untuk Di Review']);  

    }

    public function spk_temp_detail($spk_seq)
    {
        if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }

        $spk_detail = DB::connection('ts3')->table('mvm.v_temp_spk_h')->where('user_upload', Session()->get('username'))->get();
       
       
        if(count($spk_detail) == 0)
        {           
            return redirect('admin-client/spk')->with(['sukses' => 'File berhasil Di Upload, Tidak ada']);  
        }
        $spk = DB::connection('ts3')->table('mvm.v_temp_spk_h')->where('spk_seq', $spk_seq)->first();
        $spk_detail = DB::connection('ts3')->table('mvm.mvm_temp_spk')->where('spk_seq', $spk_seq)->get();
		       
		$data = array(   'title'     => 'SPK Review',
                         'spk'      => $spk,
                         'spk_detail'      => $spk_detail,
                        'content'   => 'admin-client/spk/spk_review'
                    );
        return view('admin-client/layout/wrapper',$data);
    }

    public function spk_temp_reset($spk_seq)
    {
        if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }

        $spk = DB::connection('ts3')->table('mvm.v_temp_spk_h')->where('spk_seq', $spk_seq)->first();
          
        if(File::exists($spk->path_file.$spk->nama_file)){
            File::delete($spk->path_file.$spk->nama_file);
        }else{
            return redirect('admin-client/spk')->with(['sukses' => 'File does not exists.']);  
        }

        DB::connection('ts3')->table('mvm.mvm_temp_spk')->where('spk_seq',$spk_seq)->where('user_upload',Session()->get('username'))->delete();


        return redirect('admin-client/spk')->with(['sukses' => 'Data Upload Berhasil Di Hapus']);  

    }
    
    public function spk_posting($spk_seq)
    {

        if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }
       
        $spk_detail_temp_h = DB::connection('ts3')->table('mvm.v_temp_spk_h')->where('spk_seq', $spk_seq)->first();
               

        $checkvehicle =  DB::connection('ts3')->table('mvm.v_check_vehicle_posting')->where('spk_seq',$spk_seq)->whereNull('nopol')->get(); 
        $checkbranch =  DB::connection('ts3')->table('mvm.v_check_branch_posting')->where('spk_seq',$spk_seq)->whereNull('branch')->get();
        if(count($checkvehicle) > 0)
        {
            return redirect('admin-client/spk-temp-detail/'.$spk_detail_temp_h->spk_seq)->with(['warning' => 'Data Vehicle Belum Terdaftar']);  
        }
        else
        {
            if(count($checkbranch) > 0)
            {

                return redirect('admin-client/spk-temp-detail/'.$spk_detail_temp_h->spk_seq)->with(['warning' => 'Data Cabang Belum Terdaftar']);  
            }
            else
            {   
                DB::connection('ts3')->table('mvm.mvm_spk_h')->insert([
                'spk_seq'   => $spk_seq,
                'spk_no'	=> $spk_detail_temp_h->spk_no,
                'count_vehicle'	=> $spk_detail_temp_h->count_vehicle,
                'tanggal_pengerjaan'	=> $spk_detail_temp_h->tanggal_pengerjaan,
                'tanggal_last_spk'	=> $spk_detail_temp_h->tanggal_last_spk,
                'status'	=> 'WAITING',
                'upload_date'	=> $spk_detail_temp_h->upload_date,
                'user_upload'	=> $spk_detail_temp_h->user_upload,
                'user_posting'     => Session()->get('username'),
                'posting_date'    => date("Y-m-d h:i:sa"),
                'nama_file'    =>  $spk_detail_temp_h->nama_file,
                'mst_client_id' => $spk_detail_temp_h->mst_client_id,
                'path_file' => $spk_detail_temp_h->path_file
                ]);

                $spk_detail_temp_d = DB::connection('ts3')->table('mvm.mvm_temp_spk')->where('spk_seq', $spk_seq)->get();

                foreach($spk_detail_temp_d as $x => $val) {
                    $resultArray = json_decode(json_encode($val), true);
                    
                    $branch_id = DB::connection('ts3')->table('mst.v_branch')->where('branch', $resultArray['branch'])->first();
                
                    try {
                        $serviceType = DB::connection('ts3')->table('mst.mst_general')->where('id', 13)->first();
                        if(isset($branch_id)){
                            DB::connection('ts3')->table('mvm.mvm_spk_d')->insert([
                            'spk_seq'   => $spk_seq,
                            'spk_no'	=> $spk_detail_temp_h->spk_no,
                            'nopol'	    => $resultArray['nopol'],
                            'mst_branch_id'	=> $branch_id->id,
                            'status_service'	=> 'PLANING',
                            'remark'        => $resultArray['remark'],
                            'created_date'     => date("Y-m-d h:i:sa"),
                            'create_by'     => Session()->get('username'),
                            'source'        => $serviceType->value_1
                            ]); 
                        }
                    
                    } catch (\Exception $e) {
                        DB::connection('ts3')->table('mvm.mvm_spk_h')->where('spk_seq',$spk_seq)->where('user_upload',Session()->get('username'))->delete();  
                        DB::connection('ts3')->table('mvm.mvm_spk_d')->where('spk_seq',$spk_seq)->delete();  
                        return $e->getMessage();
                    }

                }    
                DB::connection('ts3')->table('mvm.mvm_temp_spk')->where('spk_seq',$spk_seq)->where('user_upload',Session()->get('username'))->delete();
                return redirect('admin-client/spk')->with(['sukses' => 'Posting Data Upload Berhasil']);  
            }

        }
    }

    public function spk_detail($spk_seq)
    {
        if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }


        $spk_h = DB::connection('ts3')->table('mvm.mvm_spk_h')->where('spk_seq',$spk_seq)->first();
        $spk_d = DB::connection('ts3')->table('mvm.v_spk_detail')->where('spk_seq',$spk_seq)->get();
                
        $data = array(   'title'     => 'SPK Detail',
                        'spk_h'      => $spk_h,
                        'spk_d'      => $spk_d,
                        'content'   => 'admin-client/spk/spk_detail'
                    );
        return view('admin-client/layout/wrapper',$data);
    }




   
}

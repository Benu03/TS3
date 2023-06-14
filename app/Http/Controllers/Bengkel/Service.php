<?php

namespace App\Http\Controllers\Bengkel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Konfigurasi_model;
use Image;
use Illuminate\Support\Facades\File;
use PDF;

class Service extends Controller
{




    public function index()
    {
        if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }
    
        $bengkel 	= DB::connection('ts3')->table('mst.mst_bengkel')->where('pic_bengkel',Session()->get('username'))->first();

        $countservice = DB::connection('ts3')->table('mvm.v_spk_detail')->where('spk_status','ONPROGRESS')->wherein('status_service',['ONSCHEDULE'])
        ->where('mst_bengkel_id',$bengkel->id)->count();
        $service = DB::connection('ts3')->table('mvm.v_spk_detail')->where('spk_status','ONPROGRESS')
        ->wherein('status_service',['ONSCHEDULE'])->where('mst_bengkel_id',$bengkel->id)->orderByRaw('tanggal_schedule')->get();

		$data = array(   'title'     => 'List Service',
                         'countservice'      => $countservice,
                         'service'      => $service,
                        'content'   => 'bengkel/service/list_service'
                    );
        return view('bengkel/layout/wrapper',$data);
    }

   
    public function direct_service()
    {
        if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }
    
        $bengkel 	= DB::connection('ts3')->table('mst.mst_bengkel')->where('pic_bengkel',Session()->get('username'))->first();
        $countdirect = DB::connection('ts3')->table('mvm.v_service_direct')->where('mst_bengkel_id',$bengkel->id)->where('status','ESTIMATE')->count();
  
        $direct = DB::connection('ts3')->table('mvm.v_service_direct')->where('mst_bengkel_id',$bengkel->id)->where('status','ESTIMATE')->get();
       
		$data = array(   'title'     => 'Direct Service',
                         'direct'      => $direct,
                         'countdirect'      => $countdirect,
                        'content'   => 'bengkel/service/direct_service'
                    );
        return view('bengkel/layout/wrapper',$data);
    }

  

    public function service_proses_page($id)
    {
        if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}

        $bengkel 	= DB::connection('ts3')->table('mst.mst_bengkel')->where('pic_bengkel',Session()->get('username'))->first();
        $service = DB::connection('ts3')->table('mvm.v_spk_detail')->where('spk_status','ONPROGRESS')->wherein('status_service',['ONSCHEDULE'])->where('mst_bengkel_id',$bengkel->id)->where('mst_bengkel_id',$bengkel->id)->where('id',$id)->first();
        $part 	= DB::connection('ts3')->table('mst.mst_spare_part')->orderby('id')->get();
        $jobs 	= DB::connection('ts3')->table('mst.mst_pekerjaan')->where('group_vehicle','Motor')->orderby('id')->get();
      
 
        $data = array(   'title'     => 'Service '.$service->nopol,
                         'service'      => $service,
                         'part'      => $part,
                         'jobs'      => $jobs,
                        'content'   => 'bengkel/service/service_proses_page'
                    );
        return view('bengkel/layout/wrapper',$data);
    }
    

    public function service_proses(Request $request)
    {
        if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
        request()->validate([
            'tanggal_service' => 'required',
            'nama_stnk'     => 'required',
            'nama_driver' 	   => 'required',
            'last_km' 	   => 'required',
            'mekanik' 	   => 'required',
            ]);

        $service_no = 'MVM-'.$request->nopol.'-'.date("Ymd");
        $bengkel 	= DB::connection('ts3')->table('mst.mst_bengkel')->where('pic_bengkel',Session()->get('username'))->first();

        try {
          $service_id =   DB::connection('ts3')->table('mvm.mvm_service_vehicle_h')->insertGetId([
                'mvm_spk_d_id'   => $request->id,
                'tanggal_service'	=> $request->tanggal_service,
                'nama_driver'	=> $request->nama_driver,
                'last_km'	=> $request->last_km,
                'mekanik'	=> $request->mekanik,
                'created_date'    => date("Y-m-d h:i:sa"),
                'user_created'     => $request->session()->get('username'),
                'service_no'	=> $service_no,
                'remark_driver' => $request->remark_driver,
                'pic_branch' => $request->pic_branch
            ]); 

           
 


            foreach($request->jobs as $key => $val){
                $datajobs = [
                    'mvm_service_vehicle_h_id' => $service_id,
                    'detail_type' => 'Pekerjaan',
                    'unique_data' => $val,
                    'value_data' => $request->value_jobs[$key],
                    'source'    => 'mst_pekerjaan',
                    'created_date'    => date("Y-m-d h:i:sa"),
                    'user_created'     => $request->session()->get('username')
                ];

                DB::connection('ts3')->table('mvm.mvm_service_vehicle_d')->insert($datajobs);
            }

            foreach($request->part as $key => $val){
                $datapart = [
                    'mvm_service_vehicle_h_id' => $service_id,
                    'detail_type' => 'Spare Part',
                    'unique_data' => $val,
                    'value_data' => $request->value_part[$key],
                    'source'    => 'mst_spare_part',
                    'created_date'    => date("Y-m-d h:i:sa"),
                    'user_created'     => $request->session()->get('username')
                ];
                DB::connection('ts3')->table('mvm.mvm_service_vehicle_d')->insert($datapart);
            }


            foreach($request->upload as $key => $val){

                $image  = $request->file('upload')[$key];
                $filename = $service_no.'-'.$key.'.jpg';
                $destinationPath =storage_path('data/service/'.date("Y").'/'.date("m").'/').$service_no;
                
                if (!file_exists($destinationPath)) {
                File::makeDirectory($destinationPath,0755,true);
                }
                $img = Image::make($image->path());
                $img->resize(850, 850, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($destinationPath.'/'.$filename);


                $dataupload = [
                    'mvm_service_vehicle_h_id' => $service_id,
                    'detail_type' => 'Upload',
                    'unique_data' => $filename,
                    'value_data' => $request->value_upload[$key],
                    'source'    => $destinationPath,
                    'created_date'    => date("Y-m-d h:i:sa"),
                    'user_created'     => $request->session()->get('username')
                ];
                DB::connection('ts3')->table('mvm.mvm_service_vehicle_d')->insert($dataupload);
            }
         

            DB::connection('ts3')->table('mvm.mvm_spk_d')->where('id',$request->id)->update([
                'tanggal_service'	=> $request->tanggal_service,
                'status_service'   => 'SERVICE',
                'updated_at'    => date("Y-m-d h:i:sa"),
                'update_by'     => $request->session()->get('username')
            ]);  
            
            DB::connection('ts3')->table('mst.mst_vehicle')->where('nopol',$request->nopol)->update([
                'tgl_last_service'   => $request->tanggal_service,
                'nama_stnk'   => $request->nama_stnk,
                'last_km'   =>  $request->last_km,
                'updated_at'    => date("Y-m-d h:i:sa"),
                'update_by'     => $request->session()->get('username')
            ]); 

            $datahis = [
                'mvm_service_vehicle_h_id' => $service_id,
                'mst_bengkel_id' => $bengkel->id,
                'pic_branch' => $request->pic_branch
            ];
            DB::connection('ts3')->table('mvm.mvm_service_history')->insert($datahis);

            DB::commit();
        }
        catch (\Illuminate\Database\QueryException $e) {
            DB::rollback();
            return redirect('bengkel/list-service')->with(['warning' => $e]);
        }


        return redirect('bengkel/list-service')->with(['sukses' => 'Data Berhasil Di Kirim']);



    }


    public function get_image_direct($id)
    {
        if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }
        $direct = DB::connection('ts3')->table('mvm.v_service_direct')->where('id',$id)->first();

       
        $storagePath =  $direct->path_foto.$direct->foto_kendaraan;
        return response()->file($storagePath);

    }

    public function direct_service_estimate($id)
    {
        if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }

        $direct = DB::connection('ts3')->table('mvm.v_service_direct')->where('id',$id)->first();
    
        $part 	= DB::connection('ts3')->table('mst.mst_spare_part')->orderby('id')->get();
        $jobs 	= DB::connection('ts3')->table('mst.mst_pekerjaan')->where('group_vehicle','Motor')->orderby('id')->get();

        $data = array(   'title'     => 'Direct Service Estimate '. $direct->nopol,
                         'direct'     => $direct,
                         'part'      => $part,
                         'jobs'      => $jobs,
                        'content'   => 'bengkel/service/direct_service_estimate'
                    );
        return view('bengkel/layout/wrapper',$data);


    }
    

    public function history_service()
    {
        if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }
    
        $bengkel 	= DB::connection('ts3')->table('mst.mst_bengkel')->where('pic_bengkel',Session()->get('username'))->first();
        $history = DB::connection('ts3')->table('mvm.v_service_history')->where('mst_bengkel_id',$bengkel->id)->get();

		$data = array(   'title'     => 'History Service',
                         'history'      => $history,
                        'content'   => 'bengkel/service/history_service'
                    );
        return view('bengkel/layout/wrapper',$data);


    }


    public function get_image_service_detail($id)
    {
        if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }

        $image = DB::connection('ts3')->table('mvm.mvm_service_vehicle_d')->where('unique_data',$id)->first();

        $service = DB::connection('ts3')->table('mvm.mvm_service_vehicle_h')->where('id',$image->mvm_service_vehicle_h_id)->first();
        
        $storagePath =   $image->source.'/'.$image->unique_data;

        if(!file_exists($storagePath))
        return redirect('pic/list-service')->with(['warning' => 'Fila Tidak Di temukan']);
        
        else{
            return response()->file($storagePath);
        }

    }  


  

   
}

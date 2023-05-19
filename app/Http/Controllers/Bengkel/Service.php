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
    
        $nopol = DB::connection('ts3')->table('mst.v_vehicle')->get();

		$data = array(   'title'     => 'Direct Service',
                         'nopol'      => $nopol,
                        'content'   => 'bengkel/service/direct_service'
                    );
        return view('bengkel/layout/wrapper',$data);
    }

    public function history_service()
    {
        if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }
    
        $nopol = DB::connection('ts3')->table('mst.v_vehicle')->get();

		$data = array(   'title'     => 'History Service',
                         'nopol'      => $nopol,
                        'content'   => 'bengkel/service/history_service'
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

        try {
          $service_id =   DB::connection('ts3')->table('mvm.mvm_service_vehicle_h')->insertGetId([
                'mvm_spk_d_id'   => $request->id,
                'tanggal_service'	=> $request->tanggal_service,
                'nama_driver'	=> $request->nama_driver,
                'last_km'	=> $request->last_km,
                'mekanik'	=> $request->mekanik,
                'created_date'    => date("Y-m-d h:i:sa"),
                'user_created'     => $request->session()->get('username'),
                'service_no'	=> $service_no
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
                $destinationPath =storage_path('data/service/').$service_no;
                
                if (!file_exists($destinationPath)) {
                File::makeDirectory($destinationPath,0755,true);
                }
                $img = Image::make($image->path());
                $img->resize(500, 500, function ($constraint) {
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


        }
        catch (\Exception $e) { 
            return $e->getMessage();
        }


        return redirect('bengkel/list-service')->with(['sukses' => 'Data Berhasil Di Kirim']);





    }
    




  

   
}

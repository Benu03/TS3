<?php

namespace App\Http\Controllers\Bengkel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Konfigurasi_model;
use Image;
use Illuminate\Support\Facades\File;
use PDF;
use Log;

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
        $part 	= DB::connection('ts3')->table('mst.v_service_item_motor')->where('price_service_type','Part')->where('mst_regional_id',$service->mst_regional_id)->where('mst_client_id',$service->mst_client_id)->get();
        $jobs 	=  DB::connection('ts3')->table('mst.v_service_item_motor')->where('price_service_type','Jasa')->where('mst_regional_id',$service->mst_regional_id)->where('mst_client_id',$service->mst_client_id)->get();
        
        $gps = DB::connection('ts3')->table('mst.mst_vehicle_gps')->where('nopol',$service->nopol)->first();
 
        $data = array(   'title'     => 'Service '.$service->nopol,
                         'service'      => $service,
                         'part'      => $part,
                         'jobs'      => $jobs,
                         'gps'      => $gps,

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
            DB::beginTransaction();
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

           
        
                // Mengolah pekerjaan_data
            foreach ($request->pekerjaan_data as $data) {
                // Mengurai data JSON
                $parsedData = json_decode($data, true);
                
                $datajobs = [
                    'mvm_service_vehicle_h_id' => $service_id,
                    'detail_type' => 'Pekerjaan',
                    'unique_data' => $parsedData['id'],
                    'value_data' => $parsedData['remark'],
                    'source' => 'mst_price_service (Jasa)',
                    'created_date' => date("Y-m-d H:i:s"), // Menggunakan H untuk jam 24-jam
                    'user_created' => $request->session()->get('username')
                ];

                // Menyimpan data pekerjaan ke database
                DB::connection('ts3')->table('mvm.mvm_service_vehicle_d')->insert($datajobs);
            }


            foreach ($request->part_data as $key => $data) {

                $parsedData = json_decode($data, true);
                
    
                $datapart = [
                    'mvm_service_vehicle_h_id' => $service_id,
                    'detail_type' => 'Spare Part',
                    'unique_data' => $parsedData['id'], // Mengambil ID dari JSON
                    'value_data' =>  $parsedData['remark'], // Mengambil nilai part berdasarkan key
                    'source' => 'mst_price_service (Part)',
                    'created_date' => date("Y-m-d H:i:s"), // Menggunakan H untuk jam 24-jam
                    'user_created' => $request->session()->get('username')
                ];


                DB::connection('ts3')->table('mvm.mvm_service_vehicle_d')->insert($datapart);
            }

            $uploadedFilenames = [];

            foreach($request->upload_data as $key => $data){

                $destinationPath =storage_path('data/service/'.date("Y").'/'.date("m").'/').$service_no;
                $parsedData = json_decode($data, true);
                
                $uploadedFilenames[] = $parsedData['filename'];
                $dataupload = [
                    'mvm_service_vehicle_h_id' => $service_id,
                    'detail_type' => 'Upload',
                    'unique_data' => $parsedData['filename'],
                    'value_data' => $parsedData['remark'],
                    'source'    => $destinationPath,
                    'created_date'    => date("Y-m-d h:i:sa"),
                    'user_created'     => $request->session()->get('username')
                ];
                DB::connection('ts3')->table('mvm.mvm_service_vehicle_d')->insert($dataupload);
            }

            $allFiles = File::files($destinationPath);

            foreach ($allFiles as $file) {
                if (!in_array($file->getFilename(), $uploadedFilenames)) {
                    File::delete($file->getPathname());
                }
            }

            $allFiles = File::files($destinationPath);

            foreach ($allFiles as $file) {
                if (!in_array($file->getFilename(), $uploadedFilenames)) {
                    File::delete($file->getPathname());
                }
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


            DB::connection('ts3')->table('mvm.mvm_gps_process')->where('nopol',$request->nopol)->where('status','pemasangan')->whereNull('service_no')->update([
                'status' => 'service',
                'service_no' => $service_no
              
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


    public function upload_file(Request $request)
    {
        $request->validate([
            'file' => 'required|array',
            'file.*' => 'required|mimes:jpg,png,mp4|max:20480', // Max size in kilobytes (20MB)
            'remark' => 'required|string',
        ]);
    
        $service_no = 'MVM-' . $request->nopol . '-' . date("Ymd");
        $uploadedFiles = [];

        foreach ($request->file('file') as $file) {
            $key = time(); 
            $filename = $service_no . '-' . $key . '.' . $file->getClientOriginalExtension();
            $destinationPath = storage_path('data/service/' . date("Y") . '/' . date("m") . '/' . $service_no);
      
            
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }
    
            $file->move($destinationPath, $filename);
            $uploadedFiles[] = [
                'filename' => $filename,
                'remark' => $request->remark,
            ];
        }
    
        return response()->json([
            'success' => true,
            'message' => 'Files uploaded successfully!',
            'data' => $uploadedFiles,
        ]);
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

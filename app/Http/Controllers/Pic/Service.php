<?php

namespace App\Http\Controllers\Pic;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Konfigurasi_model;
use Image;
use PDF;
use Log;

class Service extends Controller
{


    // Index
    public function index()
    {
        if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }
        
        $user_branch = DB::connection('ts3')->table('mst.v_branch')->where('pic_branch',Session()->get('username'))->get();
        $branch_id = [];

        foreach($user_branch  as $key => $val){
            $branch_id[] = $val->id;
        }


        $countservice = DB::connection('ts3')->table('mvm.v_service_pic_branch')->wherein('mst_branch_id',$branch_id )->where('status_service','SERVICE')->count();
        $service = DB::connection('ts3')->table('mvm.v_service_pic_branch')->wherein('mst_branch_id',$branch_id )->get();

		$data = array(   'title'     => 'List Service',
                         'service'      => $service,
                         'countservice' => $countservice,
                        'content'   => 'pic/service/index'
                    );
        return view('pic/layout/wrapper',$data);
    }

    public function direct()
    {
        if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }
    
        $userclient = DB::connection('ts3')->table('mst.v_user_client')->where('username', Session()->get('username'))->first();
        $nopol = DB::connection('ts3')->table('mst.v_vehicle')->where('client_name',$userclient->client_name)->get();
        $branch = DB::connection('ts3')->table('mst.v_branch_client')->where('pic_branch',Session()->get('username'))->get();

        $mst_branch_id = [];

        foreach($branch  as $key => $val){
            $mst_branch_id[] = $val->id;
        }


        $direct = DB::connection('ts3')->table('mvm.v_service_direct')->whereIn('mst_branch_id',$mst_branch_id)->get();
        
		$data = array(   'title'     => 'Direct Service',
                         'nopol'      => $nopol,
                         'branch'      => $branch,
                         'direct'      => $direct,
                        'content'   => 'pic/service/direct'
                    );
        return view('pic/layout/wrapper',$data);
    }



    public function history_service()
    {
        if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }
    
        $invoice = DB::connection('ts3')->table('mst.v_regional')->get();

		$data = array(   'title'     => 'History Service',
                         'invoice'      => $invoice,
                        'content'   => 'pic/service/history'
                    );
        return view('pic/layout/wrapper',$data);
    }

    public function service_remark(Request $request)
    {

        if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }
  
        if($request->id == null)
        {
            return redirect('pic/list-service')->with(['warning' => 'Data Tidak Ada Yang Di pilih']);
        }

        $id       = $request->id;


    
       
        for($i=0; $i < sizeof($id);$i++) {

            if($id[$i] == null)
            {
                return redirect('pic/list-service')->with(['warning' => 'Data Menunggu Proses Service Terlebih Dahulu']);
            }

            $id_spk_d =  DB::connection('ts3')->table('mvm.mvm_service_vehicle_h')->where('id',$id[$i])->first();


            DB::connection('ts3')->table('mvm.mvm_service_vehicle_h')->where('id',$id[$i])->update([
                'remark_pic_branch'   => $request->remark,
                'pic_branch_date_post'   => date("Y-m-d h:i:sa")          
                ]); 
                
            DB::connection('ts3')->table('mvm.mvm_spk_d')->where('id',$id_spk_d->mvm_spk_d_id)->update([
                    'status_service'   => 'ONINVOICE'             
                    ]);
   
        }

        return redirect('pic/list-service')->with(['sukses' => 'Data telah Proses']);

    }
    

    public function tambah_direct_service(Request $request)
    {
        if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }
        request()->validate([
            'nopol' => 'required',
            'mst_branch_id'     => 'required',
            'km' 	   => 'required',
            'tanggal_pengerjaan' 	   => 'required',
            'jenis_pekerjaan' 	   => 'required',
            'keluhan' 	   => 'required',
            'nama_driver' 	   => 'required',
            'kontak_driver' 	   => 'required',
            ]);

            $image   = $request->file('foto_kendaraan');
            if(!empty($image)) {

                $filename ='DRT-'.$request->nopol.date("s").'.jpg';
                $destinationPath =storage_path('data/direct/');
                
                if (!file_exists($destinationPath)) {
                File::makeDirectory($destinationPath,0755,true);
                }
                $img = Image::make($image->path());
                $img->resize(500, 500, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($destinationPath.'/'.$filename);

                

                $service_id =   DB::connection('ts3')->table('mvm.mvm_direct_service')->insert([
                    'nopol'   => $request->nopol,
                    'status'	=> 'REQUEST',
                    'mst_branch_id'	=> $request->mst_branch_id,
                    'km'	=> $request->km,
                    'tanggal_pengerjaan'	=> $request->tanggal_pengerjaan,
                    'jenis_pekerjaan'	=> $request->jenis_pekerjaan,
                    'keluhan'	=> $request->keluhan,
                    'nama_driver'	=> $request->nama_driver,
                    'kontak_driver'	=> $request->kontak_driver,
                    'foto_kendaraan'	=> $filename,
                    'path_foto'	=> $destinationPath,
                    'created_date'    => date("Y-m-d h:i:sa"),
                    'create_by'     => $request->session()->get('username'),
                    'service_type_mvm' => 'Direct',
    
                ]); 


            }
            else{

            $service_id =   DB::connection('ts3')->table('mvm.mvm_direct_service')->insert([
                'nopol'   => $request->nopol,
                'status'	=> 'REQUEST',
                'mst_branch_id'	=> $request->mst_branch_id,
                'km'	=> $request->km,
                'tanggal_pengerjaan'	=> $request->tanggal_pengerjaan,
                'jenis_pekerjaan'	=> $request->jenis_pekerjaan,
                'keluhan'	=> $request->keluhan,
                'nama_driver'	=> $request->nama_driver,
                'kontak_driver'	=> $request->kontak_driver,
                // 'foto_kendaraan'	=> $request->foto_kendaraan,
                'created_date'    => date("Y-m-d h:i:sa"),
                'create_by'     => $request->session()->get('username'),
                'service_type_mvm' => 'Direct',

            ]); 

        }

        

        return redirect('pic/direct-service')->with(['sukses' => 'Data telah Terkirim']);

    }

    public function get_image_direct($id)
    {
        if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }
        $direct = DB::connection('ts3')->table('mvm.v_service_direct')->where('id',$id)->first();

       
        $storagePath =  storage_path('data/direct/'). $direct->foto_kendaraan;
        return response()->file($storagePath);

    }
   

    public function get_vehicle(){

        if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }

        $nopol = $_POST['nopol'];
        log::info($nopol);

        $vehicel = DB::connection('ts3')->table('mst.v_vehicle')->where('nopol',$nopol)->first();  
        return response()->json($vehicel);
     
    }

    public function delete_direct_service($id)
    {
        if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }


        DB::connection('ts3')->table('mvm.mvm_direct_service')->where('id',$id)->delete();

        return redirect('pic/direct-service')->with(['sukses' => 'Data telah Di Hapus']);

    }

    

  

   
}

<?php

namespace App\Http\Controllers\AdminTs3;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Konfigurasi_model;
use PDF;
use DataTables;
use Log;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;


class Spk extends Controller
{




    public function spk_list()
    {
        if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }
        $countspkplan = DB::connection('ts3')->table('mvm.v_spk_detail')->where('spk_status','ONPROGRESS')->wherein('status_service',['PLANING'])->count();
        $countspkonchecldule = DB::connection('ts3')->table('mvm.v_spk_detail')->where('spk_status','ONPROGRESS')->wherein('status_service',['ONSCHEDULE'])->count();
        $countspkservice = DB::connection('ts3')->table('mvm.v_spk_detail')->where('spk_status','ONPROGRESS')->wherein('status_service',['SERVICE'])->count();


        $spkservice = DB::connection('ts3')->table('mvm.v_spk_detail')->where('spk_status','ONPROGRESS')
        ->wherein('status_service',['PLANING', 'ONSCHEDULE','SERVICE'])->orderByRaw('tanggal_schedule')->get();
        $bengkel 	= DB::connection('ts3')->table('mst.v_bengkel')->get();
		$data = array(   'title'     => 'SPK List Service',
                         'countspkplan'      => $countspkplan,
                         'countspkonchecldule'      => $countspkonchecldule,
                         'countspkservice'      => $countspkservice,
                         'spkservice'      => $spkservice,
                         'bengkel'  => $bengkel,
                        'content'   => 'admin-ts3/spk/spk_list'
                    );
        return view('admin-ts3/layout/wrapper',$data);
    }


    public function GetSpkList(Request $request)
    {
        
        if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}

        
        if ($request->ajax()) {
        $spkservice = DB::connection('ts3')->table('mvm.v_spk_detail')->where('spk_status','ONPROGRESS')
            ->wherein('status_service',['PLANING', 'ONSCHEDULE','SERVICE'])->orderByRaw('tanggal_schedule')->get();
        return DataTables::of($spkservice)->addColumn('action', function($row){
                if($row->status_service != 'SERVICE')
                {
                    $edit = '<a href="'. asset('admin-ts3/spk-service-edit/'.$row->id).'" 
                    class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>';       
                }
                elseif($row->status_service == 'SERVICE')
                {
                    $edit = '<a href="'. asset('admin-ts3/spk-service-adjustments/'.$row->id).'" 
                    class="btn btn-secondary btn-sm"><i class="fas fa-tools"></i></a>';  
                }
                else{
                    $edit ="";
                   
                }
                $view = '<button type="button" class="btn btn-success btn-sm spklistdetail" data-id="'. $row->id .'" data-toggle="modal">
                        <i class="fa fa-eye"></i> </button>';

          
               $btn = '<div class="btn-group">'.$edit.''.$view.' </div>';

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
    
    public function GetSpkListDetail($id)
    {
        if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}


        $spkservice = DB::connection('ts3')->table('mvm.v_spk_detail')->where('id',$id)->orderByRaw('tanggal_schedule')->first();

        return response()->json($spkservice);

    }
    
    public function spk_status()
    {
        if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }
    
        $waiting = DB::connection('ts3')->table('mvm.mvm_spk_h')->where('status','WAITING')->count();
        $onprogress = DB::connection('ts3')->table('mvm.mvm_spk_h')->where('status','ONPROGRESS')->count();
        $spk = DB::connection('ts3')->table('mvm.mvm_spk_h')->get();

		$data = array(   'title'     => 'SPK Status',
                            'waiting'      => $waiting,
                            'onprogress'      => $onprogress,
                            'spk'      => $spk,
                        'content'   => 'admin-ts3/spk/spk_status'
                    );
        return view('admin-ts3/layout/wrapper',$data);
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


    public function spk_proses(Request $request)
    {
        if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }
         request()->validate([
            'tanggal_proses' => 'required',
            'remark' 	   => 'required'
            ]);


            DB::connection('ts3')->table('mvm.mvm_spk_h')->where('spk_seq',$request->spk_seq)->update([
                'remark'   => $request->remark,
                'status'   => 'ONPROGRESS',
                'user_proses'	    => $request->session()->get('username'),
                'proses_date'    => $request->tanggal_proses
        
            ]);   

        return redirect('admin-ts3/spk-status')->with(['sukses' => 'Data Berhasil Di Proses']);
    }

    

    public function spk_service_proses(Request $request)
    {
        if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }
  
        if($request->id == null)
        {
            return redirect('admin-ts3/spk-list')->with(['sukses' => 'Data Tidak Ada Yang Di pilih']);
        }


       
            $id       = $request->id;
   
          
            for($i=0; $i < sizeof($id);$i++) {
                      
      
               DB::connection('ts3')->table('mvm.mvm_spk_d')->where('id',$id[$i])->update([
                'remark_ts3'   => $request->remark,
                'tanggal_schedule'   => $request->tanggal_schedule,
                'mst_bengkel_id'   => $request->mst_bengkel_id,
                'status_service'   => 'ONSCHEDULE'             
                ]);   

                //insert ke table service bengkel

                
                // DB::connection('ts3')->table('mvm.mst_area')->insert([
                //     'mvm_spk_d_id'   => $id[$i],
                //     'mst_bengkel_id'	=>  $request->mst_bengkel_id,  
                //     'created_date'    => date("Y-m-d h:i:sa"),
                //     'create_by'         => $request->session()->get('username')
                // ]);


             
            }
        
            return redirect('admin-ts3/spk-list')->with(['sukses' => 'Data telah Proses']);
       
        
    }


    public function spk_service_edit($id)
    {
        if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
           
        $spk 	= DB::connection('ts3')->table('mvm.v_spk_detail')->where('id',$id)->first();
        $bengkel 	= DB::connection('ts3')->table('mst.v_bengkel')->get();
       
        $data = array(  'title'         => 'Edit SPK Service',
                        'spk'           => $spk,
                        'bengkel'        => $bengkel,
                        'content'       => 'admin-ts3/spk/spk_service_edit'
                );
    
         return view('admin-ts3/layout/wrapper',$data);

    }


    public function spk_service_adjustments($id)
    {
        if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
           
       $service_h = DB::connection('ts3')->table('mvm.v_service_admin_ts3')->where('mvm_spk_d_id',$id)->first();
       $service_upload = DB::connection('ts3')->table('mvm.v_service_detail_history')->where('id',$service_h->id)->where('detail_type', 'Upload')->get();
       $service_jasa = DB::connection('ts3')->table('mvm.v_service_detail_history')->where('id',$service_h->id)->where('detail_type', 'Pekerjaan')->get();

       
       $service_part = DB::connection('ts3')->table('mvm.v_service_detail_history')->where('id',$service_h->id)->where('detail_type', 'Spare Part')->get();

       $part 	= DB::connection('ts3')->table('mst.v_service_item_motor')->where('price_service_type','Part')->where('mst_regional_id',$service_h->mst_regional_id)->where('mst_client_id',$service_h->mst_client_id)->distinct()->get();
       $jobs 	=  DB::connection('ts3')->table('mst.v_service_item_motor')->where('price_service_type','Jasa')->where('mst_regional_id',$service_h->mst_regional_id)->where('mst_client_id',$service_h->mst_client_id)->distinct()->get();


        $data = array(  'title'         => 'Adjustment SPK Service',
                        'service_h'        => $service_h,
                        'service_upload'        => $service_upload,
                        'service_jasa'        => $service_jasa,
                        'service_part'        => $service_part,
                        'part'        => $part,
                        'jobs'        => $jobs,
                        'content'       => 'admin-ts3/spk/spk_service_adjustment'
                );
    
         return view('admin-ts3/layout/wrapper',$data);

    }





    public function spk_service_edit_proses(Request $request)
    {
        if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
        request()->validate([
            'tanggal_schedule' => 'required',
            'mst_bengkel_id' => 'required',
            'remark' 	   => 'required',
            ]);

         
            DB::connection('ts3')->table('mvm.mvm_spk_d')->where('id',$request->id)->update([
                'remark_ts3'   => $request->remark,
                'tanggal_schedule'   => $request->tanggal_schedule,
                'mst_bengkel_id'   => $request->mst_bengkel_id,
                'status_service'   => 'ONSCHEDULE'             
                ]);   


        return redirect('admin-ts3/spk-list')->with(['sukses' => 'Data telah diupdate']);             


    }

    
    public function spk_service_adjustments_proses(Request $request)
    {
        if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}

                // try 
                // {
                //     DB::connection('ts3')->table('mvm.mvm_service_vehicle_d')
                //     ->where('mvm_service_vehicle_h_id',$request->id)
                //     ->where('detail_type', 'Pekerjaan')->delete();

                //     foreach($request->jasa_id as $key => $val){
               
                //                 $datajobs = [
                //                     'mvm_service_vehicle_h_id' => $request->id,
                //                     'detail_type' => 'Pekerjaan',
                //                     'unique_data' => $val,
                //                     'remark_adjustment' => 'Revisi Admin',
                //                     'source'    => 'mst_price_service (Jasa)',
                //                     'created_date'    => date("Y-m-d h:i:sa"),
                //                     'user_created'     => $request->session()->get('username')
                //                 ];
                
                //                 DB::connection('ts3')->table('mvm.mvm_service_vehicle_d')->insert($datajobs);

                    
                //     }

              
                   

                //     DB::connection('ts3')->table('mvm.mvm_service_vehicle_d')
                //     ->where('mvm_service_vehicle_h_id',$request->id)
                //     ->where('detail_type', 'Spare Part')->delete();
              
                //     foreach($request->part_id as $key => $val){
                       
                //             $datapart = [
                //                 'mvm_service_vehicle_h_id' => $request->id,
                //                 'detail_type' => 'Spare Part',
                //                 'unique_data' => $val,
                //                 'remark_adjustment' => 'Revisi Admin',
                //                 'source'    => 'mst_price_service (Part)',
                //                 'created_date'    => date("Y-m-d h:i:sa"),
                //                 'user_created'     => $request->session()->get('username')
                //             ];
                //             DB::connection('ts3')->table('mvm.mvm_service_vehicle_d')->insert($datapart);
                        
                //     }
                    

                // }
                // catch (\Illuminate\Database\QueryException $e) {
                //     DB::rollback();
                //     return redirect('admin-ts3/spk-list')->with(['warning' => $e]);
                // }


        return redirect('admin-ts3/spk-list')->with(['sukses' => 'Data telah diupdate']);  
    }
    
    
        
    public function servicedeletedetailjasa($id)
    {

        if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
     
        try{
        DB::connection('ts3')->table('mvm.mvm_service_vehicle_d')->where('id',$id)->delete();
    
        
        DB::commit();
        }
        catch (\Illuminate\Database\QueryException $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Detail jasa tidak ditemukan.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail jasa berhasil dihapus.'
        ]);

    }

    public function servicedeletedetailpart($id)
    {

        if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
     
        try{
        DB::connection('ts3')->table('mvm.mvm_service_vehicle_d')->where('id',$id)->delete();
    
        
        DB::commit();
        }
        catch (\Illuminate\Database\QueryException $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Detail jasa tidak ditemukan.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail jasa berhasil dihapus.'
        ]);

    }

   
    public function serviceinsertdetailjasa(Request $request)
    {
        if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}


        try{
            $datajobs = [
                'mvm_service_vehicle_h_id' => $request->servicehid,
                'detail_type' => 'Pekerjaan',
                'unique_data' => $request->job_id,
                'value_data' => $request->value,
                'remark_adjustment' => 'Revisi Admin',
                'source'    => 'mst_price_service (Jasa)',
                'created_date'    => date("Y-m-d h:i:sa"),
                'user_created'     => $request->session()->get('username')
            ];
    
            DB::connection('ts3')->table('mvm.mvm_service_vehicle_d')->insert($datajobs);
    
        
            
            DB::commit();
            }
            catch (\Illuminate\Database\QueryException $e) {
                DB::rollback();
                return response()->json([
                    'success' => false,
                    'message' => 'Detail jasa tidak ditemukan.'
                ], 404);
            }


        return response()->json([
            'message' => 'Data berhasil disisipkan.'
        ]);
    }


    public function serviceinsertdetailpart(Request $request)
    {
        if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}


        try{
            $datapart = [
                'mvm_service_vehicle_h_id' => $request->servicehid,
                'detail_type' => 'Spare Part',
                'unique_data' => $request->partId,
                'value_data' => $request->value_part,
                'remark_adjustment' => 'Revisi Admin',
                'source'    => 'mst_price_service (Part)',
                'created_date'    => date("Y-m-d h:i:sa"),
                'user_created'     => $request->session()->get('username')
            ];
    
            DB::connection('ts3')->table('mvm.mvm_service_vehicle_d')->insert($datapart);
    
        
            
            DB::commit();
            }
            catch (\Illuminate\Database\QueryException $e) {
                DB::rollback();
                return response()->json([
                    'success' => false,
                    'message' => 'Detail jasa tidak ditemukan.'
                ], 404);
            }


        return response()->json([
            'message' => 'Data berhasil disisipkan.'
        ]);
    }
    
  
    public function servicedeletedetailfoto($id)
    {

        if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
     
        try{
        DB::connection('ts3')->table('mvm.mvm_service_vehicle_d')->where('id',$id)->delete();
            
        
        DB::commit();
        }
        catch (\Illuminate\Database\QueryException $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Detail foto tidak ditemukan.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail foto berhasil dihapus.'
        ]);

    }


    public function serviceinsertdetailfoto(Request $request)
    {
        if (session()->get('username') == "") {
            return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);
        }
    
        Log::info($request);
    
        try {
            $service_no = $request->servicehno;
            $image = $request->file('upload_foto');
            $filename = $service_no . '-' . mt_rand(0, 100) . '.jpg';
            $destinationPath = storage_path('data/service/' . date("Y") . '/' . date("m") . '/' . $service_no);
    
            if (!file_exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }
            
            $img = Image::make($image->getRealPath());
            $img->resize(850, 850, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath . '/' . $filename);
    
            $dataupload = [
                'mvm_service_vehicle_h_id' => $request->servicehid,
                'detail_type' => 'Upload',
                'unique_data' => $filename,
                'value_data' => $request->value_foto,
                'source'    => $destinationPath,
                'remark_adjustment' => 'Revisi Admin',
                'created_date'    => date("Y-m-d h:i:sa"),
                'user_created'     => session()->get('username')
            ];
    
            DB::connection('ts3')->table('mvm.mvm_service_vehicle_d')->insert($dataupload);
    
            return response()->json([
                'message' => 'Data berhasil disisipkan.'
            ]);
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyisipkan detail foto.'
            ], 500);
        }
    }

   
}

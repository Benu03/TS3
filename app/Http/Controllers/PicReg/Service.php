<?php

namespace App\Http\Controllers\PicReg;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Konfigurasi_model;
use Image;
use PDF;
use Log;
use Illuminate\Support\Facades\File;
use DataTables;

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
        $service = DB::connection('ts3')->table('mvm.v_service_pic_branch')->wherein('mst_branch_id',$branch_id )->where('status_service','SERVICE')->get();


		$data = array(   'title'     => 'List Service',
                         'service'      => $service,
                         'countservice' => $countservice,
                        'content'   => 'pic-regional/service/index'
                    );
        return view('pic-regional/layout/wrapper',$data);
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

    public function get_image_service_detail($id)
    {
        if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }

        $image = DB::connection('ts3')->table('mvm.mvm_service_vehicle_d')->where('unique_data',$id)->first();

        $service = DB::connection('ts3')->table('mvm.mvm_service_vehicle_h')->where('id',$image->mvm_service_vehicle_h_id)->first();
        
        $storagePath =  $image->source.'/'.$image->unique_data;
        
        if(!file_exists($storagePath))
        return redirect('pic-regional/dasbor')->with(['warning' => 'File Tidak Di temukan']);
        
        else{
            return response()->file($storagePath);
        }

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

        return redirect('pic-regional/direct-service')->with(['sukses' => 'Data telah Di Hapus']);

    }

    public function service_advisor($id)
    {
        if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }

        $service = DB::connection('ts3')->table('mvm.v_service_pic_branch')->where('id',$id)->first();

        $sdetail  = DB::connection('ts3')->table('mvm.v_service_detail_history')->where('id',$id)->get();
    
        $data = array(   'title'     => 'Service Advisor',
            'service'      => $service,
            'sdetail' => $sdetail,
            'content'   => 'pic-regional/service/service_advisor'
            );
            return view('pic-regional/layout/wrapper',$data);


    }

    public function service_advisor_proses(Request $request)
    {

        if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }
        request()->validate([
            'remark' => 'required',
            'rating'     => 'required',
            ]);
       
        $id       = $request->id;
        $id_spk_d =  DB::connection('ts3')->table('mvm.mvm_service_vehicle_h')->where('id',$id)->first();
        try{  
 
            DB::connection('ts3')->table('mvm.mvm_service_vehicle_h')->where('id',$id)->update([
            'remark_pic_branch'   => $request->remark,
            'pic_branch_date_post'   => date("Y-m-d h:i:sa")          
            ]); 
            
            DB::connection('ts3')->table('mvm.mvm_spk_d')->where('id',$id_spk_d->mvm_spk_d_id)->update([
                'status_service'   => 'APPROVAL'             
                ]);

             DB::connection('ts3')->table('mvm.mvm_service_rating')->insert([
                    'rating'   => $request->rating,
                    'service_no'   => $id_spk_d->service_no,
                    'created_date'    => date("Y-m-d h:i:sa"),
                    'create_by'     => $request->session()->get('username')
                ]);
    
                DB::commit();
        }
        catch (\Illuminate\Database\QueryException $e) {
                DB::rollback();
                return redirect('pic-regional/list-service')->with(['warning' => $e]);
            }



        return redirect('pic-regional/list-service')->with(['sukses' => 'Data telah Proses']);

    }
    
    public function history_service()
    {
        if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }
    
      
        $history = DB::connection('ts3')->table('mvm.v_service_history')->where('pic_branch',Session()->get('username'))->get();

		$data = array(   'title'     => 'History Service',
                         'history'      => $history,
                        'content'   => 'pic-regional/service/history_service'
                    );
        return view('pic-regional/layout/wrapper',$data);


    }
    

    

  
    public function ServiceDueDate(Request $request)
    {
        if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}

        
        if ($request->ajax()) {
            $sericeduedate 	= DB::connection('ts3')->table('mvm.v_service_history')->where('pic_regional',Session()->get('username'))->get();
            return DataTables::of($sericeduedate)->addColumn('action', function($row){
             
                $btn = '<a href="#" class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#vehicle' . $row->id . '"><i class="fa fa-eye"></i></a>';
                $vehicle  = DB::connection('ts3')->table('mst.v_vehicle')->where('nopol',$row->nopol)->first();
              
               
                $modal = '
                <div class="modal fade" id="vehicle' . $row->id . '" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog" style="max-width:1200px; max-height:1200px;">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title mr-4" id="myModalLabel">Detail (' . $row->nopol . ')</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            </div>
                            <div class="modal-body">
                                <div class="row">                                    
                                            <div class="col-md-3">
                                            <!-- Profile Image -->
                                            <div class="card card-primary card-outline">
                                                <div class="card-body box-profile">
                                            <div class="text-center">
                                                <img class="img img-thumbnail img-fluid" src="' . asset('assets/upload/image/thumbs/motor.png').'" >
                                            </div>

                                            <h3 class="profile-username text-center">'.$vehicle->nopol.'</h3>
                                            <h3 class="profile-username text-center">' . $vehicle->gambar_unit.'</h3>
                                            </div>
                                            <!-- /.card-body -->
                                            </div>
                                            <!-- /.card -->
                                            </div>
                                            <div class="col-md-9">
                                            <div class="card card-primary">
                                            <div class="card-header">
                                                    <h3 class="card-title">Detail Data Motor  ' .  $vehicle->client_name.'</h3>
                                                    </div>
                                                    <!-- /.card-header -->
                                                    <div class="card-body">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th width="25%">Nopol</th>
                                                        <th>' .  $vehicle->nopol.'</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>No Rangka</td>
                                                        <td>' . $vehicle->norangka.'</td>
                                                    </tr>
                                                    <tr>
                                                        <td>No Mesin</td>
                                                        <td>' . $vehicle->nomesin .'</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Type</td>
                                                        <td>' . $vehicle->type.'</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Tahun Pembuatan</td>
                                                        <td>' . $vehicle->tahun_pembuatan.'</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Tanggal Last Service</td>
                                                        <td>' . $vehicle->tgl_last_service.'</td>
                                                    </tr>
                                                    
                                                    <tr>
                                                        <td>Create Date</td>
                                                        <td>' . $vehicle->created_date.'</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Create By</td>
                                                        <td>' . $vehicle->create_by.'</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Update Date</td>
                                                        <td>' . $vehicle->updated_at.'</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Update By</td>
                                                        <td>' . $vehicle->update_by.'</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Remark</td>
                                                        <td>' . $vehicle->remark.'</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            </div>



                                         </div>
                                         <div class="row">

                                         <div class="col-md-12">
                                         <div class="card">  
                                             <div class="card-header">
                                             Service Detail
                                             </div>
                                                 <div class="card-body">  
                                                     <div class="table-responsive-md">
                                                         <table class="table table-bordered table-sm" style="font-size: 12px;">
                                                                 <thead>
                                                                 <tr class="bg-light">                                                      
                                                             
                                                                     <th width="15%">Detail Action</th>   
                                                                     <th width="15%">Attribute</th> 
                                                                         <th width="15%">Value Attibute</th>                                                 
                                                                 </tr>
                                                                 </thead>
             
                                                                 <tbody>';
                                                                 $lastservice = DB::connection('ts3')->table('mvm.v_service_history')->where('nopol', $row->nopol)->where('tanggal_service', $row->tgl_last_service)->first();

                                                                 $sdetail  = DB::connection('ts3')->table('mvm.v_service_detail_history')->where('id',$lastservice->mvm_service_vehicle_h_id)->get();

                                                                 foreach ($sdetail as $ind) {
                                                                    $modal .= '
                                                                        <tr>
                                                                            <td>' . $ind->detail_type . '</td>
                                                                            <td>';
                                                                            
                                                                    if ($ind->detail_type == 'Upload') {
                                                                        $modal .= '
                                                                            <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#DetailImage' . $ind->service_d_id . '">
                                                                                <i class="fa fa-eye"></i> ' . $ind->attribute . '
                                                                            </button>';
                                                                        
                                                                        // Include the content of the modal directly here
                                                                        $modal .= view('pic-regional.service.service_image_history', ['ind' => $ind])->render();
                                                                    } else {
                                                                        $modal .= $ind->attribute;
                                                                    }
                                                                    
                                                                    $modal .= '
                                                                            </td>
                                                                            <td>' . $ind->value_data . '</td>
                                                                        </tr>';
                                                                }
                                                                
                                        $modal .= '           
                                                                     </tbody>
                                                         
                                                             </table>
             
                                                     </div>
                                                 </div>           
                                             </div>   
             
             
                                                
                                         </div>           
                                        

                                    </div>
                                 </div>
                                </div>';
                return $btn . $modal;
                 })->rawColumns(['action'])->make(true);
       
        }

    }
   

    public function get_image_service_detail_pic($id)
    {
        if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }

        

        $image = DB::connection('ts3')->table('mvm.mvm_service_vehicle_d')->where('unique_data',$id)->first();
  
 
        $storagePath =  $image->source.'/'.$image->unique_data;


        if(!file_exists($storagePath))
        return redirect('pic-regional/dasbor')->with(['warning' => 'File Tidak Di temukan']);
        
        else{
            return response()->file($storagePath);
        }

    }  
}

<?php

namespace App\Http\Controllers\AdminClient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Konfigurasi_model;
use Image;
use PDF;
use DataTables;
use Log;

class report extends Controller
{


    // Index
    public function spk_history()
    {
        if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }
    
        // $spk_history = DB::connection('ts3')->table('mst.v_regional')->get();

		$data = array(   'title'     => 'SPK History',
                        //  'spk_history'      => $spk_history,
                        'content'   => 'admin-client/report/spk_history'
                    );
        return view('admin-client/layout/wrapper',$data);
    }


    public function getSPKHistory(Request $request)
    {
        if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
        if ($request->ajax()) {
            $user_client 	= DB::connection('ts3')->table('mst.v_user_client')->where('username',Session()->get('username'))->first();
            if(!empty($request->from_date)) {

                $service 	= DB::connection('ts3')->table('mvm.mvm_spk_h')
                ->where('mst_client_id',$user_client->mst_client_id)
                ->whereBetween('posting_date', array($request->from_date, $request->to_date))->get();

            } else {
            $service 	= DB::connection('ts3')->table('mvm.mvm_spk_h')
            ->where('mst_client_id',$user_client->mst_client_id)->get();
            }


        return DataTables::of($service)->addColumn('file', function($row){
               $btn = '<a href="'. asset('admin-client/spk-file/'.$row->nama_file).'" 
               class="btn btn-success btn-sm" ><i class="fa fa-file"></i></a>';
                return $btn;
                })
        ->rawColumns(['file'])->make(true);
       
        }

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

  

    public function history_service()
    {
        if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }
       


      

		$data = array(   'title'     => 'History Service',
                        //  'history'      => $history,
                        'content'   => 'admin-client/report/history_service'
                    );
        return view('admin-client/layout/wrapper',$data);


    }

    public function getHistoryService(Request $request)
    {
        if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
        if ($request->ajax()) {
            $user_client 	= DB::connection('ts3')->table('auth.v_user_client')->where('username',Session()->get('username'))->first();
            if(!empty($request->from_date)) {

                $service 	= DB::connection('ts3')->table('mvm.v_service_history')->where('mst_client_id',$user_client->mst_client_id)
                ->whereBetween('tanggal_service', array($request->from_date, $request->to_date))->get();

            } else {
            $service 	= DB::connection('ts3')->table('mvm.v_service_history')->where('mst_client_id',$user_client->mst_client_id)->get();

            }

        return DataTables::of($service)->addColumn('action', function($row){
               $btn = '<a href="'. asset('admin-client/report/history-service-detail/'.$row->service_no).'" 
               class="btn btn-success btn-sm" target="_blank"><i class="fa fa-eye"></i></a>';
                return $btn;
                })
        ->rawColumns(['action'])->make(true);
       
        }

    }


    public function history_service_detail($id)
    {
        if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }
    

        $ar = DB::connection('ts3')->table('mvm.v_service_history')->where('service_no', $id)->first();

		$data = array(   'title'     => 'History Service '.$ar->service_no,
                         'ar'      => $ar,
                        'content'   => 'admin-client/report/service_detail_history'
                    );
        return view('admin-client/layout/wrapper',$data);
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
        return redirect('admin-client/list-service')->with(['warning' => 'Fila Tidak Di temukan']);
        
        else{
            return response()->file($storagePath);
        }

    }  



    public function rekap_invoice()
    {
        if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }
    
      

		$data = array(   'title'     => 'Rekapitulasi Invoice',
                        //  'invoiceList'      => $invoiceList,
                        'content'   => 'admin-client/report/rekap_invoice'
                    );
        return view('admin-client/layout/wrapper',$data);
    }

    
    public function exportHistoryService(Request $request)
    {

        if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
        if ($request->ajax()) 
        {
            $user_client 	= DB::connection('ts3')->table('auth.v_user_client')->where('username',Session()->get('username'))->first();
            if(!empty($request->from_date))
             {

                $service 	= DB::connection('ts3')->table('mvm.v_service_history')->selectRaw("spk_no,
                service_no, nopol, norangka, nomesin, tahun, 
                type as tipe,  status_service, tanggal_service, 
                nama_driver, last_km,bengkel_name  as bengkel, mekanik,
                tgl_last_service,regional,area, branch as cabang, pic_branch as pic_cabang, 
                tanggal_schedule,remark_ts3 as remark")->where('mst_client_id',$user_client->mst_client_id)
                ->whereBetween('tanggal_service', array($request->from_date, $request->to_date))->get();

            } else {
                $service 	= DB::connection('ts3')->table('mvm.v_service_history')->selectRaw("spk_no,
                service_no, nopol, norangka, nomesin, tahun, 
                type as tipe,  status_service, tanggal_service, 
                nama_driver, last_km,bengkel_name  as bengkel, mekanik,
                tgl_last_service,regional,area, branch as cabang, pic_branch as pic_cabang, 
                tanggal_schedule,remark_ts3 as remark")->where('mst_client_id',$user_client->mst_client_id)->get();

            }
        }
            return response()->json(['data' => $service]);
    }


    public function getRekapInvoice(Request $request)
    {
        if (Session()->get('username') == "") {
            return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);
        }

        if ($request->ajax()) {

            $useclient = DB::connection('ts3')->table('mst.v_user_client')->where('username',Session()->get('username'))->first();

            if(!empty($request->from_date)) {

                // dd($request->from_date);

                $invoiceList = DB::connection('ts3')->table('mvm.v_rekap_invoice')
                ->whereBetween('created_date', array($request->from_date, $request->to_date))
                ->where('invoice_type','TS3 TO CLIENT')
                ->where('status','DONE')
                ->where('client_name',$useclient->client_name)
                ->get();

            } else {

                $invoiceList = DB::connection('ts3')->table('mvm.v_rekap_invoice')
                ->where('invoice_type','TS3 TO CLIENT')
                ->where('status','DONE')
                ->where('client_name',$useclient->client_name)
                ->get();

            }


          


            return DataTables::of($invoiceList)->addColumn('action', function ($row) {
                $btn = '<a href="#" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#rkapInvoice' . $row->id . '"><i class="fa fa-eye"></i></a>';

 
                    $modal = '
                        <div class="modal fade" id="rkapInvoice' . $row->id . '" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog" style="max-width:1500px; max-height:1500px;">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title mr-4" id="myModalLabel">Detail Invoice (' . $row->invoice_no . ')</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-12 text-left">
                                                <div class="card">
                                                    <div class="card-header">
                                                        Invoice Detail
                                                    </div>
                                                    <div class="card-body">
                                                    <div class="table-responsive-md">
                                                        <table class="table table-bordered table-sm" style="font-size: 10px;">
                                                            <thead>
                                                                <tr class="bg-info">
                                                                    <th width="10%">NOPOL</th>
                                                                    <th width="15%">CABANG</th>
                                                                    <th width="10%">INVOICE</th>
                                                                    <th width="10%">Tanggal Service</th>
                                                                    <th width="7%">KM</th>
                                                                    <th width="7%">Jasa</th>
                                                                    <th width="7%">Barang</th>
                                                                    <th width="7%">PPN</th>
                                                                    <th width="7%">PPH 23</th>
                                                                    <th width="10%">Total Sebelum PPH 23</th>
                                                                    <th width="10%">Total Sesudah PPH 23</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>';

                    $invoicedetail = DB::connection('ts3')->table('mvm.v_invoice_detail_admin')->where('invoice_no', $row->invoice_no)->get();
                    foreach ($invoicedetail as $ind) {
                        $modal .= '
                                                                <tr>
                                                                    <td>' . $ind->nopol . '</td>
                                                                    <td>' . $ind->branch . '</td>
                                                                    <td>' . $ind->invoice_no . '</td>
                                                                    <td>' . $ind->tanggal_service . '</td>
                                                                    <td>' . $ind->last_km . '</td>
                                                                    <td>Rp ' . number_format($ind->jasa, 0, ',', '.') . '</td>
                                                                    <td>Rp ' . number_format($ind->part, 0, ',', '.') . '</td>
                                                                    <td>Rp ' . number_format($ind->ppn, 0, ',', '.') . '</td>
                                                                    <td>Rp ' . number_format($ind->pph23, 0, ',', '.') . '</td>
                                                                    <td>Rp ' . number_format(($ind->part + $ind->jasa + $ind->ppn), 0, ',', '.') . '</td>
                                                                    <td>Rp ' . number_format(($ind->part + $ind->jasa + $ind->ppn) - $ind->pph23, 0, ',', '.') . '</td>
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
                                        <div class="row"> 
                                        <div class="col-md-12 text-right">
                                     
                                                        <a href="' . asset("admin-client/invoice-generate-ts3/{$row->id}") . '" class="btn btn-secondary">
                                                        <i class="far fa-file-pdf"></i> Generate Invoice
                                                    </a>
                                             
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

    
    public function exportRekapInvoice(Request $request)
    {
        if (Session()->get('username') == "") {
            return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);
        }

        if ($request->ajax()) 
        {
            $useclient = DB::connection('ts3')->table('mst.v_user_client')->where('username',Session()->get('username'))->first();
            if(!empty($request->from_date)) 
            {
                $invoiceList = DB::connection('ts3')->table('mvm.v_rekap_invoice')->selectRaw("invoice_no as INVOICE_NO, invoice_type as INVOICE_TYPE, 
                status as STATUS, created_date as INVOICE_DATE, create_by as CREATED_INVOICE, regional as REGIONAL,
                client_name as CLIENT,pph as PPH, ppn as PPN,jasa_total as TOTAL_JASA, part_total as TOTAL_PART, pph+COALESCE(ppn, 0)+jasa_total+part_total as TOTAL")                    
                ->whereBetween('created_date', array($request->from_date, $request->to_date))
                    ->where('invoice_type','TS3 TO CLIENT')
                    ->where('status','DONE')
                    ->where('client_name',$useclient->client_name)
                    ->get();
            } 
            else 
            {
                $invoiceList = DB::connection('ts3')->table('mvm.v_rekap_invoice')->selectRaw("invoice_no as INVOICE_NO, invoice_type as INVOICE_TYPE, 
                status as STATUS, created_date as INVOICE_DATE, create_by as CREATED_INVOICE, regional as REGIONAL,
                client_name as CLIENT,pph as PPH, ppn as PPN,jasa_total as TOTAL_JASA, part_total as TOTAL_PART, pph+COALESCE(ppn, 0)+jasa_total+part_total as TOTAL")->where('invoice_type','TS3 TO CLIENT')
                ->where('status','DONE')
                ->where('client_name',$useclient->client_name)
                ->get();
            }
        }
        return response()->json(['data' => $invoiceList]);

    }
  


   
}

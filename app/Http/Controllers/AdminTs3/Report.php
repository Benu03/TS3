<?php

namespace App\Http\Controllers\AdminTs3;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Konfigurasi_model;
use Image;
use PDF;
use DataTables;
use Log;

class Report extends Controller
{




    public function history_service()
    {
        if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }
    

        // $history = DB::connection('ts3')->table('mvm.v_service_history')->get();

		$data = array(   'title'     => 'History Service',
                        //  'history'      => $history,
                        'content'   => 'admin-ts3/report/history_service'
                    );
        return view('admin-ts3/layout/wrapper',$data);


    }

    public function getHistoryService(Request $request)
    {
        if (Session()->get('username') == "") {
            return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);
        }
    
        if ($request->ajax()) {
            $query = DB::connection('ts3')->table('mvm.v_service_history');
    
            if (!empty($request->from_date) && !empty($request->to_date)) {
                $query->whereBetween('tanggal_service', [$request->from_date, $request->to_date]);
            }
    
            if (!empty($request->spkno)) {
                $query->where('spk_no', 'ILIKE', '%' . $request->spkno . '%');
            }
    
            $service = $query->get();
    
            return DataTables::of($service)
                ->addColumn('action', function ($row) {
                    $btn = '<a href="' . asset('admin-ts3/report/history-service-detail/' . $row->service_no) . '" 
                        class="btn btn-success btn-sm" target="_blank"><i class="fa fa-eye"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
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
                        'content'   => 'admin-ts3/report/service_detail_history'
                    );
        return view('admin-ts3/layout/wrapper',$data);
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
        return redirect('admin-ts3/history_service')->with(['warning' => 'Fila Tidak Di temukan']);
        
        else{
            return response()->file($storagePath);
        }

    }  

    public function summary_bengkel()
    {
        if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }
    
        // $nopol = DB::connection('ts3')->table('mst.v_vehicle')->get();

		$data = array(   'title'     => 'Summary Bengkel',
                        //  'nopol'      => $nopol,
                        'content'   => 'admin-ts3/report/summary_bengkel'
                    );
        return view('admin-ts3/layout/wrapper',$data);
    }

    public function rekap_invoice()
    {
        if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }
    
      

		$data = array(   'title'     => 'Rekapitulasi Invoice',
                        //  'invoiceList'      => $invoiceList,
                        'content'   => 'admin-ts3/report/rekap_invoice'
                    );
        return view('admin-ts3/layout/wrapper',$data);
    }


    public function getRekapInvoice(Request $request)
    {
        if (Session()->get('username') == "") {
            return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);
        }

        if ($request->ajax()) {

            if(!empty($request->from_date)) {

                // dd($request->from_date);

                $invoiceList = DB::connection('ts3')->table('mvm.v_rekap_invoice')->whereBetween('created_date', array($request->from_date, $request->to_date))
                    ->get();

            } else {

                $invoiceList = DB::connection('ts3')->table('mvm.v_rekap_invoice')->get();

            }


          


            return DataTables::of($invoiceList)->addColumn('action', function ($row) {
                $btn = '<a href="#" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#rkapInvoice' . $row->id . '"><i class="fa fa-eye"></i></a>';

                // Modal
                if ($row->invoice_type == 'TS3 TO CLIENT') 
                {
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
                                     
                                                        <a href="' . asset("admin-ts3/invoice-export-excel-ts3/{$row->id}") . '" class="btn btn-success">
                                                        <i class="far fa-file-excel"></i> Export Excel
                                                        </a>

                                                        <a href="' . asset("admin-ts3/invoice-generate-ts3/{$row->id}") . '" class="btn btn-danger">
                                                        <i class="far fa-file-pdf"></i> Generate Invoice
                                                        </a>
                                             
                                              </div>  
                                        
                                         </div>

                                    </div>
                                </div>
                            </div>
                        </div>';
                } 
                else {
                    $modal = '
                        <div class="modal fade" id="rkapInvoice' . $row->id . '" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-xl">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Detail Invoice ' . $row->invoice_no . '</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
		
                        <div class="row mb-2">  
                                      
                                 <div class="col-md-12">
                                    <div class="card">  
                                        <div class="card-header">
                                        Invoice Data
                                        </div>
                                        <div class="card-body">  
                                        <div class="table-responsive-md">
                                        <table class="table table-bordered" style="font-size: 12px;">
                                  
                                            <thead>
                                                <tr class="bg-secondary">
                                                    
                                                    <th width="15%">Invoice Nomor</th>
                                                    <th width="15%">Tanggal Invoice</th>   
                                                    <th width="10%">Regional</th> 
                                                    <th width="10%">Status</th> 
                                                    <th width="10%">PPH</th>  
                                                    <th width="10%">Jasa</th>  
                                                    <th width="10%">Part</th>  
                                                    <th width="10%">Total</th>  
                                                    <th width="10%">User Request</th>    
                                               
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                <td>' . $row->invoice_no . '</td>
                                                <td>' . $row->created_date . '</td>
                                                <td>' . $row->regional . '</td>
                                                <td>' . $row->status . '</td>
                                                <td>' . "Rp " . number_format($row->pph, 0, ',', '.') . '</td>
                                                <td>' . "Rp " . number_format($row->jasa_total, 0, ',', '.') . '</td>
                                                <td>' . "Rp " . number_format($row->part_total, 0, ',', '.') . '</td>
                                                <td>' . "Rp " . number_format(($row->jasa_total - $row->pph) + $row->part_total, 0, ',', '.') . '</td>
                                                <td>' . $row->create_by . '</td>
                                        
                                           
                                            </tr>
                                      
                                        </tbody>

                                        </table>
                                </div> 
                                </div>
                                     </div>
                              </div>           
                          </div>   
                          

                          <div class="row"> 
                            <div class="col-md-12 text-left">
                                <div class="card">  
                                    <div class="card-header">
                                    Invoice Detail
                                    </div>
                                    <div class="card-body">  
                                         <div class="table-responsive-md">
                                        <table class="table table-bordered table-sm" style="font-size: 11px;">
                                            <thead>
                                                <tr class="bg-light">                                                      
                                               
                                                    <th width="14%">SERVICE NO</th>   
                                                    <th width="8%">JASA</th> 
                                                    <th width="8%">PART</th>  
                                                    <th width="8%">NOPOL</th> 
                                                    <th width="10%">Area</th>   
                                                    <th width="15%">CABANG</th>  
                                                    <th width="17%">TIPE</th>  
                                                    <th width="10%">Tanggal Service</th>    
                                               
                                            </tr>
                                            </thead>

                                             <tbody>';
                     
                                                $invoicedetail  = DB::connection('ts3')->table('mvm.v_invoice_detail')->where('invoice_no',$row->invoice_no)->get();
                                             
                                                foreach ($invoicedetail as $ind) {
                                                    $modal .= '

                    
                                                    <tr>
                                                    <td>' . $ind->service_no . '</td>
                                                    <td>' . "Rp " . number_format($ind->jasa, 0, ',', '.') . '</td>
                                                    <td>' . "Rp " . number_format($ind->part, 0, ',', '.') . '</td>
                                                    <td>' . $ind->nopol . '</td>
                                                    <td>' . $ind->area . '</td>
                                                    <td>' . $ind->branch . '</td>
                                                    <td>' . $ind->type . '</td>
                                                    <td>' . $ind->tanggal_service . '</td>
                                                </tr>';
                                        }
                                      
                                                 $modal .= '  </tbody>
                                                    
                                    </table>
                                     </div> 

                                    </div>           
                                    </div>   
        
                            </div>           
                        </div>   



                          
                          <div class="row"> 
                            <div class="col-md-12 text-right">
                    
                                        <a href="' .asset("admin-ts3/invoice-generate/{$row->invoice_no}").'"class="btn btn-secondary">
                                            <i class="far fa-file-excel"></i> Generate Invoice
                                        </a>
                                 
                                  </div>  
                            
                          </div>
				
		
					</div>
                                   
                                </div>
                            </div>
                        </div>';
                }

                return $btn . $modal;
            })->rawColumns(['action'])->make(true);
        }
    }


    public function due_date_service()
    {
        if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }
    
        // $nopol = DB::connection('ts3')->table('mst.v_vehicle')->get();

		$data = array(   'title'     => 'Due Date Service',
                        //  'nopol'      => $nopol,
                        'content'   => 'admin-ts3/report/due_date_service'
                    );
        return view('admin-ts3/layout/wrapper',$data);
    }


    
    public function getdue_date_service(Request $request)
    {
        if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
        if ($request->ajax()) {
           
            if(!empty($request->from_date)) {
                
                $service 	= DB::connection('ts3')->table('mst.v_vehicle_last_service')
                ->whereBetween('tgl_last_service', array($request->from_date, $request->to_date))->get();

            } else {
            $service 	= DB::connection('ts3')->table('mst.v_vehicle_last_service')->get();
            }


        return DataTables::of($service)->make(true);
       
        }

    }

    public function getSummaryBengkel(Request $request)
    {
        if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
        if ($request->ajax()) {
           
            
            if(!empty($request->month)) {

                
                $service 	= DB::connection('ts3')->table('mvm.v_summary_invoice_bengkel_group')
                ->where('month', $request->month)
                ->where('year_invoice', $request->year)->get();

            } else {
             $service 	= DB::connection('ts3')->table('mvm.v_summary_invoice_bengkel_group')->get();
            }


        return DataTables::of($service)->make(true);
       
        }

    }


    public function getLabaRugi(Request $request)
    {
        if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
        if ($request->ajax()) {
           
            

            if(!empty($request->month)) {                
                $service 	= DB::connection('ts3')->table('mvm.v_chart_report_laba_rugi_series')
                ->where('month', $request->month)
                ->where('year_spk', $request->year)->get();

            } else {
             $service 	= DB::connection('ts3')->table('mvm.v_chart_report_laba_rugi_series')->get();
            }


        return DataTables::of($service)->make(true);
       
        }

    }

    

    public function ar()
    {
        if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }
    
        $nopol = DB::connection('ts3')->table('mst.v_vehicle')->get();

		$data = array(   'title'     => 'Report AR',
                         'nopol'      => $nopol,
                        'content'   => 'admin-ts3/report/ar'
                    );
        return view('admin-ts3/layout/wrapper',$data);
    }

    public function laba_rugi()
    {
        if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }
    
        $laba_rugi = DB::connection('ts3')->table('mvm.v_chart_report_laba_rugi_series')
                    // ->whereRaw("to_char(tanggal_pengerjaan,'mm') in ('05','06')")
                    // ->where('year_spk', '2023')
                    ->whereNotNull('type1')
                    ->whereNotNull('type2')
                    ->get();


        $dataPointslaba_rugi = [];
     
        foreach ($laba_rugi as $lrp) {            
            $dataPointslaba_rugi[] = [
                "spk_no" => $lrp->spk_no,
                "type1" => $lrp->type1,
                "type2" => $lrp->type2,
                "total1" => $lrp->total1,
                "total2" => $lrp->total2               

            ];
        }
     

		$data = array(   'title'     => 'Laba Rugi',
                         'laba_rugi'      => $laba_rugi,
                         'dataPointslaba_rugi' => $dataPointslaba_rugi,
                        'content'   => 'admin-ts3/report/laba_rugi'
                    );
        return view('admin-ts3/layout/wrapper',$data);
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
                        'content'   => 'admin-ts3/report/spk_history'
                    );
        return view('admin-ts3/layout/wrapper',$data);
    }


    public function getSPKHistory(Request $request)
    {
        if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
        if ($request->ajax()) {
           
            if(!empty($request->from_date)) {

                $service 	= DB::connection('ts3')->table('mvm.mvm_spk_h')
                ->whereBetween('posting_date', array($request->from_date, $request->to_date))->get();

            } else {
            $service 	= DB::connection('ts3')->table('mvm.mvm_spk_h')->get();
            }


        return DataTables::of($service)->addColumn('file', function($row){
               $btn = '<a href="'. asset('admin-ts3/spk-file/'.$row->nama_file).'" 
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
   


    public function exportRekapInvoice(Request $request)
    {
        if (Session()->get('username') == "") {
            return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);
        }

        if ($request->ajax()) 
        {
            if(!empty($request->from_date)) 
            {
                $invoiceList = DB::connection('ts3')->table('mvm.v_rekap_invoice')->selectRaw("invoice_no as INVOICE_NO, invoice_type as INVOICE_TYPE, 
                status as STATUS, created_date as INVOICE_DATE, create_by as CREATED_INVOICE, regional as REGIONAL,
                client_name as CLIENT,pph as PPH, ppn as PPN,jasa_total as TOTAL_JASA, part_total as TOTAL_PART, pph+COALESCE(ppn, 0)+jasa_total+part_total as TOTAL")->whereBetween('created_date', array($request->from_date, $request->to_date))
                    ->get();
            } 
            else 
            {
                $invoiceList = DB::connection('ts3')->table('mvm.v_rekap_invoice')->selectRaw("invoice_no as INVOICE_NO, invoice_type as INVOICE_TYPE, 
                status as STATUS, created_date as INVOICE_DATE, create_by as CREATED_INVOICE, regional as REGIONAL,
                client_name as CLIENT,pph as PPH, ppn as PPN,jasa_total as TOTAL_JASA, part_total as TOTAL_PART, pph+COALESCE(ppn, 0)+jasa_total+part_total as TOTAL")->get();
            }
        }
        return response()->json(['data' => $invoiceList]);

    }
  

     
    public function exportHistoryService(Request $request)
    {

        if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
        if ($request->ajax()) {
            $query = DB::connection('ts3')->table('mvm.v_service_history')->selectRaw("
                spk_no, service_no, nopol, norangka, nomesin, tahun, 
                type as tipe, status_service, tanggal_service, 
                nama_driver, last_km, bengkel_name as bengkel, mekanik,
                tgl_last_service, regional, area, branch as cabang, pic_branch as pic_cabang, 
                tanggal_schedule, remark_ts3 as remark
            ");
    
            if (!empty($request->from_date) && !empty($request->to_date)) {
                $query->whereBetween('tanggal_service', [$request->from_date, $request->to_date]);
            }
    
            if (!empty($request->spkno)) {
                $query->where('spk_no', 'ILIKE', '%' . $request->spkno . '%');
            }
    
            $service = $query->get();
    
            return response()->json(['data' => $service]);
        }
    }
    
    public function exportDueDateService(Request $request)
    {

        if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
        if ($request->ajax()) 
        {
            if(!empty($request->from_date)) {

                // dd($request->from_date);

                $service 	= DB::connection('ts3')->table('mst.v_vehicle_last_service')->selectRaw("client_name, nopol, norangka, nomesin, type, tahun_pembuatan,tgl_last_service,last_km, nama_stnk,remark, created_date, updated_at, create_by, update_by")
                    ->whereBetween('tgl_last_service', array($request->from_date, $request->to_date))
                    ->get();

            } else {

                $service 	= DB::connection('ts3')->table('mst.v_vehicle_last_service')->selectRaw("client_name, nopol, norangka, nomesin, type, tahun_pembuatan,tgl_last_service,last_km, nama_stnk,remark, created_date, updated_at, create_by, update_by")->get();

            }
        }
            return response()->json(['data' => $service]);
    }



    public function exportSummaryBengkel(Request $request)
    {

        if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
        if ($request->ajax()) 
        {
            if(!empty($request->month)) {

                $service 	= DB::connection('ts3')->table('mvm.v_summary_invoice_bengkel_group')->selectRaw("bengkel_alias,bengkel_name,month_invoice, year_invoice, pic, phone_pic, wa_pic, email_pic, total")
                ->where('month', $request->month)
                ->where('year_invoice', $request->year)->get();

            } else {

                $service 	= DB::connection('ts3')->table('mvm.v_summary_invoice_bengkel_group')->selectRaw("bengkel_alias,bengkel_name,month_invoice, year_invoice, pic, phone_pic, wa_pic, email_pic, total")->get();

            }
        }
            return response()->json(['data' => $service]);
    }


    public function realisasi_spk()
    {
        if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }
        $regional 	= DB::connection('ts3')->table('mst.v_regional')->get();

		$data = array(   'title'     => 'Realisasi SPK',
                        'regional'      => $regional,
                        'content'   => 'admin-ts3/report/realisasi_spk'
                    );
        return view('admin-ts3/layout/wrapper',$data);


    }

    public function getRealisasiSPK(Request $request)
    {
        if (Session()->get('username') == "") {
            return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);
        }
    
        if ($request->ajax()) {
            $query = DB::connection('ts3')->table('mvm.v_service_history');
    
            if (!empty($request->from_date) && !empty($request->to_date)) {
                $query->whereBetween('tanggal_service', [$request->from_date, $request->to_date]);
            }
          
    
            if (!empty($request->regional)) {
                $query->where('regional', $request->regional);
            }

            if (!empty($request->spkno)) {
                $query->where('spk_no', 'ILIKE', '%' . $request->spkno . '%');
            }
    
            $service = $query->get();
            return DataTables::of($service)->make(true);
        }
    }
    

    public function exportRealisasiSPK(Request $request)
    {

        if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
        if ($request->ajax()) {
            $query = DB::connection('ts3')->table('mvm.v_service_history')->selectRaw("
                nopol, norangka, nomesin,  regional,  area, branch as cabang, spk_no, service_no, 
                tanggal_service,remark_ts3 as keterangan
            ");
    
            if (!empty($request->from_date) && !empty($request->to_date)) {
                $query->whereBetween('tanggal_service', [$request->from_date, $request->to_date]);
            }
            if (!empty($request->regional)) {
                $query->where('regional', $request->regional);
            }
    
            if (!empty($request->spkno)) {
                $query->where('spk_no', 'ILIKE', '%' . $request->spkno . '%');
            }
    
            $service = $query->get();
    
            return response()->json(['data' => $service]);
        }
    }

    
    public function exportPDFRealisasiSPK(Request $request)
    {
        if(Session()->get('username') == "") {
            return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);
        }
    
        $query = DB::connection('ts3')->table('mvm.v_service_history')->selectRaw("
            nopol, norangka, nomesin,  regional,  area, branch as cabang, spk_no, service_no, 
            tanggal_service, remark_ts3 as keterangan
        ");
    
        if (!empty($request->from_date) && !empty($request->to_date)) {
            $query->whereBetween('tanggal_service', [$request->from_date, $request->to_date]);
        }
        if (!empty($request->regional)) {
            $query->where('regional', $request->regional);
        }
    
        if (!empty($request->spkno)) {
            $query->where('spk_no', 'ILIKE', '%' . $request->spkno . '%');
        }
    
        $service = $query->get();
    
        $data = [
            'from_date' => $request->from_date,
            'to_date' => $request->to_date,
            'spkno' => $request->spkno,
            'regional' => $request->regional,
            'realisasi_spk' => $service
        ];
    
        $pdf = PDF::loadView('pdf.realisasi-spk', $data)->setPaper('a4', 'landscape');
    
        return $pdf->download('Realisasi-SPK-' . now()->format('YmdHis') . '.pdf');
    }
    
}

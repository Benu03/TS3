<?php

namespace App\Http\Controllers\Bengkel;

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
      

      

		$data = array(   'title'     => 'History Service',
                        //  'history'      => $history,
                        'content'   => 'bengkel/report/history_service'
                    );
        return view('bengkel/layout/wrapper',$data);


    }

    public function getHistoryService(Request $request)
    {
        if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}

        
        if ($request->ajax()) {
            $usebengkel = DB::connection('ts3')->table('mst.mst_bengkel')->where('pic_bengkel',Session()->get('username'))->first();
       
            if(empty($request->from_date) == true) {
       

                $service 	= DB::connection('ts3')->table('mvm.v_service_history')->where('mst_bengkel_id',$usebengkel->id)->get();
             
        

            } else {
               

                 $service 	= DB::connection('ts3')->table('mvm.v_service_history')->where('mst_bengkel_id',$usebengkel->id)
                            ->whereBetween('tanggal_service', array($request->from_date, $request->to_date))->get();

            }
        return DataTables::of($service)->addColumn('action', function($row){
               $btn = '<a href="'. asset('bengkel/report/history-service-detail/'.$row->service_no).'" 
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
                        'content'   => 'bengkel/report/service_detail_history'
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
        
        $storagePath =  $image->source.'/'.$image->unique_data;

        if(!file_exists($storagePath))
        return redirect('bengkel/report/history-service')->with(['warning' => 'File Tidak Di temukan']);
        
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
    
        $nopol = DB::connection('ts3')->table('mst.v_vehicle')->get();

		$data = array(   'title'     => 'Summary Bengkel',
                         'nopol'      => $nopol,
                        'content'   => 'bengkel/report/summary_bengkel'
                    );
        return view('bengkel/layout/wrapper',$data);
    }


    public function rekap_invoice()
    {
        if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }
    
      

		$data = array(   'title'     => 'Rekapitulasi Invoice',
                        //  'invoiceList'      => $invoiceList,
                        'content'   => 'bengkel/report/rekap_invoice'
                    );
        return view('bengkel/layout/wrapper',$data);
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
                    ->where('invoice_type','BENGKEL TO TS3')->where('create_by',Session()->get('username'))->get();

                    

            } else {

                $invoiceList = DB::connection('ts3')->table('mvm.v_rekap_invoice')->where('invoice_type','BENGKEL TO TS3')->where('create_by',Session()->get('username'))->get();

            }


          


            return DataTables::of($invoiceList)->addColumn('action', function ($row) {
                $btn = '<a href="#" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#rkapInvoice' . $row->id . '"><i class="fa fa-eye"></i></a>';


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
                    
                                        <a href="' .asset("bengkel/invoice-generate/{$row->invoice_no}").'"class="btn btn-secondary">
                                            <i class="far fa-file-excel"></i> Generate Invoice
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

  

   
}

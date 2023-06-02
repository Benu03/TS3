<?php

namespace App\Http\Controllers\AdminTs3;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Konfigurasi_model;
use Image;
use PDF;
use Log;

class Invoice extends Controller
{




    public function index()
    {
        if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }
    
        $countinvoicebengkel = DB::connection('ts3')->table('mvm.mvm_invoice_h')->where('status','REQUEST')->where('invoice_type','BENGKEL TO TS3')->count();

        $countinvoicets3 = DB::connection('ts3')->table('mvm.mvm_invoice_h')->where('status','PROSES')->where('invoice_type','BENGKEL TO TS3')->count();
      
        $invoice = DB::connection('ts3')->table('mvm.v_invoice_admin_ts3')->whereIn('status',['PROSES','REQUEST'])->where('invoice_type','BENGKEL TO TS3')->get();
        
		$data = array(   'title'     => 'Invoice Bengkel',
                         'invoice'      => $invoice,
                         'countinvoicebengkel' => $countinvoicebengkel,
                         'countinvoicets3' => $countinvoicets3,
                        'content'   => 'admin-ts3/invoice/index'
                    );
        return view('admin-ts3/layout/wrapper',$data);
    }

    public function invoice_to_client()
    {
        if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }
    
        $countinvoicets3 = DB::connection('ts3')->table('mvm.mvm_invoice_h')->where('status','DRAFT')->where('create_by',Session()->get('username'))->where('invoice_type','TS3 TO CLIENT')->count();

        if($countinvoicets3 == 1)
        {
            return redirect('admin-ts3/invoice-create');
        }
    
        $countinvoicets3pro = DB::connection('ts3')->table('mvm.mvm_invoice_h')->where('status','PROSES')->where('invoice_type','TS3 TO CLIENT')->count();
        $countinvoicets3req = DB::connection('ts3')->table('mvm.mvm_invoice_h')->where('status','REQUEST')->where('invoice_type','TS3 TO CLIENT')->count();
      
        $invoice = DB::connection('ts3')->table('mvm.v_invoice_admin_ts3')->whereIn('status',['PROSES','REQUEST'])->where('invoice_type','TS3 TO CLIENT')->get();
        
		$data = array(   'title'     => 'Invoice To Cliet',
                         'invoice'      => $invoice,                   
                         'countinvoicets3pro' => $countinvoicets3pro,
                         'countinvoicets3req' => $countinvoicets3req,
                        'content'   => 'admin-ts3/invoice/invoice_client'
                    );
        return view('admin-ts3/layout/wrapper',$data);
    }

    public function invoice_generate($invoice_no)
    {

        if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }

        $invoice = DB::connection('ts3')->table('mvm.mvm_invoice_h')->where('invoice_no',$invoice_no)->first();       
        $invoice_detail = DB::connection('ts3')->table('mvm.v_invoice_generate')->where('invoice_no',$invoice_no)->orderby('service_no')->get();

        $bengkel = DB::connection('ts3')->table('mst.mst_bengkel')->where('pic_bengkel',$invoice->create_by)->first();  
        $config = DB::connection('ts3')->table('cp.konfigurasi')->first();

        $pdf = PDF::loadview('bengkel/invoice/pdf/invoice_generate',['invoice'=>$invoice, 'invoice_detail' => $invoice_detail,'bengkel' =>$bengkel, 'config' => $config ])->setPaper('a4', 'landscape');
        $pdf->render();
        $canvas = $pdf->getDomPDF()->getCanvas();

            $w = $canvas->get_width(); 
            $h = $canvas->get_height(); 

        
            $imageURL = storage_path('data/image/logo_pdf.png');
            $imgWidth = 300; 
            $imgHeight = 200; 
            

            $canvas->set_opacity(.1); 
            

            $x = (($w-$imgWidth)/2); 
            $y = (($h-$imgHeight)/2); 
            

            $canvas->image($imageURL, $x, $y, $imgWidth, $imgHeight); 
        
        return $pdf->download($invoice_no.'.pdf');

    }

    public function invoice_proses_page($invoice_no)
    {
        if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }


        $invoice = DB::connection('ts3')->table('mvm.mvm_invoice_h')->where('invoice_no',$invoice_no)->first();       
        $invoice_detail = DB::connection('ts3')->table('mvm.v_invoice_admin_proses')->where('invoice_no',$invoice_no)->orderby('service_no')->get();


        $data = array(   'title'     => 'Invoice Proses',
                         'invoice'      => $invoice,
                         'invoice_detail'      => $invoice_detail,
                        'content'   => 'admin-ts3/invoice/invoice_proses_page'
                    );
        return view('admin-ts3/layout/wrapper',$data);

    }

    public function invoice_create_detail_proses(Request $request)
    {
        if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }

        if($request->id == null)
        {
            return redirect('admin-ts3/invoice-create')->with(['warning' => 'Data Tidak Ada Yang Di pilih']);
        }

        if(isset($_POST['invoice_create'])) {
            $id       = $request->id;
            $checkregional = DB::connection('ts3')->table('mvm.v_invoice_list_create_admin')->select('regional')->whereIn('id',$id)->groupby('regional')->get();  
           
          
            if(count($checkregional) > 1)
            {
                return redirect('admin-ts3/invoice-create')->with(['warning' => 'Data Regional Harus sama']);
            }
            else
            {       
                 $check = json_decode(json_encode($checkregional), FALSE);
                $invoicestaging =   DB::connection('ts3')->table('mvm.v_invoice_detail_admin')->select('regional')->where('invoice_no',$request->invoice_no)->groupby('regional')->get();  
                $staging = json_decode(json_encode($invoicestaging), FALSE);

               if(count($invoicestaging) == 0)
               {

                     

                    $invoice_h_admin =   DB::connection('ts3')->table('mvm.mvm_invoice_h')->insertgetID([
                    'invoice_no'   => $request->invoice_no,
                    'invoice_type'	=> 'TS3 TO CLIENT',
                    'status'	=> 'DRAFT',
                    'created_date'    => date("Y-m-d h:i:sa"),
                    'create_by'     => $request->session()->get('username'),
                    ]); 


                    $invoice_detail = DB::connection('ts3')->table('mvm.mvm_invoice_d')->whereIn('mvm_invoice_h_id',$id)->get();  
                
                    foreach($invoice_detail as $val)
                    {
                        $dataPreparing = [
                            'mvm_invoice_h_id' => $invoice_h_admin,
                            'created_date'    => date("Y-m-d h:i:sa"),
                            'create_by'     => $request->session()->get('username'),
                            'mst_price_service_id' => $val->mst_price_service_id,
                            'service_no' => $val->service_no,
                            'invoice_no' => $request->invoice_no,
                            'price_type' => $val->price_type,
                            'price_ts3_to_client' => $val->price_ts3_to_client,
                            'reference_no' => $val->invoice_no
                        ];
                    
        
                        DB::connection('ts3')->table('mvm.mvm_invoice_d')->insert($dataPreparing);

                    }
                        DB::connection('ts3')->table('mvm.mvm_invoice_h')->whereIn('id',$id)->update([
                        'status'   => 'PROSES',
                        'updated_at'    => date("Y-m-d h:i:sa"),
                        'update_by'         => $request->session()->get('username')
                        ]);   

                        $sumTotalInvoice =  DB::connection('ts3')->table('mvm.v_invoice_detail_prepare_admin')->selectRaw("ROUND((sum(jasa) * 2) / 100) as pph,
                        ROUND(((sum(jasa) + sum(part))* 11) / 100) as ppn,
                        sum(jasa) as jasa,
                        sum(part) as part")->where('invoice_no',$request->invoice_no)->first(); 
                            
                        DB::connection('ts3')->table('mvm.mvm_invoice_h')->where('invoice_no',$request->invoice_no)->update([
                                    'pph'               => $sumTotalInvoice->pph,
                                    'jasa_total'	    => $sumTotalInvoice->jasa,
                                    'part_total'	    => $sumTotalInvoice->part,
                                    'ppn'	            => $sumTotalInvoice->ppn
                                ]);   

            
                
                            
                        return redirect('admin-ts3/invoice-create')->with(['sukses' => 'Data telah Berhasil Di proses']);
                    


               }
               else
               {

                    if($check[0]->regional != $staging[0]->regional)
                    {
                        return redirect('admin-ts3/invoice-create')->with(['warning' => 'Data Regional Harus sama']);
                    }
                    else
                    {

                            $invoice_h_admin =   DB::connection('ts3')->table('mvm.mvm_invoice_h')->insertgetID([
                            'invoice_no'   => $request->invoice_no,
                            'invoice_type'	=> 'TS3 TO CLIENT',
                            'status'	=> 'DRAFT',
                            'created_date'    => date("Y-m-d h:i:sa"),
                            'create_by'     => $request->session()->get('username'),
                            ]); 


                            $invoice_detail = DB::connection('ts3')->table('mvm.mvm_invoice_d')->whereIn('mvm_invoice_h_id',$id)->get();  
                        
                            foreach($invoice_detail as $val)
                            {
                                $dataPreparing = [
                                    'mvm_invoice_h_id' => $invoice_h_admin,
                                    'created_date'    => date("Y-m-d h:i:sa"),
                                    'create_by'     => $request->session()->get('username'),
                                    'mst_price_service_id' => $val->mst_price_service_id,
                                    'service_no' => $val->service_no,
                                    'invoice_no' => $request->invoice_no,
                                    'price_type' => $val->price_type,
                                    'price_ts3_to_client' => $val->price_ts3_to_client,
                                    'reference_no' => $val->invoice_no
                                ];
                            
                
                                DB::connection('ts3')->table('mvm.mvm_invoice_d')->insert($dataPreparing);

                            }
                                DB::connection('ts3')->table('mvm.mvm_invoice_h')->whereIn('id',$id)->update([
                                'status'   => 'PROSES',
                                'updated_at'    => date("Y-m-d h:i:sa"),
                                'update_by'         => $request->session()->get('username')
                                ]);   

                                $sumTotalInvoice =  DB::connection('ts3')->table('mvm.v_invoice_detail_prepare_admin')->selectRaw("ROUND((sum(jasa) * 2) / 100) as pph,
                                ROUND(((sum(jasa) + sum(part))* 11) / 100) as ppn,
                                sum(jasa) as jasa,
                                sum(part) as part")->where('invoice_no',$request->invoice_no)->first(); 
                                    
                                DB::connection('ts3')->table('mvm.mvm_invoice_h')->where('invoice_no',$request->invoice_no)->update([
                                            'pph'               => $sumTotalInvoice->pph,
                                            'jasa_total'	    => $sumTotalInvoice->jasa,
                                            'part_total'	    => $sumTotalInvoice->part,
                                            'ppn'	            => $sumTotalInvoice->ppn
                                        ]);   

                    
                        
                                    
                                return redirect('admin-ts3/invoice-create')->with(['sukses' => 'Data telah Berhasil Di proses']);
                    }
                }
            }
        }
        

    }

    public function get_invoice()
    {

        if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }

        $invoice_no_bengkel = $_POST['invoice_no_bengkel'];
        log::info($invoice_no_bengkel);
        
        $invoice = DB::connection('ts3')->table('mvm.v_invoice_admin_ts3')->where('id',$invoice_no_bengkel)->first();  
        return response()->json($invoice);
     
    }

    public function invoice_create()
    {
        if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }

        $checkInvoice = DB::connection('ts3')->table('mvm.mvm_invoice_h')->where('status','DRAFT')->where('invoice_type','TS3 TO CLIENT')->where('create_by',Session()->get('username'))->first();

        $invoicebkl = DB::connection('ts3')->table('mvm.v_invoice_list_create_admin')->selectRaw('id,invoice_no,invoice_type,sum(jasa) as jasa,sum(part) as part,bengkel_name,regional ')->where('status','REQUEST')->where('invoice_type','BENGKEL TO TS3')->groupBy('id','invoice_no','invoice_type','bengkel_name','regional')->get();  
  


        if(isset($checkInvoice) == false){

            $month = $this->getRomawi(date("m"));
            $invoicenocheck = DB::connection('ts3')->table('mvm.mvm_invoice_h')->where('invoice_type','TS3 TO CLIENT')->orderBy('created_date','DESC')->first();
     
            if($invoicenocheck == null)
            {
                $invoice_no   = '1'.'/INV.TS3'.'/'.$month.'/'.date("Y");  
            }
            else
            {
                $y = explode('/', $invoicenocheck->invoice_no);
                $seq = $y[0]+1;
                $invoice_no   = $seq.'/INV.TS3'.'/'.$month.'/'.date("Y");  
            }
          
                     
        }
        else{
            $invoice_no = $checkInvoice->invoice_no;
        }

        $invoicedtl = DB::connection('ts3')->table('mvm.v_invoice_detail_prepare_admin_ts3')->where('invoice_no',$invoice_no)->get(); 

        $invoiceData = DB::connection('ts3')->table('mvm.v_invoice_detail_prepare_admin')->selectRaw("ROUND((sum(jasa) * 2) / 100) as pph,
        ROUND(((sum(jasa) + sum(part))* 11) / 100) as ppn,
        sum(jasa) as jasa,
        sum(part) as part")->where('invoice_no',$invoice_no)->first(); 

        $invoice_detail = DB::connection('ts3')->table('mvm.v_invoice_generate')->where('invoice_no',$invoice_no)->orderby('service_no')->get();
      
        $data = array(   'title'        => 'Invoice',
                        //  'usebengkel'      => $usebengkel,
                        //  'serviceinvoice'    => $serviceinvoice,
                        //  'priceJobs'    => $priceJobs,
                          'invoicebkl'    => $invoicebkl,
                         'invoicedtl'    => $invoicedtl,
                         'invoice_no'    => $invoice_no,
                         'invoiceData'    => $invoiceData,
                         'invoice_detail'    => $invoice_detail,
                        'content'       => 'admin-ts3/invoice/invoice_create'
                    );
        return view('admin-ts3/layout/wrapper',$data);

    }

    public function invoice_submit(Request $request)
    {
        if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }


        if(isset($request->reset))
        {

    
          
            $CheckInvoice = DB::connection('ts3')->table('mvm.mvm_invoice_d')->selectRaw("reference_no")->where('invoice_no',$request->invoice_no)->groupBy('reference_no')->get();
          
            foreach($CheckInvoice as $val)
            {

            DB::connection('ts3')->table('mvm.mvm_invoice_h')->where('invoice_no',$val->reference_no)->update([
                'status'   => 'REQUEST',
                'updated_at'    => date("Y-m-d h:i:sa"),
                'update_by'         => $request->session()->get('username')
                ]); 
                
            }
            DB::connection('ts3')->table('mvm.mvm_invoice_h')->where('invoice_no',$request->invoice_no)->delete();
            DB::connection('ts3')->table('mvm.mvm_invoice_d')->where('invoice_no',$request->invoice_no)->delete();
    
            return redirect('admin-ts3/invoice/client')->with(['warning' => 'Data telah Berhasil Di Reset']);
        }
        else
        {
        
            DB::connection('ts3')->table('mvm.mvm_invoice_h')->where('invoice_no',$request->invoice_no)->update([
                'status'               => 'REQUEST'
            ]);   
    
            return redirect('admin-ts3/invoice/client')->with(['sukses' => 'Data telah Berhasil Di proses']);

        }


       
        
    }

    public function invoice_bengkel_proses(Request $request)
    {
        if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }

        DB::connection('ts3')->table('mvm.mvm_invoice_h')->where('invoice_no',$request->invoice_no)->update([
            'remark'       => $request->remark,
            'status'       => 'DONE'
        ]);   

        return redirect('admin-ts3/invoice')->with(['sukses' => 'Data telah Berhasil Di proses']);
        
    }


    public function getRomawi($bln)
    {   
        switch ($bln){

                        case 1:

                            return "I";

                            break;

                        case 2:

                            return "II";

                            break;

                        case 3:

                            return "III";

                            break;

                        case 4:

                            return "IV";

                            break;

                        case 5:

                            return "V";

                            break;

                        case 6:

                            return "VI";

                            break;

                        case 7:

                            return "VII";

                            break;

                        case 8:

                            return "VIII";

                            break;

                        case 9:

                            return "IX";

                            break;

                        case 10:

                            return "X";

                            break;

                        case 11:

                            return "XI";

                            break;

                        case 12:

                            return "XII";

                            break;

                    }

    }
    

    public function invoice_generate_ts3($id)
    {

        if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }

        $invoice = DB::connection('ts3')->table('mvm.mvm_invoice_h')->where('id',$id)->first();       
        $invoice_detail = DB::connection('ts3')->table('mvm.v_invoice_detail_admin')->where('invoice_no',$invoice->invoice_no)->get();

        $config = DB::connection('ts3')->table('cp.konfigurasi')->first();
        $logo =  storage_path('data/image/logo_pdf.png');

        $terbilang = $this->terbilang(($invoice->part_total+$invoice->jasa_total+$invoice->ppn)-$invoice->pph);
      
        

        $pdf = PDF::loadview('admin-ts3/invoice/pdf/invoice_generate_ts3',['terbilang' =>$terbilang,'invoice'=>$invoice, 'invoice_detail' => $invoice_detail, 'logo' => $logo, 'config' => $config ])->setPaper('a4');
        $pdf->render();
        $canvas = $pdf->getDomPDF()->getCanvas();

            $w = $canvas->get_width(); 
            $h = $canvas->get_height(); 

        
            $imageURL = storage_path('data/image/logo_pdf.png');
            $imgWidth = 300; 
            $imgHeight = 200; 
            

            $canvas->set_opacity(.1); 
            

            $x = (($w-$imgWidth)/2); 
            $y = (($h-$imgHeight)/2); 
            

            $canvas->image($imageURL, $x, $y, $imgWidth, $imgHeight); 
        
        return $pdf->download($invoice->invoice_no.'.pdf');

    }


    public function penyebut($nilai) 
    {
		$nilai = abs($nilai);
		$huruf = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
		$temp = "";
		if ($nilai < 12) {
			$temp = " ". $huruf[$nilai];
		} else if ($nilai <20) {
			$temp = $this->penyebut($nilai - 10). " Belas";
		} else if ($nilai < 100) {
			$temp = $this->penyebut($nilai/10)." Puluh". $this->penyebut($nilai % 10);
		} else if ($nilai < 200) {
			$temp = " Seratus" . $this->penyebut($nilai - 100);
		} else if ($nilai < 1000) {
			$temp = $this->penyebut($nilai/100) . " Ratus" . $this->penyebut($nilai % 100);
		} else if ($nilai < 2000) {
			$temp = " Seribu" . $this->penyebut($nilai - 1000);
		} else if ($nilai < 1000000) {
			$temp = $this->penyebut($nilai/1000) . " Ribu" . $this->penyebut($nilai % 1000);
		} else if ($nilai < 1000000000) {
			$temp = $this->penyebut($nilai/1000000) . " Juta" . $this->penyebut($nilai % 1000000);
		} else if ($nilai < 1000000000000) {
			$temp = $this->penyebut($nilai/1000000000) . " Milyar" . $this->penyebut(fmod($nilai,1000000000));
		} else if ($nilai < 1000000000000000) {
			$temp = $this->penyebut($nilai/1000000000000) . " Trilyun" . $this->penyebut(fmod($nilai,1000000000000));
		}     
		return $temp;
	}
 
	public function terbilang($nilai) 
    {
		if($nilai<0) {
			$hasil = "minus ". trim($this->penyebut($nilai));
		} else {
			$hasil = trim($this->penyebut($nilai));
		}     		
		return $hasil;
	}


    public function invoice_admin_proses(Request $request) 
	{
		if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }

		DB::connection('ts3')->table('mvm.mvm_invoice_h')->where('invoice_no',$request->invoice_no)->update([
            'remark'       => $request->remark,
            'status'       => 'DONE',
			'update_by' => Session()->get('username'),
			'updated_at' =>  date("Y-m-d h:i:sa")
        ]);   

		return redirect('admin-ts3/invoice/client')->with(['sukses' => 'Invoice Proses Selesai']);

	}

  

   



 
 
 
 }

<?php

namespace App\Http\Controllers\AdminTs3;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Konfigurasi_model;
use Image;
use PDF;

class Invoice extends Controller
{




    public function index()
    {
        if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }
    
        $countinvoicebengkel = DB::connection('ts3')->table('mvm.mvm_invoice_h')->where('status','REQUEST')->where('invoice_type','BENGKEL TO TS3')->count();

        $countinvoicets3 = DB::connection('ts3')->table('mvm.mvm_invoice_h')->where('status','PROSES')->count();
      
        $invoice = DB::connection('ts3')->table('mvm.mvm_invoice_h')->whereIn('status',['PROSES','REQUEST'])->get();
    
		$data = array(   'title'     => 'Invoice',
                         'invoice'      => $invoice,
                         'countinvoicebengkel' => $countinvoicebengkel,
                         'countinvoicets3' => $countinvoicets3,
                        'content'   => 'admin-ts3/invoice/index'
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

        $pdf = PDF::loadview('bengkel/invoice/pdf/invoice_generate',['invoice'=>$invoice, 'invoice_detail' => $invoice_detail])->setPaper('a4', 'landscape');
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
   

    public function invoice_proses(Request $request)
    {
        if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }

        dd($request);



        return redirect('admin-ts3/invoice')->with(['sukses' => 'Data telah di Kirim Ke Client']);            


    }

  

   
}

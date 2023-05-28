<?php

namespace App\Http\Controllers\AdminClient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Konfigurasi_model;
use Image;
use PDF;

class Invoice extends Controller
{


    // Index
    public function index()
    {
        if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }
    
        $countinvoicets3req = DB::connection('ts3')->table('mvm.mvm_invoice_h')->where('status','REQUEST')->where('invoice_type','TS3 TO CLIENT')->count();
        $invoice = DB::connection('ts3')->table('mvm.v_invoice_admin_ts3')->whereIn('status',['PROSES','REQUEST'])->where('invoice_type','TS3 TO CLIENT')->get();

		$data = array(   'title'     => 'Invoice',
                         'invoice'      => $invoice,
                         'countinvoicets3req'      => $countinvoicets3req,
                        'content'   => 'admin-client/invoice/index'
                    );
        return view('admin-client/layout/wrapper',$data);
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
      
        

        $pdf = PDF::loadview('admin-client/invoice/pdf/invoice_generate_ts3',['terbilang' =>$terbilang,'invoice'=>$invoice, 'invoice_detail' => $invoice_detail, 'logo' => $logo, 'config' => $config ])->setPaper('a4');
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
            'remark_client'       => $request->remark,
            'status'       => 'PROSES',
			'client_post' => Session()->get('username'),
			'client_date_post' =>  date("Y-m-d h:i:sa")
        ]);   

		return redirect('admin-client/invoice')->with(['sukses' => 'Data telah Berhasil Di proses']);

	}
	
    
  

   
}

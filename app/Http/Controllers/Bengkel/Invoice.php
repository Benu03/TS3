<?php

namespace App\Http\Controllers\Bengkel;

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
    
        
        $count_req = DB::connection('ts3')->table('mvm.mvm_invoice_h')->where('create_by',Session()->get('username'))->where('status','REQUEST')->count();
        $count_pro = DB::connection('ts3')->table('mvm.mvm_invoice_h')->where('create_by',Session()->get('username'))->where('status','PROSES')->count();
        $invoice = DB::connection('ts3')->table('mvm.mvm_invoice_h')->where('create_by',Session()->get('username'))->get();
		$data = array(   'title'        => 'Invoice',
                         'invoice'      => $invoice,
                         'count_req'    => $count_req,
                         'count_pro'    => $count_pro,
                        'content'       => 'bengkel/invoice/index'
                    );
        return view('bengkel/layout/wrapper',$data);
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
                        'content'   => 'bengkel/invoice/summary_bengkel'
                    );
        return view('bengkel/layout/wrapper',$data);
    }

    public function invoice_create()
    {
        if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }

        $usebengkel = DB::connection('ts3')->table('mst.mst_bengkel')->where('pic_bengkel',Session()->get('username'))->first();
        $serviceinvoice = DB::connection('ts3')->table('mvm.v_service_oninvoice')->where('mst_bengkel_id',$usebengkel->id)->get();
      
        $regional_id = [];
        $client_id = [];

        foreach($serviceinvoice  as $key => $val){
            $regional_id[] = $val->mst_regional_id;
            $client_id[] =  $val->mst_client_id;
        }


        $priceJobs  = DB::connection('ts3')->table('mst.v_price_regional_client')
                    ->select('kode', 'service_name','price_bengkel_to_ts3','price_ts3_to_client')
                    ->wherein('mst_client_id',$client_id)
                    ->wherein('mst_regional_id',$regional_id)
                    ->where('price_service_type','Jasa')
                    ->groupBy('kode', 'service_name','price_bengkel_to_ts3','price_ts3_to_client')
                    ->get();

        $pricePart = DB::connection('ts3')->table('mst.v_price_regional_client')
                    ->select('kode', 'service_name','price_bengkel_to_ts3','price_ts3_to_client')
                    ->wherein('mst_client_id',$client_id)
                    ->wherein('mst_regional_id',$regional_id)
                    ->where('price_service_type','Part')
                    ->groupBy('kode', 'service_name','price_bengkel_to_ts3','price_ts3_to_client')
                    ->get();            


        $invoice_no   = 'INV-'.date("Ymd").'-'.date("i");   

        $invoicedtl = DB::connection('ts3')->table('mvm.v_invoice_detail_prepare')->where('invoice_no',$invoice_no)->get(); 
        $data = array(   'title'        => 'Invoice',
                         'usebengkel'      => $usebengkel,
                         'serviceinvoice'    => $serviceinvoice,
                         'priceJobs'    => $priceJobs,
                         'pricePart'    => $pricePart,
                         'invoicedtl'    => $invoicedtl,
                         'invoice_no'    => $invoice_no,
                        'content'       => 'bengkel/invoice/invoice_create'
                    );
        return view('bengkel/layout/wrapper',$data);


    }

    
    public function invoice_create_detail(Request $request)
    {
        if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }
        dd($request);

        return redirect('bengkel/invoice_create')->with(['sukses' => 'Data Berhasil Di Tambahkan']);
    }


    public function get_service(){

        if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }

        $service_no = $_POST['service_no'];
        log::info($service_no);

        $service = DB::connection('ts3')->table('mvm.v_service_oninvoice')->where('service_no',$service_no)->first();  
        return response()->json($service);
     
    }
    

    


   


  

   
}

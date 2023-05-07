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
    
        $invoice = DB::connection('ts3')->table('mst.v_regional')->get();

		$data = array(   'title'     => 'Invoice',
                         'invoice'      => $invoice,
                        'content'   => 'admin-client/invoice/index'
                    );
        return view('admin-client/layout/wrapper',$data);
    }


  

   
}

<?php

namespace App\Http\Controllers\Bengkel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Konfigurasi_model;
use Image;
use PDF;

class Dasbor extends Controller
{


    public function index()
    {
        if (Session()->get('username') == "") {
            $last_page = url()->full();
            return redirect('login?redirect=' . $last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }
    
        $mysite = new Konfigurasi_model();
        $site = $mysite->listing();
    
        $username = Session()->get('username');
        $bengkel = DB::connection('ts3')->table('mst.mst_bengkel')->where('pic_bengkel', $username)->first();
    
        if (!$bengkel) {
            return redirect('login')->with(['warning' => 'Mohon maaf,User anda belum terpairing ke master bengkel']);
        }
    
        $bengkel_id = $bengkel->id;
        
   
        $countData = DB::connection('ts3')->table('mvm.v_spk_detail')
            ->select(
                DB::raw("COUNT(*) as total_service"),
                DB::raw("SUM(CASE WHEN source = 'Direct' THEN 1 ELSE 0 END) as total_direct")
            )
            ->where('spk_status', 'ONPROGRESS')
            ->whereIn('status_service', ['ONSCHEDULE'])
            ->where('mst_bengkel_id', $bengkel_id)
            ->first();
        
        $countservice = $countData->total_service;
        $direct = $countData->total_direct;
    
        $invoice = DB::connection('ts3')->table('mvm.mvm_invoice_h')
            ->where('create_by', $username)
            ->whereIn('status', ['PROSES', 'REQUEST'])
            ->count();
    
        $data = array(
            'title' => $site->namaweb,
            'content' => 'bengkel/dasbor/index',
            'service' => $countservice,
            'direct' => $direct,
            'invoice' => $invoice
        );
        
        return view('bengkel/layout/wrapper', $data);
    }
}

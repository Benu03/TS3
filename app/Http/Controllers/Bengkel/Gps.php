<?php

namespace App\Http\Controllers\Bengkel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Konfigurasi_model;
use Image;
use PDF;
use Log;

class Gps extends Controller
{


    public function gpsPosting(Request $request)
    {
        if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }

        request()->validate([
            'sn_gps' => 'required',
            'install_date' => 'required|date',
            'uploadgps1' => 'required',
            ]);
        


      Log::info($request);

      return response()->json(['message' => 'Data GPS berhasil disimpan'], 200);

    }
}

<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Konfigurasi_model extends Model
{
    // Main Setting
    public function listing()
    {
    	 $query = DB::connection('ts3')->table('cp.konfigurasi')
            ->select('*')
            ->orderBy('id_konfigurasi','DESC')
            ->first();
        return $query;
    }
}

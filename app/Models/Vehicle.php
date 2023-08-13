<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Vehicle extends Model
{
    
	
    protected $connection   ='ts3';	
    protected $table 		= 'mst.mst_temp_vehicle';
    protected $fillable     = ['client','nopol','norangka','nomesin','type','tahun_pembuatan','tgl_last_service','last_km','nama_stnk','upload_date','user_upload'];

 
}

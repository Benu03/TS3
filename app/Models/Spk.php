<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Spk extends Model
{
    
	
    protected $connection   ='ts3';	
    public $timestamps    = false;
    public $incrementing = false;
    protected $table 		= 'mvm.mvm_temp_spk';
    protected $fillable     = ['user_upload','nopol','nomesin','norangka','tahun_pembuatan','type','branch','remark'];

 
}

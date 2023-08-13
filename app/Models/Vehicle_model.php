<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Vehicle_model extends Model
{
    public function UpdateVehicleData($id)
    {
    	$query = DB::table('rekening')
            ->select('*')
            ->orderBy('id_rekening','DESC')
            ->get();
        return $query;
    }


    public function GetTempVehicle($username)
    {
    	$query = DB::connection('ts3')->table('mst.mst_temp_vehicle')
                ->where('user_upload', $username)->get();
        return $query;
    }



}

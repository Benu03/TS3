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
}

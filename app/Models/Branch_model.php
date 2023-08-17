<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Branch_model extends Model
{


    public function GetBranchTemp($username)
    {
    	$query = DB::connection('ts3')->table('tmp.tmp_branch')
                ->where('user_upload', $username)->get();
        return $query;
    }



}

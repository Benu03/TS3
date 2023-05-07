<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class User_model extends Model
{
    // kategori
    public function login($username,$password)
    {
 
        $query = DB::connection('ts3')->table('auth.users')
            ->select('*')
            ->where(array(  'username'	=> $username,
                            'password'    => sha1($password)))
            ->orderBy('id_user','DESC')
            ->first();
        return $query;
    }

    public function check_user($username)
    {
 
        $query = DB::connection('ts3')->table('auth.users')
            ->select('*')
            ->where(array(  'username'	=> $username))
            ->orderBy('id_user','DESC')
            ->first();
        return $query;
    }

    public function check_user_email($email)
    {
 
        $query = DB::connection('ts3')->table('auth.users')
            ->select('*')
            ->where(array(  'email'	=> $email))
            ->orderBy('id_user','DESC')
            ->first();
        return $query;
    }


    public function pic_cabang($email)
    { 

        $query = DB::connection('ts3')->select( DB::raw("SELECT * from mst.mst_branch mb  where mst_area_id in (select id from mst.mst_area ma where mst_regional_id in (select id from mst.mst_regional where mst_client_id = (select distinct mst_client_id from mst.mst_user_client where username ='$email')))"));
        return $query;

    }


}

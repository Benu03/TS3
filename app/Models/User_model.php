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

}

<?php

namespace App\Http\Controllers\ComPro;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User_model;
use App\Helpers\Website;

class Login extends Controller
{
    // Main page
    public function index()
    {
    
    	$site = DB::connection('ts3')->table('cp.konfigurasi')->first();
        $data = array(  'title'     => 'Login',
    					'site'		=> $site);
        return view('login/index',$data);
    }

    // Cek
    public function check(Request $request)
    {
        $username   = $request->username;
        $password   = $request->password;
        $model      = new User_model();
        $user       = $model->login($username,$password);

        
        if(isset($user) == true){

                if($user->id_role == 1) 
                {
                    $request->session()->put('id_user', $user->id_user);
                    $request->session()->put('nama', $user->nama);
                    $request->session()->put('username', $user->username);
                    $request->session()->put('id_role', $user->id_role);
                    return redirect('admin-cms/dasbor')->with(['sukses' => 'Anda berhasil login']);
                }
                elseif($user->id_role == 2) 
                {
                    $request->session()->put('id_user', $user->id_user);
                    $request->session()->put('nama', $user->nama);
                    $request->session()->put('username', $user->username);
                    $request->session()->put('id_role', $user->id_role);
                    return redirect('admin-ts3/dasbor')->with(['sukses' => 'Anda berhasil login']);

                }
                elseif($user->id_role == 3) 
                {
                    $request->session()->put('id_user', $user->id_user);
                    $request->session()->put('nama', $user->nama);
                    $request->session()->put('username', $user->username);
                    $request->session()->put('id_role', $user->id_role);
                    return redirect('admin-client/dasbor')->with(['sukses' => 'Anda berhasil login']);

                }
                elseif($user->id_role == 4) 
                {
                    $request->session()->put('id_user', $user->id_user);
                    $request->session()->put('nama', $user->nama);
                    $request->session()->put('username', $user->username);
                    $request->session()->put('id_role', $user->id_role);
                    return redirect('bengkel/dasbor')->with(['sukses' => 'Anda berhasil login']);

                }
                elseif($user->id_role == 5) 
                {
                    $request->session()->put('id_user', $user->id_user);
                    $request->session()->put('nama', $user->nama);
                    $request->session()->put('username', $user->username);
                    $request->session()->put('id_role', $user->id_role);
                    return redirect('pic/dasbor')->with(['sukses' => 'Anda berhasil login']);

                }
                else{

                    return redirect('login')->with(['warning' => 'Mohon maaf,Role Akses Anda Belum Terdaftar']);
                }
        }
        else
        {
            return redirect('login')->with(['warning' => 'Mohon maaf, Username atau password salah']);
        }
    }

    // Homepage
    public function logout()
    {
        Session()->forget('id_user');
        Session()->forget('nama');
        Session()->forget('username');
        Session()->forget('akses_level');
        return redirect('login')->with(['sukses' => 'Anda berhasil logout']);
    }

    // Forgot password
    public function fogot()
    {
    	$site = DB::connection('ts3')->table('cp.konfigurasi')->first();
       	$data = array(  'title'     => 'Lupa Password',
    					'site'		=> $site);
        return view('login/lupa',$data);
    }
}

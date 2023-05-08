<?php

namespace App\Http\Controllers\Pic;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Konfigurasi_model;
use Image;
use PDF;

class Profile extends Controller
{



    public function index()
    {
        if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }
    	$mysite = new Konfigurasi_model();
		$site 	= $mysite->listing();

        $user = DB::connection('ts3')->table('auth.v_list_user')->where('email',Session()->get('username'))->first();
        $user_m = DB::connection('ts3')->table('auth.users')->where('email',Session()->get('username'))->first();
        
       
		$data = array(  'title'     => 'Profile',
                        'user'     =>  $user,
                        'user_m'     => $user_m,
                        'content'   => 'pic/dasbor/profile'
                    );
        return view('pic/layout/wrapper',$data);
    }

    public function ubah_password(Request $request)
    {

        if($request->password1 <> $request->password2){

            return redirect('pic/profile')->with(['warning' => 'Password Tidak sama']);
        }
        else
        {
            DB::connection('ts3')->table('auth.users')->where('username',$request->username)->update([
                'password'      => sha1($request->password1),
                'updated_at'    => date("Y-m-d h:i:sa"),
                'update_by'     => Session()->get('username')
            ]);
        return redirect('pic/profile')->with(['sukses' => 'Password berhasil Di Update']);  
        }

    }

}

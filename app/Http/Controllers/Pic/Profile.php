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
        
       
		$data = array(  'title'     => 'Profile',
                        'content'   => 'pic/dasbor/profile'
                    );
        return view('pic/layout/wrapper',$data);
    }
}

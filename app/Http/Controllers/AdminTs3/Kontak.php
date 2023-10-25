<?php

namespace App\Http\Controllers\AdminTs3;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Pagination\Paginator;
use Image;
use App\Models\Kontak_model;

class Kontak extends Controller
{
    // Main page
    public function index()
    {
    	if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
       
		$kontak 	=  DB::connection('ts3')->table('cp.kategori')->orderBy('urutan','ASC')->get();

		$data = array(  'title'       => 'Kontak',
						'kontak'    => $kontak,
                        'content'     => 'admin-ts3/kontak/index'
                    );
        return view('admin-ts3/layout/wrapper',$data);
    }

   
}

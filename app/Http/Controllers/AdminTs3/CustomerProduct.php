<?php
namespace App\Http\Controllers\AdminTs3;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Image;

class CustomerProduct extends Controller
{
    // Index
    public function index()
    {
    	if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
		$user 	= DB::connection('ts3')->table('auth.v_list_user')->orderBy('id_user','DESC')->get();
        $role 	= DB::connection('ts3')->table('auth.user_roles')->where('id', '!=' , 1)->get();
        $customer 	= DB::connection('ts3')->table('mst.mst_customer')->get();
		$data = array(  'title'     => 'Customer & Product',
						'user'      => $user,
                        'roledata'      => $role,
                        'customerdata'      => $customer,
                        'content'   => 'admin-ts3/cuspro/index'
                    );
        return view('admin-ts3/layout/wrapper',$data);
    }

   
}

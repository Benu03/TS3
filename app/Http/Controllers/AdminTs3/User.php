<?php
namespace App\Http\Controllers\AdminTs3;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Image;

class User extends Controller
{
    // Index
    public function index()
    {
    	if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
		$user 	= DB::connection('ts3')->table('auth.v_list_user')->orderBy('id_user','DESC')->get();
        $role 	= DB::connection('ts3')->table('auth.user_roles')->where('id', '!=' , 1)->get();
        $customer 	= DB::connection('ts3')->table('mst.mst_client')->get();
		$data = array(  'title'     => 'Pengguna Sistem',
						'user'      => $user,
                        'roledata'      => $role,
                        'customerdata'      => $customer,
                        'content'   => 'admin-ts3/user/index'
                    );
        return view('admin-ts3/layout/wrapper',$data);
    }

    // Index
    public function edit($id_user)
    {
        if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
        $user   =   DB::connection('ts3')->table('auth.users')->where('id_user',$id_user)->orderBy('id_user','DESC')->first();
        $role 	=   DB::connection('ts3')->table('auth.user_roles')->where('id', '!=' , 1)->get();
        $customer 	= DB::connection('ts3')->table('mst.mst_client')->get();
        $usercustomer   =   DB::connection('ts3')->table('mst.mst_user_client')->where('username',$user->username)->first();

        if(empty($usercustomer)){
            $data  = [
                'username' => '',
                'mst_client_id' => ''
            ];
            $usercustomer =  json_decode(json_encode($data), FALSE);
        }


        $data = array(  'title'     => 'Edit Pengguna Website',
                        'user'      => $user,
                        'roledata'     => $role,
                        'customerdata'      => $customer,
                        'usercustomer'      => $usercustomer,
                        'content'   => 'admin-ts3/user/edit'
                    );
        return view('admin-ts3/layout/wrapper',$data);
    }

    // Proses
    public function proses(Request $request)
    {
        $site   =DB::connection('ts3')->table('cp.konfigurasi')->first();
        // PROSES HAPUS MULTIPLE

 
        if(isset($_POST['hapus'])) {
            $id_usernya       = $request->id_user;
            $username       = $request->username;
            for($i=0; $i < sizeof($id_usernya);$i++) {
                $user   =   DB::connection('ts3')->table('auth.users')->where('id_user',$id_usernya[$i])->first();
       
               DB::connection('ts3')->table('mst.mst_user_client')->where('username',$user->username)->delete();
               DB::connection('ts3')->table('auth.users')->where('id_user',$id_usernya[$i])->delete();
            }
        
            return redirect('admin-ts3/user')->with(['sukses' => 'Data telah dihapus']);
        // PROSES SETTING DRAFT
        }
    }

    // tambah
    public function tambah(Request $request)
    {
    	if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
    	request()->validate([
                            'nama'     => 'required',
					        'username' => 'required|unique:ts3.auth.users',
					        'password' => 'required',
                            'email'    => 'required',
                            // 'gambar'   => 'file|image|mimes:jpeg,png,jpg|max:8024',
					        ]);
        // UPLOAD START
        $image                  = $request->file('gambar');
        if(!empty($image)) {
            $filenamewithextension  = $request->file('gambar')->getClientOriginalName();
            $filename               = pathinfo($filenamewithextension, PATHINFO_FILENAME);
            $input['nama_file']     = Str::slug($filename, '-').'-'.time().'.'.$image->getClientOriginalExtension();
            $destinationPath        = './assets/upload/user/thumbs/';
            $img = Image::make($image->getRealPath(),array(
                'width'     => 150,
                'height'    => 150,
                'grayscale' => false
            ));
            $img->save($destinationPath.'/'.$input['nama_file']);
            $destinationPath = './assets/upload/user/';
            $image->move($destinationPath, $input['nama_file']);
            // END UPLOAD
            
           DB::connection('ts3')->table('auth.users')->insert([
                'nama'          => $request->nama,
                'email'	        => $request->email,
                'username'   	=> $request->username,
                'password'      => sha1($request->password),
                'id_role'       => $request->role,
                'gambar'        => $input['nama_file'],
                'created_at'    => date("Y-m-d h:i:sa"),
                'create_by'     => $request->session()->get('username'),
                'is_active'     => true
            ]);

            
            if($request->role == 3  || $request->role == 5) {
            DB::connection('ts3')->table('mst.mst_user_client')->insert([
                'username'   	=> $request->username,
                'mst_client_id'   	=> $request->customer,
                'created_date'    => date("Y-m-d h:i:sa"),
                'create_by'     => $request->session()->get('username')
            ]);

        }

        }else{
            DB::connection('ts3')->table('auth.users')->insert([
                'nama'          => $request->nama,
                'email'         => $request->email,
                'username'      => $request->username,
                'password'      => sha1($request->password),
                'id_role'       => $request->role,
                'created_at'    => date("Y-m-d h:i:sa"),
                'create_by'     => $request->session()->get('username'),
                'is_active'     => true
            ]);

            if($request->role == 3  || $request->role == 5) {
            DB::connection('ts3')->table('mst.mst_user_client')->insert([
                'username'   	=> $request->username,
                'mst_client_id'   	=> $request->customer,
                'created_date'    => date("Y-m-d h:i:sa"),
                'create_by'     => $request->session()->get('username')
            ]);
         }
        }
        return redirect('admin-ts3/user')->with(['sukses' => 'Data telah ditambah']);
    }

    // edit
    public function proses_edit(Request $request)
    {
    	if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
    	request()->validate([
					        'nama'     => 'required',
                            'username' => 'required',
                            'password' => 'required',
                            'email'    => 'required',
                            'gambar'   => 'file|image|mimes:jpeg,png,jpg|max:8024',
					        ]);
        // UPLOAD START
        $image                  = $request->file('gambar');
        if(!empty($image)) {
            // UPLOAD START
            $filenamewithextension  = $request->file('gambar')->getClientOriginalName();
            $filename               = pathinfo($filenamewithextension, PATHINFO_FILENAME);
            $input['nama_file']     = Str::slug($filename, '-').'-'.time().'.'.$image->getClientOriginalExtension();
            $destinationPath        = './assets/upload/user/thumbs/';
            $img = Image::make($image->getRealPath(),array(
                'width'     => 150,
                'height'    => 150,
                'grayscale' => false
            ));
            $img->save($destinationPath.'/'.$input['nama_file']);
            $destinationPath = './assets/upload/user/';
            $image->move($destinationPath, $input['nama_file']);
            // END UPLOAD
            $slug_user = Str::slug($request->nama, '-');
        

           DB::connection('ts3')->table('auth.users')->where('id_user',$request->id_user)->update([
                'nama'          => $request->nama,
                'email'         => $request->email,
                'username'      => $request->username,
                'password'      => sha1($request->password),
                'id_role'       => $request->role,
                'gambar'        => $input['nama_file'],
                'updated_at'    => date("Y-m-d h:i:sa"),
                'update_by'     => $request->session()->get('username')
            ]);

            $UserClientCheck = DB::connection('ts3')->table('mst.mst_user_client')->where('username',$request->username)->count();
            
            if($request->role == 3  || $request->role == 5) {
                if($UserClientCheck == 0)
                {
                    DB::connection('ts3')->table('mst.mst_user_client')->insert([
                        'username'   	=> $request->username,
                        'mst_client_id'   	=> $request->customer,
                        'created_date'    => date("Y-m-d h:i:sa"),
                        'create_by'     => $request->session()->get('username')
                    ]);

                }
                else
                {
                    DB::connection('ts3')->table('mst.mst_user_client')->where('username',$request->username)->update([
                        'mst_client_id'    => $request->customer,
                        'updated_at'    => date("Y-m-d h:i:sa"),
                        'update_by'     => $request->session()->get('username')
                    ]);
                }

             }

        }else{
            $slug_user = Str::slug($request->nama, '-');
           DB::connection('ts3')->table('auth.users')->where('id_user',$request->id_user)->update([
                'nama'          => $request->nama,
                'email'         => $request->email,
                'username'      => $request->username,
                'password'      => sha1($request->password),
                'id_role'       => $request->role,
                'updated_at'    => date("Y-m-d h:i:sa"),
                'update_by'     => $request->session()->get('username')
            ]);
         
            $UserClientCheck = DB::connection('ts3')->table('mst.mst_user_client')->where('username',$request->username)->count();
            
            if($request->role == 3  || $request->role == 5) {
                if($UserClientCheck == 0)
                {
                    DB::connection('ts3')->table('mst.mst_user_client')->insert([
                        'username'   	=> $request->username,
                        'mst_client_id'   	=> $request->customer,
                        'created_date'    => date("Y-m-d h:i:sa"),
                        'create_by'     => $request->session()->get('username')
                    ]);

                }
                else
                {
                    DB::connection('ts3')->table('mst.mst_user_client')->where('username',$request->username)->update([
                        'mst_client_id'    => $request->customer,
                        'updated_at'    => date("Y-m-d h:i:sa"),
                        'update_by'     => $request->session()->get('username')
                    ]);
                }

             }

        }
        return redirect('admin-ts3/user')->with(['sukses' => 'Data telah diupdate']);
    }

    // Delete
    public function delete($username)
    {
    	if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
     
        DB::connection('ts3')->table('mst.mst_user_client')->where('username',$username)->delete();
    	DB::connection('ts3')->table('auth.users')->where('username',$username)->delete();


    	return redirect('admin-ts3/user')->with(['sukses' => 'Data telah dihapus']);
    }
}

<?php
namespace App\Http\Controllers\AdminTs3;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Image;
use DataTables;
use Log;

class User extends Controller
{
    // Index
    public function index()
    {
    	if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
		// $user 	= DB::connection('ts3')->table('auth.v_list_user')->orderBy('id_user','DESC')->get();
        $role 	= DB::connection('ts3')->table('auth.user_roles')->where('id', '!=' , 1)->get();
        $customer 	= DB::connection('ts3')->table('mst.mst_client')->get();
		$data = array(  'title'     => 'Pengguna Sistem',
						// 'user'      => $user,
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
       
                try
                { 
                        DB::connection('ts3')->table('mst.mst_user_client')->where('username',$user->username)->delete();
                        DB::connection('ts3')->table('auth.users')->where('id_user',$id_usernya[$i])->delete();
                        DB::commit();

                }
                catch (\Illuminate\Database\QueryException $e) {
                    DB::rollback();
                    return redirect('admin-ts3/user')->with(['warning' => $e]);
                }
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
            $img = Image::make($image->path());
            $img->resize(850, 850, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath.'/'.$input['nama_file']);
            $destinationPath = './assets/upload/user/';
            $image->move($destinationPath, $input['nama_file']);
            // END UPLOAD

            try{   
            
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
            DB::commit();

            }
            catch (\Illuminate\Database\QueryException $e) {
                DB::rollback();
                return redirect('admin-ts3/client')->with(['warning' => $e]);
            }

        }else{

            try{  
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
         DB::commit();

        }
        catch (\Illuminate\Database\QueryException $e) {
            DB::rollback();
            return redirect('admin-ts3/client')->with(['warning' => $e]);
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
                            'phone'    => 'required',
                            'wa'    => 'required',
                            'gambar'   => 'file|image|mimes:jpeg,png,jpg|max:8024',
					        ]);
        // UPLOAD START

        if(isset($request->active)){ $isactive = 1;} else { $isactive = 0; }
        if(isset($request->confirm)){ $isconfirm = 'true'; } else { $isconfirm = 'false'; }




        $image                  = $request->file('gambar');
        if(!empty($image)) {
            // UPLOAD START
            $filenamewithextension  = $request->file('gambar')->getClientOriginalName();
            $filename               = pathinfo($filenamewithextension, PATHINFO_FILENAME);
            $input['nama_file']     = Str::slug($filename, '-').'-'.time().'.'.$image->getClientOriginalExtension();
            $destinationPath        = './assets/upload/user/thumbs/';
            $img = Image::make($image->path());
            $img->resize(850, 850, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath.'/'.$input['nama_file']);
            $destinationPath = './assets/upload/user/';
            $image->move($destinationPath, $input['nama_file']);
            // END UPLOAD
            $slug_user = Str::slug($request->nama, '-');
           
          
            try{  
                
                
           DB::connection('ts3')->table('auth.users')->where('id_user',$request->id_user)->update([
                'nama'          => $request->nama,
                'email'         => $request->email,
                'username'      => $request->username,
                'password'      => sha1($request->password),
                'id_role'       => $request->role,
                'gambar'        => $input['nama_file'],
                'updated_at'    => date("Y-m-d h:i:sa"),
                'update_by'     => $request->session()->get('username'),
                'phone'       => $request->phone,
                'wa_number'       => $request->wa,
                'is_active'       => $isactive,
                'is_confirm'       => $isconfirm
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
             DB::commit();

            }
            catch (\Illuminate\Database\QueryException $e) {
                DB::rollback();
                return redirect('admin-ts3/client')->with(['warning' => $e]);
            }
            
          

        }else{
            $slug_user = Str::slug($request->nama, '-');
            try{
         
           DB::connection('ts3')->table('auth.users')->where('id_user',$request->id_user)->update([
                'nama'          => $request->nama,
                'email'         => $request->email,
                'username'      => $request->username,
                'password'      => sha1($request->password),
                'id_role'       => $request->role,
                'updated_at'    => date("Y-m-d h:i:sa"),
                'update_by'     => $request->session()->get('username'),
                'phone'       => $request->phone,
                'wa_number'       => $request->wa,
                'is_active'       => $isactive,
                'is_confirm'       => $isconfirm
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
             DB::commit();

            }
            catch (\Illuminate\Database\QueryException $e) {
                DB::rollback();
                return redirect('admin-ts3/client')->with(['warning' => $e]);
            }
            

        }
        return redirect('admin-ts3/user')->with(['sukses' => 'Data telah diupdate']);
    }

    // Delete
    public function delete($username)
    {
    	if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
     
        try{
        DB::connection('ts3')->table('mst.mst_user_client')->where('username',$username)->delete();
    	DB::connection('ts3')->table('auth.users')->where('username',$username)->delete();
        
        DB::commit();
        }
        catch (\Illuminate\Database\QueryException $e) {
            DB::rollback();
            return redirect('admin-ts3/price-service')->with(['warning' => $e]);
        }

    	return redirect('admin-ts3/user')->with(['sukses' => 'Data telah dihapus']);
    }

    public function getUser(Request $request)
    {
        if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
    
   
        if ($request->ajax()) {
        
            $datauser 	= DB::connection('ts3')->table('auth.v_list_user')->get();
       
            return DataTables::of($datauser)
                ->addColumn('action', function($row){
                    $btn = '<div class="btn-group">
                            <a href="'. asset('admin-ts3/user/edit/'.$row->id_user).'" 
                                class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>
                            <a href="'. asset('admin-ts3/user/delete/'.$row->id_user).'" class="btn btn-danger btn-sm  delete-link">
                                    <i class="fa fa-trash"></i></a>
                            </div>';
                return $btn; })
                ->addColumn('check', function($row){
                    $check = '<div class="icheck-primary">
                                <input type="checkbox" class="icheckbox_flat-blue " name="id_user[]" value="'.$row->id_user.'" id="check'.$row->id_user.'">
                               <label for="check'.$row->id_user.'"></label>
                                </div>';
                    return $check; })
                ->addColumn('gambaruser', function ($row) {
                     if($row->gambar <> null)
                     {
                        $gmbar = '<img src="'. asset('assets/upload/user/thumbs/'.$row->gambar).'" class="img img-fluid img-thumbnail">';
                      }
                      else
                      {
                        $gmbar = '<small class="btn btn-sm btn-warning">Tidak ada</small>'; 
                        }                         
                        return $gmbar;
                    }) 
                ->addColumn('contact', function($row){
                    if($row->wa_number <> null)
                     {
                        $contact = $row->phone.' <a href="https://wa.me/'.$row->wa_number.'" target="_blank"><i class="fab fa-whatsapp fa-lg"></i></a>';
                      }
                      else
                      {
                        $contact = $row->phone;
                      }            

                       
                        return $contact; })
                ->rawColumns(['action','check','gambaruser','contact'])
                ->make(true);
       
        }

    }

}

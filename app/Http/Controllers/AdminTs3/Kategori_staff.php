<?php
namespace App\Http\Controllers\AdminTs3;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Kategori_staff extends Controller
{
    // Index
    public function index()
    {
    	if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
		$kategori_staff 	= DB::connection('ts3')->table('cp.kategori_staff')->orderBy('urutan','ASC')->get();

		$data = array(  'title'             => 'Kategori Staff',
						'kategori_staff'	=> $kategori_staff,
                        'content'           => 'admin-ts3/kategori_staff/index'
                    );
        return view('admin-ts3/layout/wrapper',$data);
    }

    // tambah
    public function tambah(Request $request)
    {
    	if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
    	request()->validate([
					        'nama_kategori_staff' => 'required|unique:ts3.cp.kategori_staff',
					        'urutan' 		       => 'required',
					        ]);
    	$slug_kategori_staff = Str::slug($request->nama_kategori_staff, '-');
        DB::connection('ts3')->table('cp.kategori_staff')->insert([
            'nama_kategori_staff'   => $request->nama_kategori_staff,
            'bahasa'   => 'ID',
            'slug_kategori_staff'	=> $slug_kategori_staff,
            'keterangan'            => $request->keterangan,
            'urutan'   		        => $request->urutan
        ]);
        return redirect('admin-ts3/kategori_staff')->with(['sukses' => 'Data telah ditambah']);
    }

    // edit
    public function edit(Request $request)
    {
    	if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
    	request()->validate([
					        'nama_kategori_staff' => 'required',
					        'urutan'               => 'required',
					        ]);
    	$slug_kategori_staff = Str::slug($request->nama_kategori_staff, '-');
        DB::connection('ts3')->table('cp.kategori_staff')->where('id_kategori_staff',$request->id_kategori_staff)->update([
            'nama_kategori_staff'   => $request->nama_kategori_staff,
            'bahasa'   => 'ID',
            'slug_kategori_staff'	=> $slug_kategori_staff,
            'keterangan'            => $request->keterangan,
            'urutan'                => $request->urutan
        ]);
        return redirect('admin-ts3/kategori_staff')->with(['sukses' => 'Data telah diupdate']);
    }

    // Delete
    public function delete($id_kategori_staff)
    {
    	if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
    	DB::connection('ts3')->table('cp.kategori_staff')->where('id_kategori_staff',$id_kategori_staff)->delete();
    	return redirect('admin-ts3/kategori_staff')->with(['sukses' => 'Data telah dihapus']);
    }
}

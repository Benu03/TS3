<?php
namespace App\Http\Controllers\AdminTs3;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Kategori_galeri extends Controller
{
    // Index
    public function index()
    {
    	if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
		$kategori_galeri 	=  DB::connection('ts3')->table('cp.kategori_galeri')->orderBy('urutan','ASC')->get();

		$data = array(  'title'             => 'Kategori Galeri',
						'kategori_galeri'	=> $kategori_galeri,
                        'content'           => 'admin-ts3/kategori_galeri/index'
                    );
        return view('admin-ts3/layout/wrapper',$data);
    }

    // tambah
    public function tambah(Request $request)
    {
    	if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
    	request()->validate([
					        'nama_kategori_galeri' => 'required|unique:ts3.cp.kategori_galeri',
					        'urutan' 		       => 'required',
					        ]);
    	$slug_kategori_galeri = Str::slug($request->nama_kategori_galeri, '-');
        DB::connection('ts3')->table('cp.kategori_galeri')->insert([
            'nama_kategori_galeri'  => $request->nama_kategori_galeri,
            'slug_kategori_galeri'	=> $slug_kategori_galeri,
            'urutan'   		        => $request->urutan
        ]);
        return redirect('admin-ts3/kategori_galeri')->with(['sukses' => 'Data telah ditambah']);
    }

    // edit
    public function edit(Request $request)
    {
    	if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
    	request()->validate([
					        'nama_kategori_galeri' => 'required',
					        'urutan'               => 'required',
					        ]);
    	$slug_kategori_galeri = Str::slug($request->nama_kategori_galeri, '-');
        DB::connection('ts3')->table('cp.kategori_galeri')->where('id_kategori_galeri',$request->id_kategori_galeri)->update([
            'nama_kategori_galeri'  => $request->nama_kategori_galeri,
            'slug_kategori_galeri'	=> $slug_kategori_galeri,
            'urutan'                => $request->urutan
        ]);
        return redirect('admin-ts3/kategori_galeri')->with(['sukses' => 'Data telah diupdate']);
    }

    // Delete
    public function delete($id_kategori_galeri)
    {
    	if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
    	DB::connection('ts3')->table('cp.kategori_galeri')->where('id_kategori_galeri',$id_kategori_galeri)->delete();
    	return redirect('admin-ts3/kategori_galeri')->with(['sukses' => 'Data telah dihapus']);
    }
}

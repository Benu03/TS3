<?php
namespace App\Http\Controllers\AdminTs3;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Kategori extends Controller
{
    // Index
    public function index()
    {
    	if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
		$kategori 	=  DB::connection('ts3')->table('cp.kategori')->orderBy('urutan','ASC')->get();

		$data = array(  'title'     => 'Kategori Berita',
						'kategori'	=> $kategori,
                        'content'   => 'admin-ts3/kategori/index'
                    );
        return view('admin-ts3/layout/wrapper',$data);
    }

    // tambah
    public function tambah(Request $request)
    {
    	if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
    	request()->validate([
					        'nama_kategori' => 'required|unique:kategori',
					        'urutan' 		=> 'required',
					        ]);
    	$slug_kategori = Str::slug($request->nama_kategori, '-');
        DB::connection('ts3')->table('cp.kategori')->insert([
            'id_user'       => Session()->get('id_user'),
            'nama_kategori' => $request->nama_kategori,
            'slug_kategori'	=> $slug_kategori,
            'urutan'   		=> $request->urutan
        ]);
        return redirect('admin-ts3/kategori')->with(['sukses' => 'Data telah ditambah']);
    }

    // edit
    public function edit(Request $request)
    {
    	if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
    	request()->validate([
					        'nama_kategori' => 'required',
					        'urutan' 		=> 'required',
					        ]);
    	$slug_kategori = Str::slug($request->nama_kategori, '-');
        DB::connection('ts3')->table('cp.kategori')->where('id_kategori',$request->id_kategori)->update([
            'id_user'       => Session()->get('id_user'),
            'nama_kategori' => $request->nama_kategori,
            'slug_kategori'	=> $slug_kategori,
            'urutan'   		=> $request->urutan
        ]);
        return redirect('admin-ts3/kategori')->with(['sukses' => 'Data telah diupdate']);
    }

    // Delete
    public function delete($id_kategori)
    {
    	if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
        DB::connection('ts3')->table('cp.kategori')->where('id_kategori',$id_kategori)->delete();
    	return redirect('admin-ts3/kategori')->with(['sukses' => 'Data telah dihapus']);
    }
}

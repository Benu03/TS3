<?php
namespace App\Http\Controllers\AdminTs3;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Image;

class Heading extends Controller
{
    // Index
    public function index()
    {
    	if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
		$heading 	= DB::connection('ts3')->table('cp.heading')->orderBy('judul_heading','ASC')->get();

		$data = array(  'title'         => 'Setting Header',
						'heading'	    => $heading,
                        'content'       => 'admin-ts3/heading/index'
                    );
        return view('admin-ts3/layout/wrapper',$data);
    }

    // tambah
    public function tambah(Request $request)
    {
    	if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
    	request()->validate([
					        'judul_heading' => 'required',
                            'gambar'        => 'required|file|image|mimes:jpeg,png,jpg|max:8024',
					        ]);
        // UPLOAD START
        $image                  = $request->file('gambar');
        $filenamewithextension  = $request->file('gambar')->getClientOriginalName();
        $filename               = pathinfo($filenamewithextension, PATHINFO_FILENAME);
        $input['nama_file']     = Str::slug($filename, '-').'-'.time().'.'.$image->getClientOriginalExtension();
        $destinationPath        = './assets/upload/image/thumbs';
        $img = Image::make($image->getRealPath(),array(
            'width'     => 150,
            'height'    => 150,
            'grayscale' => false
        ));
        $img->save($destinationPath.'/'.$input['nama_file']);
        $destinationPath = './assets/upload/image';
        $image->move($destinationPath, $input['nama_file']);
        // END UPLOAD
        DB::connection('ts3')->table('cp.heading')->insert([
            'judul_heading' => $request->judul_heading,
            'keterangan'    => $request->keterangan,
            'gambar'        => $input['nama_file'],
            'halaman'       => $request->halaman
        ]);

         
        return redirect('admin-ts3/heading')->with(['sukses' => 'Data telah ditambah']);
    }

    // edit
    public function edit(Request $request)
    {
    	if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
    	request()->validate([
					        'judul_heading' => 'required',
					        'judul_heading'               => 'required',
                            'gambar'               => 'file|image|mimes:jpeg,png,jpg|max:8024',
					        ]);
        // UPLOAD START
        $image                  = $request->file('gambar');
        if(!empty($image)) {
            // UPLOAD START
            $filenamewithextension  = $request->file('gambar')->getClientOriginalName();
            $filename               = pathinfo($filenamewithextension, PATHINFO_FILENAME);
            $input['nama_file']     = Str::slug($filename, '-').'-'.time().'.'.$image->getClientOriginalExtension();
            $destinationPath        = './assets/upload/image/thumbs';
            $img = Image::make($image->getRealPath(),array(
                'width'     => 150,
                'height'    => 150,
                'grayscale' => false
            ));
            $img->save($destinationPath.'/'.$input['nama_file']);
            $destinationPath = './assets/upload/image';
            $image->move($destinationPath, $input['nama_file']);
            // END UPLOAD
            $slug_heading = Str::slug($request->judul_heading, '-');
            DB::connection('ts3')->table('cp.heading')->where('id_heading',$request->id_heading)->update([
                'judul_heading' => $request->judul_heading,
                'keterangan'    => $request->keterangan,
                'gambar'        => $input['nama_file'],
                'halaman'       => $request->halaman
            ]);
        }else{
            $slug_heading = Str::slug($request->judul_heading, '-');
            DB::connection('ts3')->table('cp.heading')->where('id_heading',$request->id_heading)->update([
                'judul_heading' => $request->judul_heading,
                'keterangan'    => $request->keterangan,
                // 'gambar'        => $input['nama_file'],
                'halaman'       => $request->halaman
            ]);
        }
        return redirect('admin-ts3/heading')->with(['sukses' => 'Data telah diupdate']);
    }

    // Delete
    public function delete($id_heading)
    {
    	if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
    	DB::connection('ts3')->table('cp.heading')->where('id_heading',$id_heading)->delete();
    	return redirect('admin-ts3/heading')->with(['sukses' => 'Data telah dihapus']);
    }
}

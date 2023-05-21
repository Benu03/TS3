<?php
namespace App\Http\Controllers\AdminTs3;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Image;

class PriceService extends Controller
{
    // Index
    public function index()
    {
    	if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
      
        $price 	= DB::connection('ts3')->table('mst.v_price_service')->get();
        $client 	= DB::connection('ts3')->table('mst.mst_client')->where('client_type','B2B')->get();
        $regional 	= DB::connection('ts3')->table('mst.mst_regional')->get();        
        $kode_max 	= DB::connection('ts3')->table('mst.v_price_service')->selectRaw("concat('TS3-',max(substring(kode from 5 for 5)::int + 1)) as kode")->first();
        $price_type = DB::connection('ts3')->table('mst.mst_general')->where('name','price_service_type')->get();

		$data = array(  'title'     => 'Price Service',
                        'kode_max'   => $kode_max,
                        'price'      => $price,
                        'client'      => $client,
                        'regional'      => $regional,
                        'price_type'      => $price_type,
                        'content'   => 'admin-ts3/price_service/index');
        
        return view('admin-ts3/layout/wrapper',$data);
    }

    public function tambah(Request $request)
    {
    	if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
    	request()->validate([
					        'kode' => 'required|unique:ts3.mst.mst_price_service',
					        'service_name' 	   => 'required',
                            'price_bengkel_to_ts3' 	   => 'required',
                            'mst_client_id' 	   => 'required',
                            'price_ts3_to_client' 	   => 'required',
                            'mst_regional_id' 	   => 'required',
                            'price_service_type' 	   => 'required',
					        ]);
        

           
                    
        $id_price = DB::connection('ts3')->table('mst.mst_price_service')->insertGetId([
            'kode'	=> $request->kode,
            'service_name'   => $request->service_name,
            'price_bengkel_to_ts3'	=> $request->price_bengkel_to_ts3,
            'mst_client_id'	=> $request->mst_client_id,
            'price_ts3_to_client'	=> $request->price_ts3_to_client,
            'price_service_type' 	   =>  $request->price_service_type,
            'created_date'    => date("Y-m-d h:i:sa"),
            'create_by'     => $request->session()->get('username')
        ]);

        foreach($request->mst_regional_id as $val){
            $datasets = [
                'mst_price_service_id' => $id_price,
                'mst_regional_id' => $val
            ];

            DB::connection('ts3')->table('mst.mst_price_service_x_regional')->insert($datasets);
        }

        

        return redirect('admin-ts3/price-service')->with(['sukses' => 'Data telah ditambah']);
    }

   
    public function edit($id)
    {
            if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
           
            $price 	= DB::connection('ts3')->table('mst.v_price_service')->where('id',$id)->first();
            $client 	= DB::connection('ts3')->table('mst.mst_client')->where('client_type','B2B')->get();
            $regional 	= DB::connection('ts3')->table('mst.mst_regional')->get();        
            $price_type = DB::connection('ts3')->table('mst.mst_general')->where('name','price_service_type')->get();

		    $data = array(  'title'         => 'Edit Price Service',
                            'price'         => $price,
                            'client'        => $client,
                            'regional'      => $regional,
                            'price_type'      => $price_type,
                            'content'   => 'admin-ts3/price_service/edit');
                   
        
             return view('admin-ts3/layout/wrapper',$data);
    }
    
    public function proses_edit(Request $request)
    {
    	if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
    	request()->validate([
                                'service_name' 	   => 'required',
                                'price_bengkel_to_ts3' 	   => 'required',
                                'mst_client_id' 	   => 'required',
                                'price_ts3_to_client' 	   => 'required',
                                'price_service_type' 	   => 'required',
					        ]);

                            DB::connection('ts3')->table('mst.mst_price_service')->where('id',$request->id)->update([
                                'service_name'   => $request->service_name,
                                'price_bengkel_to_ts3'	=> $request->price_bengkel_to_ts3,
                                'mst_client_id'	=> $request->mst_client_id,
                                'price_ts3_to_client'	=> $request->price_ts3_to_client,
                                'price_service_type' 	   =>  $request->price_service_type,
                                'updated_at'    => date("Y-m-d h:i:sa"),
                                'update_by'     => $request->session()->get('username')
                            ]);            
                            DB::connection('ts3')->table('mst.mst_price_service_x_regional')->where('mst_price_service_id',$request->id)->delete();
                            foreach($request->mst_regional_id as $val){
                                $datasets = [
                                    'mst_price_service_id' => $request->id,
                                    'mst_regional_id' => $val
                                ];
                    
                                DB::connection('ts3')->table('mst.mst_price_service_x_regional')->insert($datasets);
                            }


        return redirect('admin-ts3/price-service')->with(['sukses' => 'Data telah diupdate']);                                             
    }

  
    public function delete($id)
    {
    	if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
     
        DB::connection('ts3')->table('mst.mst_price_service')->where('id',$id)->delete();
        DB::connection('ts3')->table('mst.mst_price_service_x_regional')->where('mst_price_service_id',$id)->delete();
        return redirect('admin-ts3/price-service')->with(['sukses' => 'Data telah dihapus']);
    }

       

    public function proses(Request $request)
    {
        $site   =DB::connection('ts3')->table('cp.konfigurasi')->first();
        // PROSES HAPUS MULTIPLE

        if(isset($_POST['hapus'])) {
            $id       = $request->id;
     
            for($i=0; $i < sizeof($id);$i++) {
                      
               DB::connection('ts3')->table('mst.mst_price_service')->where('id',$id[$i])->delete();
               DB::connection('ts3')->table('mst.mst_price_service_x_regional')->where('mst_price_service_id',$id[$i])->delete();
             
            }
        
            return redirect('admin-ts3/price-service')->with(['sukses' => 'Data telah dihapus']);
        // PROSES SETTING DRAFT
        }
    }




}

<?php
namespace App\Http\Controllers\AdminTs3;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Image;
use DataTables;
use Log;
use App\Exports\PriceServiceExport;
use Maatwebsite\Excel\Facades\Excel;

class PriceService extends Controller
{
    // Index
    public function index()
    {
    	if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
      
        // $price 	= DB::connection('ts3')->table('mst.v_price_service')->get();
        $client 	= DB::connection('ts3')->table('mst.mst_client')->where('client_type','B2B')->get();
        $regional 	= DB::connection('ts3')->table('mst.mst_regional')->get();        
        $kode_max 	= DB::connection('ts3')->table('mst.v_price_service')->selectRaw("concat('TS3-',max(substring(kode from 5 for 5)::int + 1)) as kode")->first();
        $price_type = DB::connection('ts3')->table('mst.mst_general')->where('name','price_service_type')->get();

		$data = array(  'title'     => 'Price Service',
                        'kode_max'   => $kode_max,
                        // 'price'      => $price,
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
        

          try{
                    
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
        DB::commit();
        }
        catch (\Illuminate\Database\QueryException $e) {
            DB::rollback();
            return redirect('admin-ts3/price-service')->with(['warning' => $e]);
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
                     try{
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
                        }
                        catch (\Illuminate\Database\QueryException $e) {
                            DB::rollback();
                            return redirect('admin-ts3/price-service')->with(['warning' => $e]);
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


    public function getPriceService(Request $request)
    {
        if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}

        if ($request->ajax()) {
        

        $price 	= DB::connection('ts3')->table('mst.v_price_service')->get();
        
        return DataTables::of($price)
                ->addColumn('action', function($row){
                    $btn = '<div class="btn-group">
                            <a href="'. asset('admin-ts3/price-service/edit/'.$row->id).'" 
                                class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>
                            <a href="'. asset('admin-ts3/price-service/delete/'.$row->id).'" class="btn btn-danger btn-sm  delete-link">
                                    <i class="fa fa-trash"></i></a>
                            </div>';
                return $btn; })
                ->addColumn('check', function($row){
                    $check = ' <td class="text-center">
                                <div class="icheck-primary">
                                <input type="checkbox" class="icheckbox_flat-blue " name="id[]" value="'.$row->id.'" id="check'.$row->id.'">
                               <label for="check'.$row->id.'"></label>
                                </div>
                             </td>';
                    return $check; })
                ->editColumn('price_bengkel_to_ts3', function ($row) {
                    
                        $datapr = 'Rp '. number_format($row->price_bengkel_to_ts3,0,',','.');
                        return $datapr;
                    }) 
                ->editColumn('price_ts3_to_client', function ($row) {
                        $datapr = 'Rp '. number_format($row->price_ts3_to_client,0,',','.');
                        return $datapr;
                    }) 
                ->editColumn('regional', function ($row) {

                        $str = $row->regional;
                        $delimiter = ',';
                        $regionals = explode($delimiter, $str);
                        $datarg = '';
                        foreach ($regionals as $rgg) {
                            $datarg  .= '<span class="badge badge-pill badge-primary mr-2 mb-1">'.$rgg.'</span>' ;
                        }
                        return $datarg;
                    })

                ->rawColumns(['action','check','regional'])
                ->make(true);
       
        }

    }

    
    
    public function export()
    {
        if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}


        return Excel::download(new PriceServiceExport, 'PRICE_SERVICE-MVM.xlsx');
    }
    


}

<?php

namespace App\Http\Controllers\Bengkel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Konfigurasi_model;
use Image;
use PDF;
use Log;
use Illuminate\Support\Facades\File;

class Gps extends Controller
{


    public function gpsPosting(Request $request)
    {
        if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }

        request()->validate([
            'nopol' => 'required',
            'sn_gps' => 'required',
            'install_date' => 'required|date',
            'uploadgps1' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);
        
            $sn = strtolower(trim($request->sn_gps));    
          
            $install_date = strtotime($request->install_date);
            $expired_date = date('Y-m-d', strtotime('+3 years', $install_date));

            $existing_entry = DB::connection('ts3')
            ->table('mst.mst_vehicle_gps')
            ->where('nopol', $request->nopol)
            ->first();

            $image1 = $request->file('uploadgps1');
            $path = storage_path('data/gps/'.$sn.'/');
            $uploadgps1 =$request->nopol.'_1'.'.jpg';;
            if (!file_exists($path)) {
            File::makeDirectory($path,0755,true);
            }
            $img1 = Image::make($image1->path());
            $img1->resize(850, 850, function ($constraint) {
                $constraint->aspectRatio();
            })->save($path.$uploadgps1);


            Log::info($request->uploadgps1);

            if ($existing_entry == null)
            {
                try{

                    if ($request->hasFile('uploadgps2')) {
                        $image2 = $request->file('uploadgps2');
                        $path = storage_path('data/gps/'.$sn.'/');
                        $uploadgps2 = $request->nopol.'_2'.'.jpg';
                        
                        if (!File::exists($path)) {
                            File::makeDirectory($path, 0755, true);
                        }
                        
                        $img2 = Image::make($image2->path());
                        $img2->resize(850, 850, function ($constraint) {
                            $constraint->aspectRatio();
                        })->save($path.$uploadgps2);
                    
                        $imggps2 = $path.$uploadgps2;
                    } else {
                        $imggps2 = null;
                    }
                    
                    // Pemeriksaan upload untuk gambar ketiga
                    if ($request->hasFile('uploadgps3')) {
                        $image3 = $request->file('uploadgps3');
                        $path = storage_path('data/gps/'.$sn.'/');
                        $uploadgps3 = $request->nopol.'_3'.'.jpg';
                        
                        if (!File::exists($path)) {
                            File::makeDirectory($path, 0755, true);
                        }
                        
                        $img3 = Image::make($image3->path());
                        $img3->resize(850, 850, function ($constraint) {
                            $constraint->aspectRatio();
                        })->save($path.$uploadgps3);
                    
                        $imggps3 = $path.$uploadgps3;
                    } else {
                        $imggps3 = null;
                    }
                    
                
                    DB::connection('ts3')->table('mst.mst_vehicle_gps')->insert([
                        'sn'	=> $sn,
                        'nopol'   => $request->nopol,
                        'install_date'	=> $request->install_date,
                        'expired_date'	=> $expired_date,
                        'evidance_1' => $path.$uploadgps1,
                        'evidance_2' => $imggps2,
                        'evidance_3' => $imggps3,
                        'is_active'   => false,
                        'remark'	=> $request->remarkgps,
                        'created_by'     => $request->session()->get('username')
                    ]);
        

                  $amount = DB::connection('ts3')->table('mst.mst_general')->where('name', 'amount_gps')->first();
                        $gps = [
                        'nopol' => $request->nopol,
                        'sn_gps' => $sn,
                        'install_date' =>  $request->install_date,
                        'status' => 'pemasangan',
                        'remark' => $request->remarkgps,
                        'client_invoice' => 'MDM',
                        'invoice_type' => 'TS3 TO CLIENT GPS',
                        'amount' => $amount->value_2,
                        'created_by' => $request->session()->get('username')
                        ];
                    
                        DB::connection('ts3')->table('mvm.mvm_gps_process')->insert($gps);
                        
                        
                }
                catch (\Illuminate\Database\QueryException $e) {
        
                  
                    Log::channel('slack')->critical("Critical error occurred while inserting contact: " . $e->getMessage());
                    return redirect('admin-ts3/bengkel')->with(['warning' => $e]);
                }
                
            }
            else
            {   

                try{
                   
                    $path1 = $request->uploadgps1->storeAs('data/gps/'.$sn.'/' . date("Y") . '/' . date("m"), $request->nopol . '_1');

                        
                    $install_date = strtotime($request->install_date);
                    $expired_date = date('Y-m-d', strtotime('+3 years', $install_date));

                    if ($request->hasFile('uploadgps2')) {
                        $image2 = $request->file('uploadgps2');
                        $path = storage_path('data/gps/'.$sn.'/');
                        $uploadgps2 = $request->nopol.'_2'.'.jpg';
                        
                        if (!File::exists($path)) {
                            File::makeDirectory($path, 0755, true);
                        }
                        
                        $img2 = Image::make($image2->path());
                        $img2->resize(850, 850, function ($constraint) {
                            $constraint->aspectRatio();
                        })->save($path.$uploadgps2);
                    
                        $imggps2 = $path.$uploadgps2;
                    } else {
                        $imggps2 = null;
                    }
                    
                    // Pemeriksaan upload untuk gambar ketiga
                    if ($request->hasFile('uploadgps3')) {
                        $image3 = $request->file('uploadgps3');
                        $path = storage_path('data/gps/'.$sn.'/');
                        $uploadgps3 = $request->nopol.'_3'.'.jpg';
                        
                        if (!File::exists($path)) {
                            File::makeDirectory($path, 0755, true);
                        }
                        
                        $img3 = Image::make($image3->path());
                        $img3->resize(850, 850, function ($constraint) {
                            $constraint->aspectRatio();
                        })->save($path.$uploadgps3);
                    
                        $imggps3 = $path.$uploadgps3;
                    } else {
                        $imggps3 = null;
                    }

                    DB::connection('ts3')->table('mst.mst_vehicle_gps')->where('nopol' ,$request->nopol)->update([
                        'sn'   => $sn,
                        'install_date'	=> $request->install_date,
                        'expired_date'	=> $expired_date,
                        'remark'	=> $request->remarkgps,
                        'evidance_1' => $path.$uploadgps1,
                        'evidance_2' => $imggps2,
                        'evidance_3' => $imggps3,
                        'created_by'  => $request->session()->get('username')
                    ]);






                    $amount = DB::connection('ts3')->table('mst.mst_general')->where('name', 'amount_gps')->first();




                    DB::connection('ts3')->table('mvm.mvm_gps_process')->where('nopol' ,$request->nopol )->whereNull('service_no')->where('status','pemasangan')
                    ->update([
                        'sn_gps' => $sn,
                        'install_date' =>  $request->install_date,
                        'status' => 'pemasangan',
                        'remark' => $request->remarkgps,
                        'client_invoice' => 'MDM',
                        'invoice_type' => 'TS3 TO CLIENT GPS',
                        'amount' => $amount->value_2,
                        'created_by' => $request->session()->get('username')
                    ]);                


                   
                }
                catch (\Illuminate\Database\QueryException $e) {
        
                  
                    Log::channel('slack')->critical("Critical error occurred while inserting contact: " . $e->getMessage());
                    return redirect('admin-ts3/bengkel')->with(['warning' => $e]);
                }


            }

       




      return response()->json(['message' => 'Data GPS berhasil disimpan'], 200);

    }
}

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
use Illuminate\Support\Facades\URL;

class Vehicle extends Controller
{


    public function vehicleCheck(Request $request)
    {
        if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }

        $vehicledata = DB::connection('ts3')->table('mst.v_vehicle')->where('nopol', $request->nopol)->first();
    
        $gpsdata = DB::connection('ts3')->table('mst.mst_vehicle_gps')->where('nopol', $request->nopol)->where('is_active', true)->first();
         
        if(empty($gpsdata))
        {
            $url = $sn = $install_date = $remark = $expired_date = null;
        }
        else
        {
            $gpsdataId = $gpsdata->id;
            $url = "<a href='" . URL::asset('gps-evidance') . '/' . $gpsdataId . "' target='_blank' class='btn btn-info btn-sm'>View Evidence</a>";
            $sn = $gpsdata->sn;
            $install_date = $gpsdata->install_date;
            $remark = $gpsdata->remark;
            $expired_date =  $gpsdata->expired_date;
        }

        
        // Membuat HTML dengan data kendaraan yang ditemukan
        if ($vehicledata) {
            $vehicle_html = "
            <div class='row'>
                <div class='col-md-3'>
                    <!-- Profile Image -->
                    <div class='card card-primary card-outline'>
                        <div class='card-body box-profile'>
                            <div class='text-center'>
                                <img class='img img-thumbnail img-fluid' src='" . asset('assets/upload/image/thumbs/motor.png') . "' >
                            </div>
                            <h3 class='profile-username text-center'>" . $vehicledata->nopol . "</h3>
                            <h3 class='profile-username text-center'>" . $vehicledata->gambar_unit . "</h3>
                        </div>
                    </div>
                </div>
                <div class='col-md-9'>
                    
           
                
                
                    <div class='card card-primary'>
                        <div class='card-header'>
                            <h3 class='card-title'>Detail Data Motor " . $vehicledata->client_name . "</h3>
                        </div>
                        <div class='card-body'>


                            <div class='row'>
                                <div class='col-md-6'>

                                <table class='table table-bordered' style='font-size: 12px;'>
                                    <thead>
                                        <tr>
                                            <th width='25%'>Nopol</th>
                                            <th>" . $vehicledata->nopol . "</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>No Rangka</td>
                                            <td>" . $vehicledata->norangka . "</td>
                                        </tr>
                                        <tr>
                                            <td>No Mesin</td>
                                            <td>" . $vehicledata->nomesin  . "</td>
                                        </tr>
                                        <tr>
                                            <td>Type</td>
                                            <td>" . $vehicledata->type . "</td>
                                        </tr>
                                        <tr>
                                            <td>Tahun Pembuatan</td>
                                            <td>" . $vehicledata->tahun_pembuatan . "</td>
                                        </tr>
                                        <tr>
                                            <td>Tanggal Last Service</td>
                                            <td>" . $vehicledata->tgl_last_service . "</td>
                                        </tr>
                                        
                                        <tr>
                                            <td>Create Date</td>
                                            <td>" . $vehicledata->created_date . "</td>
                                        </tr>
                                        <tr>
                                            <td>Create By</td>
                                            <td>" . $vehicledata->create_by . "</td>
                                        </tr>
                                        <tr>
                                            <td>Update Date</td>
                                            <td>" . $vehicledata->updated_at . "</td>
                                        </tr>
                                        <tr>
                                            <td>Update By</td>
                                            <td>" . $vehicledata->update_by . "</td>
                                        </tr>
                                        <tr>
                                            <td>Remark</td>
                                            <td>" . $vehicledata->remark . "</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                    
                            <div class='col-md-6'>

                                <table class='table table-bordered'  style='font-size: 12px;'>
                                <thead>
                                    <tr>
                                        <th colspan='2'>GPS</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>GPS Serial Number</td>
                                        <td>" . $sn . "</td>
                                    </tr>
                                    <tr>
                                        <td>Install Date</td>
                                        <td>" . $install_date  . "</td>
                                    </tr>
                                    <tr>
                                        <td>Expired Date</td>
                                        <td>" . $expired_date . "</td>
                                    </tr>
                                   
                                    <tr>
                                    <td>Evidance</td>
                                    <td>
                                   ". $url ."
                                    </td>
                                    </tr>

                                    <tr>
                                    <td>Remark</td>
                                    <td>" . $remark . "</td>
                                </tr>

                                
                                </tbody>
                            </table>
    
    
                            </div>
                        </div>   



                    </div>
                   

                </div>
                
            </div>";
        } else {
            // Jika data kendaraan tidak ditemukan
            $vehicle_html = "<div class='alert alert-warning'>Data tidak ditemukan</div>";
        }
    
        // Mengembalikan HTML sebagai bagian dari respons JSON
        return response()->json(['html' => $vehicle_html], 200);
    }
    


    
    public function GpsEvidance($id)
    {
        if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }

        if(!isset($id))
        {
            return redirect('login?redirect='.$last_page)->with(['warning' => 'File Not Found']);
        }


        $gps = DB::connection('ts3')->table('mst.mst_vehicle_gps')->where('id',$id)->first();

        $storagePath =  $gps->evidance_1;
        return response()->file($storagePath);

    }
    

    public function GpsCheck(Request $request)
    {

        if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }


            $response = true;
   
            if ($response) {
                $data = [
                    'lat' =>  -6.177485361659793,
                    'long' => 106.83253521525297
                ];
                return response()->json($data, 200);
            } else {
                return response()->json(['error' => 'Data not found'], 404);
            }

    }





}
                                                    
                                                        
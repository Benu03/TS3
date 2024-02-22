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

class Vehicle extends Controller
{


    public function vehicleCheck(Request $request)
    {
        $vehicledata = DB::connection('ts3')->table('mst.v_vehicle')->where('nopol', $request->nopol)->first();
    
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
                            <table class='table table-bordered'>
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
                                    <!-- Sisipkan baris lainnya sesuai kebutuhan -->
                                </tbody>
                            </table>
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
    
    
}

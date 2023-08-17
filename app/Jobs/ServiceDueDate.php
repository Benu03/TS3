<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Log;
use Image;
use PDF;
use App\Mail\MailSend;
use Illuminate\Support\Facades\Mail;

class ServiceDueDate implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $duedate = DB::connection('ts3')->table('mst.v_vehicle')->whereRaw("tgl_last_service = (now()::date - '2 mons  1 days'::interval)")->get();

        $result= [];
        foreach($duedate as $x => $val) 
        {
            $resultArray = json_decode(json_encode($val), true);
            $nopol = $resultArray['nopol'];
            $result[] =$nopol;
            $receive = DB::connection('ts3')->table('auth.v_list_user_client')
                        ->where('entity',$resultArray['client_name'])
                        ->where('role_title', 'Admin Client')->first();

           
            DB::connection('ts3')->table('ntf.ntf_notification')->insert([
                'title'   => 'Service Due Date '.$nopol,
                // 'detail'	=> 'Service Kendaraan Dengan nopol '.$nopol.' perlu di lakukan,'.'
                // <p><a href="#" role="button" class="btn btn-secondary popover-test" onclick="redirectToURL('."https://localhost:8080/admin-client/vehicle-schedule-service".')">Buka Halaman</a></p>',
                'detail'	=> 'Service Kendaraan Dengan nopol '.$nopol.' perlu di lakukan, Silakan Mengakses halaman Vehicle Shedule Service',
                'created_date'    => date("Y-m-d h:i:sa"),
                'username'     => $receive->username,
                'ntf_category_id'     => 1
            ]);
            
            
        }


        $duedate2 = DB::connection('ts3')->table('mvm.v_service_due_date_pic')->whereRaw("tgl_last_service = (now()::date - '2 mons  1 days'::interval)")->get();

        $result2= [];
        foreach($duedate2 as $x => $val) 
        {
            $resultArray = json_decode(json_encode($val), true);
            $nopol2 = $resultArray['nopol'];
            $result2[] =$nopol;
           

           
            DB::connection('ts3')->table('ntf.ntf_notification')->insert([
                'title'   => 'Service Due Date '.$nopol2,
                // 'detail'	=> 'Service Kendaraan Dengan nopol '.$nopol.' perlu di lakukan,'.'
                // <p><a href="#" role="button" class="btn btn-secondary popover-test" onclick="redirectToURL('."https://localhost:8080/admin-client/vehicle-schedule-service".')">Buka Halaman</a></p>',
                'detail'	=> 'Service Kendaraan Dengan nopol '.$nopol2.' perlu di lakukan Tanggal Terakhir Service '.$resultArray['tgl_last_service'].' dengan KM terakhir '.$resultArray['last_km'],
                'created_date'    => date("Y-m-d h:i:sa"),
                'username'     => $resultArray['pic_branch'],
                'ntf_category_id'     => 1
            ]);
            
            
        }






        Log::info($result);

     }
}

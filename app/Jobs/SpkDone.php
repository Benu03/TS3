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

class SpkDone implements ShouldQueue
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
        $spk_detail = DB::connection('ts3')->table('mvm.mvm_spk_h')->where('status', 'ONPROGRESS')->get();

        $result= [];
        foreach($spk_detail as $x => $val) 
        {
            $resultArray = json_decode(json_encode($val), true);
            $spk_no = $resultArray['spk_no'];

            $coundDetail = DB::connection('ts3')->table('mvm.mvm_spk_d')->where('spk_no', $spk_no)->count();
            $coundDetailApv = DB::connection('ts3')->table('mvm.mvm_spk_d')->where('spk_no', $spk_no)->where('status_service', 'APPROVAL')->count();

            if($coundDetail == $coundDetailApv)
            {
                DB::connection('ts3')->table('mvm.mvm_spk_h')->where('spk_no',$spk_no)->update([
                    'status'   => 'DONE'
                ]);   
                $result[] = "SPK ".$spk_no." DONE";
            }
            else
            {
                $result[] = "SPK ".$spk_no." ONPROGRESS";
            }
            
            
        }
        Log::info($result);

     }
}

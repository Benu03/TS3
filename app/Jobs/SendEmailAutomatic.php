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

class SendEmailAutomatic implements ShouldQueue
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
        $dataMail = DB::connection('ts3')->table('auth.user_mail')->where('is_send',null)->get();
        $msgCounter = 0;
        if(count($dataMail) > 0) 
        {
           foreach($dataMail as $x => $val) 
           {
               $resultArray = json_decode(json_encode($val), true);
               $emailid = $resultArray['id'];

               if($resultArray['attachment'] == null)
               {
                   $body = $resultArray['body'];
                   $to   = $resultArray['to'];
                   $cc   = $resultArray['cc'];
                   $bcc   = $resultArray['bcc'];
                   $subject = $resultArray['subject'];
                   $sender = $resultArray['from'];

                       
                       Mail::mailer('smtp')->send([], [], function ($message) use ($body,$to,$cc,$subject) {
                       $message->to($to); 
                       if (isset($cc)){ $message->cc($cc); 
                       if (isset($bcc)){ $message->bcc($bcc); }    }    
                       $message->subject($subject);
                       $message->from('ts3.notif@gmail.com','TS3 Indonesia');
                       $message->setBody($body, 'text/html');});
                       $msgCounter++;
                      
                       DB::connection('ts3')->table('auth.user_mail')->where('id',$emailid)->update([
                           'is_send'   => true,
                           'send_date'	    => date("Y-m-d h:i:sa")
                       ]);   
                      
               }
               else
               {
                   $body = $resultArray['body'];
                   $to   = $resultArray['to'];
                   $cc   = $resultArray['cc'];
                   $subject = $resultArray['subject'];
                   // $path = $resultArray['attachment'];
                   $sender = $resultArray['from'];

                       Mail::mailer('smtp')->send([], [], function ($message) use ($body,$to,$cc,$subject) {
                       $message->to($to); 
                       if (isset($cc)){ $message->cc($cc); 
                       if (isset($bcc)){ $message->bcc($bcc); }    }    
                       $message->subject($subject);
                       $message->from('ts3.notif@gmail.com','TS3 Indonesia');
                       // $message->attach(storage_path($path));
                       $message->setBody($body, 'text/html');});
                       $msgCounter++;
                      
                       DB::connection('ts3')->table('auth.user_mail')->where('id',$emailid)->update([
                           'is_send'   => true,
                           'send_date'	    => date("Y-m-d h:i:sa")
                       ]);   



               }
            

           }
         }
     }
}

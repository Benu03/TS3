<?php

namespace App\Http\Controllers\Feature;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Konfigurasi_model;
use Image;
use PDF;
use App\Mail\MailSend;
use Illuminate\Support\Facades\Mail;
use App\Jobs\SendEmailAutomatic;



class EmailContoller extends Controller
{


   
    public function SendMailAutomatic(Request $request)
    {
        
      if(isset($request['type']))
      {

        if($request['type'] == 'SendEmailAutomatic')        {

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
                        $path = $resultArray['attachment'];
                        $sender = $resultArray['from'];
               

                            Mail::mailer('smtp')->send([], [], function ($message) use ($body,$to,$cc,$subject,$path) {
                            $message->to($to); 
                            if (isset($cc)){ $message->cc($cc); 
                            if (isset($bcc)){ $message->bcc($bcc); }    }    
                            $message->subject($subject);
                            $message->from('ts3.notif@gmail.com','TS3 Indonesia');
                            $message->attach($path);
                            $message->setBody($body, 'text/html');});
                            $msgCounter++;
                           
                            DB::connection('ts3')->table('auth.user_mail')->where('id',$emailid)->update([
                                'is_send'   => true,
                                'send_date'	    => date("Y-m-d h:i:sa")
                            ]);   



                    }
                    


                }

             }
             else{
                return response()->json([
                  'status'  => '200',
                  'success' => true,
                  'messages'=> 'No Email data to send.',
                  'data'=>[]
                ],200);
              }



        }
        else
        {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'You type Not Avaliable',
                    'data' => []
                ], 401);
        }
        
      }
      else
      {
        return response()->json(
            [
                'success' => false,
                'message' => 'You Body Not Avaliable',
                'data' => []
            ], 401);

      }

      return response()->json([
        'status'  => '200',
        'success' => true,
        'messages'=> "Send Emai Total $msgCounter messages sent through ",
        'data'=>[]
      ],200);

     
        

    }
}

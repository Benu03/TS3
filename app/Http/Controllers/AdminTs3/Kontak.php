<?php

namespace App\Http\Controllers\AdminTs3;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Pagination\Paginator;
use Image;
use App\Models\Kontak_model;
use DataTables;
use Log;
use App\Mail\MailSend;
use Illuminate\Support\Facades\Mail;

class Kontak extends Controller
{
    // Main page
    public function index()
    {
    	if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
       
		

		$data = array(  'title'       => 'Kontak',
                        'content'     => 'admin-ts3/kontak/index'
                    );
        return view('admin-ts3/layout/wrapper',$data);
    }

    public function reply($id_kontak)
    {
    	if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}
       
		$kontak 	=  DB::connection('ts3')->table('cp.kontak')->where('id',$id_kontak)->first();

		$data = array(  'title'       => 'Reply Kontak',
						'kontak'    => $kontak,
                        'content'     => 'admin-ts3/kontak/reply'
                    );
        return view('admin-ts3/layout/wrapper',$data);
    }


    public function replyProcess(Request $request)
    {
        if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}

        if($request->reply_via == 'phone' ){

            try{
                DB::connection('ts3')->beginTransaction();
            DB::connection('ts3')->table('cp.kontak')->where('id',$request->id_kontak)->update([
                'updated_date'       => date("Y-m-d h:i:sa"),
                'updated_by'       => $request->session()->get('username'),
                'message_reply'     => $request->message_reply,
                'reply_via'   		=> $request->reply_via,
                'is_reply'  => true
            ]);

             DB::connection('ts3')->commit();
            
             return redirect('admin-ts3/kontak')->with(['sukses' => 'Pesan Anda Telah Terkirim.!!']);
          } catch (\Illuminate\Database\QueryException $e) {
             DB::connection('ts3')->rollback();
             Log::channel('slack')->critical("Critical error occurred while inserting contact: " . $e->getMessage());
             return redirect('admin-ts3/kontak/reply/'.$request->id_kontak)->with(['warning' => 'Terjadi kesalahan saat mengirim data. Mohon coba lagi nanti.']);
         }


        }
        else{

            try{
      

                $body = $request->message_reply;
                $to   = strtolower(trim($request->email));
                $subject = $request->subject;
                $sender =  'noreply@ts3.co.id';

                Mail::mailer('smtp')->send([], [], function ($message) use ($body, $to, $subject, $sender) {
                    $message->to($to)
                            ->subject($subject)
                            ->from($sender, 'TS3 Indonesia')
                            ->setBody($body, 'text/html');
                });
                

                DB::connection('ts3')->beginTransaction();
                DB::connection('ts3')->table('cp.kontak')->where('id',$request->id_kontak)->update([
                'updated_date'       => date("Y-m-d h:i:sa"),
                'updated_by'       => $request->session()->get('username'),
                'message_reply' => $request->message_reply,
                'reply_via'   		=> $request->reply_via,
                'is_reply'  => true
            ]);

            
             DB::connection('ts3')->commit();            
             return redirect('admin-ts3/kontak')->with(['sukses' => 'Pesan Anda Telah Terkirim.!!']);
          } catch (\Illuminate\Database\QueryException $e) {
             DB::connection('ts3')->rollback();
             Log::channel('slack')->critical("Critical error occurred while inserting contact: " . $e->getMessage());
             return redirect('admin-ts3/kontak/reply/'.$request->id_kontak)->with(['warning' => 'Terjadi kesalahan saat mengirim data. Mohon coba lagi nanti.']);
         }

        }
        



    }
    


    public function getKontak(Request $request)
    {
        if(Session()->get('username')=="") { return redirect('login')->with(['warning' => 'Mohon maaf, Anda belum login']);}

        
        if ($request->ajax()) {
        $area 	= DB::connection('ts3')->table('cp.kontak')->where('is_reply',false)->get();
        return DataTables::of($area)->addColumn('action', function($row){
               $btn = '<div class="btn-group">
               <a href="'. asset('admin-ts3/kontak/reply/'.$row->id).'" 
                 class="btn btn-warning btn-sm"><i class="fa fa-reply"></i></a>
               </div>';
                return $btn;
                })->addColumn('check', function($row){
                    $check = ' <td class="text-center">
                                <div class="icheck-primary">
                                <input type="checkbox" class="icheckbox_flat-blue " name="id[]" value="'.$row->id.'" id="check'.$row->id.'">
                               <label for="check'.$row->id.'"></label>
                                </div>
                             </td>';
                    return $check;
                })
        ->rawColumns(['action','check'])->make(true);
 
        }


    }
   
}

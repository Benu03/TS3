<?php

namespace App\Http\Controllers\Pic;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Konfigurasi_model;
use Image;
use PDF;
use Carbon\Carbon;

class Notif extends Controller
{


    // Index
    public function index()
    {
        if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }
        $username = Session()->get('username');
        $threeMonthsAgo = Carbon::now()->subMonths(3);

        // $notif          = DB::connection('ts3')->table('ntf.v_notif_list')
        //                         ->where(function ($query) use ($username) {
        //                             $query->where('username', $username)
        //                                 ->orWhereNull('username');
        //                         })
        //                         ->whereDate('created_date', '>', $threeMonthsAgo)
        //                         ->orderBy('created_date', 'desc')
        //                         ->get();
        $count_notif     = DB::connection('ts3')->table('ntf.v_notif_list')
                                ->where(function ($query) use ($username) {
                                    $query->where('username', $username)
                                        ->orWhereNull('username');
                                })
                                ->WhereNull('is_read')
                                ->count();           



		$data = array(  'title'     => 'Notification',
                        'content'   => 'pic/notif/index',
                        // 'notif'   => $notif,
                        'count_notif'   => $count_notif
                    );
        return view('pic/layout/wrapper',$data);
    }


    public function read(Request $request)
    {
        if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }

        if ($request->ajax()) {

            $check =  DB::connection('ts3')->table('ntf.ntf_notification_read')->where('username',Session()->get('username'))->where('ntf_notification_id',$request->notifId)->count();

            if($check == 0)
            {
            DB::connection('ts3')->table('ntf.ntf_notification_read')->insert([
                'is_read'   => true,
                'ntf_notification_id'	=> $request->notifId,
                'username'     => $request->session()->get('username')
            ]);
            }

        }



    }

    public function getdata()
    {

        if(Session()->get('username')=="") {
            $last_page = url()->full();
            return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
        }
        $username = Session()->get('username');
        $threeMonthsAgo = Carbon::now()->subMonths(3);

        $notif          = DB::connection('ts3')->table('ntf.v_notif_list')
                                ->where(function ($query) use ($username) {
                                    $query->where('username', $username)
                                        ->orWhereNull('username');
                                })
                                ->whereDate('created_date', '>', $threeMonthsAgo)
                                ->orderBy('created_date', 'desc')
                                ->get();

        return response()->json(['data' => $notif]);
    }




}

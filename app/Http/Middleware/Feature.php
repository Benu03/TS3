<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;

class Feature
{
   

    public function handle(Request $request, Closure $next)
    {
        $all_headers = $request->header();
       
        if(isset($all_headers['signature'][0])  and !empty($all_headers['timerequest'][0]) ){
                $sign = $all_headers['signature'][0];
        
                $KeySig = DB::connection('ts3')->table('mst.mst_general')->where('value_1',$sign)->first();
        
              $signature = hash('sha256',implode($all_headers['timerequest']).$KeySig->value_1); 
              Log::info('Check Signature'); 


            if(empty($signature)){
                //Log::error('Unauthorized Access Using Token ' . $all_headers['token'][0]);
                return response()->json(
                [
                    'success' => false,
                    'message' => 'Invalid token',
                    'data' => []
                ], 401);
            }
                }
                else{
                    return response()->json(
                            ['status'       =>  500,
                                'success'   =>  false,
                                'message'   =>  'Invalid Token',
                                'data'      =>  []
                            ], 200);
                }
        


        return $next($request);
    }
}

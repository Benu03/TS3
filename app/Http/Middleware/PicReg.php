<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;
use App\Models\User_model;

class PicReg
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
      
         $username =  $request->session()->get('username');
         $model      = new User_model();
         $user       = $model->check_user($username);
     
         if($username == null)
         {
            return redirect('/login')->with(['warning' => 'Mohon maaf, Sesi Anda Berakhir']);
         }
         else   
         {
         if($user->id_role <> 6) 
         {
            if($user->id_role == 3){
            return redirect('admin-client/dasbor')->with(['warning' => 'Mohon maaf, Anda Tidak Memiliki Akses']);
            }
            elseif($user->id_role == 4){
            return redirect('bengkel/dasbor')->with(['warning' => 'Mohon maaf, Anda Tidak Memiliki Akses']);
            }
            elseif($user->id_role == 2){
                return redirect('admin-ts3/dasbor')->with(['warning' => 'Mohon maaf, Anda Tidak Memiliki Akses']);
            }
            elseif($user->id_role == 1){
                return redirect('admin-cms/dasbor')->with(['warning' => 'Mohon maaf, Anda Tidak Memiliki Akses']);
            }
            elseif($user->id_role == 5){
                return redirect('pic/dasbor')->with(['warning' => 'Mohon maaf, Anda Tidak Memiliki Akses']);
            }
            else{
                return redirect('/')->with(['warning' => 'Mohon maaf, Anda Tidak Memiliki Akses']);
            }         
         }
        }
             
        return $next($request);
    }
}

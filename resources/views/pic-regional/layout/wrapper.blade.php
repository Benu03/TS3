<?php 
if(Session()->get('username')=="") {
	$last_page = url()->full();
    return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
}
?>
@include('pic-regional/layout/head')
@include('pic-regional/layout/header')
@include('pic-regional/layout/menu')
@include($content)
@include('pic-regional/layout/footer')
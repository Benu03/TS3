<?php 
if(Session()->get('username')=="") {
	$last_page = url()->full();
    return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
}
?>
@include('pic/layout/head')
@include('pic/layout/header')
@include('pic/layout/menu')
@include($content)
@include('pic/layout/footer')
<?php 
if(Session()->get('username')=="") {
	$last_page = url()->full();
    return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
}
?>
@include('admin-ts3/layout/head')
@include('admin-ts3/layout/header')
@include('admin-ts3/layout/menu')
@include($content)
@include('admin-ts3/layout/footer')
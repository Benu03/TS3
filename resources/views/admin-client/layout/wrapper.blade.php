<?php 
if(Session()->get('username')=="") {
	$last_page = url()->full();
    return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
}
?>
@include('admin-client/layout/head')
@include('admin-client/layout/header')
@include('admin-client/layout/menu')
@include($content)
@include('admin-client/layout/footer')
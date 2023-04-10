<?php 
if(Session()->get('username')=="") {
	$last_page = url()->full();
    return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
}
?>
@include('admin-cms/layout/head')
@include('admin-cms/layout/header')
@include('admin-cms/layout/menu')
@include($content)
@include('admin-cms/layout/footer')
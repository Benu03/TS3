<?php 
if(Session()->get('username')=="") {
	$last_page = url()->full();
    return redirect('login?redirect='.$last_page)->with(['warning' => 'Mohon maaf, Anda belum login']);
}
?>
@include('bengkel/layout/head')
@include('bengkel/layout/header')
@include('bengkel/layout/menu')
@include($content)
@include('bengkel/layout/footer')
<?php 
use Illuminate\Support\Facades\DB;
use App\Models\Nav_model;
$site_config = DB::connection('ts3')->table('cp.konfigurasi')->first();
// Nav profil
$myprofil    = new Nav_model();
$nav_profil  = $myprofil->nav_profil();
$nav_layanan = $myprofil->nav_layanan();
$nav_berita  = $myprofil->nav_berita();
$nav_terjadi  = $myprofil->nav_terjadi();
$nav_materi  = $myprofil->nav_materi();
?>
<div class="row">
<div class="col-md-12">
<nav class="navbar navbar-expand-lg">
<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"> <i class="fas fa-bars"></i> </button>
<div class="collapse navbar-collapse" id="navbarSupportedContent">
   <ul class="navbar-nav mr-auto">
      <li class="nav-item"><a class="nav-link" href="{{ asset('/') }}" style="font-size: 14px;"><i class="fas fa-home"></i> Beranda</a> </li>
      <li class="nav-item"><a class="nav-link" href="{{ asset('ts3') }}" style="font-size: 14px;"><i class="fas fa-building"></i> About Us</a> </li>
      <li class="nav-item dropdown">
         <a class="nav-link dropdown" href="#"  style="font-size: 14px;" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-newspaper"></i> Berita &amp; Updates <span class="pull-right"><i class="fas fa-caret-down"></i></span></a>
         <ul class="dropdown-menu" >
            <?php foreach($nav_berita as $nav_berita) { ?>
            <li><a href="{{ asset('berita/kategori/'.$nav_berita->slug_kategori) }}"><i class="fas fa-angle-double-right" aria-hidden="true"></i> {{ Str::words($nav_berita->nama_kategori,4) }}</a></li>
            <?php } ?>
         </ul>
      </li>
      <li class="nav-item dropdown">
         <a class="nav-link dropdown" href="#" style="font-size: 14px;" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-handshake"></i> Layanan <span class="pull-right"><i class="fas fa-caret-down"></i></span></a>
         <ul class="dropdown-menu" >
            <?php foreach($nav_layanan as $nav_layanan) { ?>
            <li><a href="{{ asset('berita/layanan/'.$nav_layanan->slug_berita) }}"><i class="fas fa-angle-double-right" aria-hidden="true"></i> {{ Str::words($nav_layanan->judul_berita,6) }}</a></li>
            <?php } ?>
         </ul>
      </li>
      

      <li class="nav-item"> <a class="nav-link" href="{{ asset('galeri') }}" style="font-size: 14px;"><i class="fas fa-images"></i> Galeri</a> </li>
      <li class="nav-item"> <a class="nav-link" href="{{ asset('kontak') }}" style="font-size: 14px;"><i class="fas fa-id-card-alt"></i> Kontak</a> </li>
      <li class="nav-item"> <a class="nav-link" href="{{ asset('jaringan') }}" style="font-size: 14px;"><i class="fas fa-globe"></i> Jaringan</a> </li>
      <li class="nav-item"> <a class="nav-link" href="{{ asset('academy') }}" style="font-size: 14px;"><i class="fas fa-book-open"></i> TS3 Academy</a> </li>
   </ul>
</div>
</nav>
</div>
</div>
</div>
</div>
</header>
<!--Header End-->    
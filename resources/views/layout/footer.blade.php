<?php 
use Illuminate\Support\Facades\DB;
use App\Models\Nav_model;
$site_config = DB::connection('ts3')->table('cp.konfigurasi')->first();
// Nav profil
$myprofil    = new Nav_model();
$nav_profilf  = $myprofil->nav_profil();
$nav_layananf = $myprofil->nav_layanan();
?>
<!--Footer Start-->
<footer class="h3footer wf100">
   <div class="container">
      <div class="row">
         <!--Footer Widget Start-->
         <div class="col-md-6 col-sm-6">
            <div class="footer-widget">
               <h3>{{ $site_config->namaweb }}</h3>
               <p>{{ $site_config->deskripsi }}</p>
               <hr style="border-top: solid thin #EEE;padding:0; margin: 5px 0;">
               <p><strong>Our office:</strong>
                  <?php echo nl2br($site_config->alamat) ?>
                  <br><strong>Phone:</strong> {{ $site_config->telepon }}
                  {{-- <br><strong>Fax:</strong> {{ $site_config->fax }} --}}
                  <br><strong>Email:</strong> {{ $site_config->email }}
                  <br><strong>Website:</strong> {{ $site_config->website }}</p>
            </div>
         </div>
         <!--Footer Widget End--> 
         <!--Footer Widget Start-->
         <div class="col-md-6 col-sm-6">
            <div class="footer-widget">
               <h3>Layanan</h3>

               <ul class="lastest-products">
                  <?php foreach($nav_layananf as $nav_layananf) { ?>
                  <li class="list-item col-sm-6"><img src="{{ asset('assets/upload/image/thumbs/'.$nav_layananf->gambar) }}" alt="{{ $nav_layananf->judul_berita }}"> <strong><a href="{{ asset('berita/layanan/'.$nav_layananf->slug_berita) }}">{{ $nav_layananf->judul_berita }}</a></strong> <span class="pdate"><i>Updated:</i> <?php echo tanggal('tanggal_id',$nav_layananf->tanggal_post) ?></span> </li>
                  <?php } ?>
               </ul>
            </div>
         </div>
        
      </div>
      <div class="row footer-copyr">
         <div class="col-md-4 col-sm-4"> <img src="{{ asset('assets/upload/image/'.$site_config->logo) }}" alt="" style="max-height: 35px; width: auto;"> </div>
         <div class="col-md-8 col-sm-8">
               <p><a target="_blank" href="{{ asset('/') }}">Copyright &copy;<?= date('Y'); ?> {{ website('namaweb') }} Indonesia</a></p>
            </div>
      </div>
   </div>
</footer>
<!--Footer End--> 
</div>
<!--   JS Files Start  --> 
<script src="{{ asset('assets/aws/js/jquery-3.3.1.min.js') }}"></script> 
<script src="{{ asset('assets/aws/js/jquery-migrate-1.4.1.min.js') }}"></script> 
<script src="{{ asset('assets/aws/js/popper.min.js') }}"></script> 
<script src="{{ asset('assets/aws/js/bootstrap.min.js') }}"></script> 
<script src="{{ asset('assets/aws/js/owl.carousel.min.js') }}"></script> 
<script src="{{ asset('assets/aws/js/jquery.prettyPhoto.js') }}"></script> 
<script src="{{ asset('assets/aws/js/isotope.min.js') }}"></script> 
<script src="{{ asset('assets/aws/js/slick.min.js') }}"></script> 
<script src="{{ asset('assets/aws/js/custom.js') }}"></script>
</body>
</html>
<?php 
$bg   = DB::connection('ts3')->table('cp.heading')->where('halaman','Layanan')->orderBy('id_heading','DESC')->first();
 ?>
<!--Inner Header Start-->
<section class="wf100 p80 inner-header" style="background-image: url('{{ asset('assets/upload/image/'.$bg->gambar) }}'); background-position: bottom center;">
   <div class="container">
      <h1>{{ $title }}</h1>
   </div>
</section>
<!--Inner Header End--> 
<!--About Start-->
<section class="wf100 about">
<!--About Txt Video Start-->
<div class="about-video-section wf100">
   <div class="container">
      <div class="row">
         <div class="col-lg-6">
            <div class="about-text text-aws">               
               <?php echo $berita->isi ?>
            </div>
         </div>
         <div class="col-lg-6">
            <a href="#"><img src="{{ asset('assets/upload/image/'.$berita->gambar) }}" alt="{{ $title }}" class="img img-fluid img-thumbnail"></a>
         </div>
         
      </div>
       
      @if($read->sop_layanan != null)
      <div class="container">
         <h5 class="mb-4 font-weight-bold">
             Jaringan layanan service kunjung kami, tersebar di beberapa lokasi di wilayah Indonesia, antara lain:
         </h5>
      <div class="row mb-4">
         <div class="col-lg-12">
             <div class="d-flex flex-wrap justify-content-start">
                 <!-- Sumatera -->
                 <div class="custom-margin-berita">
                     <h6 class="font-weight-bold">Sumatera</h6>
                     <ul class="list-unstyled mb-0">
                         <li>Aceh</li>
                         <li>Bengkulu</li>
                         <li>Jambi</li>
                         <li>Kepulauan Riau</li>
                         <li>Kepulauan Bangka Belitung</li>
                         <li>Lampung</li>
                         <li>Riau</li>
                         <li>Sumatera Barat</li>
                         <li>Sumatera Selatan</li>
                         <li>Sumatera Utara</li>
                     </ul>
                 </div>
     
                 <!-- Jawa -->
                 <div class="custom-margin-berita">
                     <h6 class="font-weight-bold">Jawa</h6>
                     <ul class="list-unstyled mb-0">
                         <li>Banten</li>
                         <li>Jakarta</li>
                         <li>Jawa Barat</li>
                         <li>Jawa Tengah</li>
                         <li>Jawa Timur</li>
                     </ul>
                 </div>
     
                 <!-- Nusa Tenggara -->
                 <div class="custom-margin-berita">
                     <h6 class="font-weight-bold">Nusa Tenggara</h6>
                     <ul class="list-unstyled mb-0">
                         <li>Bali</li>
                         <li>Nusa Tenggara Barat</li>
                         <li>Nusa Tenggara Timur</li>
                     </ul>
                 </div>
     
                 <!-- Kalimantan -->
                 <div class="custom-margin-berita">
                     <h6 class="font-weight-bold">Kalimantan</h6>
                     <ul class="list-unstyled mb-0">
                         <li>Kalimantan Barat</li>
                         <li>Kalimantan Selatan</li>
                         <li>Kalimantan Tengah</li>
                         <li>Kalimantan Timur</li>
                         <li>Kalimantan Utara</li>
                     </ul>
                 </div>
     
                 <!-- Sulawesi -->
                 <div>
                     <h6 class="font-weight-bold">Sulawesi</h6>
                     <ul class="list-unstyled mb-0">
                         <li>Gorontalo</li>
                         <li>Sulawesi Barat</li>
                         <li>Sulawesi Selatan</li>
                         <li>Sulawesi Tengah</li>
                         <li>Sulawesi Tenggara</li>
                         <li>Sulawesi Utara</li>
                     </ul>
                 </div>
             </div>
         </div>
     </div>
   </div>
     

       @endif

      @if($berita->sop_layanan != null)
         <div class="row text center">
            <div class="embed-responsive embed-responsive-4by3"> 
               <iframe src="{{ asset('berita/sop-layanan/'.$berita->sop_layanan) }}#toolbar=0" type="application/pdf" width="80%"> </iframe>
            </div>
         </div>
      @endif


   </div>
</div>
</section>
<!--About Txt Video End--> 

 <!--Service Area Start-->
 <section class="donation-join wf100 p80">
   <div class="container text-center">
      <div class="row">
         <?php foreach($layanan as $layanan) { ?>
            <div class="col-md-4 col-sm-6">
               <br><a href="{{ asset('berita/layanan/'.$layanan->slug_berita) }}">
               <img src="{{ asset('assets/upload/image/thumbs/'.$layanan->gambar) }}" alt="{{ $layanan->judul_berita }}" class="img img-thumbnail img-fluid"></a>
               <div class="volbox">
                  <h6>{{ $layanan->judul_berita }}</h6>
                  <p>{{ $layanan->keywords }}</p>
                  <a href="{{ asset('berita/layanan/'.$layanan->slug_berita) }}">Lihat detail</a> 
               </div>
            </div>
            <!--box  end--> 
         <?php } ?>
      </div>
   </div>
</div>
<br><br>
</section>
<div class="clearfix"><br><br></div>



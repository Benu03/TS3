<?php 
$bg   = DB::connection('ts3')->table('cp.heading')->where('halaman','Berita')->orderBy('id_heading','DESC')->first();
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
            <style type="text/css" media="screen">
                              .text-aws img {
                                 width: auto;
                                 max-width: 100%;
                                 height: auto;
                              }
                           </style>               
               <?php echo $read->isi ?>
            </div>
         </div>
         <div class="col-lg-6">
            <a href="#"><img src="{{ asset('assets/upload/image/'.$read->gambar) }}" alt="{{ $title }}" class="img img-fluid img-thumbnail"></a>
         </div>
         
         
      </div>

      @if($read->sop_layanan != null)
      <div class="row text center">
         <div class="embed-responsive embed-responsive-4by3"> 
            <iframe src="{{ asset('berita/sop-layanan/'.$read->sop_layanan) }}#toolbar=0" type="application/pdf" width="80%"> </iframe>
         </div>
      </div>
      @endif
   </div>
</div>
</section>
<!--About Txt Video End--> 




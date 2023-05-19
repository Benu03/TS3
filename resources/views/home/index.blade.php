<!--Slider Start-->
         <section id="home-slider" class="owl-carousel owl-theme wf100">
            <?php foreach($slider as $slider) { ?>
            <div class="item">
               <div class="slider-caption h3slider">
                  <div class="container">
                     <?php if($slider->status_text=="Ya") { ?>
                     <strong>{{ strip_tags($slider->isi) }}</strong>
                     <h1>{{ $slider->judul_galeri }}</h1>
                     <a href="{{ $slider->website }}">Baca detail</a>
                     <?php } ?>
                  </div>
               </div>
               <img src="{{ asset('assets/upload/image/'.$slider->gambar) }}" alt=""> 
            </div>
            <?php } ?>
         </section>
         <!--Slider End--> 
         <!--Service Area Start-->
         <section class="donation-join wf100">
            <div class="container text-center">
               <div class="row">
                  
                  <?php foreach($layanan as $layanan) { ?>
                     <div class="col-md-4 col-sm-12">
                        <br>
                        <img src="{{ asset('assets/upload/image/thumbs/'.$layanan->gambar) }}" alt="{{ $layanan->judul_berita }}" class="img img-thumbnail img-fluid">
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
         </section>
         <!--Service Area End--> 
         <section class="wf100 about">
            <!--About Txt Video Start-->
            <div class="about-video-section wf100">
               <div class="container">
                  <div class="row">
                     <div class="col-lg-7">
                        <div class="about-text">
                           <h5>TENTANG KAMI</h5>
                           <h2>{{ $site_config->nama_singkat }}</h2>
                           <?php echo $site_config->tentang ?>

                           <a href="{{ asset('kontak') }}" class="btn btn-info btn-lg">Kontak Kami</a> 
                        </div>
                     </div>
                     <div class="col-lg-5">
                        <a href="#"><img src="{{ asset('assets/upload/image/'.$site_config->gambar) }}" alt="{{ $site_config->nama_singkat }}" class="img img-fluid img-thumbnail">
                     </div>
                  </div>
               </div>
            </div>
         
<section class="wf100 about">
   <div class="blog-grid">
      <div class="container">
         <div class="row">
            <div class="col-md-8">
            
                  <h2>Berita & Updates</h2>
             
            </div>
            <div class="col-md-4 text-right"> <a href="{{ asset('berita') }}" class="view-more">Lihat berita lainnya</a> </div>
            
         </div>
         <div class="row">
           
            <div class="col-md-12">
               <hr>
            </div>
         </div>
        
         
      </div>
   </div>
</section>

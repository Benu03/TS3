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
                        <a href="#"><img src="{{ asset('assets/upload/image/'.$site_config->gambar) }}" alt="{{ $site_config->nama_singkat }}" class="img img-fluid img-thumbnail border border-0">
                     </div>
                  </div>
               </div>
            </div>
         </section> 
         

         <section class="wf100 content">  
            <br>
            <div class="container">
              <h2 class="text-center"><b>Clients</b></h2>
              <div class="section-text align-center mbr-fonts-style display-5">
            
              <div class="row">
            
              <div id="gallery" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active" data-interval="1000">
                    <div class="row">
                        <div class="col text-center mr-1">
                        <img class="rounded mx-auto d-block img-thumbnail border border-0" src="{{ asset('assets/upload/client/pnm.png') }}"  alt="Image 1"/>
                        </div>
            
                        <div class="col mr-1">
                        <img class="rounded mx-auto d-block img-thumbnail border border-0" src="{{ asset('assets/upload/client/polytron.png') }}"  alt="Image 1"/>
                        </div>
            
                        <div class="col mr-1">
                        <img class="rounded mx-auto d-block img-thumbnail border border-0" src="{{ asset('assets/upload/client/mbm.png') }}"  alt="Image 1"/>
                        </div>
            
                        <div class="col mr-1">
                        <img class="rounded mx-auto d-block img-thumbnail border border-0" src="{{ asset('assets/upload/client/btpn_syariah.png') }}"  alt="Image 1"/>
                        </div>
            
                        <div class="col mr-1">
                        <img class="rounded mx-auto d-block img-thumbnail border border-0" src="{{ asset('assets/upload/client/phapros.png') }}"  alt="Image 1"/>
                        </div>
            
                       
                    </div>
                </div>
            
                <div class="carousel-item">
                    <div class="row">
                        <div class="col text-center mr-1">
                        <img class="rounded mx-auto d-block img-thumbnail  border border-0" src="{{ asset('assets/upload/client/glory.png') }}"  alt="Image 1"/>
                        </div>
            
                        <div class="col mr-1">
                        <img class="rounded mx-auto d-block img-thumbnail  border border-0" src="{{ asset('assets/upload/client/helmut.png') }}"  alt="Image 1"/>
                        </div>
            
                        <div class="col mr-1">
                        <img class="rounded mx-auto d-block img-thumbnail  border border-0" src="{{ asset('assets/upload/client/distambun.png') }}"  alt="Image 1"/>
                        </div>
            
                        <div class="col mr-1">
                        <img class="rounded mx-auto d-block img-thumbnail  border border-0" src="{{ asset('assets/upload/client/spj.png') }}"  alt="Image 1"/>
                        </div>
            
                        <div class="col mr-1">
                        <img class="rounded mx-auto d-block img-thumbnail  border border-0" src="{{ asset('assets/upload/client/uns.png') }}"  alt="Image 1"/>
                        </div>
            
                      
                    </div>
                 </div>
               </div>
            
                  <a class="carousel-control-prev" href="#gallery" role="button" data-slide="prev">
                      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                      <span class="sr-only">Previous</span>
                  </a>
            
                  <a class="carousel-control-next" href="#gallery" role="button" data-slide="next">
                      <span class="carousel-control-next-icon" aria-hidden="true"></span>
                      <span class="sr-only">Next</span>
                  </a>
              </div>
            
            
              </div>
              </div>
            </div>
            </section>
            
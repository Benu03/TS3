<!--Slider Start-->

<style>
/* Slider utama */
#home-slider .item {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 300px; /* tinggi area slider, bisa disesuaikan */
  background: #f8f9fa; /* biar tidak kosong kalau gambar kecil */
}

#home-slider .item img {
  max-height: 200px;
  width: auto;
  object-fit: contain;
  margin: 0 auto;
}

/* Client slider */
.client-slide .item {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 120px; /* kotak logo lebih seragam */
}

.client-slide .item img {
  max-height: 80px;
  object-fit: contain;
  width: auto;
}

/* Tombol navigasi slider utama */
#home-slider.owl-theme .owl-nav {
  position: absolute;
  top: 50%;
  left: 0;
  right: 0;
  transform: translateY(-50%);
  display: flex;
  justify-content: space-between;
  padding: 0 20px;
  pointer-events: none;
}

#home-slider.owl-theme .owl-nav button.owl-prev,
#home-slider.owl-theme .owl-nav button.owl-next {
  background: rgba(0,0,0,0.4) !important;
  color: #fff !important;
  border-radius: 50%;
  width: 40px;
  height: 40px;
  pointer-events: auto;
}

#home-slider.owl-theme .owl-nav button.owl-prev:hover,
#home-slider.owl-theme .owl-nav button.owl-next:hover {
  background: rgba(0,0,0,0.8) !important;
}

</style>

<section id="home-slider" class="owl-carousel owl-theme wf100">
    @foreach($slider as $s)
        <div class="item">
            <img src="{{ asset('assets/upload/image/'.$s->gambar) }}" alt="{{ $s->judul_galeri }}"> 

            @if($s->status_text == "Ya")
                <div class="slider-caption h3slider">
                    <div class="container text-center">
                        <strong>{{ strip_tags($s->isi) }}</strong>
                        <h1>{{ $s->judul_galeri }}</h1>
                        @if($s->website)
                            <a href="{{ $s->website }}" target="_blank" class="btn btn-primary">Baca detail</a>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    @endforeach
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
                     <div class="col-lg-12">
                        <div class="about-text">
                           <h5>TENTANG KAMI</h5>


          
                           <?php echo $site_config->tentang ?>

                           <div class="wrapper33">
                              <img src="{{ asset('assets/upload/image/'.$site_config->gambar) }}" class="img-logots3">  
                            </div>
                       

                          
              
                        </div>
                        
                     </div>
                     <a href="{{ asset('kontak') }}" class="btn btn-md" style="color: #ffffff; background-color: #32af81; border-color: #32af81"><i class="fas fa-id-card-alt"></i> Kontak Kami</a> 
                 
                  </div>


         </section> 
         


         <section class="wf100 content">  
            <br>
            <div class="container">
              <h2 class="text-center"><b>Clients</b></h2>
              <div class="section-text align-center mbr-fonts-style display-5">
            
              <div class="row">
     
              <div class="container mt-4">
                  <div class="owl-carousel owl-theme client-slide">
                     <div class="item">
                           <img class="rounded img-thumbnail border-0" src="{{ asset('assets/upload/client/pnm.png') }}" alt="PNM"/>
                     </div>
                     <div class="item">
                           <img class="rounded img-thumbnail border-0" src="{{ asset('assets/upload/client/polytron.png') }}" alt="Polytron"/>
                     </div>
                     <div class="item">
                           <img class="rounded img-thumbnail border-0" src="{{ asset('assets/upload/client/mbm.png') }}" alt="MBM"/>
                     </div>
                     <div class="item">
                           <img class="rounded img-thumbnail border-0" src="{{ asset('assets/upload/client/btpn_syariah.png') }}" alt="BTPN Syariah"/>
                     </div>
                     <div class="item">
                           <img class="rounded img-thumbnail border-0" src="{{ asset('assets/upload/client/phapros.png') }}" alt="Phapros"/>
                     </div>
                     <div class="item">
                           <img class="rounded img-thumbnail border-0" src="{{ asset('assets/upload/client/brother.png') }}" alt="Brother"/>
                     </div>
                     <div class="item">
                           <img class="rounded img-thumbnail border-0" src="{{ asset('assets/upload/client/glory.png') }}" alt="Glory"/>
                     </div>
                     <div class="item">
                           <img class="rounded img-thumbnail border-0" src="{{ asset('assets/upload/client/helmut.png') }}" alt="Helmut"/>
                     </div>
                     <div class="item">
                           <img class="rounded img-thumbnail border-0" src="{{ asset('assets/upload/client/distambun.png') }}" alt="Distambun"/>
                     </div>
                     <div class="item">
                           <img class="rounded img-thumbnail border-0" src="{{ asset('assets/upload/client/spj.png') }}" alt="SPJ"/>
                     </div>
                     <div class="item">
                           <img class="rounded img-thumbnail border-0" src="{{ asset('assets/upload/client/uns.png') }}" alt="UNS"/>
                     </div>
                  </div>
               </div>

                           
          


            
              </div>
              </div>


                     <div class="row" style="margin-top: 60px;">
                     <div class="col-lg-12">
                                 <h2 class="mb-4 font-weight-bold text-center">Jaringan Kami</h2>
                              <h5 class="mb-4 font-weight-bold">
                                 Jaringan layanan service kunjung kami, tersebar di beberapa lokasi di wilayah Indonesia, antara lain:
                              </h5>
                           <select id="locationSelect" class="form-control" style="margin-bottom: 20px;">
                              <option value="">Pilih Kota</option>
                              <?php foreach ($locations as $provinsi => $cities): ?>
                                 <optgroup label="<?= $provinsi ?>">
                                    <?php foreach ($cities as $city): ?>
                                       <option value="<?= $city['gmap'] ?>" data-address="<?= $city['address'] ?>">
                                          <?= $city['name'] ?>
                                       </option>
                                    <?php endforeach; ?>
                                 </optgroup>
                              <?php endforeach; ?>
                           </select>


                           {{-- <div id="map" style="width: 100%; height: 500px; margin-bottom: 20px;"></div> --}}
                           <div class="custom-card" style ="margin-bottom: 20px;">
                              
                              <div class="card-body">
                                <div id="map" style="width: 100%; height: 500px;"></div>
                              </div>
                            </div>

                        </div>
                        </div>


               </div>
            </div>








            </div>
            </section>

            
<!-- Tambahkan JS Owl Carousel -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>


<script>
$(document).ready(function(){
  $("#home-slider").owlCarousel({
      items:1,
      loop:true,
      autoplay:true,
      autoplayTimeout:4000,
      autoplayHoverPause:true,
      nav:true,
      dots:true
  });
});
</script>

<script>
$(document).ready(function(){
  $(".client-slide").owlCarousel({
      loop:true,
      margin:20,
      autoplay:true,
      autoplayTimeout:1500,
      autoplayHoverPause:false,
      responsive:{
          0:{ items:2 },
          600:{ items:4 },
          1000:{ items:6 }
      }
  });
});
</script>
          
<script>
         let map, markers = [];
         const locations2 = @json($locations2);
       
         const customIcon = L.icon({
             iconUrl: 'https://ts3.co.id/assets/upload/image/2.png',
             iconSize: [32, 32],
             iconAnchor: [16, 32],
             popupAnchor: [0, -32]
         });
      
         function initMap() {
            map = L.map('map', {
            center: [-2.600029, 118.015776], // Pusat Indonesia
            zoom: 5, // Level zoom awal
          
        });
      
             L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                 attribution: '&copy; OpenStreetMap contributors'
             }).addTo(map);

             const markersCluster = L.markerClusterGroup({
               iconCreateFunction: function(cluster) {
                  const markersInCluster = cluster.getAllChildMarkers();
                  const markerCount = markersInCluster.length;
                  
                 
                  const size = Math.min(40 + (markerCount * 2), 80);  // Maksimal ukuran 80px
                  const radius = size / 2;

                        // Membuat ikon untuk cluster
                        return L.divIcon({
                           html: `<div style="background-color: #6dcbd3; border-radius: 50%; width: ${size}px; height: ${size}px; line-height: ${size}px; text-align: center; color: white; font-size: 16px;">${markerCount}</div>`,
                           className: 'leaflet-markercluster-custom',
                           iconSize: [size, size],
                           iconAnchor: [radius, radius],
                           popupAnchor: [0, -radius]
                        });
                     }
               });





      
             locations2.forEach(location => {
                 const marker = L.marker([location.lat, location.lng], { icon: customIcon }).addTo(map);
                 marker.bindPopup(`
                     <div style="display: flex; align-items: center;">
                         <img src="https://ts3.co.id/assets/upload/image/2.png" alt="Location Icon" style="width: 50px; height: 50px; margin-right: 10px;">
                         <div>
                             <h5>${location.title}</h5>
                             <p>${location.address}</p>
                         </div>
                     </div>
                 `);
      
                 marker.on('click', function() {
                     map.setView([location.lat, location.lng], 16); 
                     marker.openPopup();  
                 });
      
                 markers.push(marker);

                 markersCluster.addLayer(marker);
             });

             map.addLayer(markersCluster);
             
               if (map.getZoom() <= 8) {
                     markers.forEach(marker => marker.setOpacity(0));
                  }

                 map.on('zoomend', function() {
                  const zoomLevel = map.getZoom();
                  if (zoomLevel <= 8) {
                        // Jika zoom level <= 5, sembunyikan marker
                        markers.forEach(marker => marker.setOpacity(0));
                  } else {
                        // Jika zoom level > 5, tampilkan marker
                        markers.forEach(marker => marker.setOpacity(1));
                  }
               });
         }
      
         function changeLocation(value) {
             if (value === "") {
                 map.setView([-2.600029, 118.015776], 5); 
                 markers.forEach(marker => marker.addTo(map));
             } else {
                 const selectedLocation = locations2.find(location => 
                     `${location.lat},${location.lng}` === value
                 );
      
                 if (selectedLocation) {
                     const newLocation = { lat: selectedLocation.lat, lng: selectedLocation.lng };
                     map.setView(newLocation, 20);
      
                     const tempPopup = L.popup()
                         .setLatLng(newLocation)
                         .setContent(`
                             <div style="display: flex; align-items: center;">
                                 <img src="https://ts3.co.id/assets/upload/image/2.png" alt="Location Icon" style="width: 30px; height: 30px; margin-right: 10px;">
                                 <div><h5>${selectedLocation.title}</h5><p>${selectedLocation.address}</p></div>
                             </div>
                         `)
                         .openOn(map);
                 }
             }
         }
      
         document.getElementById('locationSelect').addEventListener('change', function() {
             const selectedValue = this.value;
             changeLocation(selectedValue); 
         });
      
         window.onload = initMap;
</script>
      
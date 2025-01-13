
<section class="wf100 p80 inner-header" style="background-image: url('{{ asset('assets/upload/image/'.$bg->gambar) }}'); background-position: bottom center;">
   <div class="container">
      <h1>{{ $title }}</h1>
   </div>
</section>

<!-- Header End -->

<!-- Map Locator Section -->
<section class="wf100 about mb-4">
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

      @if($berita->sop_layanan != null)
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


      {{-- <div id="mapNetworks" style="width: 100%; height: 500px; margin-bottom: 20px;"></div> --}}
      <div id="map" style="width: 100%; height: 500px; margin-bottom: 20px;"></div>

      


       @endif
       @if($berita->sop_layanan != null)
         <div class="row text center">
            <div class="embed-responsive embed-responsive-4by3"> 
               <iframe src="{{ asset('berita/sop-layanan/'.$berita->sop_layanan) }}#toolbar=0" type="application/pdf" width="80%"> </iframe>
            </div>
         </div>
      @endif

   </div>
</section>



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
      
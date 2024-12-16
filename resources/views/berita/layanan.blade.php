<?php
// Data Dummy untuk Lokasi di Grouping Berdasarkan Provinsi
$locations = [
    'DKI Jakarta' => [
        ['id' => 1, 'name' => 'Jakarta Pusat', 'gmap' => '-6.186486,106.834091', 'address' => 'Jl. Merdeka No. 1, Jakarta Pusat'],
        ['id' => 2, 'name' => 'Jakarta Selatan', 'gmap' => '-6.261493,106.810600', 'address' => 'Jl. Sudirman No. 2, Jakarta Selatan'],
    ],
    'Jawa Barat' => [
        ['id' => 3, 'name' => 'Bandung', 'gmap' => '-6.917464,107.619123', 'address' => 'Jl. Asia Afrika No. 3, Bandung'],
        ['id' => 4, 'name' => 'Bekasi', 'gmap' => '-6.238270,107.005042', 'address' => 'Jl. Ahmad Yani No. 4, Bekasi'],
    ],
    'Jawa Timur' => [
        ['id' => 5, 'name' => 'Surabaya', 'gmap' => '-7.250445,112.768845', 'address' => 'Jl. Gubernur Suryo No. 5, Surabaya'],
        ['id' => 6, 'name' => 'Malang', 'gmap' => '-7.966620,112.632632', 'address' => 'Jl. Ijen No. 6, Malang'],
    ],
];


?>
<?php 
$bg   = DB::connection('ts3')->table('cp.heading')->where('halaman','Layanan')->orderBy('id_heading','DESC')->first();
 ?>


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

      


            <div class="container">
     
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

   const locations = [
       { lat: -6.186486, lng: 106.834091, title: "Jakarta Pusat", address: "Jl. Merdeka No. 1, Jakarta Pusat" },
       { lat: -6.261493, lng: 106.810600, title: "Jakarta Selatan", address: "Jl. Sudirman No. 2, Jakarta Selatan" },
       { lat: -6.917464, lng: 107.619123, title: "Bandung", address: "Jl. Asia Afrika No. 3, Bandung" },
       { lat: -6.238270, lng: 107.005042, title: "Bekasi", address: "Jl. Ahmad Yani No. 4, Bekasi" },
       { lat: -7.250445, lng: 112.768845, title: "Surabaya", address: "Jl. Gubernur Suryo No. 5, Surabaya" },
       { lat: -7.966620, lng: 112.632632, title: "Malang", address: "Jl. Ijen No. 6, Malang" },
       { lat: -0.472448, lng: 117.144128, title: "Balikpapan", address: "Jl. Soekarno Hatta No. 7, Balikpapan" },
       { lat: -0.322533, lng: 117.578508, title: "Banjarmasin", address: "Jl. A. Yani No. 9, Banjarmasin" },
       { lat: 1.145207, lng: 109.334868, title: "Pontianak", address: "Jl. Alian No. 5, Pontianak" },
       { lat: 3.595194, lng: 98.672221, title: "Medan", address: "Jl. Merdeka No. 10, Medan" },
       { lat: 5.466732, lng: 100.360168, title: "Padang", address: "Jl. Ahmad Yani No. 11, Padang" },
       { lat: 1.671087, lng: 104.202817, title: "Palembang", address: "Jl. Raya Palembang No. 15, Palembang" },
       { lat: -0.949954, lng: 119.878724, title: "Makassar", address: "Jl. Losari No. 13, Makassar" },
       { lat: 0.594269, lng: 122.626142, title: "Manado", address: "Jl. Sam Ratulangi No. 8, Manado" },
       { lat: -0.548272, lng: 122.982297, title: "Gorontalo", address: "Jl. Sultan Botutihe No. 3, Gorontalo" }
   ];

   const customIcon = L.icon({
       iconUrl: 'https://ts3.co.id/assets/upload/image/2.png',
       iconSize: [32, 32],
       iconAnchor: [16, 32],
       popupAnchor: [0, -32]
   });


   function initMap() {

       map = L.map('map').setView([ -2.600029, 118.015776 ], 5); // Pusat Indonesia

       // Menambahkan layer OpenStreetMap
       L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
         //   attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
         'Streets': L.tileLayer('https://{s}.tile.streets.org/{z}/{x}/{y}.png')
       }).addTo(map);

       // Tambahkan Semua Marker
       locations.forEach(location => {
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
               map.setZoom(8);  
               map.setView([location.lat, location.lng], 8); 
               marker.openPopup();  
           });


           markers.push(marker);
       });


   }


   function changeLocation(value) {
       if (value === "") {
           // Jika value kosong, reset peta ke pusat dan tampilkan semua marker
           map.setView([ -2.600029, 118.015776 ], 5); // Kembali ke posisi pusat Indonesia
           markers.forEach(marker => marker.addTo(map)); // Menambahkan semua marker ke peta
       } else {
           const selectedLocation = locations.find(location => `${location.lat},${location.lng}` === value);

           if (selectedLocation) {
               const newLocation = { lat: selectedLocation.lat, lng: selectedLocation.lng };
               map.setView(newLocation, 12);
               
             
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

   // Event listener untuk dropdown
   document.getElementById('locationSelect').addEventListener('change', function() {
       const selectedValue = this.value;
       changeLocation(selectedValue); 
   });




   window.onload = initMap;
</script>

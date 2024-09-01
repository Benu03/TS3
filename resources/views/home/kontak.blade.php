<?php 
$bg   = DB::connection('ts3')->table('cp.heading')->where('halaman','Kontak')->orderBy('id_heading','DESC')->first();
 ?>
<!--Inner Header Start-->
<section class="wf100 p80 inner-header" style="background-image: url('{{ asset('assets/upload/image/'.$bg->gambar) }}'); background-position: bottom center;">
   <div class="container">
      <h1>{{ $title }}</h1>
   </div>
</section>
<!--Inner Header End--> 
<!--Contact Start-->
<section class="contact-page wf100 p50">
   <div class="container contact-info">
      <div class="row">
         <!--Contact Info Start-->
         <div class="col-md-6">
            <div class="c-info">
               <h6>Alamat:</h6>
               <p>
                <strong><?php echo $site_config->namaweb ?></strong>
                <br><?php echo nl2br($site_config->alamat) ?>
              </p>
            </div>
         </div>
         <!--Contact Info End--> 
         <!--Contact Info Start-->
         <div class="col-md-6">
            <div class="c-info">
               <h6>Kontak:</h6>
               <p>Telepon: <?php echo $site_config->telepon ?>
                <br>Email: <?php echo $site_config->email ?>
                <br>Website: <?php echo $site_config->website ?></p>
            </div>
         </div>
         <!--Contact Info End--> 
         
      </div>
      <br><br>
   </div>
   <div class="container">
      <div class="row">
         <div class="col-md-6">
            <div class="contact-form">
               <form action="{{ asset('kirim-kontak') }}" enctype="multipart/form-data" method="post" accept-charset="utf-8">
                  {{ csrf_field() }}
               <ul class="cform">
                  <li class="half pr-15">
                     <input type="text" name="fullname" class="form-control" placeholder="Full Name">
                  </li>
                  <li class="half pl-15">
                     <input type="text" name="email" class="form-control" placeholder="Email">
                  </li>
                  <li class="half pr-15">
                     <input type="text" name="contact" class="form-control" placeholder="Contact">
                  </li>
                  <li class="half pl-15">
                     <input type="text"  name="subject" class="form-control" placeholder="Subject">
                  </li>
                  <li class="full">
                     <textarea name="pesan" class="textarea-control" placeholder="Message"></textarea>
                  </li>
                  <li class="full">
                     <input type="submit" value="Contact us" class="btn btn-info btn-lg btn-block">
                  </li>
               </ul>
            </form>
            </div>
         </div>
         <div class="col-md-6">
            <div class="google-map">
               <?php echo $site_config->google_map ?>
            </div>
         </div>
      </div>
   </div>
   <br><br>
</section>
<!--Contact End--> 

<script>
   @if ($message = Session::get('sukses'))
   // Notifikasi
   swal ( "Berhasil" ,  "<?php echo $message ?>" ,  "success" )
   @endif
 
   @if ($message = Session::get('warning'))
   // Notifikasi
   swal ( "Oops.." ,  "<?php echo $message ?>" ,  "warning" )
   @endif
 
   // Popup Delete
   $(document).on("click", ".delete-link", function(e){
   e.preventDefault();
   url = $(this).attr("href");
   swal({
     title:"Yakin akan menghapus data ini?",
     type: "warning",
     showCancelButton: true,
     confirmButtonClass: 'btn btn-danger',
     cancelButtonClass: 'btn btn-success',
     buttonsStyling: false,
     confirmButtonText: "Delete",
     cancelButtonText: "Cancel",
     closeOnConfirm: false,
     showLoaderOnConfirm: true,
   },
   function(isConfirm){
     if(isConfirm){
       $.ajax({
         url: url,
         success: function(resp){
           window.location.href = url;
         }
       });
     }
     return false;
   });
   });
   // Popup disable
   $(document).on("click", ".disable-link", function(e){
   e.preventDefault();
   url = $(this).attr("href");
   swal({
     title:"Yakin akan menonaktifkan data ini?",
     type: "warning",
     showCancelButton: true,
     confirmButtonClass: 'btn btn-danger',
     cancelButtonClass: 'btn btn-success',
     buttonsStyling: false,
     confirmButtonText: "Non Aktifkan",
     cancelButtonText: "Cancel",
     closeOnConfirm: false,
     showLoaderOnConfirm: true,
   },
   function(isConfirm){
     if(isConfirm){
       $.ajax({
         url: url,
         success: function(resp){
           window.location.href = url;
         }
       });
     }
     return false;
   });
   });
 
 // Popup approval
   $(document).on("click", ".approval-link", function(e){
   e.preventDefault();
   url = $(this).attr("href");
   swal({
     title:"Anda yakin ingin menyetujui data ini?",
     type: "info",
     showCancelButton: true,
     confirmButtonClass: 'btn btn-danger',
     cancelButtonClass: 'btn btn-success',
     buttonsStyling: false,
     confirmButtonText: "Ya, Setujui",
     cancelButtonText: "Cancel",
     closeOnConfirm: false,
     showLoaderOnConfirm: true,
   },
   function(isConfirm){
     if(isConfirm){
       $.ajax({
         url: url,
         success: function(resp){
           window.location.href = url;
         }
       });
     }
     return false;
   });
 });
 </script>
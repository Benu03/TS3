
<!-- Info boxes -->
<div class="row">
  <div class="col-12 col-sm-6 col-md-3">
    <div class="info-box">
      <span class="info-box-icon bg-info elevation-1"><i class="fas fa-motorcycle"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">List Service</span>
        <span class="info-box-number">
          <?php 
          $berita = DB::connection('ts3')->table('cp.berita')->where('jenis_berita','Berita')->get(); 
          echo $berita->count();
          ?>
          <small>Waiting</small>
        </span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->
  <div class="col-12 col-sm-6 col-md-3">
    <div class="info-box mb-3">
      <span class="info-box-icon bg-success elevation-1"><i class="fa fa-certificate"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">
          Jumlah Service Perbulan
        </span>
        <span class="info-box-number">
        <?php 
          $berita = DB::connection('ts3')->table('cp.berita')->where('jenis_berita','Layanan')->get(); 
          echo $berita->count();
          ?>
          {{-- <small>Sudah Dipublikasikan</small> --}}
        </span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->

  <!-- fix for small devices only -->
  {{-- <div class="clearfix hidden-md-up"></div> --}}

  {{-- <div class="col-12 col-sm-6 col-md-3">
    <div class="info-box mb-3">
      <span class="info-box-icon bg-success elevation-1"><i class="fas fa-download"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">File &amp; Dokumen</span>
        <span class="info-box-number">
        <?php 
          $download = DB::connection('ts3')->table('cp.berita')->get(); 
          echo $download->count();
          ?>
          <small>File</small>
        </span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div> --}}
  <!-- /.col -->
  <div class="col-12 col-sm-6 col-md-3">
    <div class="info-box mb-3">
      <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-directions"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Direct Service</span>
        <span class="info-box-number">
        	<?php 
          $galeri = DB::connection('ts3')->table('cp.galeri')->get(); 
          echo $galeri->count();
          ?>
          {{-- <small>Gambar</small> --}}
        </span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->
  <div class="col-12 col-sm-6 col-md-3">
    <div class="info-box mb-3">
      <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-money-check"></i></span>
  
      <div class="info-box-content">
        <span class="info-box-text">
          Invoice
        </span>
        <span class="info-box-number">
        <?php 
          $staff = DB::connection('ts3')->table('cp.staff')->get(); 
          echo $staff->count();
          ?>
          {{-- <small>Orang</small> --}}
        </span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  
</div>
<!-- /.row -->



<!-- Info boxes -->
<div class="row">
 



</div>
<!-- /.row -->

<!-- Info boxes -->
<div class="row">
  <div class="col-12 col-sm-6 col-md-3">
    <div class="info-box">
      <span class="info-box-icon bg-info elevation-1"><i class="fas fa-thumbs-up"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Approval</span>
        <span class="info-box-number">
          <?php 
          $berita = DB::connection('ts3')->table('cp.berita')->where('jenis_berita','Berita')->get(); 
          echo $berita->count();
          ?>
          {{-- <small>Sudah dibuat</small> --}}
        </span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->
  <div class="col-12 col-sm-6 col-md-3">
    <div class="info-box mb-3">
      <span class="info-box-icon bg-success elevation-1"><i class="fas fa-hand-holding"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">
          Product Sevice
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


  <div class="col-12 col-sm-6 col-md-3">
    <div class="info-box mb-3">
      <span class="info-box-icon bg-warning elevation-1"><i class="fa fa-file-contract"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">SPK Proses</span>
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
      <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-motorcycle"></i></span>
  
      <div class="info-box-content">
        <span class="info-box-text">
          Vehicle Due Date
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
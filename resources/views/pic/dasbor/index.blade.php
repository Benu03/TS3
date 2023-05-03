
<!-- Info boxes -->
<div class="row">
  <div class="col-12 col-sm-6 col-md-3">
    <div class="info-box">
      <span class="info-box-icon bg-info elevation-1"><i class="fas fa-hands"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">List Service</span>
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
      <span class="info-box-icon bg-success elevation-1"><i class="fas fa-directions"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">
          Direct Service
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
      <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-hand-point-up"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Service Advisor</span>
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
          Jumlah Kendaraan
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
  {{-- <div class="col-12 col-sm-6 col-md-3">
    <div class="info-box">
      <span class="info-box-icon bg-info elevation-1"><i class="fa fa-check"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Rekening</span>
        <span class="info-box-number">
          <?php 
          $rekening = DB::connection('ts3')->table('cp.rekening')->get(); 
          echo $rekening->count();
          ?>
          <small>Bank</small>
        </span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div> --}}
  <!-- /.col -->
  
  <!-- /.col -->

  <!-- fix for small devices only -->
  <div class="clearfix hidden-md-up"></div>

  {{-- <div class="col-12 col-sm-6 col-md-3">
    <div class="info-box mb-3">
      <span class="info-box-icon bg-success elevation-1"><i class="fas fa-video"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Video Youtube</span>
        <span class="info-box-number">
        <?php 
          $video = DB::connection('ts3')->table('cp.video')->get(); 
          echo $video->count();
          ?>
          <small>Video</small>
        </span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div> --}}
  <!-- /.col -->
  {{-- <div class="col-12 col-sm-6 col-md-3">
    <div class="info-box mb-3">
      <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-calendar"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Agenda Kegiatan</span>
        <span class="info-box-number">
        	<?php 
          $agenda = DB::connection('ts3')->table('cp.agenda')->get(); 
          echo $agenda->count();
          ?>
          <small>Acara</small>
        </span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div> --}}
  <!-- /.col -->
</div>
<!-- /.row -->
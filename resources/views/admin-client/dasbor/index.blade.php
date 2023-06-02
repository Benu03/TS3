
<!-- Info boxes -->
<div class="row">
  <div class="col-12 col-sm-6 col-md-3">
    <a href="{{ asset('admin-client/approval') }}">
    <div class="info-box">
      <span class="info-box-icon bg-info elevation-1"><i class="fas fa-thumbs-up"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Approval</span>
        <span class="info-box-number">
          {{ $approval }}
        </span>
      </div>
      <!-- /.info-box-content -->
    </div>
   </a>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->
  <div class="col-12 col-sm-6 col-md-3">
    <a href="{{ asset('admin-client/dasbor') }}">
    <div class="info-box mb-3">
      <span class="info-box-icon bg-success elevation-1"><i class="fas fa-hand-holding"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">
          Product Sevice
        </span>
        <span class="info-box-number">
          {{ $product }}
          {{-- <small>Sudah Dipublikasikan</small> --}}
        </span>
      </div>
      <!-- /.info-box-content -->
    </div>
    </a>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->


  <div class="col-12 col-sm-6 col-md-3">
    <a href="{{ asset('admin-client/spk') }}">
    <div class="info-box mb-3">
      <span class="info-box-icon bg-warning elevation-1"><i class="fa fa-file-contract"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">SPK Proses</span>
        <span class="info-box-number">
          {{ $spk }}
          {{-- <small>Gambar</small> --}}
        </span>
      </div>
      <!-- /.info-box-content -->
    </div>
  </a>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->
  <div class="col-12 col-sm-6 col-md-3">
    <a href="{{ asset('admin-client/vehicle-schedule-service') }}">
    <div class="info-box mb-3">
      <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-motorcycle"></i></span>
  
      <div class="info-box-content">
        <span class="info-box-text">
          Vehicle Schedule Service
        </span>
        <span class="info-box-number">
          {{ $vehiclecount }}
          {{-- <small>Orang</small> --}}
        </span>
      </div>
      <!-- /.info-box-content -->
    </div>
  </a>
    <!-- /.info-box -->
  </div>
  
</div>
<!-- /.row -->



<!-- Info boxes -->
<div class="row">
 
</div>
<!-- /.row -->
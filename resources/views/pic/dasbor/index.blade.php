
<!-- Info boxes -->
<div class="row">
  <div class="col-12 col-sm-6 col-md-3">
    <a href="{{ asset('pic/list-service') }}">
    <div class="info-box">
      <span class="info-box-icon bg-info elevation-1"><i class="fas fa-hands"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Service</span>
        <span class="info-box-number">
         {{ $service }}

        </span>
      </div>
      <!-- /.info-box-content -->
    </div>
     </a>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->
  <div class="col-12 col-sm-6 col-md-3">
    <a href="{{ asset('pic/direct-service') }}">
    <div class="info-box mb-3">
      <span class="info-box-icon bg-success elevation-1"><i class="fas fa-directions"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">
          Direct Service
        </span>
        <span class="info-box-number">
          {{ $direct }}
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
    <a href="{{ asset('pic/list-service') }}">
    <div class="info-box mb-3">
      <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-hand-point-up"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Service Advisor</span>
        <span class="info-box-number">
        	{{ $advisor }}
          {{-- <small>Gambar</small> --}}
        </span>
      </div>
      <!-- /.info-box-content -->
    </div>
  </a>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->

  
</div>
<!-- /.row -->



<!-- Info boxes -->
<div class="row">
  <div class="col-12 col-sm-6 col-md-3">
    <a href="{{ asset('bengkel/list-service') }}">
    <div class="info-box">
      <span class="info-box-icon bg-info elevation-1"><i class="fas fa-motorcycle"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Service</span>
        <span class="info-box-number">
        {{ $service }}
          <small>Waiting</small>
        </span>
      </div>
      <!-- /.info-box-content -->
    </div>
    </a>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->


  <div class="col-12 col-sm-6 col-md-3">
    <a href="{{ asset('bengkel/list-service') }}">
    <div class="info-box mb-3">
      <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-directions"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Direct Service</span>
        <span class="info-box-number">
        	{{ $direct }}
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
    <a href="{{ asset('bengkel/invoice') }}">
    <div class="info-box mb-3">
      <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-money-check"></i></span>
  
      <div class="info-box-content">
        <span class="info-box-text">
          Invoice
        </span>
        <span class="info-box-number">
          {{ $invoice }}
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
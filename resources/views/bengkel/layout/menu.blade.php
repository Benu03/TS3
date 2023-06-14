<style type="text/css" media="screen">
  .nav ul li p !important {
    font-size: 12px;
  }
  .infoku {
    margin-left: 20px; 
    text-transform: uppercase;
    color: yellow;
    font-size: 11px;
  }
</style>
<!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ asset('bengkel/dasbor') }}" class="brand-link">
      <img src="{{ asset('assets/upload/image/'.website('icon')) }}"
         alt="{{ website('namaweb') }}"
         class="brand-image img-circle elevation-3"
         style="opacity: .8">
      <span class="brand-text font-weight-light">{{ website('nama_singkat') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- DASHBOARD -->
          <li class="nav-item">
            <a href="{{ asset('bengkel/dasbor') }}" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          
          <!-- Website Content -->
          <li class="batas"><hr> <span class="infoku"><i class="fa fa-certificate"></i> Motor Vehicle Maintenace</span></li>
          <li class="batas"><hr></li>


          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="fas fa-paste nav-icon"></i>
              <p>Service<i class="fas fa-angle-left right"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item ml-4"><a href="{{ asset('bengkel/list-service') }}" class="nav-link"><i class="fas fa-motorcycle nav-icon"></i><p>List Service</p></a>
              </li>
              {{-- <li class="nav-item ml-4"><a href="{{ asset('bengkel/direct-service') }}" class="nav-link"><i class="fas fa-directions nav-icon"></i><p>Direct Service</p></a>
              </li> --}}
             
            </ul>
          </li>    
  
          <li class="nav-item"><a href="{{ asset('bengkel/invoice') }}" class="nav-link"><i class="nav-icon fas fa-money-check"></i><p> Invoice</p></a></li>

             {{-- report  --}}
             <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="fas fa-paste nav-icon"></i>
                <p>Report<i class="fas fa-angle-left right"></i></p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item ml-4"><a href="{{ asset('bengkel/report/history-service') }}" class="nav-link"><i class="fas fa-history nav-icon"></i><p>History Service</p></a>
                </li>
                <li class="nav-item ml-4"><a href="{{ asset('bengkel/report/summary-bengkel') }}" class="nav-link"><i class="fas fa-warehouse nav-icon"></i><p>Summary Bengkel</p></a>
                </li>
  
  
               
              </ul>
            </li>             

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row">
          
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <div class="row">
              <div class="col-md-12">
                 <h2 class="card-title"><?php echo $title ?></h2> 
              </div>
             
              
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
{{-- <div class="table-responsive konten"> --}}

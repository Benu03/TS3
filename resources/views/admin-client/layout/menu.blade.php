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
<aside class="main-sidebar sidebar-dark-primary elevation-4" style="background: linear-gradient(to bottom, #1d1c1c, #25872a); border-top-right-radius: 15px;">
  <!-- Brand Logo -->
    <!-- Brand Logo -->
    <a href="{{ asset('admin-client/dasbor') }}" class="brand-link">
      <img src="{{ asset('assets/upload/image/'.website('icon')) }}"
         alt="{{ website('namaweb') }}"
         class="brand-image img-circle elevation-3"
         style="opacity: .8">
      <span class="brand-text font-weight-light">{{ website('nama_singkat') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
    
    <?php
      use Illuminate\Support\Facades\DB;

      $user       = DB::connection('ts3')->table('auth.v_user_client')->where('username',Session()->get('username'))->first();
      $menu        = DB::connection('ts3')->table('auth.v_user_client_product')->where('mst_client_id',$user->mst_client_id)->get();
      
      $product = [];
      foreach ($menu as $val) {
        $product[] = $val->product_name;
      }
      
      ?>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- DASHBOARD -->
          <li class="nav-item">
            <a href="{{ asset('admin-client/dasbor') }}" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>



          @if (in_array("Motor Vehicle Maintenance", $product))
          <li class="batas"><hr> <span class="infoku"><i class="fa fa-certificate"></i> Motor Vehicle Maintenace</span></li>
          <li class="batas"><hr></li>
          <li class="nav-item"><a href="{{ asset('admin-client/spk') }}" class="nav-link"><i class="fa fa-file-contract nav-icon"></i><p>SPK Proses</p></a>

          <li class="nav-item"><a href="{{ asset('admin-client/invoice') }}" class="nav-link"><i class="fa fa-file-invoice nav-icon"></i><p>Invoice</p></a>
          <li class="nav-item">

          
            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-check-square"></i>
                <p>Approval<i class="fas fa-angle-left right"></i></p>
              </a>
                <ul class="nav nav-treeview">               
                <li class="nav-item ml-4"><a href="{{ asset('admin-client/approval') }}" class="nav-link"><i class="fas fa-tools"></i> <p> Service</p></a>
                </li>
                <li class="nav-item ml-4"><a href="{{ asset('admin-client/approval/direct') }}" class="nav-link"><i class="fas fa-location-arrow"></i> <p>Direct</p></a>
                </li>
        
  
                </ul>
            </li>





            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-table"></i>
                <p>Master Data<i class="fas fa-angle-left right"></i></p>
              </a>
                <ul class="nav nav-treeview">               
                <li class="nav-item ml-4"><a href="{{ asset('admin-client/regional') }}" class="nav-link"><i class="fa fa-tags nav-icon"></i><p>Regional</p></a>
                </li>
                <li class="nav-item ml-4"><a href="{{ asset('admin-client/area') }}" class="nav-link"><i class="fa fa-tags nav-icon"></i><p>Area</p></a>
                </li>
                <li class="nav-item ml-4"><a href="{{ asset('admin-client/branch') }}" class="nav-link"><i class="fa fa-tags nav-icon"></i><p>Branch</p></a>
                </li>  
        
  
                </ul>
            </li>

            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-cogs"></i>
                <p>Vehicle<i class="fas fa-angle-left right"></i></p>
              </a>
              <ul class="nav nav-treeview">

            <li class="nav-item ml-4"><a href="{{ asset('admin-client/vehicle') }}" class="nav-link"><i class="fas fa-motorcycle nav-icon"></i><p>Vehicle List</p></a>
            </li>
            <li class="nav-item ml-4"><a href="{{ asset('admin-client/vehicle-type') }}" class="nav-link"><i class="fas fa-tools nav-icon"></i><p>Vehicle Type</p></a>
            </li>

          </ul>
        </li>  


          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="fas fa-paste nav-icon"></i>
              <p>Report<i class="fas fa-angle-left right"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item ml-4"><a href="{{ asset('admin-client/report/history-service') }}" class="nav-link"><i class="fas fa-hands-helping nav-icon"></i></i><p>History Service</p></a>
              </li>
              <li class="nav-item ml-4"><a href="{{ asset('admin-client/report/realisasi-spk') }}" class="nav-link"><i class="fas fa-file-alt nav-icon"></i><p>Realisasi SPK</p></a>
              </li>
              <li class="nav-item ml-4"><a href="{{ asset('admin-client/report/rekap-invoice') }}" class="nav-link"><i class="fas fa-calculator nav-icon"></i><p>Rekap Invoice</p></a>
              </li>
              <li class="nav-item ml-4"><a href="{{ asset('admin-client/report/spk-history') }}" class="nav-link"><i class="fas fa-file-alt nav-icon"></i><p>SPK History</p></a>
              </li>

            </ul>
          </li>              

          @endif


          @if (in_array("Building Maintenance Service", $product))
          <li class="batas"><hr> <span class="infoku"><i class="fa fa-certificate"></i> Building Maintenance Service</span></li>
          <li class="batas"><hr></li>
          @endif

          @if (in_array("Cleaning Service", $product))
          <li class="batas"><hr> <span class="infoku"><i class="fa fa-certificate"></i> Cleaning Service</span></li>
          <li class="batas"><hr></li>
          @endif

          @if (in_array("Security Services", $product))
          <li class="batas"><hr> <span class="infoku"><i class="fa fa-certificate"></i> Security Services</span></li>
          <li class="batas"><hr></li>
          @endif

          @if (in_array("Car Vehicle Maintenace", $product))
          <li class="batas"><hr> <span class="infoku"><i class="fa fa-certificate"></i> Car Vehicle Maintenace</span></li>
          <li class="batas"><hr></li>
          @endif

          @if (in_array("Parking Services", $product))
          <li class="batas"><hr> <span class="infoku"><i class="fa fa-certificate"></i> Parking Services</span></li>
          <li class="batas"><hr></li>
          @endif

          @if (in_array("HR Provider", $product))
          <li class="batas"><hr> <span class="infoku"><i class="fa fa-certificate"></i> HR Provider</span></li>
          <li class="batas"><hr></li>
          @endif
        
       

          
          
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

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
  <aside class="main-sidebar sidebar-dark-primary elevation-4" style="background-color: #03830a; border-top-right-radius: 15px;">
    <!-- Brand Logo -->
    <a href="{{ asset('admin-ts3/dasbor') }}" class="brand-link">
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
            <a href="{{ asset('admin-ts3/dasbor') }}" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          
          <!-- Website Content -->
          <li class="batas"><hr> <span class="infoku"><i class="fa fa-certificate"></i> Navigasi &amp; User</span></li>
          <li class="batas"><hr></li>


          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-cogs"></i>
              <p>Navigasi &amp; User<i class="fas fa-angle-left right"></i></p>
            </a>
            
            <ul class="nav nav-treeview">

              <li class="nav-item ml-4">
                <a href="{{ asset('admin-ts3/user') }}" class="nav-link">
                  <i class="nav-icon fas fa-lock"></i>
                  <p>Pengguna Sistem</p>
                </a>
              </li>

              <li class="nav-item ml-4 has-treeview">
                <a href="#" class="nav-link">
                  <i class="fas fa-hands nav-icon"></i>
                  <p>Client &amp; Product<i class="fas fa-angle-left right"></i></p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item ml-4"><a href="{{ asset('admin-ts3/client') }}" class="nav-link"><i class="fa fa-user-tie nav-icon"></i><p>Client</p></a>
                  </li>
                  <li class="nav-item ml-4"><a href="{{ asset('admin-ts3/product') }}" class="nav-link"><i class="fa fa-handshake nav-icon"></i><p>Product</p></a>
                  </li>
                </ul>
              </li>   
    

              <li class="nav-item ml-4">
                <a href="{{ asset('admin-ts3/heading') }}" class="nav-link">
                  <i class="nav-icon fas fa-image"></i>
                  <p>Header Gambar</p>
                </a>
              </li>

             
              
              <!-- MENU -->
              <li class="nav-item has-treeview ml-4">
                <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-cog"></i>
                  <p>
                    Konfigurasi
                    <i class="fas fa-angle-left right"></i>
                    
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item ml-4"><a href="{{ asset('admin-ts3/konfigurasi') }}" class="nav-link"><i class="fas fa-tools nav-icon"></i><p>Konfigurasi Umum</p></a>
                  </li>
                
                  <li class="nav-item ml-4"><a href="{{ asset('admin-ts3/konfigurasi/logo') }}" class="nav-link"><i class="fa fa-home nav-icon"></i><p>Ganti Logo</p></a>
                  </li>
                  <li class="nav-item ml-4"><a href="{{ asset('admin-ts3/konfigurasi/icon') }}" class="nav-link"><i class="fa fa-upload nav-icon"></i><p>Ganti Icon</p></a>
                  </li>
                  <li class="nav-item ml-4"><a href="{{ asset('admin-ts3/konfigurasi/email') }}" class="nav-link"><i class="fa fa-envelope nav-icon"></i><p>Email Setting</p></a>
                  </li>
                  {{-- <li class="nav-item"><a href="{{ asset('admin-ts3/rekening') }}" class="nav-link"><i class="fas fa-book nav-icon"></i><p>Rekening</p></a>
                  </li> --}}
                </ul>
              </li>
    



            </ul>
          </li>

          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-image"></i>
              <p>Galeri &amp; Banner<i class="fas fa-angle-left right"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item ml-4"><a href="{{ asset('admin-ts3/galeri') }}" class="nav-link"><i class="fas fa-newspaper nav-icon"></i><p>Data Galeri</p></a>
              </li>
              <li class="nav-item ml-4"><a href="{{ asset('admin-ts3/galeri/tambah') }}" class="nav-link"><i class="fa fa-plus nav-icon"></i><p>Tambah Galeri</p></a>
              </li>
              <li class="nav-item ml-4"><a href="{{ asset('admin-ts3/kategori_galeri') }}" class="nav-link"><i class="fa fa-tags nav-icon"></i><p>Kategori Galeri</p></a>
              </li>
            </ul>
          </li>
          
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-newspaper"></i>
              <p>Berita &amp; Update<i class="fas fa-angle-left right"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item ml-4"><a href="{{ asset('admin-ts3/berita') }}" class="nav-link"><i class="fas fa-newspaper nav-icon"></i><p>Data Berita &amp; Update</p></a>
              </li>
              <li class="nav-item ml-4"><a href="{{ asset('admin-ts3/berita/tambah') }}" class="nav-link"><i class="fa fa-plus nav-icon"></i><p>Tambah Berita/Update</p></a>
              </li>
              <li class="nav-item ml-4"><a href="{{ asset('admin-ts3/kategori') }}" class="nav-link"><i class="fa fa-tags nav-icon"></i><p>Kategori berita</p></a>
              </li>
            </ul>
          </li>

          <li class="nav-item">
            <a href="{{ asset('admin-ts3/konfigurasi/profil') }}" class="nav-link">
              <i class="nav-icon fas fa-leaf"></i>
              <p>Update Profil</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ asset('admin-ts3/kontak') }}" class="nav-link">
              <i class="nav-icon fas fa-envelope-square"></i>
              <p>Kontak</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ asset('admin-ts3/berita/jenis_berita/Layanan') }}" class="nav-link">
              <i class="nav-icon fas fa-book"></i>
              <p>Layanan</p>
            </a>
          </li>

          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>Board &amp; Team<i class="fas fa-angle-left right"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item ml-4"><a href="{{ asset('admin-ts3/staff') }}" class="nav-link"><i class="fas fa-newspaper nav-icon"></i><p>Data Board &amp; Team</p></a>
              </li>
              <li class="nav-item ml-4"><a href="{{ asset('admin-ts3/staff/tambah') }}" class="nav-link"><i class="fa fa-plus nav-icon"></i><p>Tambah Board &amp; Team</p></a>
              </li>
              <li class="nav-item ml-4"><a href="{{ asset('admin-ts3/kategori_staff') }}" class="nav-link"><i class="fa fa-tags nav-icon"></i><p>Kategori Board &amp; Team</p></a>
              </li>
            </ul>
          </li>

          <!-- master data -->
          <li class="batas"><hr> <span class="infoku"><i class="fa fa-certificate"></i> Motor Vehicle Maintenace</span></li>
          <li class="batas"><hr></li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-table"></i>
              <p>Master Data<i class="fas fa-angle-left right"></i></p>
            </a>
              <ul class="nav nav-treeview">
              <li class="nav-item ml-4"><a href="{{ asset('admin-ts3/bengkel') }}" class="nav-link"><i class="fas fa-tags nav-icon"></i><p>Bengkel</p></a>
              </li>
              <li class="nav-item ml-4"><a href="{{ asset('admin-ts3/price-service') }}" class="nav-link"><i class="fa fa-tags nav-icon"></i><p>Price Service</p></a>
              </li>
              <li class="nav-item ml-4"><a href="{{ asset('admin-ts3/regional') }}" class="nav-link"><i class="fa fa-tags nav-icon"></i><p>Regional</p></a>
              </li>
              <li class="nav-item ml-4"><a href="{{ asset('admin-ts3/area') }}" class="nav-link"><i class="fa fa-tags nav-icon"></i><p>Area</p></a>
              </li>
              <li class="nav-item ml-4"><a href="{{ asset('admin-ts3/branch') }}" class="nav-link"><i class="fa fa-tags nav-icon"></i><p>Branch</p></a>
              </li>             

              <li class="nav-item ml-4 has-treeview">
                <a href="#" class="nav-link">
                  <i class="fa fa-tags nav-icon"></i>
                  <p>Vehicle<i class="fas fa-angle-left right"></i></p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item ml-4"><a href="{{ asset('admin-ts3/vehicle') }}" class="nav-link"><i class="fa fa-tags nav-icon"></i><p>Vehicle List</p></a>
                  </li>
                  <li class="nav-item ml-4"><a href="{{ asset('admin-ts3/vehicle-type') }}" class="nav-link"><i class="fa fa-tags nav-icon"></i><p>Vehicle Type</p></a>
                  </li>
                </ul>
              </li>              

           

             
              <li class="nav-item ml-4"><a href="{{ asset('admin-ts3/general') }}" class="nav-link"><i class="fa fa-tags nav-icon"></i><p>General</p></a>
              </li>
              </ul>
          </li>
       
           {{-- SPK  --}}
           <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="fas fa-file-signature nav-icon"></i>
              <p>SPK Proses<i class="fas fa-angle-left right"></i></p>
            </a>
            <ul class="nav nav-treeview">
             
              <li class="nav-item ml-4"><a href="{{ asset('admin-ts3/spk-status') }}" class="nav-link"><i class="fas fa-map-signs nav-icon"></i><p>SPK Status</p></a>
              </li>
              <li class="nav-item ml-4"><a href="{{ asset('admin-ts3/spk-list') }}" class="nav-link"><i class="fas fa-list-alt nav-icon"></i><p>SPK List Service</p></a>
              </li>
            </ul>
          </li>        

       

          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="fas fa-file-invoice nav-icon"></i>
              <p>Invoice<i class="fas fa-angle-left right"></i></p>
            </a>
            <ul class="nav nav-treeview">

              <li class="nav-item ml-4"><a href="{{ asset('admin-ts3/invoice') }}" class="nav-link"><i class="fas fa-receipt nav-icon"></i><p>Invoice Bengkel</p></a>
              </li>

              <li class="nav-item ml-4"><a href="{{ asset('admin-ts3/invoice/client') }}" class="nav-link"><i class="fas fa-file-contract nav-icon"></i><p>Invoice Client</p></a>
              </li>

            </ul>
          </li>  






          <li class="nav-item"><a href="{{ asset('admin-ts3/direct-service') }}" class="nav-link"><i class="fas fa-hands nav-icon"></i><p>Direct Service</p></a>
        

        

          {{-- report  --}}
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="fas fa-paste nav-icon"></i>
              <p>Report<i class="fas fa-angle-left right"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item ml-4"><a href="{{ asset('admin-ts3/report/history-service') }}" class="nav-link"><i class="fas fa-history nav-icon"></i><p>History Service</p></a>
              </li>
              <li class="nav-item ml-4"><a href="{{ asset('admin-ts3/report/realisasi-spk') }}" class="nav-link"><i class="fas fa-file-alt nav-icon"></i><p>Realisasi SPK</p></a>
              </li>

              <li class="nav-item ml-4"><a href="{{ asset('admin-ts3/report/rekap-invoice') }}" class="nav-link"><i class="fas fa-calculator nav-icon"></i><p>Rekap Invoice</p></a>
              </li>
              <li class="nav-item ml-4"><a href="{{ asset('admin-ts3/report/spk-history') }}" class="nav-link"><i class="fas fa-file-alt nav-icon"></i><p>SPK History</p></a>
              </li>
              <li class="nav-item ml-4"><a href="{{ asset('admin-ts3/report/summary-bengkel') }}" class="nav-link"><i class="fas fa-warehouse nav-icon"></i><p>Summary Bengkel</p></a>
              </li>

              <li class="nav-item ml-4"><a href="{{ asset('admin-ts3/report/due-date-service') }}" class="nav-link"><i class="far fa-calendar-times nav-icon"></i><p>Service Due Date</p></a>
              </li>

              {{-- <li class="nav-item ml-4"><a href="{{ asset('admin-ts3/report/ar') }}" class="nav-link"><i class="fas fa-industry nav-icon"></i><p>Report AR </p></a>
              </li> --}}
              <li class="nav-item ml-4"><a href="{{ asset('admin-ts3/report/laba-rugi') }}" class="nav-link"><i class="fas fa-chart-line nav-icon"></i><p>Laba Rugi</p></a>
              </li>
            </ul>
          </li>             
    

          <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                <i class="fas fa-search nav-icon"></i>
                  <p>Other Feature<i class="fas fa-angle-left right"></i></p>
                </a>
                <ul class="nav nav-treeview">
                <li class="nav-item ml-4"><a href="{{ asset('admin-ts3/other-feature/vehicle-check') }}" class="nav-link"><i class="fas fa-motorcycle nav-icon"></i> <p> Vehicle Check</p></a>
                  </li>
                  <li class="nav-item ml-4"><a href="{{ asset('admin-ts3/other-feature/gps-check') }}" class="nav-link"><i class="fas fa-map-marked-alt nav-icon"></i> <p> GPS Check</p></a>
                  </li>       
    
                
                </ul>
          </li>    
         
         <br>
         <br>
         <br>

          
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

@include($content)

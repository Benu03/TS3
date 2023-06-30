<?php
use Illuminate\Support\Facades\DB;

$chat                 = DB::connection('ts3')->table('mst.mst_general')->where('name','Live Chat Account')->first();
?>
<body class="hold-transition sidebar-mini layout-fixed pace-primary">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light" >
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>
      
      {{-- <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ asset('panduan') }}" target="_blank" class="nav-link"><i class="fa fa-file-pdf"></i> Panduan</a>
      </li> --}}
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ asset('/') }}" target="_blank" class="nav-link"><i class="fa fa-home"></i> Beranda</a>
      </li>

      <li class="nav-item d-none d-sm-inline-block ml-2">
        <a href="https://app.crisp.chat/" target="_blank" data-html="true" class="nav-link tooltip-lg"  style="color:rgb(251, 136, 4)" data-toggle="tooltip" title="Username : {{$chat->value_1}}<br>Password : {{$chat->value_2}}" ><i class="fas fa-comments"></i> Live Chat</a>
       </li>
    </ul>
   
    

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Notifications Dropdown Menu -->
   
      <li class="nav-item">
        <a class="nav-link text-info" href="{{ asset('admin-ts3/profile') }}">
          <i class="fas fa-bell"></i> 
        </a> 
      </li>


      <li class="nav-item ml-2">
        <a class="nav-link text-success" href="{{ asset('admin-ts3/profile') }}">
          <i class="fa fa-lock"></i> <?php echo Session()->get('nama'); ?>
        </a>
      </li>

      <!-- Notifications Dropdown Menu -->
      <li class="nav-item ml-2">
        <a class="nav-link text-danger" href="{{ asset('login/logout') }}">
          <i class="fas fa-sign-out-alt"></i> KELUAR
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->
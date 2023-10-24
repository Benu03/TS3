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
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Notifications Dropdown Menu -->
      <?php
      use Illuminate\Support\Facades\DB;   
      
      $username = Session()->get('username');
      $notif          = DB::connection('ts3')->table('ntf.v_notif_list')
                        ->where(function ($query) use ($username) {
                              $query->where('username', $username)
                                  ->orWhereNull('username');
                          })
                         ->orderBy('created_date', 'desc')
                         ->limit(10)
                        ->get();
      $count_notif     = DB::connection('ts3')->table('ntf.v_notif_list')
                          ->where(function ($query) use ($username) {
                              $query->where('username', $username)
                                  ->orWhereNull('username');
                          })
                          ->WhereNull('is_read')
                          ->count();                  
      ?>

    <li class="nav-item dropdown">
      <a class="nav-link text-info" data-toggle="dropdown" href="#" aria-expanded="true" >
       <i class="fas fa-bell mr-3"></i> 
       @if ($count_notif > 0)
       <span class="badge navbar-badge">{{ $count_notif }}</span>
        @endif
      </a> 

      <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right text-primary" style="left: inherit; right: 0px;">
        <span class="dropdown-item dropdown-header">Notifications</span>
        <div class="dropdown-divider"></div>

        @foreach($notif as $notification)
        <a href="{{ asset('pic-regional/notification') }}" class="dropdown-item @if(!$notification->is_read) text-info @endif">
            <i class="fas fa-envelope mr-2"></i> {{ $notification->title }}
        </a>
        @endforeach


        <div class="dropdown-divider"></div>
        <a href="{{ asset('pic-regional/notification') }}" class="dropdown-item dropdown-footer">Lihat Semua Notifications</a>
        </div>
      
    </li>


      <li class="nav-item">
        <a class="nav-link text-success" href="{{ asset('pic-regional/profile') }}">
          <i class="fa fa-lock"></i> <?php echo Session()->get('nama'); ?>
        </a>
      </li>

      <!-- Notifications Dropdown Menu -->
      <li class="nav-item">
        <a class="nav-link text-danger" href="{{ asset('login/logout') }}">
          <i class="fas fa-sign-out-alt"></i> KELUAR
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->
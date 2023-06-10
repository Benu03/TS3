<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet" />

    <link rel="stylesheet" href="{{ asset('assets/auth/fonts/icomoon/style.css') }}" />

    <link rel="stylesheet" href="{{ asset('assets/auth/css/owl.carousel.min.css') }}" />

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('assets/auth/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/admin/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Style -->
    <link rel="stylesheet" href="{{ asset('assets/auth/css/style.css') }}" />

    <title>{{ $title }}</title>
    <link rel="shortcut icon" href="{{ asset('assets/upload/image/'.website('icon')) }}">
    <script src="{{ asset('assets/sweetalert/js/sweetalert.min.js') }}"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/sweetalert/css/sweetalert.css') }}">
</head>


<body>
    <div class="content">
        <div class="container">
            <div class="row">
               
                

                <div class="col-md-5 mb-4">
                    <div class="mb-4 text-center">
                        <img src="{{ asset('assets/upload/image/'.website('logo')) }}" alt="Image" class="img-fluid" width="70" height="70" />
                        <span class="d-block text-left text-center text-white">Hii {{ $username }}</span>
                        <span class="d-block text-left text-center text-white">Mohon Untuk Melengkapi Data Akun Anda</span>
                    </div>

             
                  <a href="{{ '/' }}">
                    <img src="{{ asset('assets/auth/images/6.svg')}}" alt="Image" class="img-fluid" />
                  </a>
                
                </div>


                <div class="col-md-7 contents">
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                          
                            @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                            <form action="{{ asset('login/login-konfirmasi-process') }}" method="post" accept-charset="utf-8">
                            {{ csrf_field() }}

                            <input type="hidden" name="username" value="{{ $username }}">
                           

                                <div class="form-group first">
                                    <label for="email">Email</label>
                                    <input type="text" class="form-control" id="email" name="email"  required />
                                </div>

                                <div class="form-group">
                                    <label for="email">Phone No</label>
                                    <input type="text" class="form-control" id="phone" name="phone"  required />
                                </div>

                                <div class="form-group">
                                    <label for="email">WhastApp No</label>
                                    <input type="text" class="form-control" id="wa_number" name="wa_number"  required />
                                </div>


                                <div class="form-group">
                                    <label for="password">Masukan Password</label>
                                    <input type="password" class="form-control" id="password1" name="password1"  autocomplete="off" required />
                                </div>

                                <div class="form-group last mb-4">
                                    <label for="password">Verifikasi Password</label>
                                    <input type="password" class="form-control" id="password2" name="password2"  autocomplete="off" required />
                                </div>

                                {{-- <div class="form-group last mb-4">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" required />
                                </div> --}}

                                <div class="d-flex mb-2 align-items-center">
                                    <label class="control control--checkbox mb-0">


                                        <span class="caption">Show Password</span>
                                        <input type="checkbox" onclick="showpassword()" />
                                        <div class="control__indicator"></div>


                                    </label>
                           
                                </div>
                                <button type="submit" class="btn btn-light btn-block"><i class="fas fa-check-circle" style="color: #32af81;"></i> Konfirmasi</button>

                                {{-- <span class="ml-auto"><a href="javascript:void(0)" onclick="location.href='{{ '/login' }}'" class="forgot-pass">Back to Login</a></span>
                                <input type="submit" value="Log In" class="btn btn-block btn-light" /> --}}

                                <span class="d-block text-left my-4 text-center text-white">Copyright &copy;<?= date('Y'); ?> {{ website('namaweb') }} Indonesia</span>
                            

                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- <div class="card card-footer text-center">s
            <strong class="text-center">
                Copyright &copy;<?= date('Y'); ?> PT TS3 Indonesia
            </strong>
    </div> -->
    <script src="{{ asset('assets/auth/js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('assets/auth/js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/auth/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/auth/js/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('assets/auth/js/main.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('assets/admin/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('assets/admin/dist/js/adminlte.min.js') }}"></script>
    <script>
        function showpassword() {
            var x = document.getElementById("password1");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }

            var y = document.getElementById("password2");
            if (y.type === "password") {
                y.type = "text";
            } else {
                y.type = "password";
            }
        }
    </script>
    <script>
    @if ($message = Session::get('warning'))
    // Notifikasi
    swal ( "Mohon maaf" ,  "<?php echo $message ?>" ,  "warning" )
    @endif

    @if ($message = Session::get('sukses'))
    // Notifikasi
    swal ( "Berhasil" ,  "<?php echo $message ?>" ,  "success" )
    @endif
    </script>
</body>


</html>
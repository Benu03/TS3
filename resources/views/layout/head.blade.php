<?php 
$site_config = DB::connection('ts3')->table('cp.konfigurasi')->first();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>{{ $title }}</title>
<meta name="description" content="{{ $deskripsi }}">
<meta name="keywords" content="{{ $keywords }}">
<meta name="author" content="{{ $site_config->namaweb }}">
<!-- icon -->
<link rel="shortcut icon" href="{{ asset('assets/upload/image/'.$site_config->icon) }}">
<!-- Font Awesome -->
<link rel="stylesheet" href="{{ asset('assets/admin/plugins/fontawesome-free/css/all.min.css') }}">
<!-- CSS FILES START -->
<link href="{{ asset('assets/aws/css/custom.css') }}" rel="stylesheet">
<link href="{{ asset('assets/aws/css/color.css') }}" rel="stylesheet">
<link href="{{ asset('assets/aws/css/responsive.css') }}" rel="stylesheet">
<link href="{{ asset('assets/aws/css/owl.carousel.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/aws/css/bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/aws/css/prettyPhoto.css') }}" rel="stylesheet">
<link href="{{ asset('assets/aws/css/all.min.css') }}" rel="stylesheet">
<style>
.img-loader{
  text-align: center;
  width: 500px;
  height: 500px;
  display: block;
  position:absolute;
  left:0;
  right:0;
  top:0;
  bottom:0;
  margin:auto;
  opacity: 0.2;
}

.wrapper{
  margin: 0 auto;
  width: 100%;
  height: 100%;
  /* background: rgba(0, 135, 0, 0.1); */
  position: absolute;
  top: 0;

}
</style>
<?php echo $site_config->metatext ?>
</head>

<body>
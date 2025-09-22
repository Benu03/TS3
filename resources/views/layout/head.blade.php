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
{{-- <script src="{{ asset('assets/sweetalert/js/sweetalert.min.js') }}"></script> --}}
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<!-- angular -->
{{-- <script src="{{ asset('assets/angular/angular.min.js') }}"></script>   --}}
<link rel="stylesheet" type="text/css" href="{{ asset('assets/sweetalert/css/sweetalert.css') }}">
<link href="{{ asset('assets/aws/css/custom.css') }}" rel="stylesheet">
<link href="{{ asset('assets/aws/css/color.css') }}" rel="stylesheet">
<link href="{{ asset('assets/aws/css/responsive.css') }}" rel="stylesheet">
<link href="{{ asset('assets/aws/css/owl.carousel.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/aws/css/bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/aws/css/prettyPhoto.css') }}" rel="stylesheet">
<link href="{{ asset('assets/aws/css/all.min.css') }}" rel="stylesheet">
<script type="text/javascript">window.$crisp=[];window.CRISP_WEBSITE_ID="c71a3709-3d11-44de-9713-ff377233acd3";(function(){d=document;s=d.createElement("script");s.src="https://client.crisp.chat/l.js";s.async=1;d.getElementsByTagName("head")[0].appendChild(s);})();</script>
<style>
.img-logots3{
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

.wrapper33{
  margin: 0 auto;
  width: 100%;
  height: 100%;
  /* background: rgba(0, 135, 0, 0.1); */
  position: absolute;
  top: 0;

}
.custom-margin-berita {
    margin-right: 90px;
}

</style>


<?php echo $site_config->metatext ?>
</head>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />


<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.5.1/dist/MarkerCluster.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.5.1/dist/MarkerCluster.Default.css" />

<!-- Leaflet MarkerCluster JS -->
<script src="https://unpkg.com/leaflet.markercluster@1.5.1/dist/leaflet.markercluster.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">

<body>
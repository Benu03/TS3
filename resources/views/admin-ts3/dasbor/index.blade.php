
<!-- Info boxes -->
<div class="row">
  <div class="col-12 col-sm-6 col-md-3">
    <a href="{{ asset('admin-ts3/berita') }}">
    <div class="info-box">
      <span class="info-box-icon bg-info elevation-1"><i class="fas fa-newspaper"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Berita &amp; Update</span>
        <span class="info-box-number">
         
          {{ $berita }}
          
        </span>
      </div>
      <!-- /.info-box-content -->
    </div>
   </a>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->
  <div class="col-12 col-sm-6 col-md-3">
    <a href="{{ asset('admin-ts3/product') }}">
    <div class="info-box mb-3">
      <span class="info-box-icon bg-secondary elevation-1"><i class="fas fa-book"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">
          Layanan
        </span>
        <span class="info-box-number">
          {{ $product }}
        
        </span>
      </div>
      <!-- /.info-box-content -->
    </div>
   </a>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->


  <div class="col-12 col-sm-6 col-md-3">
    <a href="{{ asset('admin-ts3/galeri') }}">
    <div class="info-box mb-3">
      <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-image"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Galeri</span>
        <span class="info-box-number">
          {{ $galeri }}
        </span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
    </a>
  </div>
  <!-- /.col -->
  <div class="col-12 col-sm-6 col-md-3">
    <a href="{{ asset('admin-ts3/staff') }}">
    <div class="info-box mb-3">
      <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-users"></i></span>
  
      <div class="info-box-content">
        <span class="info-box-text">
          Board dan Team
        </span>
        <span class="info-box-number">
          {{ $staff }}
        
        </span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
    </a>
  </div>
  
</div>
<!-- /.row -->

<div class="row">
 <div class="col-sm-6"> 
            <div id="mvm-rating-chart"></div>
 
 </div>
  
  <div class="col-sm-6">

      <div id="mvm-count-client-chart"></div>
  </div>


</div>


<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script>
  $(function() {
      Highcharts.chart('mvm-count-client-chart', {
          chart: {
              plotBackgroundColor: null,
              plotBorderWidth: null,
              plotShadow: false,
              type: 'column'
          },
          title: {
              text: 'Jumlah Vehicle MVM Client '
          },
          subtitle: {
                text: ''
            },
            xAxis: {
                categories: ['Client']
            },
            yAxis: {
                title: {
                    text: 'Vehicle'
                }
            },
            plotOptions: {
                line: {
                    dataLabels: {
                        enabled: true
                    },
                    enableMouseTracking: false
                }
            },
            series: [{
              name: 'Vehicle Motor',
              colorByPoint: true,
              data: <?= $dataPointsmotor ?>
            }]
      });
  });


</script>

<script>
  $(function() {
      Highcharts.chart('mvm-rating-chart', {
          chart: {
              plotBackgroundColor: null,
              plotBorderWidth: null,
              plotShadow: false,
              type: 'pie'
          },
          title: {
              text: 'Rating Motor Vehicle Maintenance '
          },
          tooltip: {
              pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
          },
          accessibility: {
              point: {
                  valueSuffix: '%'
              }
          },
          plotOptions: {
              pie: {
                  allowPointSelect: true,
                  cursor: 'pointer',
                  dataLabels: {
                      enabled: true,
                      format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                  }
              }
          },
          series: [{
              name: 'Rating',
              colorByPoint: true,
              data: <?= $dataPointsrating ?>
          }]
      });
  });


</script>
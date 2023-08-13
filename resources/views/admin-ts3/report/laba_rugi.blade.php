@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
{{-- <p>
  @include('admin-client/spk/tambah_upload')
</p> --}}
<form action="{{ asset('admin-client/report/proses') }}" method="post" accept-charset="utf-8">
{{ csrf_field() }}

<div class="row">
        <div class="col-sm-3">
           
                <div class="input-group-prepend">
                    <span class="input-group-text">
                    Month <i class="far fa-calendar-alt ml-2"></i>
                    </span>
                    <select name="month" id="month">
                        <option value="1" <?php if(date("n") == 1) echo 'selected'; ?>>January</option>
                        <option value="2" <?php if(date("n") == 2) echo 'selected'; ?>>February</option>
                        <option value="3" <?php if(date("n") == 3) echo 'selected'; ?>>March</option>
                        <option value="4" <?php if(date("n") == 4) echo 'selected'; ?>>April</option>
                        <option value="5" <?php if(date("n") == 5) echo 'selected'; ?>>May</option>
                        <option value="6" <?php if(date("n") == 6) echo 'selected'; ?>>June</option>
                        <option value="7" <?php if(date("n") == 7) echo 'selected'; ?>>July</option>
                        <option value="8" <?php if(date("n") == 8) echo 'selected'; ?>>August</option>
                        <option value="9" <?php if(date("n") == 9) echo 'selected'; ?>>September</option>
                        <option value="10" <?php if(date("n") == 10) echo 'selected'; ?>>October</option>
                        <option value="11" <?php if(date("n") == 11) echo 'selected'; ?>>November</option>
                        <option value="12" <?php if(date("n") == 12) echo 'selected'; ?>>December</option>
                    </select>
                    
                </div>
       
        </div>

        <div class="col-sm-2">
           
            <div class="input-group-prepend">
                <span class="input-group-text">
                Year <i class="far fa-calendar-alt ml-2"></i>
                </span>
                <select id="yearSelect">
                    <?php
                    $currentYear = date("Y");
                    $startYear = $currentYear - 2;
                    $endYear = $currentYear + 2;
                    
                    for ($year = $startYear; $year <= $endYear; $year++) {
                        echo '<option value="' . $year . '"';
                        
                        if ($year == $currentYear) {
                            echo ' selected';
                        }
                        
                        echo '>' . $year . '</option>';
                    }
                    ?>
                </select>
            </div>
   
        </div>
       


        <div class="col-sm-6">
            <div class="form-group pull-right btn-group">
                <button type="button" name="filter" id="filter" class="btn btn-primary" value="Filter Data">
                    <i class="fas fa-filter"></i> Filter Data
                </button>
                <button type="button" name="refresh"  id="refresh" class="btn btn-warning " value="Refresh">
                    <i class="fas fa-sync-alt"></i> Refresh
                </button>

            </div>
        </div>
    
</div>

<div class="clearfix"><hr></div>

<div class="row">
  
        <div class="col-md-12"> 
                   <div id="mvm-laba_rugi-chart"></div>
        
        </div>
         
       
       
       
</div>   




</form>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script>
   $(function() {
    Highcharts.chart('mvm-laba_rugi-chart', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Report Laba Rugi',
            align: 'left'
        },
        xAxis: {
            categories: [<?php foreach ($dataPointslaba_rugi as $item) { ?>
                '<?= $item['spk_no'] ?>',
            <?php } ?>],
            crosshair: true,
            accessibility: {
                description: 'SPK'
            }
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Total Invoice (Rp)'
            },
            labels: {
                formatter: function() {
                    return Highcharts.numberFormat(this.value, 0, ',', '.') + ' Rp';
                }
            }
        },
        tooltip: {
            valuePrefix: 'Rp',
            valueDecimals: 0,
            valueThousandsSeparator: ','
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: [
            {
                name: 'BENGKEL TO TS3',
                data: [<?php foreach ($dataPointslaba_rugi as $item) {
                    echo isset($item["total1"]) ? $item["total1"] . ", " : "0, ";
                } ?>]
            },
            {
                name: 'TS3 TO CLIENT',
                data: [<?php foreach ($dataPointslaba_rugi as $item) {
                    echo isset($item["total2"]) ? $item["total2"] . ", " : "0, ";
                } ?>]
            }
        ]
    });
});

  </script>
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

        <div class="col-sm-4">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">
                    Period <i class="far fa-calendar-alt ml-2"></i>
                    </span>
                </div>
                <input type="text" name="month_spk" id="month_spk" class="form-control monthPicker"  value="">	
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
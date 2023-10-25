
<!-- Info boxes -->
<div class="row">
  <div class="col-12 col-sm-6 col-md-3">
    <a href="{{ asset('pic-regional/vehicle-schedule-service') }}">
    <div class="info-box mb-3">
      <span class="info-box-icon bg-success elevation-1"><i class="fas fa-motorcycle"></i></span>
  
      <div class="info-box-content">
        <span class="info-box-text">
          Vehicle Schedule Service
        </span>
        <span class="info-box-number">
          {{ $vehiclecount }}
          {{-- <small>Orang</small> --}}
        </span>
      </div>
      <!-- /.info-box-content -->
    </div>
  </a>
    <!-- /.info-box -->
  </div>


  
</div>
<!-- /.row -->
<div class="row">
  <div class="col-sm-12">
    <div class="clearfix"><hr></div>
  
  
    <div class="card">
      <div class="card-header bg-info">
        List Motor Due Date Service
      </div>
      <div class="card-body">

        <div class="table-responsive mailbox-messages">
          <div class="table-responsive mailbox-messages">
      <table id="dataTable" class="display table table-bordered" cellspacing="0" width="100%">
      <thead>
          <tr class="bg-info">
        
      
              <th width="8%">Nopol</th>
              <th width="10%">No Rangka</th>
              <th width="10%">No Mesin</th>
              <th width="15%">Type</th>
              <th width="6%">Last KM</th>
              <th width="8%">Last Service</th>
              <th width="10%">Cabang</th>
              <th width="10%">Action</th>

      </tr>
      </thead>
    
      </table>
      </div>

</div>



      </div>
    </div>
 

           
  </div>

</div>







<script type="text/javascript">
  $(document).ready(function() { 
      fetch_data()
      function fetch_data(){                    
              $('#dataTable').DataTable({
                  pageLength: 10,
                  lengthChange: true,
                  bFilter: true,
                  destroy: true,
                  processing: true,
                  serverSide: true,
                  oLanguage: {
                      sZeroRecords: "Tidak Ada Data",
                      sSearch: "Pencarian _INPUT_",
                      sLengthMenu: "_MENU_",
                      sInfo: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                      sInfoEmpty: "0 data",
                      oPaginate: {
                          sNext: "<i class='fa fa-angle-right'></i>",
                          sPrevious: "<i class='fa fa-angle-left'></i>"
                      }
                  },
                  ajax: {
                      url:"{{  asset('pic-regional/get-service-due-date') }}",
                      type: "GET"
                           
                  },
                  columns: [

                      {
                          name: 'nopol',
                          data: 'nopol'
                      },
                      {
                          name: 'norangka',
                          data: 'norangka'
                      },
                      {
                          name: 'nomesin',
                          data: 'nomesin'
                      },
                      {
                          name: 'type',
                          data: 'type'
                      },
                      {
                          name: 'last_km',
                          data: 'last_km'
                      },
                      {
                          name: 'tgl_last_service',
                          data: 'tgl_last_service'
                      },
                      {
                          name: 'branch',
                          data: 'branch'
                      },
                      {
                          data: 'action', 
                          name: 'action', 
                          className: "text-center",
                          orderable: false, 
                          searchable: false
                         
                      },
                  ]
              });
          }         
  });
  </script>
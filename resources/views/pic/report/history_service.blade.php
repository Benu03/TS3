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
<div class="row">


    {{-- <div class="btn-group">
      {{-- <button class="btn btn-danger" type="submit" name="hapus" onClick="check();" >
          <i class="fa fa-trash"></i>
      </button>  --}}
        {{-- <button type="button" class="btn btn-success " data-toggle="modal" data-target="#Tambah">
            <i class="fa fa-plus"></i> Tambah SPK Baru
        </button>
   </div>  --}}
   <div class="col-md-12">
        {{-- <div class="form-group">
            <label>Date range:</label>
            <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text">
                 <i class="far fa-calendar-alt"></i>
                </span>
            </div>
            <input type="text" class="form-control float-right" id="reservation">
            </div> --}}
            
        
            <div class="form-group row">
				
                <div class="col-sm-2">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                             From <i class="far fa-calendar-alt ml-2"></i>
                            </span>
                        </div>
                        <input type="text" name="from_date" id="from_date" class="form-control tanggal" placeholder="From Date" value="" data-date-format="yyyy-mm-dd">	
                        </div> 
                </div>
                <div class="col-sm-2">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                             To <i class="far fa-calendar-alt ml-2"></i>
                            </span>
                        </div>
                        <input type="text" name="to_date"  id="to_date" class="form-control tanggal" placeholder="To Date" value="" data-date-format="yyyy-mm-dd">	
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
                <div class="clearfix"></div>
            </div>

               
    {{-- </div>        --}}
</div> 

</div>

<div class="clearfix"><hr></div>
<div class="table-responsive mailbox-messages">
    <div class="table-responsive mailbox-messages">
<table id="dataTable" class="display table table-bordered" cellspacing="0" width="100%">
<thead>
    <tr class="bg-info">
        {{-- <th width="5%">
          <div class="mailbox-controls">
                <!-- Check all button -->
               <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="far fa-square"></i>
                </button>
            </div>
        </th> --}}
        <th width="17%">Service No</th>
        <th width="7%">Nopol</th>   
        <th width="7%">Status</th> 
        <th width="10%">Tanggal Service</th> 
        <th width="7%">Last KM</th> 
        <th width="12%">Nama Driver</th>    
        <th width="12%">Bengkel</th>    
        <th width="12%">Mekanik</th>    
        <th width="5%">Action</th>    
</tr>
</thead>

</table>
</div>
</div>
</form>

<script>
    $('#reservation').daterangepicker()
</script>



<script type="text/javascript">
    $(document).ready(function() { 
        fetch_data()
        function fetch_data(from_date = '', to_date = ''){                    
                $('#dataTable').DataTable({
                    pageLength: 10,
                    lengthChange: true,
                    bFilter: true,
                    destroy: true,
                    processing: true,
                    serverSide: true,
                    order: [[3, 'desc']],
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
                        headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                        url:"{{  asset('pic/get-history-service') }}",
                        type: "POST",
                        data: function (d) {
                        d.from_date = from_date;
                        d.to_date = to_date;
                        }
                             
                    },
                    columns: [
                        { 
                            data: 'service_no', 
                            name: 'service_no', 
        
                        },
                        {
                            name: 'nopol',
                            data: 'nopol'
                        },
                        {
                            name: 'status_service',
                            data: 'status_service'
                        },
                        {
                            name: 'tanggal_service',
                            data: 'tanggal_service'
                        },
                        {
                            name: 'last_km',
                            data: 'last_km'
                        },
                        {
                            name: 'nama_driver',
                            data: 'nama_driver'
                        },
                        {
                            name: 'bengkel_name',
                            data: 'bengkel_name'
                        },
                        {
                            name: 'mekanik',
                            data: 'mekanik'
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
            
            $('#filter').click(function(){
            var from_date = $('#from_date').val();
            var to_date = $('#to_date').val();

            if(from_date != '' &&  to_date != ''){
                $('#dataTable').DataTable().destroy();
                fetch_data(from_date, to_date);
            } else{
                alert('Both Date is required');
            }

        });

        $('#refresh').click(function(){
            $('#from_date').val('');
            $('#to_date').val('');
            $('#dataTable').DataTable().destroy();
            fetch_data();
        });
    });
    </script>
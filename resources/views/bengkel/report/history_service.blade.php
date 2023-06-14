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
<form action="{{ asset('admin-ts3/report/proses') }}" method="post" accept-charset="utf-8">
{{ csrf_field() }}
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
					<label class="col-sm-2 control-label text-left">Tanggal Transaksi</label>
					<div class="col-sm-3">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                 <i class="far fa-calendar-alt"></i>
                                </span>
                            </div>
                            <input type="text" class="form-control float-right" id="reservation">
                            </div> 
					</div>
                    <div class="col-sm-6">
						<div class="form-group pull-right btn-group">
							<input type="submit" name="submit" class="btn btn-primary " value="Filter Data">
							<input type="reset" name="reset" class="btn btn-success " value="Reset">
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
                        url:"{{  asset('bengkel/get-history-service') }}",
                        type: "GET"
                             
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
    });
    </script>
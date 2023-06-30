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
					<label class="col-sm-2 control-label text-left">Tanggal Invoice</label>
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
<table id="dataTable" class="display table table-bordered" cellspacing="0" width="100%" style="font-size: 12px;">
<thead>
    <tr class="bg-info">
        {{-- <th width="5%">
          <div class="mailbox-controls">
                <!-- Check all button -->
               <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="far fa-square"></i>
                </button>
            </div>
        </th> --}}
        <th width="9%">Invoice No</th>
        <th width="9%">Type</th>   
        <th width="7%">Status</th> 
        <th width="8%">Invoice Date</th> 
        <th width="7%">Created Invoice</th> 
        <th width="10%">REGIONAL</th> 
        <th width="7%">CLIENT</th> 
        <th width="7%">PPH</th>    
        <th width="7%">PPN</th>    
        <th width="12%">TOTAl JASA</th> 
        <th width="12%">TOTAl PART</th>       
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
                        url:"{{  asset('admin-ts3/get-rekap-invoice') }}",
                        type: "GET"
                             
                    },
                    columns: [
                        { 
                            data: 'invoice_no', 
                            name: 'invoice_no', 
        
                        },
                        {
                            name: 'invoice_type',
                            data: 'invoice_type'
                        },
                        {
                            name: 'status',
                            data: 'status'
                        },
                        {
                            name: 'created_date',
                            data: 'created_date'
                        },
                        {
                            name: 'create_by',
                            data: 'create_by'
                        },
                        {
                            name: 'regional',
                            data: 'regional'
                        },
                        {
                            name: 'client_name',
                            data: 'client_name'
                        },
                        {
                            name: 'pph',
                            data: 'pph',
                            render: function(data, type, full, meta) {
                            var formattedAmount = formatRupiah(data);
                            return formattedAmount;
                            }
                        },
                        {
                            name: 'ppn',
                            data: 'ppn',
                            render: function(data, type, full, meta) {
                            var formattedAmount = formatRupiah(data);
                            return formattedAmount;
                            }
                        },
                        {
                            name: 'jasa_total',
                            data: 'jasa_total',
                            render: function(data, type, full, meta) {
                            var formattedAmount = formatRupiah(data);
                            return formattedAmount;
                            }
                        },
                        {
                            name: 'part_total',
                            data: 'part_total',
                            render: function(data, type, full, meta) {
                            var formattedAmount = formatRupiah(data);
                            return formattedAmount;
                            }
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

    function formatRupiah(amount) {
    var formatter = new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0, 
        maximumFractionDigits: 0
    });
    var formattedAmount = formatter.format(amount);
    var decimalRemoved = formattedAmount.replace(/\.00(?=\D|$)/, '');
    return decimalRemoved;
    }   
    </script>
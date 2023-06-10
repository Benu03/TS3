@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<p>
  @include('admin-ts3/user/tambah')
</p>
<form action="{{ asset('admin-ts3/user/proses') }}" method="post" accept-charset="utf-8">
{{ csrf_field() }}
<div class="row">

  <div class="col-md-12">
    <div class="btn-group">
      <button class="btn btn-danger" type="submit" name="hapus" onClick="check();" >
          <i class="fa fa-trash"></i>
      </button> 
        <button type="button" class="btn btn-success " data-toggle="modal" data-target="#Tambah">
            <i class="fa fa-plus"></i> Tambah Baru
        </button>
   </div>
</div>
</div>

<div class="clearfix"><hr></div>
<div class="table-responsive mailbox-messages">
    <div class="table-responsive mailbox-messages">
        <table id="dataTable" class="display table table-bordered" cellspacing="0" width="100%">
<thead>
    <tr class="bg-info">
        <th width="5%">
          <div class="mailbox-controls">
                <!-- Check all button -->
               <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="far fa-square"></i>
                </button>
            </div>
        </th>
        <th width="7%">GAMBAR</th>
        <th width="20%">NAMA</th>
        <th width="20%">USERNAME</th>
        <th width="10%">ROLE</th>
        <th width="10%">ENTITY</th>  
        <th width="10%">CONTACT</th>       
        <th>ACTION</th>
</tr>
</thead>

</table>
</div>
</div>
</form>


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
                        url:"{{ asset('admin-ts3/get-user-list') }}",
                        type: "GET"
                             
                    },
                    columns: [
                        { 
                            data: 'check', 
                            name: 'check', 
                            className: "text-center",
                            orderable: false, 
                            searchable: false
                        },
                        { name: 'gambaruser', data: 'gambaruser' },
                        { name: 'nama', data: 'nama' },
                        { name: 'username', data: 'username' },
                        { name: 'role_title', data: 'role_title' },
                        { name: 'entity', data: 'entity' },
                        { name: 'contact', data: 'contact',  className: "text-center" },
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

    $('#div_customer').hide();
  $('document').ready(function () {
                       $("#role").change(function () {
                       var data = $(this).val();
                       if (data == "3" || data == "5" ) {
                       $('#div_customer').show();
                       } 
                       else {
                       $('#div_customer').hide();
                       }
                       });
                       });
    </script>



<script>
    $(document).ready(function() {
       var role_type = document.getElementById("role");
       console.log(role_type);
           if(role_type.value != '2')
           {
               document.getElementById("customer").show();
           }
            else {
               document.getElementById("customer").hide();
           } 
       
       }); 
   
       
   </script>
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ asset('admin-client/spk/proses') }}" method="post" accept-charset="utf-8">
{{ csrf_field() }}
<div class="row">

  <div class="col-md-8">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th  colspan="4" width="25%">SPK Nomor : {{  $spk->spk_no }}</th>    
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th>Jumlah Kendaraan</th>
                    <td>{{ $spk->count_vehicle }}</td>
                    <th>Status</th>
                    <td>{{ $spk->status }}</td>
                </tr>

                <tr>
                    <th>Tanggal Pengerjaan</th>
                    <td>{{ $spk->tanggal_pengerjaan }}</td>
                    <th>User Upload</th>
                    <td>{{ $spk->user_upload }}</td>
                </tr>

                <tr>
                    <th>Tanggal Berlaku SPK Terakhir</th>
                    <td>{{ $spk->tanggal_last_spk }}</td>
                    <th>Tanggal Upload</th>
                    <td>{{ $spk->upload_date }}</td>
                </tr>

            
            
            </tbody>
        </table>


    </div>

    <div class="col-md-4 mb-2">
        <div class="card card-success">
            <div class="card-header">
                Action
              </div>
            <div class="card-body">
                <div class="row text-center">
                  <div class="col-md-12 text-center">
                  <div class="form-group pull-right btn-group ">
                    <a href="{{ asset('admin-client/spk-posting/'.$spk->spk_seq) }}" 
                      class="btn btn-warning btn-md"><i class="fas fa-upload"></i> Posting Data</a>
                      <a href="{{ asset('admin-client/spk-synchron/'.$spk->spk_seq) }}" 
                        class="btn btn-secondary btn-md"><i class="fas fa-sync-alt"></i> Synchron Vehicle</a>
                        <a href="{{ asset('admin-client/spk-reset/'.$spk->spk_seq) }}" 
                          class="btn btn-danger btn-md reset-link"><i class="fas fa-trash-alt"></i> Reset Data</a>
                  </div>

                </div>
                  </div>
            </div>
          </div>

   
    </div>

</div>

<div class="clearfix"><hr></div>
<div class="table-responsive mailbox-messages">
    <div class="table-responsive mailbox-messages">

  <table id="dataTable" class="display table table-bordered" cellspacing="0" width="100%">
<thead>
    <tr class="bg-info">
       
        <th width="10%">NOPOL</th>
        <th width="10%">NOMESIN</th>   
        <th width="15%">NORANGKA</th>  
        <th width="12%">TAHUN_BEMBUATAN</th>  
        <th width="17%">TYPE</th>  
        <th width="17%">NAMA_CABANG</th>   
        <th width="10%">INFO</th>  
      
</tr>
</thead>
</table>
</div>
</div>
</form>


<script type="text/javascript">
 $(document).ready(function() {
    fetch_data();

    function fetch_data() {
        $('#dataTable').DataTable({
            pageLength: 10,
            lengthChange: true,
            bFilter: true,
            destroy: true,
            processing: true,
            serverSide: true,
            order: [[7, 'desc']], // Mengurutkan berdasarkan kolom 'invalid_data'
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
                url: "{{ url('admin-client/get-temp-spk') }}",
                type: "POST",
                data: function (d) {
                    d.spk_seq = '{{ $spk->spk_seq }}'; // Pastikan $spk->spk_seq terdefinisi di blade template Anda
                }
            },
            columns: [
                { name: 'nopol', data: 'nopol' },
                { name: 'nomesin', data: 'nomesin' },
                { name: 'norangka', data: 'norangka' },
                { name: 'tahun_pembuatan', data: 'tahun_pembuatan' },
                { name: 'type', data: 'type' },
                { name: 'nama_cabang', data: 'branch' },
                { name: 'info', data: 'info', orderable: false, searchable: false },
                { name: 'invalid_data', data: 'invalid_data', visible: false, searchable: false } // Kolom untuk mengurutkan data
            ]
        });
    }
});


  </script>

<script>
    function isNumber(evt) {
     evt = (evt) ? evt : window.event;
     var charCode = (evt.which) ? evt.which : evt.keyCode;
     if (charCode > 31 && (charCode < 48 || charCode > 57)) {
         return false;
     }
     return true;
  }
  </script>

<script>

// Popup Posting
$(document).on("click", ".posting-link", function(e){
  e.preventDefault();
  url = $(this).attr("href");
  swal({
    title:"Yakin akan Posting data ini?",
    type: "warning",
    showCancelButton: true,
    confirmButtonClass: 'btn btn-danger',
    cancelButtonClass: 'btn btn-success',
    buttonsStyling: false,
    confirmButtonText: "Yes",
    cancelButtonText: "Cancel",
    closeOnConfirm: false,
    showLoaderOnConfirm: true,
  },
  function(isConfirm){
    if(isConfirm){
      $.ajax({
        url: url,
        success: function(resp){
          window.location.href = "{{ asset('admin-client/spk')}}";
        }
      });
    }
    return false;
  });
});



// Popup Posting
$(document).on("click", ".reset-link", function(e){
  e.preventDefault();
  url = $(this).attr("href");
  spk = 
  swal({
    title:"Yakin akan reset data ini?",
    type: "warning",
    showCancelButton: true,
    confirmButtonClass: 'btn btn-danger',
    cancelButtonClass: 'btn btn-success',
    buttonsStyling: false,
    confirmButtonText: "Yes",
    cancelButtonText: "Cancel",
    closeOnConfirm: false,
    showLoaderOnConfirm: true,
  },
  function(isConfirm){
    if(isConfirm){
      $.ajax({
        url: url,
        success: function(resp){
          window.location.href = "{{ asset('admin-client/spk')}}";
        }
      });
    }
    return false;
  });
});
</script>
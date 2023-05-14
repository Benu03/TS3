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
  @include('admin-client/spk/tambah_upload')
</p>
<form action="{{ asset('admin-client/spk/proses') }}" method="post" accept-charset="utf-8">
{{ csrf_field() }}
<div class="row">

  <div class="col-md-12">
    <div class="btn-group">
      {{-- <button class="btn btn-danger" type="submit" name="hapus" onClick="check();" >
          <i class="fa fa-trash"></i>
      </button>  --}}
        <button type="button" class="btn btn-success " data-toggle="modal" data-target="#Tambah">
            <i class="fa fa-plus"></i> Tambah SPK Baru
        </button>
   </div>
</div>
</div>

<div class="clearfix"><hr></div>
<div class="table-responsive mailbox-messages">
    <div class="table-responsive mailbox-messages">
<table id="example1" class="display table table-bordered" cellspacing="0" width="100%">
<thead>
    <tr class="bg-info">
        <th width="5%">
          <div class="mailbox-controls">
                <!-- Check all button -->
               <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="far fa-square"></i>
                </button>
            </div>
        </th>
        <th width="15%">SPK Nomor</th>
        <th width="10%">Jumlah Kendaraan</th>   
        <th width="15%">Tanggal Pengerjaan</th> 
        <th width="15%">Tanggal Berlaku SPK Terakhir</th>  
        <th width="10%">Status</th>  
        <th width="15%">User Posting</th>    
        <th width="15%">Tanggal Posting</th> 
        <th>ACTION</th>
</tr>
</thead>
<tbody>
<?php $i=1; foreach($spk as $dt) { ?> 

    <td class="text-center">
        <div class="icheck-primary">
                  <input type="checkbox" class="icheckbox_flat-blue " name="id[]" value="<?php echo $dt->id ?>" id="check<?php echo $i ?>">
                   <label for="check<?php echo $i ?>"></label>
        </div>
    
    </td>
    <td><?php echo $dt->spk_no ?></td>
    <td><?php echo $dt->count_vehicle ?></td>
    <td><?php echo $dt->tanggal_pengerjaan ?></td>
    <td><?php echo $dt->tanggal_last_spk ?></td>
    <td><?php echo $dt->status ?></td>
    <td><?php echo $dt->user_posting ?></td>
    <td><?php echo $dt->posting_date ?></td>
    <td>
        <div class="btn-group">
          <a href="{{ asset('admin-client/spk-detail/'.$dt->spk_seq) }}" 
            class="btn btn-success btn-sm"><i class="fa fa-eye"></i></a>
        </div>

    </td>
</tr>

<?php $i++; } ?>  

</tbody>
</table>
</div>
</div>
</form>

<script>
    function isNumber(evt) {
     evt = (evt) ? evt : window.event;
     var charCode = (evt.which) ? evt.which : evt.keyCode;
     if (charCode > 31 && (charCode < 48 || charCode > 57)) {
         return false;
     }
     return true;
  }
 



// Popup Posting
$(document).on("click", ".upload-link", function(e){
  e.preventDefault();
  url = $(this).attr("href");
  swal({
    title:"Apakah Data Sudah Sesuai?",
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
        headers: {'X-CSRF-TOKEN': "{{ csrf_token() }}"},
        url: "{{ asset('admin-client/spk-upload')}}",
        type: "POST",
        success: function(resp){
          window.location.href = "{{ asset('admin-client/spk')}}";
        }
      });
    }
    return false;
  });
});


</script>
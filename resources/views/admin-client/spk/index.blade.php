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
        {{-- <th width="5%">
          <div class="mailbox-controls">
                <!-- Check all button -->
               <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="far fa-square"></i>
                </button>
            </div>
        </th> --}}
        <th width="15%">SPK Nomor</th>
        <th width="15%">Jumlah Kendaraan</th>   
        <th width="15%">Tanggal Pengerjaan</th> 
        <th width="15%">Tanggal Berlaku SPK Terakhir</th>  
        <th width="10%">Status</th>  
        <th width="15%">User Posting</th>    
        <th width="15%">Tanggal Posting</th> 
        <th>ACTION</th>
</tr>
</thead>
<tbody>
{{-- 
    {{-- <?php $i=1; foreach($area as $ar) { ?> --}}

    {{-- <td class="text-center">
        <div class="icheck-primary">
                  <input type="checkbox" class="icheckbox_flat-blue " name="id[]" value="<?php echo $ar->id ?>" id="check<?php echo $i ?>">
                   <label for="check<?php echo $i ?>"></label>
        </div> --}}
        {{-- <small class="text-center"><?php echo $i ?></small> --}}
    {{-- </td>
    <td><?php echo $ar->regional_slug ?></td>
    <td><?php echo $ar->area ?></td>
    <td>
        <div class="btn-group">
        <a href="{{ asset('admin-ts3/area/edit/'.$ar->id) }}" 
          class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>

          <a href="{{ asset('admin-ts3/area/delete/'.$ar->id) }}" class="btn btn-danger btn-sm  delete-link">
            <i class="fa fa-trash"></i></a>
        </div>

    </td>
</tr> --}}
{{-- 
<?php $i++; } ?>  --}}

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
  </script>

<script>
    $(function () {
        $(document).ready(function () {
            
            var message = $('.success__msg');
            $('#fileUploadForm').ajaxForm({
                beforeSend: function () {
                    var percentage = '0';
                },
                uploadProgress: function (event, position, total, percentComplete) {
                    var percentage = percentComplete;
                    $('.progress .progress-bar').css("width", percentage+'%', function() {
                        return $(this).attr("aria-valuenow", percentage) + "%";
                    })
                },
                complete: function (xhr) {
                    console.log('File has uploaded');
                    message.fadeIn().removeClass('alert-danger').addClass('alert-success');
                    message.text("Uploaded File successfully.");
                    setTimeout(function () {
                        message.fadeOut();
                    }, 2000);
                    form.find('input:not([type="submit"]), textarea').val('');
                    var percentage = '0';
                }
            });
        });
    });
</script>
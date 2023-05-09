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
        <div class="card card-info">
            <div class="card-header">
                Action
              </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 text-center">
                
                  <a href="{{ asset('admin-client/spk-posting/'.$spk->spk_no) }}" 
                    class="btn btn-warning btn-md "><i class="fas fa-upload"></i> Posting Data</a>
                </div>
                <div class="col-md-6 text-center">
                    <a href="{{ asset('admin-client/spk-reset/'.$spk->spk_no) }}" 
                        class="btn btn-danger btn-md"><i class="fas fa-trash-alt"></i> Reset Data</a>
                    </div>
                    </div>
            </div>
          </div>

        {{-- <div class="col-12 col-sm-6">
            <div class="info-box">
            <span class="info-box-icon bg-success elevation-1"><i class="fa fa-file-contract"></i></span>

            <div class="info-box-content">
               
            </div>
            <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div> --}}
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
        <th width="10%">NOPOL</th>
        <th width="10%">NOMESIN</th>   
        <th width="15%">NORANGKA</th>  
        <th width="12%">TAHUN_BEMBUATAN</th>  
        <th width="17%">TYPE</th>  
        <th width="17%">NAMA_CABANG</th>  
        <th width="20%">KETERANGAN</th>  
      
</tr>
</thead>
<tbody>

    <?php $i=1; foreach($spk_detail as $sp) { ?>


    <td><?php echo $sp->nopol ?></td>
    <td><?php echo $sp->nomesin ?></td>
    <td><?php echo $sp->norangka ?></td>
    <td><?php echo $sp->tahun_pembuatan ?></td>
    <td><?php echo $sp->type ?></td>
    <td><?php echo $sp->branch ?></td>
    <td><?php echo $sp->remark ?></td>
    

    
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
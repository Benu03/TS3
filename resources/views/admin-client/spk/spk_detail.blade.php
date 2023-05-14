@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ asset('admin-client/spk-detail/proses') }}" method="post" accept-charset="utf-8">
{{ csrf_field() }}
<div class="row">

  <div class="col-md-8">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th  colspan="4" width="25%">SPK Nomor : {{  $spk_h->spk_no }}</th>    
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th>Jumlah Kendaraan</th>
                    <td>{{ $spk_h->count_vehicle }}</td>
                    <th>Status</th>
                    <td>{{ $spk_h->status }}</td>
                </tr>

                <tr>
                    <th>Tanggal Pengerjaan</th>
                    <td>{{ $spk_h->tanggal_pengerjaan }}</td>
                    <th>User Upload</th>
                    <td>{{ $spk_h->user_upload }}</td>
                </tr>

                <tr>
                    <th>Tanggal Berlaku SPK Terakhir</th>
                    <td>{{ $spk_h->tanggal_last_spk }}</td>
                    <th>Tanggal Upload</th>
                    <td>{{ $spk_h->upload_date }}</td>
                </tr>

            
            
            </tbody>
        </table>


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
        <th width="17%">NAMA_CABANG</th>   
        <th width="15%">PIC_CABANG</th>  
        <th width="10%">STATUS</th>  
        <th width="10%">TANGGAL SCHEDULE</th>  
        <th width="10%">TANGGAL SERVICE</th>  
        <th width="10%">ACTION</th>  
      
</tr>
</thead>
<tbody>

    <?php $i=1; foreach($spk_d as $sp) { ?>
    <td><?php echo $sp->nopol ?></td>
    <td> <?php echo $sp->branch ?> </td>
    <td> <?php echo $sp->pic_branch ?> </td>
    <td> <?php echo $sp->status_service ?> </td>
    <td><?php echo $sp->tanggal_schedule ?>  </td>
    <td>  <?php echo $sp->tanggal_service ?></td>
    <td>
     

      <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#Tambah<?php echo $sp->id ?>">
        <i class="fa fa-eye"></i> 
      </button>

            
      <div class="modal fade" id="Tambah<?php echo $sp->id ?>"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-xl">
        <div class="modal-content">
          <div class="modal-header">

            <h4 class="modal-title mr-4" id="myModalLabel">Detail <?php echo $sp->spk_no ?> (<?php echo $sp->nopol ?>)  </h4>
          
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          </div>
          <div class="modal-body">


            <div class="card border-primary mb-3">
              <div class="card-header">
                SPK Nomor : {{  $spk_h->spk_no }}
              </div>
              <div class="card-body text-primary">
            <div class="row">              
              <div class="col-md-12">
                <div class="table-responsive-md">
                    <table class="table table-bordered">
                        
                        <tbody>
                            <tr>
                                <th>Jumlah Kendaraan</th>
                                <td>{{ $spk_h->count_vehicle }}</td>
                                <th>Status</th>
                                <td>{{ $spk_h->status }}</td>
                            </tr>
            
                            <tr>
                                <th>Tanggal Pengerjaan</th>
                                <td>{{ $spk_h->tanggal_pengerjaan }}</td>
                                <th>User Upload</th>
                                <td>{{ $spk_h->user_upload }}</td>
                            </tr>
            
                            <tr>
                                <th>Tanggal Berlaku SPK Terakhir</th>
                                <td>{{ $spk_h->tanggal_last_spk }}</td>
                                <th>Tanggal Upload</th>
                                <td>{{ $spk_h->upload_date }}</td>
                            </tr>
                        </tbody>
                    </table>
                  </div> 
                </div>           
            </div>

              </div>
            </div>


            <div class="card mb-2">
              <div class="card-header">
                Detail Vehicle
              </div>
              <div class="card-body  text-info">

                <div class="row">              
                  <div class="col-md-12">
                    <div class="table-responsive-md">
                        <table class="table table-borderless">
                   
                            <tbody>
                                <tr>
                                    <th>Nopol</th>
                                    <td><?php echo $sp->nopol ?></td>
                                    <th>No Rangka</th>
                                    <td><?php echo $sp->norangka ?></td>
                                </tr>
                
                                <tr>
                                    <th>No Mesin</th>
                                    <td><?php echo $sp->nomesin ?></td>
                                    <th>Type</th>
                                    <td><?php echo $sp->type ?></td>
                                </tr>
                
                                <tr>
                                    <th>Tahun Pembuatan</th>
                                    <td><?php echo $sp->tahun_pembuatan ?></td>
                                    <th>Tanggal Last Service</th>
                                    <td><?php echo $sp->tgl_last_service ?></td>
                                </tr>
                                <tr>
                                  <th>Cabang</th>
                                  <td><?php echo $sp->branch ?></td>
                                  <th>PIC Cabang</th>
                                  <td><?php echo $sp->pic_branch ?></td>
                              </tr>
                              <tr>
                                <th>Tanggal Schedule</th>
                                <td><?php echo $sp->tanggal_schedule ?></td>
                                <th>Tanggal Service</th>
                                <td><?php echo $sp->tanggal_service ?></td>
                            </tr>
                            <tr>
                              <th >Status Service</th>  
                              <td ><?php echo $sp->status_service ?></td>      
                            </tr>
                            
                            </tbody>
                        </table>
                      </div>   
                    </div>           
                </div>




              </div>
            </div>
        

          </div>
        </div>
      </div>
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
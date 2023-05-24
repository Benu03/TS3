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
<form action="{{ asset('admin-client/approval/service-approval-remark') }}" method="post" accept-charset="utf-8">
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

                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                    <span class="info-box-icon bg-success elevation-1"><i class="fa fa-file-contract"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">
                        Approval Service
                        </span>
                        <span class="info-box-number">
                            {{ $countapproval }}
                        </span>
                    </div>
                    <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>

               


              


</div>
<div class="clearfix"><hr></div>


<p>
    <button type="button" class="btn btn-warning" name="service_adm" onClick="check();"   data-toggle="modal" data-target="#serviceadmcli" >
        <i class="fa fa-edit"> </i> Remark Approval
    </button> 
    

</p>
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
          <th width="15%">Service no</th>
          <th width="12%">NOPOL</th>
          <th width="12%">Tanggal Service</th>   
          <th width="12%">Status Service</th> 
          <th width="12%">PIC Cabang Service</th>  
          <th width="15%">Nama Driver</th>    
          <th width="15%">Mekanik</th> 
          <th>ACTION</th>
</tr>
</thead>
<tbody>
 <?php $i=1; foreach($approval as $dt) { ?> 

    <td class="text-center">
        <div class="icheck-primary">
                  <input type="checkbox" class="icheckbox_flat-blue " name="id[]" value="<?php echo $dt->id ?>" id="check<?php echo $i ?>">
                   <label for="check<?php echo $i ?>"></label>
        </div>
    
    </td>
    <td><?php echo $dt->service_no ?></td>
    <td><?php echo $dt->nopol ?></td>
    <td><?php echo $dt->tanggal_service ?></td>
    <td><?php echo $dt->status_service ?></td>
    <td><?php echo $dt->pic_branch_service ?></td>
    <td><?php echo $dt->nama_driver ?></td>
    <td><?php echo $dt->mekanik ?></td>
    <td>
        <div class="btn-group">
        <a href="{{ asset('admin-client/approval/service-approval/'.$dt->id) }}" 
          class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>

            @if($dt->status_service == 'APPROVAL')
            <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#Detail<?php echo $dt->service_no ?>">
                <i class="fa fa-eye"></i> 
             </button>   
             @endif
             @include('admin-client/approval/service_approval_detail') 

        </div>

    </td>
</tr> 
@include('admin-client/approval/service_approval_remark') 
<?php $i++; } ?>  

</tbody>
</table>
</div>
</div>
</form>
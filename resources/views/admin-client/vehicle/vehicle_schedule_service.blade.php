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
@include('admin-client/vehicle/tambah')
</p> --}}
{{-- <form action="{{ asset('admin-client/vehicle/proses') }}" method="post" accept-charset="utf-8">
{{ csrf_field() }} --}}
<div class="row">

    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
        <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-motorcycle"></i></span>

        <div class="info-box-content">
            <span class="info-box-text">
            Vehicle Service Schedule
            </span>
            <span class="info-box-number">
                {{ $vehiclecount }}
            </span>
        </div>
        <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>

   


  </div>

<div class="clearfix"><hr></div>

<div class="row">

    <div class="col-md-12">
      <div class="btn-group">
        <a href="{{ asset('admin-client/vehicle-schedule-service-excel') }}" 
            class="btn btn-success btn-md"><i class="fas fa-file-excel mr-2"></i>  Generate Excel</a>
     </div>
  </div>
  </div>
<div class="clearfix"><hr></div>
<div class="table-responsive mailbox-messages">
    <div class="table-responsive mailbox-messages">
<table id="example1" class="display table table-bordered" cellspacing="0" width="100%">
<thead>
    <tr class="bg-info">
   
 
        <th width="10%">Nopol</th>
        <th width="15%">No Rangka</th>
        <th width="15%">No Mesin</th>
        <th width="20%">Type</th>
        <th width="10%">Last Service</th>

</tr>
</thead>
<tbody>

<?php $i=1; foreach($vehicle as $vc) { ?>

<td><?php echo $vc->nopol ?></td>
<td><?php echo $vc->norangka ?></td>
<td><?php echo $vc->nomesin ?></td>
<td><?php echo $vc->type ?></td>
<td><?php echo $vc->tgl_last_service ?></td>

</tr>

<?php $i++; } ?>

</tbody>
</table>
</div>
</div>
</form>
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
{{-- @include('admin-ts3/vehicle/tambah') --}}
</p>
{{-- <form action="{{ asset('admin-client/vehicle/proses') }}" method="post" accept-charset="utf-8">
{{ csrf_field() }} --}}
<div class="row">

{{-- <div class="col-md-12">
    <div class="btn-group">
    <button class="btn btn-danger" type="submit" name="hapus" onClick="check();" >
        <i class="fa fa-trash"></i>
    </button> 
        <button type="button" class="btn btn-success " data-toggle="modal" data-target="#Tambah">
            <i class="fa fa-plus"></i> Tambah Baru
        </button>
</div>
</div> --}}

                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                    <span class="info-box-icon bg-success elevation-1"><i class="fas fa-motorcycle"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">
                        Vehicle
                        </span>
                        <span class="info-box-number">
                     
                        {{  $count_vehicle }}
                        </span>
                    </div>
                    <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
           
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                    <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-copyright"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">
                        Type Vehicle
                        </span>
                        <span class="info-box-number">
                            {{  $count_type_vehicle }}
                        {{-- <small>Sudah Dipublikasikan</small> --}}
                        </span>
                    </div>
                    <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
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
        <th width="10%">Client</th>
        <th width="10%">Nopol</th>
        <th width="15%">No Rangka</th>
        <th width="15%">No Mesin</th>
        <th width="20%">Type</th>
        <th width="10%">Last Service</th>
        <th>ACTION</th>
</tr>
</thead>
<tbody>

<?php $i=1; foreach($vehicle as $vc) { ?>

    <td class="text-center">
    <div class="icheck-primary">
            <input type="checkbox" class="icheckbox_flat-blue " name="id[]" value="<?php echo $vc->id ?>" id="check<?php echo $i ?>">
            <label for="check<?php echo $i ?>"></label>
    </div>


</td>
<td><?php echo $vc->client_name ?></td>
<td><?php echo $vc->nopol ?></td>
<td><?php echo $vc->norangka ?></td>
<td><?php echo $vc->nomesin ?></td>
<td><?php echo $vc->type ?></td>
<td><?php echo $vc->tgl_last_service ?></td>
<td>
    <div class="btn-group">
    <a href="{{ asset('admin-client/vehicle/detail/'.$vc->id) }}" 
            class="btn btn-success btn-sm"><i class="fa fa-eye"></i></a>


</td>
</tr>

<?php $i++; } ?>

</tbody>
</table>
</div>
</div>
{{-- </form> --}}
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
@include('admin-ts3/client_product/tambah')
</p>
<form action="{{ asset('admin-ts3/client/proses') }}" method="post" accept-charset="utf-8">
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
        <th width="8%">Gambar</th>
        <th width="25%">Client Name</th>
        <th width="10%">Type</th>
        <th width="35%">Product</th>
        <th>ACTION</th>
</tr>
</thead>
<tbody>

<?php $i=1; foreach($clientdata as $cl) { ?>

    <td class="text-center">
    <div class="icheck-primary">
              <input type="checkbox" class="icheckbox_flat-blue " name="id[]" value="<?php echo $cl->id ?>" id="check<?php echo $i ?>">
               <label for="check<?php echo $i ?>"></label>
    </div>
    {{-- <small class="text-center"><?php echo $i ?></small> --}}

</td>
<td class="text-center">
       
    <?php if($cl->img_client <> "NULL") { ?>
        <img src="{{ asset('admin-ts3/get-image-client/'.$cl->img_client) }}" class="img img-fluid img-thumbnail">
    <?php }else{ echo '<small class="btn btn-sm btn-warning">Tidak ada</small>'; } ?>
</td>

<td><?php echo $cl->client_name ?></td>
<td><?php echo $cl->client_type ?></td>
<td><?php     
    $str = $cl->product_name;
    $delimiter = ',';
    $products = explode($delimiter, $str);
    foreach ($products as $pds) {
        echo "<span class='badge badge-pill badge-primary mr-2 mb-1'>$pds </span>" ;
    }
 ?></td>
<td>
    <div class="btn-group">
    <a href="{{ asset('admin-ts3/client/edit/'.$cl->id) }}" 
      class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>

      <a href="{{ asset('admin-ts3/client/delete/'.$cl->id) }}" class="btn btn-danger btn-sm  delete-link">
        <i class="fa fa-trash"></i></a>
    </div>

</td>
</tr>

<?php $i++; } ?>

</tbody>
</table>
</div>
</div>
</form>
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
  @include('admin-ts3/price_service/tambah')
</p>
<form action="{{ asset('admin-ts3/price-service/proses') }}" method="post" accept-charset="utf-8">
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
        <th width="10%">Kode</th>
        <th width="25%">Name</th>
        <th width="12%">Price Bengkel to TS3</th>
        <th width="10%">Client</th>
        <th width="12%">Price TS3 to Client</th>
        <th width="25%">Regional</th>
       
        <th>ACTION</th>
</tr>
</thead>
<tbody>

    <?php $i=1; foreach($price as $pr) { ?>

    <td class="text-center">
        <div class="icheck-primary">
                  <input type="checkbox" class="icheckbox_flat-blue " name="id[]" value="<?php echo $pr->id ?>" id="check<?php echo $i ?>">
                   <label for="check<?php echo $i ?>"></label>
        </div>
        {{-- <small class="text-center"><?php echo $i ?></small> --}}
    </td>
    <td><?php echo $pr->kode ?></td>
    <td><?php echo $pr->service_name ?></td>
    <td><?php echo "Rp " . number_format($pr->price_bengkel_to_ts3,0,',','.');  ?></td>
    <td><?php echo $pr->client_name ?></td>
    <td><?php echo "Rp " . number_format($pr->price_ts3_to_client,0,',','.'); ?></td>
    <td><?php 
    
        $str = $pr->regional;
        $delimiter = ',';
        $regionals = explode($delimiter, $str);
        foreach ($regionals as $rgg) {
            echo "<span class='badge badge-pill badge-primary mr-2 mb-1'>$rgg </span>" ;
        }
     ?></td>
   
    <td>
        <div class="btn-group">
        <a href="{{ asset('admin-ts3/price-service/edit/'.$pr->id) }}" 
          class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>

          <a href="{{ asset('admin-ts3/price-service/delete/'.$pr->id) }}" class="btn btn-danger btn-sm  delete-link">
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




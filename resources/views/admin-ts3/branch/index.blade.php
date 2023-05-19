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
  @include('admin-ts3/branch/tambah')
</p>
<form action="{{ asset('admin-ts3/branch/proses') }}" method="post" accept-charset="utf-8">
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
        <th width="15%">Area</th>
        <th width="15%">Branch</th>   
        <th width="15%">PIC Branch</th>    
        <th width="10%">Phone</th>   
        <th width="20%">Address</th>    
        <th>ACTION</th>
</tr>
</thead>
<tbody>

    <?php $i=1; foreach($branch as $br) { ?>

    <td class="text-center">
        <div class="icheck-primary">
                  <input type="checkbox" class="icheckbox_flat-blue " name="id[]" value="<?php echo $br->id ?>" id="check<?php echo $i ?>">
                   <label for="check<?php echo $i ?>"></label>
        </div>
        {{-- <small class="text-center"><?php echo $i ?></small> --}}
    </td>
    <td><?php echo $br->area_slug ?></td>
    <td><?php echo $br->branch ?></td>
    <td><?php echo $br->pic_branch ?></td>
    <td><?php echo $br->phone ?></td>
    <td><?php echo $br->address ?></td>
    <td>
        <div class="btn-group">
        <a href="{{ asset('admin-ts3/branch/edit/'.$br->id) }}" 
          class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>

          <a href="{{ asset('admin-ts3/branch/delete/'.$br->id) }}" class="btn btn-danger btn-sm  delete-link">
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
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
  @include('admin-ts3/user/tambah')
</p>
<form action="{{ asset('admin-ts3/user/proses') }}" method="post" accept-charset="utf-8">
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
        <th width="7%">GAMBAR</th>
        <th width="20%">NAMA</th>
        <th width="20%">USERNAME</th>
        <th width="10%">ROLE</th>
        <th width="10%">LOGIN</th>
        <th width="10%">ENTITY</th>       
        <th>ACTION</th>
</tr>
</thead>
<tbody>

    <?php $i=1; foreach($user as $user) { ?>



    <td class="text-center">
        <div class="icheck-primary">
                <input type="checkbox" class="icheckbox_flat-blue " name="id_user[]" value="<?php echo $user->id_user ?>" id="check<?php echo $i ?>">
                <label for="check<?php echo $i ?>"></label>
        </div>
    
    
    </td>
      <td class="text-center">
       
        <?php if($user->gambar <> "NULL") { ?>
            <img src="{{ asset('assets/upload/user/thumbs/'.$user->gambar) }}" class="img img-fluid img-thumbnail">
        <?php }else{ echo '<small class="btn btn-sm btn-warning">Tidak ada</small>'; } ?>
    </td>

    <td><?php echo $user->nama ?></td>
    <td><?php echo $user->username ?></td>
    <td><?php echo $user->role_title ?></td>
    <td class="text-center"> <?php if($user->is_login == true) { echo '<small class="btn btn-sm btn-success">YES</small>'; ?>
        <?php }else{ echo '<small class="btn btn-sm btn-warning">NO</small>'; } ?>
    </td>
    <td><?php echo $user->entity ?></td>
    <td>
        <div class="btn-group">
        <a href="{{ asset('admin-ts3/user/edit/'.$user->id_user) }}" 
          class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>

          <a href="{{ asset('admin-ts3/user/delete/'.$user->username) }}" class="btn btn-danger btn-sm  delete-link">
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

<script>
     $('#div_customer').hide();
   $('document').ready(function () {
                        $("#role").change(function () {
                        var data = $(this).val();
                        if (data == "3" || data == "5" ) {
                        $('#div_customer').show();
                        } 
                        else {
                        $('#div_customer').hide();
                        }
                        });
                        });

</script>
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
{{-- <form action="{{ asset('admin-client/spk/proses') }}" method="post" accept-charset="utf-8">
{{ csrf_field() }} --}}
<div class="row">

  {{-- <div class="col-md-12"> --}}
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
                <span class="info-box-icon bg-success elevation-1"><i class="fas fa-users"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">
                    PIC Cabang
                    </span>
                    <span class="info-box-number">
                   {{ $count_pic }}
                    {{-- <small>Sudah Dipublikasikan</small> --}}
                    </span>
                </div>
                <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>




{{-- </div> --}}
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
        <th width="20%">Cabang</th>
        <th width="20%">PIC Cabang</th>   
        <th width="20%">Phone</th>  
        <th>ACTION</th>
</tr>
</thead>
<tbody>
 
    <?php $i=1; foreach($pic_cabang as $pb) { ?>

    <td class="text-center">
        <div class="icheck-primary">
                  <input type="checkbox" class="icheckbox_flat-blue " name="id[]" value="<?php echo $pb->id ?>" id="check<?php echo $i ?>">
                   <label for="check<?php echo $i ?>"></label>
        </div> 
        {{-- <small class="text-center"><?php echo $i ?></small> --}}
    </td>
    <td><?php echo $pb->branch ?></td>
    <td><?php echo $pb->pic_branch ?></td>
    <td><?php echo $pb->phone ?></td>
    <td>
        <div class="btn-group">
        <a href="{{ asset('admin-client/pic-cabang/detail/'.$pb->id) }}" 
            class="btn btn-success btn-sm"><i class="fa fa-eye"></i></a>
        <a href="{{ asset('admin-client/pic-cabang/edit/'.$pb->id) }}" 
          class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>

          <a href="{{ asset('admin-client/pic-cabang/delete/'.$pb->id) }}" class="btn btn-danger btn-sm  delete-link">
            <i class="fa fa-trash"></i></a>
        </div>

    </td>
</tr>

<?php $i++; } ?> 

</tbody>
</table>
</div>
</div>
{{-- </form> --}}
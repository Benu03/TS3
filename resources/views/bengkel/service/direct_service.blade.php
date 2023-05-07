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
  @include('pic/service/tambah_direct_service')
</p> --}}
{{-- <form action="{{ asset('pic/service/proses-direct-service') }}" method="post" accept-charset="utf-8">
{{ csrf_field() }} --}}
<div class="row">


    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
        <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-motorcycle"></i></span>

        <div class="info-box-content">
            <span class="info-box-text">
            Jumlah Service
            </span>
            <span class="info-box-number">
            <?php 
            $berita = DB::connection('ts3')->table('cp.berita')->where('jenis_berita','Layanan')->get(); 
            echo $berita->count();
            ?>
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
        <th width="15%">Request No</th>
        <th width="15%">Nopol</th>
        <th width="15%">No Mesin</th>   
        <th width="15%">No Rangka</th> 
        <th width="15%">Tanggal Service</th> 
        <th width="15%">Status</th> 
        <th>ACTION</th>
</tr>
</thead>
<tbody>
{{-- 
    {{-- <?php $i=1; foreach($area as $ar) { ?> --}}

    {{-- <td class="text-center">
        <div class="icheck-primary">
                  <input type="checkbox" class="icheckbox_flat-blue " name="id[]" value="<?php echo $ar->id ?>" id="check<?php echo $i ?>">
                   <label for="check<?php echo $i ?>"></label>
        </div> --}}
        {{-- <small class="text-center"><?php echo $i ?></small> --}}
    {{-- </td>
    <td><?php echo $ar->regional_slug ?></td>
    <td><?php echo $ar->area ?></td>
    <td>
        <div class="btn-group">
        <a href="{{ asset('admin-ts3/area/edit/'.$ar->id) }}" 
          class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>

          <a href="{{ asset('admin-ts3/area/delete/'.$ar->id) }}" class="btn btn-danger btn-sm  delete-link">
            <i class="fa fa-trash"></i></a>
        </div>

    </td>
</tr> --}}
{{-- 
<?php $i++; } ?>  --}}

</tbody>
</table>
</div>
</div>
</form>
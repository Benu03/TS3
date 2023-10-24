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
  @include('pic/service/tambah_direct_service')
</p>
<form action="{{ asset('pic/service/proses-direct-service') }}" method="post" accept-charset="utf-8">
{{ csrf_field() }}
<div class="row">


     <div class="btn-group">
       {{-- <button class="btn btn-danger" type="submit" name="hapus" onClick="check();" >
          <i class="fa fa-trash"></i>
      </button>   --}}
         <button type="button" class="btn btn-success " data-toggle="modal" data-target="#Tambah">
            <i class="fa fa-plus"></i> Form Request Service
        </button>
   </div>  

            


              


</div>

<div class="clearfix"><hr></div>
<div class="table-responsive mailbox-messages">
    <div class="table-responsive mailbox-messages">
<table id="example1" class="display table table-bordered" cellspacing="0" width="100%">
<thead>
    <tr class="bg-info">
         <th width="5%">
         No
        </th> 
        <th width="15%">Nopol</th>
        <th width="15%">Status</th> 
        <th width="15%">Cabang</th> 
        <th width="15%">Tanggal Pengerjaan</th> 
        <th width="15%">User Request</th> 
        <th width="15%">Date Request</th> 
        <th>ACTION</th>
</tr>
</thead>
<tbody>

    <?php $i=1; foreach($direct as $dt) { ?> 

        <td class="text-center">

        
            <?php echo $i ?>
        </td>
        <td><?php echo $dt->nopol ?></td>
        <td><?php echo $dt->status ?></td>
        <td><?php echo $dt->branch ?></td>
        <td><?php echo $dt->tanggal_pengerjaan ?></td>
        <td><?php echo $dt->create_by ?></td>
        <td><?php echo $dt->created_date ?></td>
        <td>
            <div class="btn-group">
                @if ($dt->status == 'REQUEST')
                <a href="{{ asset('pic/service/delete-direct-service/'.$dt->id) }}" 
                    class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>
            @endif           
    
                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#DetailDirect<?php echo $dt->id ?>">
                    <i class="fa fa-eye"></i> 
                 </button>   

    
                 @include('pic/service/service_direct_detail') 
    
            </div>
    
        </td>
    </tr> 
    @include('pic/service/service_remark') 
    <?php $i++; } ?>  
    



</tbody>
</table>
</div>
</div>
</form>

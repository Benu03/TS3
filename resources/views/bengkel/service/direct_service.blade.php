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
            Direct Service
            </span>
            <span class="info-box-number">
           
                {{ $countdirect }}
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
                @if ($dt->status == 'ESTIMATE')
                <a href="{{ asset('bengkel/direct_service_estimate/'.$dt->id) }}" 
                    class="btn btn-warning btn-sm mr-1"><i class="fa fa-edit"></i></a>
            @endif           
    
                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#DetailDirect<?php echo $dt->id ?>">
                    <i class="fa fa-eye"></i> 
                 </button>   

    
                 @include('bengkel/service/service_direct_detail') 
    
            </div>
    
        </td>
    </tr> 

    <?php $i++; } ?>  

</tbody>
</table>
</div>
</div>
</form>
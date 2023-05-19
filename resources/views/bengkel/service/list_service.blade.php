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
        <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-motorcycle"></i></span>

        <div class="info-box-content">
            <span class="info-box-text">
            Service
            </span>
            <span class="info-box-number">
                {{ $countservice }}
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
        <table id="sevicebengkel" class="display table table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr class="bg-info">
                    <th width="5%">
                      {{-- <div class="mailbox-controls">
                            <!-- Check all button -->
                           <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="far fa-square"></i>
                            </button>
                        </div> --}}
                        No
                    </th>
                    <th width="10%">Source</th>
                    <th width="7%">NOPOL</th>
                    <th width="10%">Tanggal last Service</th>   
                    <th width="12%">Cabang</th> 
                    <th width="10%">Status Service</th>  
                    <th width="15%">Tanggal Schedule</th> 
                    <th width="15%">Bengkel</th>    
                    <th width="15%">Tanggal Service</th> 
                    <th>ACTION</th>
            </tr>
            </thead>
            <tbody>
            <?php $i=1; foreach($service as $dt) { ?> 
            
                <td class="text-center">
                    {{-- <div class="icheck-primary">
                              <input type="checkbox" class="icheckbox_flat-blue " name="id[]" value="<?php echo $dt->id ?>" id="check<?php echo $i ?>">
                               <label for="check<?php echo $i ?>"></label>
                    </div> --}}
                    <?php echo $i ?>
                
                </td>
                <td><?php echo $dt->source ?></td>
                <td><?php echo $dt->nopol ?></td>
                <td><?php echo $dt->tgl_last_service ?></td>
                <td><?php echo $dt->branch ?></td>
                <td><?php echo $dt->status_service ?></td>
                <td><?php echo $dt->tanggal_schedule ?></td>
                <td> <?php echo $dt->bengkel_name ?> </td>
                <td><?php echo $dt->tanggal_service ?></td>
                <td>
                    <div class="btn-group">

                        <a href="{{ asset('bengkel/service-proses-page/'.$dt->id) }}" 
                            class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>

                        <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#Detail<?php echo $dt->nopol ?>">
                            <i class="fa fa-eye"></i> 
                         </button>     


                         @include('bengkel/service/service_detail') 

                    </div>
            
                </td>
            </tr>
          

            <?php $i++; } ?>  
            
            </tbody>
            </table>
</div>
</div>
</form>
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
<form action="{{ asset('admin-ts3/spk-service-proses') }}" enctype="multipart/form-data" method="post" accept-charset="utf-8">
    {{ csrf_field() }}
<div class="row">
    


    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
        <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-tools"></i></span>
        
        <div class="info-box-content">
            <span class="info-box-text">
                PLAN
            </span>
            <span class="info-box-number">
                {{ $countspkplan }} 
            {{-- <small>Sudah Dipublikasikan</small> --}}
            </span>
        </div>
        <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>

    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
        <span class="info-box-icon bg-success elevation-1"><i class="fas fa-tools"></i></span>
        
        <div class="info-box-content">
            <span class="info-box-text">
                ON SCHEDULE
            </span>
            <span class="info-box-number">
                {{ $countspkonchecldule }} 
            {{-- <small>Sudah Dipublikasikan</small> --}}
            </span>
        </div>
        <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>

    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
        <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-tools"></i></span>
        
        <div class="info-box-content">
            <span class="info-box-text">
                SERVICE
            </span>
            <span class="info-box-number">
                {{ $countspkservice }} 
            {{-- <small>Sudah Dipublikasikan</small> --}}
            </span>
        </div>
        <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>

              


</div>

<div class="clearfix"><hr></div>


<p>
    <button type="button" class="btn btn-warning" name="proses_service" onClick="check();"   data-toggle="modal" data-target="#ProsesSpkService" >
        <i class="fa fa-edit"> </i> Proses Mapping Service
    </button> 

</p>
<div class="table-responsive mailbox-messages">
    <div class="table-responsive mailbox-messages">
        <table id="spklist" class="display table table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr class="bg-info">
                    <th width="5%">
                      <div class="mailbox-controls">
                            <!-- Check all button -->
                           <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="far fa-square"></i>
                            </button>
                        </div>
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
            <?php $i=1; foreach($spkservice as $dt) { ?> 
            
                <td class="text-center">
                    <div class="icheck-primary">
                              <input type="checkbox" class="icheckbox_flat-blue " name="id[]" value="<?php echo $dt->id ?>" id="check<?php echo $i ?>">
                               <label for="check<?php echo $i ?>"></label>
                    </div>
                
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
                        @if ($dt->status_service != 'SERVICE')
                        <a href="{{ asset('admin-ts3/spk-service-edit/'.$dt->id) }}" 
                            class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>
                        @endif
                                             
                        <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#Detail<?php echo $dt->nopol ?>">
                            <i class="fa fa-eye"></i> 
                         </button>     


                         @include('admin-ts3/spk/spk_service_detail') 

                    </div>
            
                </td>
            </tr>
             @include('admin-ts3/spk/spk_service_proses') 

            <?php $i++; } ?>  
            
            </tbody>
            </table>
</div>
</div>
</form>